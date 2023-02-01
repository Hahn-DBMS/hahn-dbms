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
$fname = $lname = $admin = $username = $password = $confirm_password = "";
$fname_err = $lname_err = $username_err = $password_err = $confirm_password_err = "";
if (!isset( $_SESSION['account_id'] )) {
    $_SESSION['account_id'] = $_GET['Staff_id'] ;
    
};
$id = $_SESSION['account_id'];
    


$query = "SELECT * FROM STAFF WHERE Staff_id = $id";
$result = mysqli_query($link, $query);
$row = $result->fetch_assoc();
$fname = $row["First_name"];
$lname = $row["Last_name"];
$username = $row["Username"];
$admin = $row["Admin_bool"];
//$id = $row["Staff_id"];
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate First and Last name
    if(empty(trim($_POST["fname"])) || empty(trim($_POST["lname"]))) {
        $fname_err = $lname_err = "Please enter a first and last name.";
    } else {
        $param_fname = trim($_POST["fname"]);
        $param_lname = trim($_POST["lname"]);
    }

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_.]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT 'hahn.USER' as table_name, U_id, Username, Password FROM hahn.USER WHERE username = ? UNION select 'hahn.STAFF' as table_name, Staff_id, Username, Password from hahn.STAFF where username = ? and staff_id != ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssi", $param_username, $param_username, $id);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
           
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
   if(strlen(trim($_POST["password"])) < 6 &&strlen(trim($_POST["password"])) > 0)  {
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(!empty(trim($_POST["password"])) && empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($fname_err) && empty($lname_err)){
        
        if(empty(trim($_POST["password"]))) {
            // Prepare an insert statement
        $sql = "UPDATE STAFF SET first_name = ?, last_name = ?, username = ?, admin_bool = ? WHERE Staff_id = ?";

             
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssii", $param_fname, $param_lname, $param_username, $admin, $id);
            
            // Set parameters
            $param_username = $username;
            
            if(isset($_POST['admin'])){
                $admin = 1;
              } else {
                  $admin = 0;
              }
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                // Redirect to login page
                
                if ($_SESSION['admin'] == 1) {
                    $_SESSION["edit_succ"] = "Update Successful";
                    header("location: staff.php");
                } else {
                    header("location: index.php");
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            
            // Close statement
            mysqli_stmt_close($stmt);
        }
        } else {
            // Prepare an insert statement
        $sql = "UPDATE STAFF SET first_name = ?, last_name = ?, username = ?, admin_bool = ?, password = ? WHERE Staff_id = ?";

         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssisi", $param_fname, $param_lname, $param_username, $admin, $param_password, $id);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            if(isset($_POST['admin'])){
                $admin = 1;
              } else {
                  $admin = 0;
              }
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                
                if ($_SESSION['admin'] == 1) {
                    $_SESSION["edit_succ"] = "Update Successful";
                    header("location: staff.php");
                } else {
                    header("location: index.php");
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            
            // Close statement
            mysqli_stmt_close($stmt);
        }
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
    <title>Edit Staff</title>

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
        <h1 class="h2">Edit Staff</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            
          </div>
          
        </div>
      </div>
      
 

    <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
                <label>First Name</label>
                <input type="text" name="fname" class="form-control <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fname; ?>">
                <span class="invalid-feedback"><?php echo $fname_err; ?></span>
            </div>   
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lname" class="form-control <?php echo (!empty($lname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lname; ?>">
                <span class="invalid-feedback"><?php echo $lname_err; ?></span>
            </div>   
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <?php
            if($_SESSION['admin'] == 1) {
                echo '<div class="form-group">
                
                <input type="checkbox" name="admin" id="admin"'. ($admin == 1 ? 'checked': '').'>
                <label for="admin"> Admin</label><br>
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>';
            }
            ?>
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <?php
                    if($_SESSION['admin'] == 1) {
                        echo '<a href="staff.php" class="btn btn-secondary ml-2">Cancel</a>';
                    } else {
                        echo '<a href="index.php" class="btn btn-secondary ml-2">Cancel</a>';
                    }
                    ?>
                
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
