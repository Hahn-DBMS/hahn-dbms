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
$Common_name = $Scientific_name = $Description = $Plant_type = $Plant_image = "";
$Common_name_err = $Scientific_name_err = $Description_err = $Plant_type_err = "";
if (!isset( $_SESSION['Plant_id'] )) {
    $_SESSION['Plant_id'] = $_GET['Plant_id'] ;
    
};
$id = $_SESSION['Plant_id'];
    


$query = "SELECT * FROM PLANT WHERE Plant_id = $id";
$result = mysqli_query($link, $query);
$row = $result->fetch_assoc();
$Common_name = $row["Common_name"];
$Scientific_name = $row["Scientific_name"];
$Description = $row["Description"];
$Plant_type = $row["Plant_type"];
$Plant_image = $row['Picture'];
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate First and Last name
    if(empty(trim($_POST["Common_name"]))) {
        $Common_name_err = "Please enter a valid Common name.";
    } else {
        $param_Common_name = trim($_POST["Common_name"]);
    }

    // Validate First and Last name
    if(empty(trim($_POST["Scientific_name"]))) {
        $Scientific_name_err = "Please enter a scientific name.";
    } else {
        $param_Scientific_name = trim($_POST["Scientific_name"]);
    }
    
    // Validate First and Last name
    if(empty(trim($_POST["Description"]))) {
        $Description_err = "Please enter a Description.";
    } else {
        $param_Description = trim($_POST["Description"]);
    }

    // Validate First and Last name
    if(empty(trim($_POST["Plant_type"]))) {
        $Plant_type_err = "Please enter a Plant type.";
    } else {
        $param_Plant_type = trim($_POST["Plant_type"]);
    }
     // Validate First and Last name
     if(empty(trim($_POST["Plant_image"]))) {
      $Plant_image_err = "Please enter an image url.";
  } else {
      $param_Plant_image = trim($_POST["Plant_image"]);
  }
    
    // Check input errors before inserting in database
    if(empty($Common_name_err) && empty($Scientific_name_err) && empty($Description_err) && empty($Plant_type_err) && empty($Plant_image_err)){
        
        
        $sql = "UPDATE PLANT SET Common_name = ?, Scientific_name = ?, Description = ?, Plant_type = ?, Picture = ? WHERE Plant_id = ?";

             
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssi", $param_Common_name, $param_Scientific_name, $param_Description, $param_Plant_type, $param_Plant_image, $id);
            
            // Set parameters
          
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                // Redirect to login page
                $_SESSION["edit_succ"] = "Update Successful";
                header("location: plants.php");
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
    <title>Edit Plant</title>

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
        <h1 class="h2">Edit Plant</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          
          
        </div>
      </div>
      
 
      <img src=<?php echo $Plant_image; ?> alt="Italian Trulli" width="20%" height="225">
    <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
                <label>Common Name</label>
                <input type="text" name="Common_name" class="form-control <?php echo (!empty($Common_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Common_name; ?>">
                <span class="invalid-feedback"><?php echo $Common_name_err; ?></span>
            </div>   
            <div class="form-group">
                <label>Scientific Name</label>
                <input type="text" name="Scientific_name" class="form-control <?php echo (!empty($Scientific_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Scientific_name; ?>">
                <span class="invalid-feedback"><?php echo $Scientific_name_err; ?></span>
            </div>   
            <div class="form-group">
                <label>Description</label>
                <input type="text" name="Description" class="form-control <?php echo (!empty($Description_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Description; ?>">
                <span class="invalid-feedback"><?php echo $prodname_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Plant Type</label>
                <input type="text" name="Plant_type" class="form-control <?php echo (!empty($Plant_type_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Plant_type; ?>">
                <span class="invalid-feedback"><?php echo $Plant_type_err; ?></span>
            </div>
            <div class="form-group">
                <label>Plant Image Url</label>
                <input type="text" name="Plant_image" class="form-control <?php echo (!empty($Plant_image_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Plant_image; ?>">
                <span class="invalid-feedback"><?php echo $Plant_image_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="plants.php" class="btn btn-secondary ml-2">Cancel</a>
                
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
