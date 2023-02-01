<?php
// Initialize the session
session_start();

// Include config file
require_once "../config.php";


// Define variables and initialize with empty values
$Task = $Date_completed = $Staff_id = $Section_id = "";
$Task_err = $Date_completed_err = $Staff_id_err = $Section_id_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate First and Last name
    if(empty(trim($_POST["Task"]))) {
        $Task_err = "Please enter a task.";
    } else {
        $param_Task = trim($_POST["Task"]);
    }

    // Validate First and Last name
    if(empty(trim($_POST["Date_completed"]))) {
        $Date_completed_err = "Please enter a date to complete the task.";
    } else {
        $param_Date_completed = trim($_POST["Date_completed"]);
    }
    
    // Validate First and Last name
    if(empty(trim($_POST["Staff_id"]))) {
        $Staff_id_err = "Please enter a staff name.";
    } else {
        $param_Staff_id = trim($_POST["Staff_id"]);
    }

    // Validate First and Last name
    if(empty(trim($_POST["Section_id"]))) {
        $Section_id_err = "Please enter a section name.";
    } else {
        $param_Section_id = trim($_POST["Section_id"]);
    }

    
    // Check input errors before inserting in database
    if(empty($Task_err) && empty($Date_completed_err) && empty($Staff_id_err) && empty($Section_id_err)){
        
        
        $sql = "INSERT INTO MAINTENANCE (Task , Date_completed , Staff_id , Section_id) VALUES (?, ?, ?, ?)";

             
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_Task, $param_Date_completed, $param_Staff_id, $param_Section_id);
          
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                
                // Redirect to login page
                $_SESSION["edit_succ"] = "Add Successful";
                header("location: maintenance.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            
            // Close statement
            mysqli_stmt_close($stmt);
        
        
        }  
    }
    
    // Close connection
    //mysqli_close($link);
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
    <title>Add Task</title>

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
        <h1 class="h2">Add Task</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          
        </div>
      </div>
      
 

    <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
                <label>Task</label>
                <input type="text" name="Task" class="form-control <?php echo (!empty($Task_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Task; ?>">
                <span class="invalid-feedback"><?php echo $Task_err; ?></span>
            </div>   
            <div class="form-group">
                <label>Date Completed</label>
                <input type="date" name="Date_completed" class="form-control <?php echo (!empty($Date_completed_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Date_completed; ?>">
                <span class="invalid-feedback"><?php echo $Date_completed_err; ?></span>
            </div>   
            <?php
                $query = "SELECT * FROM STAFF;";
                $query1 = "SELECT * FROM SECTION;";
                $result = mysqli_query($link, $query);
                $result1 = mysqli_query($link, $query1);
                if ($result->num_rows >0){
                  echo '<div class="form-group"> <label for="staff">Staff Member</label></br>
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
                    echo '<label for="sections">Section</label></br>
                  <select name="Section_id" id="Section_id" class="form-control">';
                    while ($row = $result1->fetch_assoc()){
                      if ($row["Section_id"] == $Vendor_id) {
                        echo '<option value='.$row["Section_id"].' selected>'.$row["Section_name"].'</option>';
                      } else {
                        echo '<option value='.$row["Section_id"].'>'.$row["Section_name"].'</option>';
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
                <a href="maintenance.php" class="btn btn-secondary ml-2">Cancel</a>
                
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
