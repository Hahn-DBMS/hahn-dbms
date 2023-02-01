<?php
require_once('../config.php');
session_start();
$id= $_GET['Vendor_id'] ;
$sql = "DELETE FROM VENDOR WHERE VENDOR.Vendor_id = ?";

if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    // Set parameters
   
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        $_SESSION["edit_succ"] = "Delete Successful";
        header("location: vendors.php");
        
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}