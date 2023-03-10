<?php
 session_start();
require_once "/www/config.php";
//require_once "sidebar.php";
$dataPoints = array();
$query = 'SELECT (DATE_FORMAT(S.Order_date,"%M")) AS "Month", COUNT(*) AS Orders, (DATE_FORMAT(S.Order_date,"%Y")) AS "Year" FROM SUPPLIES_ORDER S WHERE year(S.Order_date)= year(CURRENT_DATE) GROUP BY (DATE_FORMAT(S.Order_date,"%M")) ORDER BY max(S.Order_date) ASC;';

$result = mysqli_query($link, $query);
$total = 0;
if ($result->num_rows >0){
    while ($row = $result->fetch_assoc()){
        
      array_push($dataPoints, array("label"=> $row["Month"], "y"=> $row["Orders"]));
      $year = $row["Year"];
      $total = $total + $row["Orders"];

    }
}
    else{
        echo "No results found";
    }

$link->close();



    
	
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Orders 12 Months</title>

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
    <link href="/www/admin/dashboard.css" rel="stylesheet">
    <link href="/www/admin/sidebars.css" rel="stylesheet">

    <script>

    
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	
	axisY: {
		title: "Orders"
	},
	data: [{
		type: "column",
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
    <?php require_once('/www/admin/sidebar.php'); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Orders This Year (<?php echo $year?>) | <?php echo $total?> Orders</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          
          
          </button>
          
        </div>
      </div>
      <div id="chartContainer" style="height: 400; width: 100%;"></div>

      </div>
    </main>
  </div>
</div>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
      <script src="/www/admin/sidebars.js"></script>
  </body>
</html>
