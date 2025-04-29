<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>SIP.js Softphone UI</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Include SIP.js from CDN -->
  <script src="https://unpkg.com/sip.js@0.32.1/dist/sip.min.js"></script>
  <style>
    /* (same CSS styling as before) */
    body { margin: 0; font-family: Arial, sans-serif; height: 100vh; display: flex; background: #f0f2f5; }
    .sidebar { width: 300px; background: #fff; border-right: 1px solid #ddd; display: flex; flex-direction: column; }
    .main    { flex-grow: 1; background: #f9fafb; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative; }
    .user-info { padding: 1rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #ddd; }
    .user-info-left { display: flex; align-items: center; gap: 0.5rem; }
    .user-info img { width: 40px; height: 40px; border-radius: 50%; }
    .status       { font-size: 12px; color: green; }
    .user-icons   { display: flex; gap: 0.5rem; }
    .user-icons img { width: 20px; height: 20px; }
    .search { padding: 0.5rem; border-bottom: 1px solid #ddd; }
    .search input { width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 5px; }
    .lines { padding: 0.5rem; border-bottom: 1px solid #ddd; }
    .line { background: #e7f3ff; border: 1px solid #99c7ff; padding: 0.5rem; border-radius: 5px; margin-bottom: 0.5rem; font-size: 14px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; transition: background 0.2s, border-color 0.2s; }
    .line.active { background: #c0e0ff; border-color: #66aaff; }
    .calls-list { flex-grow: 1; overflow-y: auto; padding: 0.5rem; }
    .call-item { padding: 0.5rem; display: flex; align-items: center; gap: 0.5rem; cursor: pointer; border-radius: 5px; transition: background 0.2s; }
    .call-item:hover { background: #eee; }
    .call-item img { width: 30px; height: 30px; border-radius: 50%; }
    .call-info { text-align: center; margin-bottom: 2rem; }
    .call-info img { width: 120px; height: 120px; border-radius: 50%; margin-bottom: 1rem; }
    .timer { font-size: 18px; color: #666; margin-top: 0.5rem; }
    .call-controls { position: absolute; bottom: 2rem; display: flex; gap: 1rem; }
    .call-controls button { background: #fff; border: 1px solid #ccc; padding: 0.8rem; border-radius: 50%; cursor: pointer; font-size: 1.4rem; transition: background 0.2s; }
    .call-controls button:hover { background: #f0f0f0; }
    .call-controls button.end { background: red; color: white; border: none; }
    @keyframes blink { 0%,50%,100% { opacity: 1; } 25%,75% { opacity: 0; } }
    .call-info.ringing p { animation: blink 1s infinite; color: red; font-weight: bold; }
    .keypad-overlay { position: absolute; bottom: 6rem; background: #fff; border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 1rem; display: none; width: 200px; }
    .keypad { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.5rem; }
    .keypad button { padding: 1rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 5px; background: #fafafa; cursor: pointer; transition: background 0.2s, transform 0.1s; }
    .keypad button:hover { background: #f0f0f0; }
    .keypad button:active { transform: scale(0.95); }
    @media (max-width: 600px) { .sidebar { width: 100%; height: 50vh; box-shadow: none; } }
  </style>
</head>
<body>

<div class="sidebar">
  <div class="user-info">
    <div class="user-info-left">
      <img src="avatar1.png" alt="User">
      <div><div id="myExtension">6003</div><div class="status" id="regStatus">Registering...</div></div>
    </div>
    <div class="user-icons">
      <img src="mic.png" alt="Mic" id="micIcon">
      <img src="speaker.png" alt="Speaker" id="speakerIcon">
    </div>
  </div>
  <div class="search"><input type="text" placeholder="Find someone..."></div>
  <div class="lines">
    <div class="line active" data-line="1">Line 1 <span id="line1-status">Idle</span></div>
    <div class="line" data-line="2">Line 2 <span id="line2-status">Idle</span></div>
  </div>
  <div class="calls-list">
    <div class="call-item" data-number="1001"><img src="avatar2.png"><div>1001</div></div>
    <div class="call-item incoming" data-number="1002"><img src="avatar3.png"><div>Incoming: 1002</div></div>
  </div>
</div>

<div class="main">
  <div class="call-info" id="callInfo">
    <h2 id="callNumber">--</h2>
    <img src="avatar2.png" alt="Contact">
    <p id="callStatus">No Call</p>
    <div class="timer" id="timer">00:00</div>
  </div>
  <div class="keypad-overlay" id="keypadOverlay">
    <div class="keypad">
      <button onclick="sendDTMF('1')">1</button><button onclick="sendDTMF('2')">2</button><button onclick="sendDTMF('3')">3</button>
      <button onclick="sendDTMF('4')">4</button><button onclick="sendDTMF('5')">5</button><button onclick="sendDTMF('6')">6</button>
      <button onclick="sendDTMF('7')">7</button><button onclick="sendDTMF('8')">8</button><button onclick="sendDTMF('9')">9</button>
      <button onclick="sendDTMF('*')">*</button><button onclick="sendDTMF('0')">0</button><button onclick="sendDTMF('#')">#</button>
    </div>
  </div>
  <div class="call-controls">
    <button id="muteBtn">🔇</button>
    <button id="holdBtn">⏸️</button>
    <button id="keypadBtn">⌨️</button>
    <button class="end" id="endBtn">📞</button>
  </div>
</div>

<script>
// SIP.js configuration
const userURI = '6003@example.com';
const password = 'supersecret';
const targetServer = 'wss://sip-ws.example.com';

// Create UserAgent
const ua = new SIP.UA({
  uri: userURI,
  transportOptions: { wsServers: [ targetServer ] },
  authorizationUser: userURI.split('@')[0],
  password: password,
  sessionDescriptionHandlerFactoryOptions: { constraints: { audio: true, video: false } }
});

let currentSession = null;
let timerInterval;

ua.on('registered', () => document.getElementById('regStatus').textContent = 'Registered');
ua.on('registrationFailed', () => document.getElementById('regStatus').textContent = 'Reg Failed');

// Handle incoming call
ua.on('invite', session => {
  currentSession = session;
  setupSession(session);
  document.getElementById('callNumber').textContent = session.remoteIdentity.uri.user;
  document.getElementById('callStatus').textContent = 'Incoming Call...';
  document.getElementById('callInfo').classList.add('ringing');
  session.on('accepted', () => onCallAccepted());
  session.on('terminated', () => onCallTerminated());
});

// UI events
function setupSession(session) {
  // Answer automatically for demo
  session.accept();
}

function onCallAccepted() {
  document.getElementById('callStatus').textContent = 'Call in Progress';
  document.getElementById('callInfo').classList.remove('ringing');
  startTimer();
}

function onCallTerminated() {
  document.getElementById('callStatus').textContent = 'No Call';
  clearInterval(timerInterval);
  document.getElementById('timer').textContent = '00:00';
}

// Outgoing call
document.querySelectorAll('.call-item').forEach(item => {
  item.addEventListener('click', () => {
    const number = item.dataset.number;
    if (currentSession) currentSession.terminate();
    currentSession = ua.invite(number + '@example.com');
    setupSession(currentSession);
  });
});

// Controls
document.getElementById('endBtn').addEventListener('click', () => currentSession && currentSession.bye());
document.getElementById('muteBtn').addEventListener('click', () => currentSession && currentSession.sessionDescriptionHandler.toggleMute());
document.getElementById('holdBtn').addEventListener('click', () => currentSession && currentSession.hold());

// DTMF
function sendDTMF(tone) {
  if (currentSession) currentSession.dtmf(tone);
}

// Timer
function startTimer() {
  clearInterval(timerInterval);
  let seconds=0, minutes=0;
  timerInterval = setInterval(() => {
    seconds++;
    if (seconds===60) { seconds=0; minutes++; }
    document.getElementById('timer').textContent = (minutes<10? '0'+minutes:minutes) + ':' + (seconds<10? '0'+seconds:seconds);
  },1000);
}

// Keypad toggle
const keypadBtn = document.getElementById('keypadBtn');
const keypadOverlay = document.getElementById('keypadOverlay');
keypadBtn.addEventListener('click', () => keypadOverlay.style.display = keypadOverlay.style.display==='block'? 'none':'block');
</script>

</body>
</html>
