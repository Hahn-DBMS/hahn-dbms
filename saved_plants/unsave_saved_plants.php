<?php
//Start Session
session_start();

require_once('../config.php');

$plant_id= $_GET['Plant_id'] ;
$u_id = $_SESSION['id'];
$sql = "DELETE FROM SAVED_PLANT WHERE SAVED_PLANT.U_id = ? AND SAVED_PLANT.Plant_id = ?";

if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ii", $u_id, $plant_id);
   
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        $_SESSION["edit_succ"] = "Unsave Successful";
        header("location: saved_plants.php");
        
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}