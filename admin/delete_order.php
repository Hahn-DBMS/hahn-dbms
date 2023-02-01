<?php
require_once('../config.php');
session_start();
$id= $_GET['Order_num'] ;
$sql = "DELETE FROM SUPPLIES_ORDER WHERE SUPPLIES_ORDER.Order_num = ?";

if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    // Set parameters
   
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        $_SESSION["edit_succ"] = "Delete Successful";
        header("location: orders.php");
        
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}