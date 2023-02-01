<?php
session_start();
require_once "/www/config.php";
require_once "/www/page_views.php";
$visitor_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
add_view($link, $visitor_ip);
?>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark shadow flex-md-nowrap">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Hahn Horticulture Garden</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="/www/index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/www/plants/plants.php">Plants</a>
          </li>
          
        <?php

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["account_type"] == 'hahn.STAFF'){
  
} else {
  echo ' <li class="nav-item">
  <a class="nav-link" href="/www/saved_plants/saved_plants.php">Saved Plants</a>
</li>';
}
        if(!isset($_SESSION["account_type"]) || $_SESSION["account_type"] !== 'hahn.STAFF'){

  echo '</ul>';
  
} else {
  echo ' <li class="nav-item">
  <a class="nav-link" href="/www/admin/index.php">Admin</a>
</li></ul>';
}
        ?>

        <?php
          
          if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
            
            echo '<ul class="navbar-nav ">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="/www/login/login.php">Login</a>
            </li>
          </ul>';
          } else {
            if(!isset($_SESSION["account_type"]) || $_SESSION["account_type"] !== 'hahn.USER'){
              echo '<ul class="navbar-nav ">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#">Welcome, '.$_SESSION["fname"].'</a>
              </li>
            </ul>';
            } else {
              echo '<ul class="navbar-nav ">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="/www/edit_user_profile.php?U_id='.$_SESSION["id"].'">Welcome, '.$_SESSION["fname"].'</a>
              </li>
            </ul>';
            }
           
            echo '<div class="navbar-nav">
            <div class="nav-item text-nowrap">
              <a class="nav-link px-3 bg-dark" href="/www/login/logout.php">Sign out</a>
            </div>
          </div>';
          }

          
          ?>
      </div>
    </div>
  </nav>