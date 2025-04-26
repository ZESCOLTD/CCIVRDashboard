<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Advanced SIP.js Softphone with Video & Conference</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- SIP.js -->
  <script src="https://unpkg.com/sip.js@0.32.1/dist/sip.min.js"></script>
  <style>
    body { margin: 0; font-family: Arial, sans-serif; display: flex; height: 100vh; background: #f0f2f5; }
    .sidebar { width: 280px; background: #fff; border-right: 1px solid #ddd; display: flex; flex-direction: column; }
    .main { flex:1; display:flex; flex-direction:column; align-items:center; justify-content:center; position:relative; background:#fafafa; }
    .controls, .conference-controls { margin: 10px; }
    button { margin: 0 5px; padding: 8px 12px; border:1px solid #ccc; border-radius:4px; cursor:pointer; }
    button.active { background:#4CAF50; color:#fff; }
    video { width: 45%; max-width: 300px; margin:5px; background:#000; }
    #video-container { display:flex; flex-wrap:wrap; justify-content:center; }
    .log { position:absolute; bottom:0; left:0; right:0; max-height:100px; overflow:auto; background:rgba(0,0,0,0.1); font-size:12px; padding:5px; }
  </style>
</head>
<body>
  <div class="sidebar">
    <h3 style="padding:10px;">Contacts</h3>
    <div id="contacts"></div>
    <h3 style="padding:10px;">Messaging</h3>
    <input id="messageInput" placeholder="Type message..." style="width:90%; margin:5px; padding:5px;" />
    <button onclick="sendMessage()">Send</button>
  </div>
  <div class="main">
    <div class="controls">
      <button id="callBtn">Call</button>
      <button id="hangupBtn">Hangup</button>
      <button id="muteBtn">Mute</button>
      <button id="holdBtn">Hold</button>
      <button id="videoToggleBtn">Video On</button>
      <button id="dtmfBtn">Send DTMF</button>
    </div>
    <div id="video-container">
      <video id="localVideo" autoplay muted></video>
      <!-- remote videos will be appended here -->
    </div>
    <div class="conference-controls">
      <button id="joinConfBtn">Join Conference</button>
      <button id="leaveConfBtn">Leave Conference</button>
    </div>
    <div id="timer" style="font-size:16px; margin-top:10px;">00:00</div>
    <div class="log" id="log"></div>
  </div>

<script>
// ======= SIP.js Setup =======
const configuration = {
  uri: 'sip:6003@example.com',
  transportOptions: { wsServers: ['wss://sip-ws.example.com'] },
  authorizationUser: '6003',
  password: 'supersecret',
  sessionDescriptionHandlerFactoryOptions: { constraints: { audio:true, video:true } }
};
const ua = new SIP.UA(configuration);
let session = null;
let isMuted=false, isHeld=false, videoEnabled=false;
let localStream;

// ======= Logging =====nfunction log(msg) { const l=document.getElementById('log'); l.innerHTML+=msg+ '<br>'; l.scrollTop=l.scrollHeight; }

// ======= Media =====
async function initMedia() {
  localStream = await navigator.mediaDevices.getUserMedia({ audio:true, video:true });
  document.getElementById('localVideo').srcObject = localStream;
}
initMedia();

// ======= Contacts UI =====
const contacts=['1001','1002','1003'];
const contactsDiv=document.getElementById('contacts');
contacts.forEach(num=>{
  const btn=document.createElement('button'); btn.textContent=num;
  btn.onclick=()=>makeCall(num);
  contactsDiv.appendChild(btn);
});

// ======= Call controls =====
function makeCall(target) {
  if(session) session.terminate();
  session = ua.invite(`sip:${target}@example.com`, {
    sessionDescriptionHandlerOptions: { constraints:{ audio:true, video:videoEnabled } }
  });
  setupSession(session);
}
function hangup() { session && session.bye(); }
function toggleMute() {
  if(!session) return;
  isMuted=!isMuted;
  session.sessionDescriptionHandler.peerConnection.getSenders().forEach(s=>{ if(s.track.kind==='audio') s.track.enabled=!isMuted; });
  document.getElementById('muteBtn').classList.toggle('active', isMuted);
}
function toggleHold() {
  if(!session) return;
  if(!isHeld) session.hold(); else session.unhold();
  isHeld=!isHeld;
  document.getElementById('holdBtn').classList.toggle('active', isHeld);
}
function toggleVideo() {
  videoEnabled=!videoEnabled;
  if(session) makeCall(session.remoteIdentity.uri.user);
  document.getElementById('videoToggleBtn').textContent = videoEnabled? 'Video Off':'Video On';
}
function sendDTMF() {
  const tone = prompt('Enter DTMF digit');
  session && session.dtmf(tone, { toneType: 'RTP' });
}

document.getElementById('callBtn').onclick=()=>makeCall(prompt('Number?'));
document.getElementById('hangupBtn').onclick=hangup;
document.getElementById('muteBtn').onclick=toggleMute;
document.getElementById('holdBtn').onclick=toggleHold;
document.getElementById('videoToggleBtn').onclick=toggleVideo;
document.getElementById('dtmfBtn').onclick=sendDTMF;

// ======= Conference =====
let conferenceSessions=[];
document.getElementById('joinConfBtn').onclick=()=>{
  const target=prompt('Conf room SIP URI?');
  const confSession = ua.invite(target, { sessionDescriptionHandlerOptions:{ constraints:{ audio:true, video:false }} });
  setupSession(confSession, true);
  conferenceSessions.push(confSession);
};
document.getElementById('leaveConfBtn').onclick=()=>{
  conferenceSessions.forEach(s=>s.bye()); conferenceSessions=[];
};

// ======= Messaging =====
function sendMessage() {
  const msg = document.getElementById('messageInput').value;
  ua.message(`sip:1001@example.com`, msg);
  log('Sent MESSAGE: '+msg);
}
ua.on('message', m=> log('Received MESSAGE from '+m.remoteIdentity.uri.user+': '+m.body));

// ======= Session setup =====
function setupSession(sess, isConf=false) {
  sess.on('accepted', () => {
    log('Call accepted');
    startTimer();
    // Attach remote streams
    const pc = sess.sessionDescriptionHandler.peerConnection;
    pc.getReceivers().forEach(r=>{
      if(r.track && r.track.kind==='video') {
        const v = document.createElement('video'); v.autoplay=true;
        const remoteStream = new MediaStream([r.track]); v.srcObject=remoteStream;
        document.getElementById('video-container').appendChild(v);
      }
      if(r.track && r.track.kind==='audio') log('Audio track received');
    });
  });
  sess.on('terminated', () => {
    log('Call terminated');
    clearInterval(callTimer);
    document.getElementById('timer').textContent='00:00';
    if(!isConf) document.getElementById('video-container').innerHTML='';
  });
}

// ======= Timer =====
let callTimer; function startTimer(){clearInterval(callTimer); let s=0; callTimer=setInterval(()=>{s++; const m=Math.floor(s/60), sec=s%60; document.getElementById('timer').textContent= (m<10?'0'+m:m)+':'+(sec<10?'0'+sec:sec);},1000);}
</script>
</body>
</html>
