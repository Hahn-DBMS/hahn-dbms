<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login/login.php");
    exit;
}
?>

<?php
// Include config file
require_once "../config.php";
 
// Define variables and initialize with empty values
$Order_date = $Quantity = $Cost = $Product_name = $Staff_id = $Vendor_id = "";
$OrderD_err = $quantity_err = $cost_err = $prodname_err = $Staff_id_err = $Vendor_id_err = "";
if (!isset( $_SESSION['Order_num'] )) {
    $_SESSION['Order_num'] = $_GET['Order_num'] ;
    
};
$id = $_SESSION['Order_num'];
    


$query = "SELECT * FROM SUPPLIES_ORDER WHERE Order_num = $id";
$result = mysqli_query($link, $query);
$row = $result->fetch_assoc();
$Order_date = $row["Order_date"];
$Quantity = $row["Quantity"];
$Cost = $row["Cost"];
$Product_name = $row["Product_name"];
$Staff_id = $row["Staff_id"];
$Vendor_id = $row["Vendor_id"];
//$id = $row["Staff_id"];
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate First and Last name
    if(empty(trim($_POST["Order_date"]))) {
        $OrderD_err = $Order_date = "Please enter a valid date.";
    } else {
        $param_Order_date = trim($_POST["Order_date"]);
    }

    // Validate First and Last name
    if(empty(trim($_POST["Quantity"]))) {
        $quantity_err = "Please enter a quantity.";
    } else {
        $param_quantity = trim($_POST["Quantity"]);
    }
    if(empty(trim($_POST["Cost"]))) {
      $cost_err = "Please enter a cost.";
  } else {
      $param_cost = trim($_POST["Cost"]);
  }
    
    // Validate First and Last name
    if(empty(trim($_POST["Product_name"]))) {
        $prodname_err = $Product_name = "Please enter a product name.";
    } else {
        $param_prod_name = trim($_POST["Product_name"]);
    }

    // Validate First and Last name
    if(empty(trim($_POST["Staff_id"]))) {
        $Staff_id_err = $Staff_id = "Please enter a staff id.";
    } else {
        $param_staff_id = trim($_POST["Staff_id"]);
    }

    // Validate First and Last name
    if(empty(trim($_POST["Vendor_id"]))) {
        $Vendor_id_err = $Vendor_id = "Please enter a vendor id.";
    } else {
        $param_vendor_id = trim($_POST["Vendor_id"]);
    }
    
    // Check input errors before inserting in database
    if(empty($OrderD_err) && empty($quantity_err) && empty($prodname_err) && empty($Staff_id_err) && empty($Vendor_id_err) && empty($cost_err)){
        
        
        $sql = "UPDATE SUPPLIES_ORDER SET Order_date = ?, Quantity = ?, Cost = ?, Product_name = ?, Staff_id = ?, Vendor_id = ? WHERE Order_num = ?";

             
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssi", $param_Order_date, $param_quantity, $param_cost, $param_prod_name, $param_staff_id, $param_vendor_id, $id);
            
            // Set parameters
          
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                // Redirect to login page
                $_SESSION["edit_succ"] = "Update Successful";
                header("location: orders.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            
            // Close statement
            mysqli_stmt_close($stmt);
        
        
        }  
    }
    
    // Close connection
    mysqli_close($link);
}
?>
<?php require_once('sidebar.php'); ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Edit Orders</title>

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
  </head>
  <body>
    


<div class="container-fluid">
  <div class="row">


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Order</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          
        </div>
      </div>
      
 

    <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
                <label>Order Date</label>
                <input type="date" name="Order_date" class="form-control <?php echo (!empty($OrderD_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Order_date; ?>">
                <span class="invalid-feedback"><?php echo $OrderD_err; ?></span>
            </div>   
            <div class="form-group">
                <label>Quantity</label>
                <input type="text" name="Quantity" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Quantity; ?>">
                <span class="invalid-feedback"><?php echo $quantity_err; ?></span>
            </div>   
            <div class="form-group">
                <label>Cost</label>
                <input type="text" name="Cost" class="form-control <?php echo (!empty($cost_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Cost; ?>">
                <span class="invalid-feedback"><?php echo $cost_err; ?></span>
            </div> 
            <div class="form-group">
                <label>Product Item</label>
                <input type="text" name="Product_name" class="form-control <?php echo (!empty($prodname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Product_name; ?>">
                <span class="invalid-feedback"><?php echo $prodname_err; ?></span>
            </div>   
             
            
            
            <?php
                $query = "SELECT * FROM STAFF;";
                $query1 = "SELECT * FROM VENDOR;";
                $result = mysqli_query($link, $query);
                $result1 = mysqli_query($link, $query1);
                if ($result->num_rows >0){
                  echo '<div class="form-group"> <label for="cars">Staff Member</label></br>
                <select name="Staff_id" id="Staff_id" class="form-control">';
                  while ($row = $result->fetch_assoc()){
                    if ($row["Staff_id"] == $Staff_id) {
                      echo '<option value='.$row["Staff_id"].' selected>'.$row["First_name"].' '.$row["Last_name"].'</option>';
                    } else {
                      echo '<option value='.$row["Staff_id"].'>'.$row["First_name"].' '.$row["Last_name"].'</option>';
                    }
                  }
                  echo ' </select>
                  </div>';
                }
                  else{
                      echo "No results found";
                  }
                  if ($result->num_rows >0){
                    echo '<label for="cars">Staff Member</label></br>
                  <select name="Vendor_id" id="Vendor_id" class="form-control">';
                    while ($row = $result1->fetch_assoc()){
                      if ($row["Vendor_id"] == $Vendor_id) {
                        echo '<option value='.$row["Vendor_id"].' selected>'.$row["Vendor_name"].'</option>';
                      } else {
                        echo '<option value='.$row["Vendor_id"].'>'.$row["Vendor_name"].'</option>';
                      }
                    }
                    echo ' </select>
                    </div>';
                  }
                    else{
                        echo "No results found";
                    }
          
              $link->close();
            ?>
               
            
         
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="orders.php" class="btn btn-secondary ml-2">Cancel</a>
                
            </div>
        </form>
    </div>    

      
    </main>
  </div>
</div>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
      <script src="sidebars.js"></script>
  </body>
</html>
