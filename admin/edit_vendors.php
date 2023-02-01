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
$Vendor_name = $Point_of_contact = $Contact_info = $Vendor_type = "";
$Vendor_name_err = $Point_of_contact_err = $Contact_info_err = $Vendor_type_err= "";
if (!isset( $_SESSION['Vendor_id'] )) {
    $_SESSION['Vendor_id'] = $_GET['Vendor_id'] ;
    
};
$id = $_SESSION['Vendor_id'];
    


$query = "SELECT * FROM VENDOR WHERE Vendor_id = $id";
$result = mysqli_query($link, $query);
$row = $result->fetch_assoc();
$Vendor_name = $row["Vendor_name"];
$Point_of_contact = $row["Point_of_contact"];
$Contact_info = $row["Contact_info"];
$Vendor_type = $row["Vendor_type"];
//$id = $row["Staff_id"];
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate First and Last name
    if(empty(trim($_POST["Vendor_name"]))) {
        $Vendor_name_err = $Vendor_name = "Please enter a vendor name.";
    } else {
        $param_Vendor_name = trim($_POST["Vendor_name"]);
    }

    // Validate First and Last name
    if(empty(trim($_POST["Point_of_contact"]))) {
        $Point_of_contact_err = "Please enter a point of contact.";
    } else {
        $param_point_of_contact = trim($_POST["Point_of_contact"]);
    }
    
    // Validate First and Last name
    if(empty(trim($_POST["Contact_info"]))) {
        $Contact_info_err = $Contact_info = "Please enter contact info.";
    } else {
        $param_contact_info = trim($_POST["Contact_info"]);
    }

    // Validate First and Last name
    if(empty(trim($_POST["Vendor_type"]))) {
        $Vendor_type_err  = "Please enter a vendor type.";
    } else {
        $param_vendor_type .= trim($_POST["Vendor_type"]);
    }
    

    
    // Check input errors before inserting in database
    if(empty($Vendor_name_err) && empty($Point_of_contact_err) && empty($Contact_info_err) && empty($Vendor_type_err)){
        
        
        $sql = "UPDATE VENDOR SET Vendor_name = ?, Point_of_contact = ?, Contact_info = ?, Vendor_type = ? WHERE Vendor_id = ?";

             
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssi", $param_Vendor_name, $param_point_of_contact, $param_contact_info, $param_vendor_type, $id);
            
            // Set parameters
            //$param_vendor_type = "Seeds";
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                // Redirect to login page
                $_SESSION["edit_succ"] = "Update Successful";
                header("location: vendors.php");
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
    <title>Edit Vendor</title>

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
        <h1 class="h2">Edit Vendor</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          
        </div>
      </div>
      
 

    <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
                <label>Vendor Name</label>
                <input type="text" name="Vendor_name" class="form-control <?php echo (!empty($Vendor_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Vendor_name; ?>">
                <span class="invalid-feedback"><?php echo $Vendor_name_err; ?></span>
            </div>   
            <div class="form-group">
                <label>Point of Contact</label>
                <input type="text" name="Point_of_contact" class="form-control <?php echo (!empty($Point_of_contact_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Point_of_contact; ?>">
                <span class="invalid-feedback"><?php echo $Point_of_contact_err; ?></span>
            </div>   
            <div class="form-group">
                <label>Contact Info</label>
                <input type="text" name="Contact_info" class="form-control <?php echo (!empty($Contact_info_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Contact_info; ?>">
                <span class="invalid-feedback"><?php echo $Contact_info_err; ?></span>
            </div>    
           <div class="form-group">
                <label>Vendor Type</label>
                <input type="text" name="Vendor_type" class="form-control <?php echo (!empty($Vendor_type_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Vendor_type; ?>">
                <span class="invalid-feedback"><?php echo $Vendor_type_err; ?></span>
            </div>
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="vendors.php" class="btn btn-secondary ml-2">Cancel</a>
                
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
