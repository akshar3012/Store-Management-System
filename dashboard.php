<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Super Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f2f5;
    }

    .sidebar {
      height: 100vh;
      background: #1f1f2e;
      color: white;
      padding: 20px;
      position: fixed;
      width: 250px;
    }

    .sidebar h3 {
      margin-bottom: 30px;
    }

    .sidebar a {
      display: block;
      padding: 12px 20px;
      margin-bottom: 12px;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      transition: 0.3s;
    }

    .sidebar a:hover {
      background: #343a40;
    }

    .main-content {
      margin-left: 260px;
      padding: 40px 30px;
    }

    .dashboard-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
      padding: 30px;
      transition: all 0.3s ease;
    }

    .dashboard-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .dashboard-card h4 {
      margin-bottom: 15px;
    }

    .btn-dark {
      width: 100%;
      padding: 10px;
    }

    @media (max-width: 768px) {
      .sidebar {
        position: static;
        width: 100%;
        height: auto;
        margin-bottom: 20px;
      }

      .main-content {
        margin-left: 0;
        padding: 20px;
      }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h3><i class="bi bi-speedometer2 me-2"></i>Super Admin</h3>
    <a href="manage_users.php"><i class="bi bi-person-lines-fill me-2"></i> Manage Users</a>
    <a href="departments.php"><i class="bi bi-diagram-3-fill me-2"></i> Departments</a>
    <a href="product_categories.php"><i class="bi bi-tags-fill me-2"></i> Product Categories</a>
    <a href="products.php"><i class="bi bi-box-seam me-2"></i> Products</a>
    <a href="billing_reports.php"><i class="bi bi-receipt-cutoff me-2"></i> Billing & Reports</a>
    <a href="logout.php" class="bg-danger text-white"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <h2 class="mb-4">Welcome, Super Admin</h2>

    <div class="row g-4">
      <div class="col-md-6 col-lg-4">
        <div class="dashboard-card text-center">
          <h4><i class="bi bi-person-lines-fill"></i> Manage Users</h4>
          <p>Activate, deactivate, or delete user accounts.</p>
          <a href="manage_users.php" class="btn btn-dark">Open</a>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="dashboard-card text-center">
          <h4><i class="bi bi-diagram-3-fill"></i> Departments</h4>
          <p>Create, edit or remove departments.</p>
          <a href="departments.php" class="btn btn-dark">Open</a>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="dashboard-card text-center">
          <h4><i class="bi bi-tags-fill"></i> Product Categories</h4>
          <p>Manage product category types.</p>









          <a href="product_categories.php" class="btn btn-dark">Open</a>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="dashboard-card text-center">
          <h4><i class="bi bi-box-seam"></i> Products</h4>
          <p>View and control product listings.</p>
          <a href="products.php" class="btn btn-dark">Open</a>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="dashboard-card text-center">
          <h4><i class="bi bi-receipt-cutoff"></i> Billing & Reports</h4>
          <p>Review invoice history and analytics.</p>
          <a href="billing_reports.php" class="btn btn-dark">Open</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<a href='logout.php'>Logout</a>