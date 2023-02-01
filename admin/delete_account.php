<?php
session_start();
require_once('../config.php');
$username= $_GET['Account_username'] ;
$sql = "DELETE FROM STAFF WHERE STAFF.username = ?";

if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $username);
    
    // Set parameters
   
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}
$sql = "DELETE FROM USER WHERE USER.username = ?";

if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s",$username);
    
    // Set parameters
   
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
            $_SESSION["edit_succ"] = "Delete Successful";
        header("location:". $_GET['Back']);
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}
?>