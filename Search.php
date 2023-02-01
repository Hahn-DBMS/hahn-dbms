<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Search</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/headers/">

    

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
    <link href="headers.css" rel="stylesheet">
  </head>
  <body>
    
    <header class="p-3 bg-dark text-white">
      <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
          <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
          </a>
  
          <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li><a href="#" class="nav-link px-2 text-secondary">Home</a></li>
            <li><a href="#" class="nav-link px-2 text-white">Features</a></li>
            <li><a href="#" class="nav-link px-2 text-white">Pricing</a></li>
            <li><a href="#" class="nav-link px-2 text-white">FAQs</a></li>
            <li><a href="#" class="nav-link px-2 text-white">About</a></li>
          </ul>
  
          <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
            <input type="search" class="form-control form-control-dark" placeholder="Search..." aria-label="Search">
          </form>
  
          <div class="text-end">
            <button type="button" class="btn btn-outline-light me-2">Login</button>
            <button type="button" class="btn btn-warning">Sign-up</button>
          </div>
        </div>
      </div>
    </header>
    
      
  </body>
</html>

<?php
   require_once "config.php";

    $searchTerm = $_POST['searchterm'];
    $query = "SELECT * FROM PLANT WHERE Common_name = '{$searchTerm}';";

    $result = mysqli_query($link, $query);

    if ($result->num_rows >0){
        while ($row = $result->fetch_assoc()){
            echo "<h1> Search Results </h1>";
            echo "<p1> Your search term returned these results: </p1> <br>";
            echo '<table class="table table-sm">
            <thead>
              <tr>
                <th scope="col">Common Name</th>
                <th scope="col">Scientific Name</th>
                <th scope="col">Description</th>
                <th scope="col">Plant Type</th>
              </tr>
            </thead>';

            echo '<tbody>
            <tr>
              <th scope="row">'.$row["Common_name"].'</th>
              <td>' .$row["Scientific_name"] .'</td>
              <td>'. $row["Description"] .'</td>
              <td>'. $row["Picture"].'</td>
              <img src='. $row["Picture"].' alt="Italian Trulli">
            </tr>
            </tbody>';
            

            
            echo '</table>';
        }
    }
        else{
            echo "No results found";
        }

    $link->close();
?>



