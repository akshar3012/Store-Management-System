<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Store Settings Panel</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: #1f1f2e;
      color: #f0f0f0;
      display: flex;
      min-height: 100vh;
      overflow: hidden;
    }

    .sidebar {
      width: 240px;
      background: #1f1f2e;
      border-right: 2px solid #29293d;
      padding: 30px 20px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .sidebar h2 {
      color: #ffffff;
      margin-bottom: 30px;
      font-size: 22px;
    }

    .sidebar ul {
      list-style: none;
    }

    .sidebar ul li {
      background: #29293d;
      padding: 12px 15px;
      margin-bottom: 10px;
      border-radius: 8px;
      cursor: pointer;
      color: #f0f0f0;
      transition: background 0.3s ease;
    }

    .sidebar ul li:hover,
    .sidebar ul li.active {
      background: #3d3d5c;
    }

    .sidebar-buttons {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-top: 30px;
    }

    .sidebar-buttons button {
      background: #3d3d5c;
      color: white;
      border: none;
      border-radius: 6px;
      padding: 10px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .sidebar-buttons button:hover {
      background: #56567a;
    }

    .main-content {
      flex: 1;
      padding: 40px;
      background: #f7f7f9;
      overflow-y: auto;
      position: relative;
    }

    h2 {
      margin-bottom: 20px;
      font-size: 22px;
      color: #060000;
    }

    .setting-box {
      background: #29293d;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 8px rgba(0,0,0,0.2);
      margin-bottom: 30px;
    }

    .setting-box label {
      display: block;
      margin-bottom: 6px;
      font-weight: 500;
      color: #f4eeee;
    }

    .setting-box input,
    .setting-box textarea,
    .setting-box select {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      background: #e9e9ed;
      border: 1px solid #444;
      border-radius: 8px;
      color: #000000;
      font-size: 14px;
    }

    .setting-box textarea {
      resize: vertical;
    }

    .setting-box button {
      background: #3d3d5c;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s;
    }

    .setting-box button:hover {
      background: #56567a;
    }

    .section {
      display: none;
      animation: fadeSlide 0.4s ease-in-out;
    }

    .section.active {
      display: block;
    }

    @keyframes fadeSlide {
      from {
        opacity: 0;
        transform: translateY(15px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (max-width: 768px) {
      body {
        flex-direction: column;
      }

      .sidebar {
        width: 100%;
        flex-direction: column;
        align-items: center;
        border-right: none;
        border-bottom: 2px solid #29293d;
      }

      .sidebar h2 {
        display: none;
      }

      .sidebar ul {
        flex-direction: row;
        gap: 10px;
        display: flex;
        width: 100%;
      }

      .sidebar ul li {
        flex: 1;
        text-align: center;
      }

      .main-content {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <div>
      <h2>⚙ Settings</h2>
      <ul>
        <li class="tab active" data-tab="policies">Store Policies</li>
        <li class="tab" data-tab="appearance">System Appearance</li>
      </ul>
    </div>
    <div class="sidebar-buttons">
      <button onclick="alert('Help Documentation Coming Soon!')">Help</button>
      <button onclick="logout()">Logout</button>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="section active" id="policies">
      <h2>Define Store Policies</h2>
      <div class="setting-box">
        <label>Return Policy</label>
        <textarea rows="4" placeholder="Write return policy..."></textarea>
        <label>Privacy Policy</label>
        <textarea rows="4" placeholder="Write privacy policy..."></textarea>
        <button>Save Policies</button>
      </div>
    </div>

    <div class="section" id="appearance">
      <h2>Customize System Appearance</h2>
      <div class="setting-box">
      
         <label>Dark Mode</label>
        <select>
          <option>Enable</option>
          <option>Disable</option>
        </select>
        <button>Apply Changes</button>
      </div>
    </div>

  </div>

  <script>
    const tabs = document.querySelectorAll('.tab');
    const sections = document.querySelectorAll('.section');

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        sections.forEach(s => s.classList.remove('active'));
        tab.classList.add('active');
        document.getElementById(tab.dataset.tab).classList.add('active');
      });
    });

    function logout() {
      alert("Logging out...");
      window.location.href = "login.html"; // Simulated logout
    }
  </script>

</body>
</html>