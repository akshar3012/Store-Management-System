<?php
// DB Config
$host = 'localhost';
$db   = 'store_mng';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}

// Add or Update Category
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $catName = trim($_POST['category_name']);
    $gstRate = isset($_POST['gst_rate']) ? floatval($_POST['gst_rate']) : 0;
    $catId = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;

    if ($catName !== '') {
        if ($catId > 0) {
            $stmt = $pdo->prepare("UPDATE categories_1 SET name = :name, gst_rate = :gst WHERE id = :id");
            $stmt->execute(['name' => $catName, 'gst' => $gstRate, 'id' => $catId]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO categories_1 (name, gst_rate) VALUES (:name, :gst)");
            $stmt->execute(['name' => $catName, 'gst' => $gstRate]);
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Remove Category
if (isset($_GET['remove_id'])) {
    $removeId = intval($_GET['remove_id']);
    $stmt = $pdo->prepare("DELETE FROM categories_1 WHERE id = :id");
    $stmt->execute(['id' => $removeId]);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Get all categories
$stmt = $pdo->query("SELECT * FROM categories_1 ORDER BY name ASC");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Manage Product Categories</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style>
  body {
    font-family: Arial, sans-serif;
    background: #f5f7fa;
    margin: 0; padding: 20px;
  }
  h1 {
    text-align: center;
    color: #2c3e50;
  }
  .container {
    max-width: 700px;
    margin: 20px auto;
    background: white;
    padding: 20px 30px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgb(0 0 0 / 0.1);
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }
  th, td {
    padding: 12px 15px;
    border-bottom: 1px solid #eee;
    text-align: left;
  }
  th {
    background-color: #f0f3f5;
  }
  .remove-btn, .edit-btn {
    padding: 6px 12px;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    color: white;
    cursor: pointer;
    transition: background 0.3s ease;
  }
  .remove-btn {
    background: #e74c3c;
  }
  .remove-btn:hover {
    background: #c0392b;
  }
  .edit-btn {
    background: #3498db;
  }
  .edit-btn:hover {
    background: #2980b9;
  }
  .add-btn {
    background: #27ae60;
    color: white;
    padding: 10px 18px;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 15px;
    cursor: pointer;
    transition: background 0.3s ease;
  }
  .add-btn:hover {
    background: #219150;
  }

  /* Modal */
  .modal {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    justify-content: center;
    align-items: center;
  }
  .modal-content {
    background: white;
    padding: 25px;
    border-radius: 10px;
    width: 90%;
    max-width: 400px;
    position: relative;
  }
  .modal-content h2 {
    margin-top: 0;
    color: #2c3e50;
  }
  .modal-content input {
    width: 100%;
    padding: 10px;
    margin-top: 12px;
    border: 1.5px solid #ccc;
    border-radius: 6px;
  }
  .modal-content .close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 22px;
    font-weight: bold;
    color: #888;
    cursor: pointer;
  }
  .modal-content .close:hover {
    color: #e74c3c;
  }
</style>
</head>
<body>

<h1>Manage Product Categories</h1>

<div class="container">
  <button class="add-btn" onclick="openModal()">+ Add Category</button>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Category Name</th>
        <th>GST Rate (%)</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($categories): foreach ($categories as $index => $cat): ?>
        <tr>
          <td><?= $index + 1 ?></td>
          <td><?= htmlspecialchars($cat['name']) ?></td>
          <td><?= number_format($cat['gst_rate'], 2) ?></td>
          <td>
            <button class="edit-btn" onclick="openModal(<?= $cat['id'] ?>, '<?= addslashes($cat['name']) ?>', <?= $cat['gst_rate'] ?>)">Edit</button>
            <a href="?remove_id=<?= $cat['id'] ?>" class="remove-btn" onclick="return confirm('Remove this category?')">Remove</a>
          </td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="4" style="text-align:center;">No categories found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Modal -->
<div class="modal" id="categoryModal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2 id="modalTitle">Add Category</h2>
    <form method="POST">
      <input type="hidden" name="category_id" id="category_id" value="0">
      <input type="text" name="category_name" id="category_name" placeholder="Category name" required>
      <input type="number" step="0.01" min="0" name="gst_rate" id="gst_rate" placeholder="GST Rate (%)" required>
      <button type="submit" name="add_category" class="add-btn">Save</button>
    </form>
  </div>
</div>

<script>
  const modal = document.getElementById('categoryModal');
  const categoryIdInput = document.getElementById('category_id');
  const categoryNameInput = document.getElementById('category_name');
  const gstRateInput = document.getElementById('gst_rate');
  const modalTitle = document.getElementById('modalTitle');

  function openModal(id = 0, name = '', gst = '') {
    modal.style.display = 'flex';
    categoryIdInput.value = id;
    categoryNameInput.value = name;
    gstRateInput.value = gst;
    modalTitle.textContent = id ? 'Edit Category' : 'Add Category';
  }

  function closeModal() {
    modal.style.display = 'none';
    categoryIdInput.value = 0;
    categoryNameInput.value = '';
    gstRateInput.value = '';
  }

  window.onclick = function(event) {
    if (event.target === modal) {
      closeModal();
    }
  }
</script>

</body>
</html>
