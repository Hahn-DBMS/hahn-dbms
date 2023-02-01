<?php
require_once "/www/config.php";

function is_unique_view($link, $visitor_ip)
{
  $query = "SELECT * FROM `PAGE_VIEWS` WHERE Visitor_ip = '$visitor_ip' AND DAY(View_date) = DAY(CURRENT_DATE)";
  $result = mysqli_query($link, $query);
  
  if(mysqli_num_rows($result) > 0)
  {
    return false;
  }
  else
  {
    return true;
  }
}



function add_view($link, $visitor_ip)
{
  if(is_unique_view($link, $visitor_ip) === true)
  {
    // insert unique visitor record for checking whether the visit is unique or not in future.
    $query = "INSERT INTO PAGE_VIEWS (visitor_ip) VALUES ('$visitor_ip')";
    
    
      
      if(!mysqli_query($link, $query))
      {
        echo "Error updating record: " . mysqli_error($conn);
      }
    
    
  }
}
?>