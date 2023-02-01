<!doctype html>
<!--Start html-->
<html lang="en">
   <!--Start head-->
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Plants</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/album/">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </head>
     <!--End head-->
    
    <!--Start body-->
    <body>
      <?php require_once('../navbar.php');?>

       <!--Start main-->
      <main>
        <section class="py-5 text-center container">
          <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
              <h1 class="fw-light">Plant Database</h1>
              <p class="lead text-muted">Learn about the plants that we have in the garden right now!</p>
            </div>
          </div>
        </section>

        <div class="album py-5 bg-light">
          <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php
              require_once "../config.php";
              
              $query = "SELECT * FROM PLANT";

              $result = mysqli_query($link, $query);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo '<div class="col">
                  <div class="card shadow-sm">
                  <img src='. $row["Picture"].' alt="Italian Trulli" width="100%" height="225">
                    <div class="card-body">
                      <p class="card-text">'.$row ["Description"].'</p>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-outline-secondary">'.$row["Common_name"].'</button>
                          <button type="button" class="btn btn-sm btn-outline-secondary">'.$row["Scientific_name"].'</button>
                          <button type="button" class="btn btn-sm btn-outline-secondary">'.$row["Plant_type"].'</button>';
                          if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                            if ($_SESSION["account_type"] == 'hahn.USER') {
                              echo '<button type="button" class="btn btn-sm btn-outline-secondary"><a href="../saved_plants/save_saved_plants.php?Plant_id='.$row["Plant_id"].'" style="text-decoration: none; color: limegreen;" onclick="return confirm(\'Are you sure you want to save?\');"><path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>Save</a></Button>';
                              
                            } else {
                                
                            }

                          }
                                       echo '</div>
                                       </div>
                                     </div>
                                   </div>
                                 </div>';
                                      }
                                    }
              $link->close();
            ?>
        </div>
      </main>
       <!--End main-->
      
      <!--Start footer-->
      <footer class="text-muted py-5">
        <div class="container">
          <p class="float-end mb-1">
            <a href="#">Back to top</a>
          </p>
        </div>
      </footer>
       <!--End footer-->

      <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

  </body>
   <!--End body-->
</html>
<!--End html-->