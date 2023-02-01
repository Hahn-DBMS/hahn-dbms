<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if ($_SESSION["account_type"] == 'hahn.STAFF') {
        header("location: ../admin/index.php");
        exit;
    } else {
        header("location: ../index.php");
        exit;
    }
}
 
// Include config file
require_once "../config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT 'hahn.USER' as table_name, U_id, First_name, Username, Password FROM hahn.USER WHERE username = ? UNION select 'hahn.STAFF' as table_name, Staff_id, First_name, Username, Password from hahn.STAFF where username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $table_name, $id, $fname, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            if($table_name == "hahn.STAFF"){
                                $sql = "SELECT admin_bool from STAFF where Staff_id = ?";

                                if($stmt = mysqli_prepare($link, $sql)){
                                    // Bind variables to the prepared statement as parameters
                                    mysqli_stmt_bind_param($stmt, "i", $id);
                                    
                                    // Attempt to execute the prepared statement
                                    if(mysqli_stmt_execute($stmt)){
                                        // Store result
                                        mysqli_stmt_store_result($stmt);
                                        
                                        // Check if username exists, if yes then verify password
                                        if(mysqli_stmt_num_rows($stmt) == 1){                    
                                            // Bind result variables
                                            mysqli_stmt_bind_result($stmt, $admin_bool);
                                            if(mysqli_stmt_fetch($stmt)){
                                                $_SESSION["admin"] = $admin_bool;
                                            }
                                        }
                                    }
                                }
                            }
                            
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["account_type"] = $table_name;
                            $_SESSION["fname"] = $fname;                                
                            
                            // Redirect user to welcome page
                            if ($_SESSION["account_type"] == 'hahn.STAFF') {
                                header("location: ../admin/index.php");
                                exit;
                            } else {
                                header("location: ../index.php");
                                exit;
                            }
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username.";
                }
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
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
    <link href="signin.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body class="text-center">
<main class="form-signin">
<?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <a href="../index.php"><svg xmlns="http://www.w3.org/2000/svg" width="72" height="57" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
  <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
</svg></a>
    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

    <div class="form-floating">
    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="johndoe">
      <label for="floatingInput">Username</label>
      <span class="invalid-feedback"><?php echo $username_err; ?></span>
    </div>
    <div class="form-floating">
    <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="password">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
      <label for="floatingPassword">Password</label>
    </div>

    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit" value="login">Sign in</button>
    <p>Don't have an account? <a href="registration.php">Sign up now</a>.</p>
    
  </form>
</main>


    
   
</body>
</html>