<?php
 session_start();
require_once "/www/config.php";

if(!isset($_SESSION["admin"]) || $_SESSION["admin"] !== 1){
  header("location: /www/admin/maintenance.php");
  exit;
}
$query = "select COUNT(U.U_id) as 'num' FROM USER U WHERE (U.Created_date BETWEEN (CURDATE() - INTERVAL 7 DAY) AND CURDATE()+ INTERVAL 1 DAY);";
$query1 = "select COUNT(S.Staff_id) as 'num' FROM STAFF S WHERE (S.Created_date BETWEEN (CURDATE() - INTERVAL 7 DAY) AND CURDATE()+ INTERVAL 1 DAY);";
$query2 = "select COUNT(P.Plant_id) as 'num' FROM SAVED_PLANT P WHERE (P.Created_date BETWEEN (CURDATE() - INTERVAL 7 DAY) AND CURDATE()+ INTERVAL 1 DAY);";

//$result = mysqli_multi_query($link, $query);
$users = 0;
$staff = 0;
$saved_plants = 0;

$result1 = mysqli_query($link, $query);
$result2 = mysqli_query($link, $query1);
$result3 = mysqli_query($link, $query2);

while($row = mysqli_fetch_array($result1)) {

  $users = $users + $row['num'];
      }  
      ;
while($row = mysqli_fetch_array($result2)) {

  $staff = $staff + $row['num'];
      }  
      ;
while($row = mysqli_fetch_array($result3)) {

$saved_plants = $saved_plants + $row['num'];
  }  
  ;     
// mysqli_multi_query($link, $query);
// do {
//     /* store the result set in PHP */
//     if ($result = mysqli_store_result($link)) {
//         while ($row = mysqli_fetch_row($result)) {
//             echo $row['num'];
//             $users = $users + $row[0];
//         }
//     }
//     /* print divider */
//     if (mysqli_more_results($link)) {
//         $users = 0;
//     }
// } while (mysqli_next_result($link));


