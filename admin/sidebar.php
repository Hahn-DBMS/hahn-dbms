<?php
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["account_type"] !== "hahn.STAFF"){
  header("location: /www/login/login.php");
  exit;
}
?>
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="../index.php">Hahn DBMS</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="/www/login/logout.php">Sign out</a>
    </div>
  </div>
</header>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
      <ul class="list-unstyled ps-0">
      <li class="mb-1">
          <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
            Home
          </button>
          <div class="collapse" id="home-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li><a href="/www/admin/index.php" class="link-dark rounded">Dashboard</a></li>
            </ul>
          </div>
        </li>
        <li class="mb-1">
          <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#garden-collapse" aria-expanded="false">
            Garden
          </button>
          <div class="collapse" id="garden-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li><a href="/www/admin/plants.php" class="link-dark rounded">Plants</a></li>
              <li><a href="/www/admin/sections.php" class="link-dark rounded">Sections</a></li>
            </ul>
          </div>
        </li>
        
          <?php
          
          if($_SESSION['admin'] == 1) {
            echo '<li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
              Accounts
            </button>
            <div class="collapse" id="dashboard-collapse">
              <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li><a href="/www/admin/users.php" class="link-dark rounded">Users</a></li>
                <li><a href="/www/admin/staff.php" class="link-dark rounded">Staff</a></li>
              </ul>
            </div>
          </li>';
          }

          
          ?>
          
        <li class="mb-1">
          <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
            Manage
          </button>
          <div class="collapse" id="orders-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li><a href="/www/admin/orders.php" class="link-dark rounded">Orders</a></li>
              <li><a href="/www/admin/maintenance.php" class="link-dark rounded">Tasks</a></li>
              <li><a href="/www/admin/vendors.php" class="link-dark rounded">Vendors</a></li>
            </ul>
          </div>
          <li class="border-top my-3"></li>
          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Saved reports</span>
          
        </h6>
        <button class="btn btn-toggle align-items-center rounded collapsed sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 text-muted" data-bs-toggle="collapse" data-bs-target="#ordersreports-collapse" aria-expanded="false">
            Orders
          </button>
          <div class="collapse" id="ordersreports-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li class="nav-item">
            <a class="nav-link" href="/www/admin/reports/orders/orders_12_months.php">
              <span data-feather="file-text"></span>
              Orders This Year
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/www/admin/reports/orders/orders_all_time.php">
              <span data-feather="file-text"></span>
              Orders All Time
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/www/admin/reports/orders/orders_avg_cost_per_month.php">
              <span data-feather="file-text"></span>
              Orders Cost by Month
            </a>
          </li>
            </ul>
          </div>
          <button class="btn btn-toggle align-items-center rounded collapsed sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 text-muted" data-bs-toggle="collapse" data-bs-target="#plantsreports-collapse" aria-expanded="false">
            Plants
          </button>
          <div class="collapse" id="plantsreports-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li class="nav-item">
            <a class="nav-link" href="/www/admin/reports/plants/saved_plants_12_months.php">
              <span data-feather="file-text"></span>
              Saved Plants This Years
            </a>
          </li>
        </div>
          <button class="btn btn-toggle align-items-center rounded collapsed sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 text-muted" data-bs-toggle="collapse" data-bs-target="#vendorsreports-collapse" aria-expanded="false">
            Vendors
          </button>
          <div class="collapse" id="vendorsreports-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li class="nav-item">
            <a class="nav-link" href="/www/admin/reports/vendors/vendors_orders_12_months.php">
              <span data-feather="file-text"></span>
              Orders Per Vendor This Year
            </a>
          </li>
            </ul>
          </div>
          <?php 
          if($_SESSION['admin'] == 1) {
          echo '<button class="btn btn-toggle align-items-center rounded collapsed sidebar-heading d-flex justify-content-between align-items-center px-3 mb-1 text-muted" data-bs-toggle="collapse" data-bs-target="#tasks-collapse" aria-expanded="false">
            Tasks
          </button>
          <div class="collapse" id="tasks-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li class="nav-item">
            <a class="nav-link" href="/www/admin/reports/tasks/task_by_staff.php">
              <span data-feather="file-text"></span>
              Tasks Completed Last 30 Days
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/www/admin/reports/tasks/tasks_by_staff_all_time.php">
              <span data-feather="file-text"></span>
              Tasks Completed All Time
            </a>
          </li>
            </ul>
          </div>';
          }
          ?>
        </li>
        <li class="border-top my-3"></li>
        <li class="mb-1">
          <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
          <?php echo htmlspecialchars($_SESSION["username"]); ?>
          </button>
          <div class="collapse" id="account-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li><a href="edit_staff.php?Staff_id=<?php echo htmlspecialchars($_SESSION["id"]); ?>" class="link-dark rounded">Edit Profile</a></li>
              <li><a href="/www/login/logout.php" class="link-dark rounded">Sign out</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </nav>