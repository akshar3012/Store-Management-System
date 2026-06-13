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
      background: linear-gradient(to right, #eef1f5, #f9fbff);
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }

    /* Decorative Wave */
    .header-wave {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      z-index: -1;
    }

    /* Navbar */
    .navbar-custom {
      background-color: #1f1f2e;
      color: white;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1040;
      padding: 0.75rem 1rem;
    }

    .navbar-custom .nav-link,
    .navbar-custom .navbar-brand {
      color: white !important;
    }

    .dropdown-menu {
      background-color: #343a40;
    }

    .dropdown-menu a {
      color: white;
    }

    .dropdown-menu a:hover {
      background-color: #495057;
    }

    .toggle-btn {
      font-size: 26px;
      color: white;
      border: none;
      background: transparent;
      margin-right: 15px;
      position: relative;
      z-index: 1060;
    }

    .toggle-btn i {
      transition: transform 0.3s ease;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 56px;
      left: -250px;
      width: 250px;
      height: calc(100% - 56px);
      background: #1f1f2e;
      padding: 20px;
      color: white;
      transition: all 0.4s ease-in-out;
      z-index: 1050;
    }

    .sidebar.active {
      left: 0;
    }

    .sidebar h3 {
      margin-top: 30px;
      margin-bottom: 30px;
    }

    .sidebar a {
      display: block;
      color: white;
      text-decoration: none;
      padding: 12px 20px;
      margin-bottom: 10px;
      border-radius: 8px;
      transition: background 0.3s ease;
    }

    .sidebar a:hover {
      background: #343a40;
    }

    /* Main Content */
    .main-content {
      padding: 100px 30px 30px 30px;
      transition: margin-left 0.3s ease;
    }

    .main-content.shifted {
      margin-left: 250px;
    }

    /* Dashboard Cards */
    .dashboard-card {
      background: rgb(255, 255, 255);
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
      padding: 30px;
      transition: all 0.3s ease;
      height: 100%;
      position: relative;
      overflow: hidden;
    }

    .dashboard-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .dashboard-card h4 {
      margin-bottom: 15px;
      font-weight: 600;
    }

    .dashboard-card p {
      font-size: 0.95rem;
      color: #555;
    }

    .dashboard-card .bi {
      font-size: 28px;
      color: #6c63ff;
      margin-bottom: 10px;
      transition: transform 0.3s ease;
    }

    .dashboard-card:hover .bi {
      transform: scale(1.2);
    }

    .dashboard-card::before {
      content: "";
      position: absolute;
      top: -20px;
      right: -20px;
      width: 100px;
      height: 100px;
      background: rgba(108, 99, 255, 0.1);
      border-radius: 50%;
      z-index: 0;
    }

    .dashboard-card * {
      position: relative;
      z-index: 1;
    }

    @media (min-width: 768px) {
      .main-content.shifted {
        margin-left: 250px;
      }
    }
  </style>
</head>
<body>

  <!-- Decorative SVG Wave -->
  <svg class="header-wave" height="130" viewBox="0 0 300 150" preserveAspectRatio="none">
    <path d="M0.00,49.98 C181.56,204.52 347.31,-55.37 500.00,49.98 L500.00,0.00 L0.00,0.00 Z"
      style="stroke: none; fill:  #1f1f2e;"></path>
  </svg>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
      <button class="toggle-btn" id="sidebarToggle"><i class="bi bi-list"></i></button>
      <a class="navbar-brand" href="#">Super Admin Panel</a>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle"></i> Admin
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
            <li><a class="dropdown-item" href="setting.php">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <h3><i class="bi bi-speedometer2 me-2"></i>Dashboard</h3>
    <a href="manageusers.php"><i class="bi bi-person-lines-fill me-2"></i> Manage Users</a>
    <a href="deparment.php"><i class="bi bi-diagram-3-fill me-2"></i> Departments</a>
    <a href="Pro_catagories.php"><i class="bi bi-tags-fill me-2"></i> Product Categories</a>
    <a href="product.php"><i class="bi bi-box-seam me-2"></i> Products</a>
    <a href="billing.php"><i class="bi bi-receipt-cutoff me-2"></i> Billing & Reports</a>
    <a href="logout.php" class="bg-danger text-white"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
  </div>

  <!-- Main Content -->
  <div class="main-content" id="mainContent">
    <h2 class="mb-4">Welcome, Super Admin</h2>
    <div class="row g-4">
      <!-- Cards as shown before -->
      <div class="col-md-6 col-lg-4">
        <div class="dashboard-card text-center">
          <i class="bi bi-person-lines-fill"></i>
          <h4>Manage Users</h4>
          <p>Activate, deactivate, or delete user accounts.</p>
          <a href="manageusers.php" class="btn btn-dark w-100">Open</a>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="dashboard-card text-center">
          <i class="bi bi-diagram-3-fill"></i>
          <h4>Departments</h4>
          <p>Create, edit or remove departments.</p>
          <a href="deparment.php" class="btn btn-dark w-100">Open</a>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="dashboard-card text-center">
          <i class="bi bi-tags-fill"></i>
          <h4>Product Categories</h4>
          <p>Manage product category types.</p>
          <a href="Pro_catagories.php" class="btn btn-dark w-100">Open</a>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="dashboard-card text-center">
          <i class="bi bi-box-seam"></i>
          <h4>Products</h4>
          <p>View and control product listings.</p>
          <a href="product.php" class="btn btn-dark w-100">Open</a>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="dashboard-card text-center">
          <i class="bi bi-receipt-cutoff"></i>
          <h4>Billing & Reports</h4>
          <p>Review invoice history and analytics.</p>
          <a href="billing.php" class="btn btn-dark w-100">Open</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleIcon = sidebarToggle.querySelector('i');

    sidebarToggle.addEventListener('click', () => {
      sidebar.classList.toggle('active');
      mainContent.classList.toggle('shifted');

      const isOpen = sidebar.classList.contains('active');
      toggleIcon.classList.remove(isOpen ? 'bi-list' : 'bi-x');
      toggleIcon.classList.add(isOpen ? 'bi-x' : 'bi-list');
      toggleIcon.style.transform = isOpen ? 'rotate(90deg)' : 'rotate(0deg)';
    });
  </script>
</body>
</html>