<?php
// DB connection setup
$host = "localhost";
$db = "store_mng";
$user = "root";
$pass = "";

try {
  $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}
// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
  $action = $_POST['action'];

  if ($action === 'save_user') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $nameParts = explode(' ', $_POST['name'], 2);
    $first_name = $nameParts[0];
    $last_name = $nameParts[1] ?? '';
    $dob = $_POST['dob'];
    $mobile = $_POST['mobile'];
    $role = $_POST['role'];

    $roleMap = ['Super Admin'=>1, 'Store Admin'=>2, 'Manager'=>3, 'Salesperson'=>4];
    $role_id = $roleMap[$role] ?? 4;

    $photo_url = null;
    if (!empty($_FILES['photo']['tmp_name'])) {
      $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
      $uploadPath = "upload/profile" . time() . "." . $ext;
      move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath);
      $photo_url = $uploadPath;
    } else {
      $stmt = $pdo->prepare("SELECT photo_url FROM tbl_users WHERE id=?");
      $stmt->execute([$id]);
      $photo_url = $stmt->fetchColumn();
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tbl_users WHERE id=?");
    $stmt->execute([$id]);
    $exists = $stmt->fetchColumn();

    if ($exists) {
      $query = "UPDATE tbl_users SET username=?, first_name=?, last_name=?, dob=?, mobile=?, role_id=?";
      $params = [$username, $first_name, $last_name, $dob, $mobile, $role_id];
      if ($photo_url) {
        $query .= ", photo_url=?";
        $params[] = $photo_url;
      }
      $query .= " WHERE id=?";
      $params[] = $id;
      $stmt = $pdo->prepare($query);
      $stmt->execute($params);
    } else {
      $stmt = $pdo->prepare("INSERT INTO tbl_users (id, first_name, last_name, dob, username, mobile, password, role_id, is_active, photo_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, ?)");
      $stmt->execute([$id, $first_name, $last_name, $dob, $username, $mobile, '123456', $role_id, $photo_url ?? '']);
    }
    exit;
  }

  if ($action === 'delete_user') {
    $stmt = $pdo->prepare("DELETE FROM tbl_users WHERE id=?");
    $stmt->execute([$_POST['id']]);
    exit;
  }

  if ($action === 'promote_user') {
    $id = $_POST['id'];
    $role = $_POST['role'];
    $roleMap = ['Super Admin'=>1, 'Store Admin'=>2, 'Manager'=>3, 'Salesperson'=>4];
    $role_id = $roleMap[$role] ?? 4;
    $stmt = $pdo->prepare("UPDATE tbl_users SET role_id=? WHERE id=?");
    $stmt->execute([$role_id, $id]);
    exit;
  }

  if ($action === 'toggle_active') {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $stmt = $pdo->prepare("UPDATE tbl_users SET is_active=? WHERE id=?");
    $stmt->execute([$status, $id]);
    exit;
  }

  exit;
}

