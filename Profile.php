<?php  require_once("Includes/DB.php"); ?>
<?php  require_once("Includes/Functions.php"); ?>
<?php  require_once("Includes/Sessions.php"); ?>
<!-- fetching Existing data  -->
<?php 
$SearchQueryParameter = $_GET["username"];
global $ConnectingDB;
$sql = "SELECT aname,aheadline,abio,aimage FROM admins WHERE username=:userName";
$stmt = $ConnectingDB->prepare($sql);
$stmt->bindValue(':userName',$SearchQueryParameter);
$stmt->execute();
$Result = $stmt->rowcount();
if($Result==1)
{
    while ($DataRows=$stmt->fetch())
    {
        $ExistingName = $DataRows["aname"];
        $ExistingBio = $DataRows["abio"];
        $ExistingImage = $DataRows["aimage"];
        $ExistingHeadline = $DataRows["aheadline"];
    }
}
else
{
    $_SESSION["ErrorMessage"]="Bad Request !!!";
    Redirect_to("Blog.php?page=1");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="style.css">
    <title>Profile Page</title>
</head>

<body>
    <!-- <h1 class="display-1">Hello world</h1> -->
    <!-- NAVBAR -->
    <div style="height: 10px; background-color: #27aae1;"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand">AkhileshYadav.COM</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="Blog.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php" class="nav-link">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Featues</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <form  class="form-inline d-none d-sm-block" action="Blog.php">
                        <div class="form-group">
                           <input class="form-control mr-2" type="text" name="Search" placeholder="Search here"value=""> 
                           <button class="btn btn-primary" name="SearchButton">Go</button>
                        </div>
                    </form>

                </ul>
                </div> 
          </div>      
    </nav>
    <div style="height: 10px; background-color: #27aae1;"></div>
    <!-- NAVABR END-->

    <!-- HEADER -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1><i class="fas fa-user text-success mr-2" style="color: yellow;"></i><?php echo $ExistingName; ?></h1>
                    <h3><?php echo $ExistingHeadline; ?></h3>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END -->

    <!--   MAIN AREA -->
    


    <!--  END MAIN AREA -->

    <!-- FOOTER -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-md-3">
                <img src="Images/<?php echo $ExistingImage; ?>" class="d-block img-fluid mb-3 rounded-circle" alt="">
            </div>
            <div class="col-md-9" style="min-height:490px">
                    <div class="card">
                        <div class="card-body">
                            <p class="lead">
                            <?php  echo $ExistingBio; ?>
                            </p>
                        </div>
                    </div>
                </div>
        </div>

    </section>

    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center">Theme By | Akhilesh Yadav | <span id="year"></span> &copy; -----All
                        rights Reserved.</p>
                    <p class="text-center small"><a href="#">About Footer</a>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore nam minus, modi delectus
                        assumenda molestiae exercitationem corrupti nostrum, quia temporibus quaerat odit esse quod
                        soluta repellendus quisquam iusto veniam, ab a. Rerum natus sapiente!</p>
                </div>
            </div>
        </div>
    </footer>
    <div style="height: 10px; background-color: #27aae1;"></div>

    <!-- FOOTER  END -->


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>

    <script>
        $('#year').text(new Date().getFullYear());
    </script>
</body>

</html>