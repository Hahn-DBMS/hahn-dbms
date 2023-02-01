<?php
//Start Session
session_start();

require_once('../config.php');

$plant_id= $_GET['Plant_id'] ;
$u_id = $_SESSION['id'];

$query = "SELECT * FROM SAVED_PLANT S
          INNER JOIN PLANT P ON S.Plant_id = P.Plant_id
          WHERE S.U_id = $u_id AND P.Plant_id = $plant_id";
$result = mysqli_query($link, $query);
$sql = "INSERT INTO SAVED_PLANT (U_id, Plant_id) VALUES (?, ?)";

if (mysqli_num_rows($result) > 0) {
    $_SESSION["edit_succ"] = "You've already saved this plant!";
    header("location: saved_plants.php"); 
} else {
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ii", $u_id, $plant_id);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            
            // Redirect to login page
            $_SESSION["edit_succ"] = "Add Successful";
            header("location: saved_plants.php");
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
}
    