// Fetch user list
$users = $pdo->query("
  SELECT 
    id, 
    CONCAT(first_name, ' ', last_name) AS name, 
    dob, 
    username,
    mobile,
    is_active,
    CASE role_id
      WHEN 1 THEN 'Super Admin'
      WHEN 2 THEN 'Store Admin'
      WHEN 3 THEN 'Manager'
      WHEN 4 THEN 'Salesperson'
      ELSE 'Unknown'
    END AS role,
    COALESCE(photo_url, 'https://via.placeholder.com/120') AS photo_url
  FROM tbl_users
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage Users</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    body {
      background-color: #f4f6fa;
      font-family: 'Segoe UI', sans-serif;
      padding: 40px 20px;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #1f1f2e;
    }
    .user-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      max-width: 1300px;
      margin: auto;
    }
    .user-card {
      background-color: #fff;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.2);
      text-align: center;
      transition: transform 0.3s;
    }
    .user-card:hover {
      transform: scale(1.02);
    }
    .inactive-user {
      background-color: #f0f0f0 !important;
      filter: grayscale(100%);
      opacity: 0.7;
      box-shadow: none;
    }
    .profile-img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      border: 4px solid #1f1f2e;
      margin-bottom: 15px;
    }
    .user-details h3 {
      margin-bottom: 8px;
      font-size: 18px;
      color: #333;
    }
    .user-details p {
      font-size: 14px;
      margin: 4px 0;
      color: #555;
    }
    .btn-group {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      margin-top: 15px;
      gap: 10px;
    }
    .btn {
      padding: 8px 10px;
      border: none;
      border-radius: 6px;
      font-size: 14px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .btn-edit { background-color: #ffc107; color: #000; }
    .btn-delete { background-color: #dc3545; color: #fff; }
    .btn-promote { background-color: #007bff; color: #fff; }
    .btn-save { background-color: #28a745; color: #fff; }
    .btn-cancel { background-color: #6c757d; color: #fff; }
    .btn-edit:hover { background-color: #e0a800; }
    .btn-delete:hover { background-color: #c82333; }
    .btn-promote:hover { background-color: #0069d9; }
    .modal {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0; top: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background: white;
      padding: 20px 30px;
      border-radius: 10px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.25);
    }
    .modal-content input, .modal-content select {
      width: 100%;
      padding: 8px;
      border-radius: 6px;
      border: 1px solid #ccc;
      margin-bottom: 10px;
    }
    .modal-buttons {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
    }
  </style>
</head>
<body>

<div style="text-align: center; margin-bottom: 20px;">
  <h1>Manage Users</h1>
  <button class="btn btn-save" onclick="exportToExcel()">Export to Excel</button>
</div>

<div style="text-align: center; margin: 10px 0;">
  <label for="statusFilter"><strong>Filter:</strong></label>
  <select id="statusFilter" onchange="filterUsers()">
    <option value="all">All Users</option>
    <option value="active">Active Only</option>
    <option value="inactive">Inactive Only</option>
  </select>
</div>

<div class="user-container">
  <?php foreach ($users as $user): ?>
    <?php
      $roleClass = strtolower(str_replace(' ', '-', $user['role']));
      $inactiveClass = $user['is_active'] == 0 ? 'inactive-user' : '';
    ?>
    <div class="user-card <?= $roleClass ?> <?= $inactiveClass ?>"
  data-id="<?= htmlspecialchars($user['id']) ?>"
  data-username="<?= htmlspecialchars($user['username']) ?>"
  data-name="<?= htmlspecialchars($user['name']) ?>"
  data-dob="<?= htmlspecialchars($user['dob']) ?>"
  data-mobile="<?= htmlspecialchars($user['mobile']) ?>"
  data-role="<?= htmlspecialchars($user['role']) ?>"
  data-photo="<?= htmlspecialchars($user['photo_url']) ?>"
  data-status="<?= $user['is_active'] ?>"
    >
      <img src="<?= htmlspecialchars($user['photo_url']) ?>" class="profile-img" />
      <div class="user-details">
        <h3>ID: <?= htmlspecialchars($user['id']) ?></h3>
        <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
        <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
        <p><strong>DOB:</strong> <?= htmlspecialchars($user['dob']) ?></p>
        <p><strong>Mobile:</strong> +91 <?= htmlspecialchars($user['mobile']) ?></p>
        <p><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
        <p>
  <strong>Status:</strong>
  <?php if ($user['is_active'] == 1): ?>
    <span style="color: green; font-weight: bold;">Active</span>
  <?php else: ?>
    <span style="color: red; font-weight: bold;">Inactive</span>
  <?php endif; ?>
</p>

      </div>
      <div class="btn-group">
  <?php if ($user['is_active'] == 0): ?>
    <button class="btn btn-save" onclick="toggleActive(this, 1)">Activate</button>
  <?php else: ?>
    <button class="btn btn-edit" onclick="openEditModal(this)">Edit</button>
    <button class="btn btn-delete" onclick="deleteUser(this)">Delete</button>
    <button class="btn btn-promote" onclick="openPromoteModal(this)">Role</button>
    <button class="btn btn-delete" onclick="toggleActive(this, 0)">Deactivate</button>
  <?php endif; ?>
</div>
    </div>
  <?php endforeach; ?>
</div>

<!-- Edit Modal -->
<div class="modal" id="editModal">
  <div class="modal-content">
    <h3>Edit/Add User</h3>
    <form id="editForm" enctype="multipart/form-data">
      <input type="text" id="editId" name="id" placeholder="ID" required />
      <input type="text" id="editUsername" name="username" placeholder="Username" required />
      <input type="text" id="editName" name="name" placeholder="Full Name" required />
      <input type="date" id="editDOB" name="dob" required />
      <input type="text" id="editMobile" name="mobile" placeholder="Mobile" required pattern="\d{10}" maxlength="10" title="Enter 10 digit mobile number" />
      <input type="text" id="editRole" name="role" placeholder="Role" required />
      <input type="file" id="editPhoto" name="photo" accept="image/*" />
      <img id="photoPreview" src="https://via.placeholder.com/120" class="profile-img" style="margin-top:10px;" />
      <div class="modal-buttons">
        <button type="button" class="btn-cancel" onclick="closeModal('editModal')">Cancel</button>
        <button type="submit" class="btn-save">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Promote Modal -->
<div class="modal" id="promoteModal">
  <div class="modal-content">
    <h3>Manage User</h3>
    <select id="newRole">
      <option>Salesperson</option>
      <option>Manager</option>
      <option>Store Admin</option>
      <option>Super Admin</option>
    </select>
    <div class="modal-buttons">
      <button type="button" class="btn-cancel" onclick="closeModal('promoteModal')">Cancel</button>
      <button type="button" class="btn-save" onclick="applyPromotion()">Promote</button>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
let currentCard = null;

function openEditModal(button) {
  currentCard = button.closest('.user-card');
  document.getElementById('editId').value = currentCard.dataset.id;
  document.getElementById('editUsername').value = currentCard.dataset.username;
  document.getElementById('editName').value = currentCard.dataset.name;
  document.getElementById('editDOB').value = currentCard.dataset.dob;
  document.getElementById('editMobile').value = currentCard.dataset.mobile;
  document.getElementById('editRole').value = currentCard.dataset.role;
  document.getElementById('photoPreview').src = currentCard.dataset.photo || "https://via.placeholder.com/120";
  document.getElementById('editPhoto').value = '';
  document.getElementById('editModal').style.display = 'flex';
}

document.getElementById('editPhoto').addEventListener('change', function (e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById('photoPreview').src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
});

document.getElementById('editForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const formData = new FormData(this);
  formData.append('action', 'save_user');
  fetch('', {
    method: 'POST',
    body: formData
  }).then(() => location.reload());
});

function deleteUser(button) {
  if (confirm("Are you sure?")) {
    const id = button.closest('.user-card').dataset.id;
    const formData = new FormData();
    formData.append('action', 'delete_user');
    formData.append('id', id);
    fetch('', { method: 'POST', body: formData }).then(() => location.reload());
  }
}

function openPromoteModal(button) {
  currentCard = button.closest('.user-card');
  document.getElementById('newRole').value = currentCard.dataset.role;
  document.getElementById('promoteModal').style.display = 'flex';
}

function applyPromotion() {
  const formData = new FormData();
  formData.append('action', 'promote_user');
  formData.append('id', currentCard.dataset.id);
  formData.append('role', document.getElementById('newRole').value);
  fetch('', { method: 'POST', body: formData }).then(() => location.reload());
}

function toggleActive(button, status) {
  const id = button.closest('.user-card').dataset.id;
  const formData = new FormData();
  formData.append('action', 'toggle_active');
  formData.append('id', id);
  formData.append('status', status);
  fetch('', {
    method: 'POST',
    body: formData
  }).then(() => location.reload());
}

function closeModal(id) {
  document.getElementById(id).style.display = 'none';
}

window.addEventListener('click', function(e) {
  if (e.target.classList.contains('modal')) e.target.style.display = 'none';
});

function exportToExcel() {
  const rows = [["ID", "Name", "DOB", "Mobile", "Role"]];
  document.querySelectorAll('.user-card').forEach(card => {
    rows.push([
      card.dataset.id,
      card.dataset.name,
      card.dataset.dob,
      card.dataset.mobile,
      card.dataset.role
    ]);
  });

  const wb = XLSX.utils.book_new();
  const ws = XLSX.utils.aoa_to_sheet(rows);
  XLSX.utils.book_append_sheet(wb, ws, "Users");
  XLSX.writeFile(wb, "users.xlsx");
}

function filterUsers() {
  const filter = document.getElementById('statusFilter').value;
  const container = document.querySelector('.user-container');
  const cards = Array.from(document.querySelectorAll('.user-card'));

  let filtered = cards.filter(card => {
    const status = card.dataset.status;
    return (
      filter === 'all' ||
      (filter === 'active' && status === '1') ||
      (filter === 'inactive' && status === '0')
    );
  });

  // Sort active (1) before inactive (0)
  filtered.sort((a, b) => parseInt(b.dataset.status) - parseInt(a.dataset.status));

  // Clear and re-add filtered & sorted cards
  container.innerHTML = '';
  filtered.forEach(card => container.appendChild(card));
}
</script>

</body>
</html>