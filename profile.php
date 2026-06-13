<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background-color: #f0f2f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .profile-card {
      background-color: #ffffff;
      width: 360px;
      padding: 30px 20px;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .profile-img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 5px solid #4CAF50;
      margin-bottom: 20px;
    }

    .profile-name,
    .profile-role,
    .profile-email {
      margin-top: 6px;
    }

    .profile-name {
      font-size: 24px;
      font-weight: bold;
      color: #333;
    }

    .profile-role {
      font-size: 16px;
      color: #777;
    }

    .profile-email {
      font-size: 14px;
      color: #888;
    }

    .input-field {
      width: 90%;
      padding: 8px;
      font-size: 14px;
      margin: 6px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .buttons {
      margin-top: 20px;
    }

    .buttons button {
      padding: 10px 20px;
      margin: 5px;
      border: none;
      border-radius: 30px;
      font-size: 14px;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn-edit {
      background-color: #4CAF50;
      color: #fff;
    }

    .btn-edit:hover {
      background-color: #45a049;
    }

    .btn-logout {
      background-color: #e53935;
      color: #fff;
    }

    .btn-logout:hover {
      background-color: #d32f2f;
    }

    @media (max-width: 400px) {
      .profile-card {
        width: 90%;
      }
    }
  </style>
</head>
<body>

<div class="profile-card">
  <img src="WhatsApp Image 2025-06-24 at 17.35.18_f28d6c1b.jpg" alt="Profile Picture" class="profile-img">

  <!-- Static Info (view mode) -->
  <div class="profile-name" id="name">John Doe</div>
  <div class="profile-role" id="role">Store Manager</div>
  <div class="profile-email" id="email">john.doe@example.com</div>

  <!-- Editable Inputs (edit mode, hidden by default) -->
  <input type="text" id="nameInput" class="input-field" style="display:none;">
  <input type="text" id="roleInput" class="input-field" style="display:none;">
  <input type="email" id="emailInput" class="input-field" style="display:none;">

  <div class="buttons">
    <button class="btn-edit" onclick="toggleEdit()" id="editBtn">Edit Profile</button>
    <button class="btn-logout">Logout</button>
  </div>
</div>

<script>
  const nameEl = document.getElementById('name');
  const roleEl = document.getElementById('role');
  const emailEl = document.getElementById('email');

  const nameInput = document.getElementById('nameInput');
  const roleInput = document.getElementById('roleInput');
  const emailInput = document.getElementById('emailInput');

  const editBtn = document.getElementById('editBtn');

  let editing = false;

  function toggleEdit() {
    if (!editing) {
      // Enter edit mode
      nameInput.value = nameEl.innerText;
      roleInput.value = roleEl.innerText;
      emailInput.value = emailEl.innerText;

      nameEl.style.display = 'none';
      roleEl.style.display = 'none';
      emailEl.style.display = 'none';

      nameInput.style.display = 'block';
      roleInput.style.display = 'block';
      emailInput.style.display = 'block';

      editBtn.innerText = 'Save';
    } else {
      // Save and switch to view mode
      nameEl.innerText = nameInput.value;
      roleEl.innerText = roleInput.value;
      emailEl.innerText = emailInput.value;

      nameEl.style.display = 'block';
      roleEl.style.display = 'block';
      emailEl.style.display = 'block';

      nameInput.style.display = 'none';
      roleInput.style.display = 'none';
      emailInput.style.display = 'none';

      editBtn.innerText = 'Edit Profile';
    }

    editing = !editing;
  }
</script>

</body>
</html>
