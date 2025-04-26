<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Softphone UI with Advanced Features</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* Base layout */
    body { margin: 0; font-family: Arial, sans-serif; height: 100vh; display: flex; background: #f0f2f5; }
    .sidebar { width: 300px; background: #fff; border-right: 1px solid #ddd; display: flex; flex-direction: column; }
    .main    { flex-grow: 1; background: #f9fafb; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative; }

    /* User info & icons */
    .user-info { padding: 1rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #ddd; }
    .user-info-left { display: flex; align-items: center; gap: 0.5rem; }
    .user-info img { width: 40px; height: 40px; border-radius: 50%; }
    .status       { font-size: 12px; color: green; }
    .user-icons   { display: flex; gap: 0.5rem; }
    .user-icons img { width: 20px; height: 20px; }

    /* Search */
    .search { padding: 0.5rem; border-bottom: 1px solid #ddd; }
    .search input { width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 5px; }

    /* Lines */
    .lines { padding: 0.5rem; border-bottom: 1px solid #ddd; }
    .line { background: #e7f3ff; border: 1px solid #99c7ff; padding: 0.5rem; border-radius: 5px; margin-bottom: 0.5rem; font-size: 14px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; transition: background 0.2s, border-color 0.2s; }
    .line.active { background: #c0e0ff; border-color: #66aaff; }

    /* Calls list */
    .calls-list { flex-grow: 1; overflow-y: auto; padding: 0.5rem; }
    .call-item { padding: 0.5rem; display: flex; align-items: center; gap: 0.5rem; cursor: pointer; border-radius: 5px; transition: background 0.2s; }
    .call-item:hover { background: #eee; }
    .call-item img { width: 30px; height: 30px; border-radius: 50%; }

    /* Call info and controls */
    .call-info { text-align: center; margin-bottom: 2rem; }
    .call-info img { width: 120px; height: 120px; border-radius: 50%; margin-bottom: 1rem; }
    .timer { font-size: 18px; color: #666; margin-top: 0.5rem; }
    .call-controls { position: absolute; bottom: 2rem; display: flex; gap: 1rem; }
    .call-controls button { background: #fff; border: 1px solid #ccc; padding: 0.8rem; border-radius: 50%; cursor: pointer; font-size: 1.4rem; transition: background 0.2s; }
    .call-controls button:hover { background: #f0f0f0; }
    .call-controls button.end { background: red; color: white; border: none; }

    /* Ringing animation */
    @keyframes blink { 0%,50%,100% { opacity: 1; } 25%,75% { opacity: 0; } }
    .call-info.ringing p { animation: blink 1s infinite; color: red; font-weight: bold; }

    /* Keypad popup */
    .keypad-overlay { position: absolute; bottom: 6rem; background: #fff; border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 1rem; display: none; width: 200px; }
    .keypad { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.5rem; }
    .keypad button { padding: 1rem; font-size: 1rem; border: 1px solid #ccc; border-radius: 5px; background: #fafafa; cursor: pointer; transition: background 0.2s, transform 0.1s; }
    .keypad button:hover { background: #f0f0f0; }
    .keypad button:active { transform: scale(0.95); }

    /* Responsive */
    @media (max-width: 600px) { .sidebar { width: 100%; height: 50vh; box-shadow: none; } }
  </style>
</head>
<body>

<div class="sidebar">
  <div class="user-info">
    <div class="user-info-left">
      <img src="avatar1.png" alt="User">
      <div><div>6003</div><div class="status">Registered</div></div>
    </div>
    <div class="user-icons">
      <img src="mic.png" alt="Mic On" id="micIcon">
      <img src="speaker.png" alt="Speaker On" id="speakerIcon">
    </div>
  </div>

  <div class="search"><input type="text" placeholder="Find someone..."></div>

  <div class="lines">
    <div class="line active" data-line="1">Line 1 <span id="line1-status">In Call</span></div>
    <div class="line" data-line="2">Line 2 <span id="line2-status">Available</span></div>
  </div>

  <div class="calls-list">
    <div class="call-item incoming" data-number="1234"><img src="avatar3.png"><div>Incoming: 1234</div></div>
    <div class="call-item" data-number="3346"><img src="avatar2.png"><div>3346</div></div>
    <div class="call-item" data-number="00260977463501"><img src="avatar4.png"><div>00260977463501</div></div>
  </div>
</div>

<div class="main">
  <div class="call-info" id="callInfo">
    <h2 id="callNumber">3346</h2>
    <img src="avatar2.png" alt="Contact">
    <p id="callStatus">Call in Progress...</p>
    <div class="timer" id="timer">00:00</div>
  </div>

  <div class="keypad-overlay" id="keypadOverlay">
    <div class="keypad">
      <button onclick="dial('1')">1</button><button onclick="dial('2')">2</button><button onclick="dial('3')">3</button>
      <button onclick="dial('4')">4</button><button onclick="dial('5')">5</button><button onclick="dial('6')">6</button>
      <button onclick="dial('7')">7</button><button onclick="dial('8')">8</button><button onclick="dial('9')">9</button>
      <button onclick="dial('*')">*</button><button onclick="dial('0')">0</button><button onclick="dial('#')">#</button>
    </div>
  </div>

  <div class="call-controls">
    <button id="muteBtn" onclick="toggleMute()">🔇</button>
    <button id="holdBtn" onclick="toggleHold()">⏸️</button>
    <button id="keypadBtn">⌨️</button>
    <button class="end" id="endBtn" onclick="hangup()">📞</button>
  </div>
</div>

<script>
  // Stub call logic
  function dial(digit) {
    console.log('Dialed', digit);
    // integrate actual SIP.js/WebRTC dial here
  }
  function hangup() { console.log('Hangup call'); }
  function toggleMute() { console.log('Toggle mute'); }
  function toggleHold() { console.log('Toggle hold'); }

  // Timer
  let seconds = 0, minutes = 0;
  const timerEl = document.getElementById('timer');
  let timerInterval;
  function startTimer() {
    clearInterval(timerInterval);
    seconds = 0; minutes = 0;
    timerInterval = setInterval(() => {
      seconds++;
      if (seconds === 60) { seconds = 0; minutes++; }
      timerEl.textContent = (minutes<10? '0'+minutes:minutes) + ':' + (seconds<10? '0'+seconds:seconds);
    }, 1000);
  }

  // Line switching
  document.querySelectorAll('.line').forEach(line => {
    line.addEventListener('click', () => {
      document.querySelector('.line.active').classList.remove('active');
      line.classList.add('active');
      const ln = line.dataset.line;
      document.getElementById('callNumber').textContent = 'Line ' + ln;
      document.getElementById('callStatus').textContent = line.querySelector('span').textContent;
      document.getElementById('callInfo').classList.remove('ringing');
      startTimer();
    });
  });

  // Incoming ringing
  document.querySelectorAll('.call-item.incoming').forEach(item => {
    item.addEventListener('click', () => {
      const num = item.dataset.number;
      const info = document.getElementById('callInfo');
      document.getElementById('callNumber').textContent = num;
      document.getElementById('callStatus').textContent = 'Incoming Call...';
      info.classList.add('ringing');
      clearInterval(timerInterval);
    });
  });

  // Keypad popup
  const keypadBtn = document.getElementById('keypadBtn');
  const keypadOverlay = document.getElementById('keypadOverlay');
  keypadBtn.addEventListener('click', () => {
    keypadOverlay.style.display = keypadOverlay.style.display === 'block' ? 'none' : 'block';
  });

  // Start initial timer
  startTimer();
</script>

</body>
</html>