$dataPoints = array();
$query3 = "select COUNT(Id) as'num', CASE WHEN DAYOFWEEK(View_date) = 1 THEN 'Sunday' WHEN DAYOFWEEK(View_date) = 2 THEN 'Monday' WHEN DAYOFWEEK(View_date) = 3 THEN 'Tuesday' WHEN DAYOFWEEK(View_date) = 4 THEN 'Wednesday' WHEN DAYOFWEEK(View_date) = 5 THEN 'Thursday' WHEN DAYOFWEEK(View_date) = 6 THEN 'Friday' WHEN DAYOFWEEK(View_date) = 7 THEN 'Saturday' END  as 'day' from PAGE_VIEWS  WHERE (View_date BETWEEN (CURDATE() - INTERVAL 7 DAY) AND CURDATE()+ INTERVAL 1 DAY) GROUP BY DAY(View_date) ORDER BY View_date";
$result4 = mysqli_query($link, $query3);
while($row = mysqli_fetch_array($result4)) {

  array_push($dataPoints, array("label"=> $row["day"], "y"=> $row["num"]));
      }  
      ;
	
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Dashboard</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">

    

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
    <link href="sidebars.css" rel="stylesheet">
    <link href="features.css" rel="stylesheet">


    <script>

    
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	
	axisY: {
		title: "Visits"
	},
	data: [{
		type: "line",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  </head>
  <body>
    


<div class="container-fluid">
  <div class="row">
    <?php require_once('sidebar.php'); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            
          </div>
        </div>
      </div>
      <div class="container px-4 py-5" id="hanging-icons">
  
    <div class="row g-4 row-cols-1 row-cols-lg-3">
      <div class="col d-flex align-items-start">
        <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
        <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
        <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
      </svg>
        </div>
        <div>
          <h2><?php echo $users?></h2>
          <p>New Users This Month</p>
          <a href="users.php" class="btn btn-primary">
            View Users
          </a>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
      <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
      <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
      <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
    </svg>
        </div>
        <div>
          <h2><?php echo $staff?></h2>
          <p>New Staff This Month</p>
          <a href="staff.php" class="btn btn-primary">
           View Staff
          </a>
        </div>
      </div>
      <div class="col d-flex align-items-start">
        <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flower3" viewBox="0 0 16 16">
  <path d="M11.424 8c.437-.052.811-.136 1.04-.268a2 2 0 0 0-2-3.464c-.229.132-.489.414-.752.767C9.886 4.63 10 4.264 10 4a2 2 0 1 0-4 0c0 .264.114.63.288 1.035-.263-.353-.523-.635-.752-.767a2 2 0 0 0-2 3.464c.229.132.603.216 1.04.268-.437.052-.811.136-1.04.268a2 2 0 1 0 2 3.464c.229-.132.489-.414.752-.767C6.114 11.37 6 11.736 6 12a2 2 0 1 0 4 0c0-.264-.114-.63-.288-1.035.263.353.523.635.752.767a2 2 0 1 0 2-3.464c-.229-.132-.603-.216-1.04-.268zM9 4a1.468 1.468 0 0 1-.045.205c-.039.132-.1.295-.183.484a12.88 12.88 0 0 1-.637 1.223L8 6.142a21.73 21.73 0 0 1-.135-.23 12.88 12.88 0 0 1-.637-1.223 4.216 4.216 0 0 1-.183-.484A1.473 1.473 0 0 1 7 4a1 1 0 1 1 2 0zM3.67 5.5a1 1 0 0 1 1.366-.366 1.472 1.472 0 0 1 .156.142c.094.1.204.233.326.4.245.333.502.747.742 1.163l.13.232a21.86 21.86 0 0 1-.265.002 12.88 12.88 0 0 1-1.379-.06 4.214 4.214 0 0 1-.51-.083 1.47 1.47 0 0 1-.2-.064A1 1 0 0 1 3.67 5.5zm1.366 5.366a1 1 0 0 1-1-1.732c.001 0 .016-.008.047-.02.037-.013.087-.028.153-.044.134-.032.305-.06.51-.083a12.88 12.88 0 0 1 1.379-.06c.09 0 .178 0 .266.002a21.82 21.82 0 0 1-.131.232c-.24.416-.497.83-.742 1.163a4.1 4.1 0 0 1-.327.4 1.483 1.483 0 0 1-.155.142zM9 12a1 1 0 0 1-2 0 1.476 1.476 0 0 1 .045-.206c.039-.131.1-.294.183-.483.166-.378.396-.808.637-1.223L8 9.858l.135.23c.241.415.47.845.637 1.223.083.19.144.352.183.484A1.338 1.338 0 0 1 9 12zm3.33-6.5a1 1 0 0 1-.366 1.366 1.478 1.478 0 0 1-.2.064c-.134.032-.305.06-.51.083-.412.045-.898.061-1.379.06-.09 0-.178 0-.266-.002l.131-.232c.24-.416.497-.83.742-1.163a4.1 4.1 0 0 1 .327-.4c.046-.05.085-.086.114-.11.026-.022.04-.03.041-.032a1 1 0 0 1 1.366.366zm-1.366 5.366a1.494 1.494 0 0 1-.155-.141 4.225 4.225 0 0 1-.327-.4A12.88 12.88 0 0 1 9.74 9.16a22 22 0 0 1-.13-.232l.265-.002c.48-.001.967.015 1.379.06.205.023.376.051.51.083.066.016.116.031.153.044l.048.02a1 1 0 1 1-1 1.732zM8 9a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
</svg>
        </div>
        <div>
        <h2><?php echo $saved_plants?></h2>
          <p>Saved Plants This Month</p>
          <a href="plants.php" class="btn btn-primary">
            View Plants
          </a>
        </div>
      </div>
    </div>
  </div>
  <h1 class="h4">Unique Site Visits Per Day (By IP)</h1>
  <div id="chartContainer" style="height: 400; width: 100%;"></div>

      
     
    </main>
  </div>
</div>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
      <script src="sidebars.js"></script>
  </body>
</html>
