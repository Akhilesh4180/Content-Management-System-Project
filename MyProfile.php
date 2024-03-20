<?php  require_once("Includes/DB.php"); ?>
<?php  require_once("Includes/Functions.php"); ?>
<?php  require_once("Includes/Sessions.php"); ?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login();?>

<?php 
// Fetching the existing admin data start
$AdminId = $_SESSION["User_ID"];
global $ConnectingDB;
$sql = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt=$ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch())
{
    $ExistingUserName = $DataRows["username"];
    $ExistingName = $DataRows['aname'];
    $ExistingHeadline = $DataRows['aheadline'];
    $ExistingBio = $DataRows['abio'];
    $ExistingImage = $DataRows['aimage'];
}
// Fetching the existing admin data end

if(isset($_POST["Submit"]))
{
    $AName = $_POST["Name"];
    $AHeadline  = $_POST["Headline"];
    $ABio = $_POST["Bio"];
    $Image     = $_FILES["Image"]["name"];
    $Target    = "Images/".basename($_FILES["Image"]["name"]);

if (strlen($AHeadline)>30){
    $_SESSION["ErrorMessage"] = "Headline should be less  than 30 characters" ;
    Redirect_to("MyProfile.php");
}
elseif (strlen($ABio)>500){
    $_SESSION["ErrorMessage"] = "Bio  should be less than 500 characters" ;
    Redirect_to("MyProfile.php");
}
else
{
    // query to insert  post category to the DB when everything is fine
    // query to update  post category to the DB when everything is fine
    global $ConnectingDB;
    if(!empty($_FILES["Image"]["name"]))
    {
        $sql = "UPDATE admins 
        SET  aname='$AName' , aheadline='$AHeadline' , abio='$ABio',aimage='$Image'
        WHERE id = '$AdminId'";
    }
    else
    {
        $sql = "UPDATE admins 
        SET  aname='$AName' , aheadline='$AHeadline' , abio='$ABio',
        WHERE id = '$AdminId'";
    }
   
    $Execute = $ConnectingDB->query($sql);
    move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
    if($Execute)
    {
        $_SESSION["SuccessMessage"]= "Details Updated  Successfully";
        Redirect_to("MyProfile.php");
    }
    else
    {
        $_SESSION["ErrorMessage"]= "Something went wrong.Try Again !";
        Redirect_to("MyProfile.php");
    }
    
}

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
    <title>My Profile</title>
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
                        <a href="MyProfile.php" class="nav-link"> <i class="fa-solid fa-user text-success"></i> My Page </a>
                    </li>
                    <li class="nav-item">
                        <a href="Dashboard.php" class="nav-link">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="Posts.php" class="nav-link">Posts</a>
                    </li>
                    <li class="nav-item">
                        <a href="Categories.php" class="nav-link">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a href="Admins.php" class="nav-link">Manage Admins</a>
                    </li>
                    <li class="nav-item">
                        <a href="Comments.php" class="nav-link">Comments</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php?page=1" class="nav-link">Live Blog</a>
                    </li>
                </ul>


                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="Logout.php" class="nav-link text-danger"> <i
                                class="fas fa-user-times "></i> Logout</a></li>

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
                <div class="col-md-12">
                    <h1><i class="fas fa-user text-success mr-2" ></i>@<?php  echo $ExistingUserName;?></h1>
                    <small><?php  echo $ExistingHeadline; ?></small>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END -->

    <!--   MAIN AREA -->
    <section class="container py-2 mb-4">
        <div class="row">
            <!-- Left Area -->
            <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-dark text-light">
                <h3><?php echo $ExistingName; ?></h3>
                </div>
                <div class="card-body">
                    <img src="Images/<?php echo $ExistingImage; ?>" class="block img-fluid mb-3" alt="">
                    <div class="">
                        <?php echo $ExistingBio;?>
                    </div>
                </div>
            </div>
            </div>
            <!-- Right Area -->
            <div class="col-md-9" style="min-height:500px";>
            <!-- Calling out the  error and success function in the sessions.php file -->
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
                <form class="" action="MyProfile.php" method="post" enctype="multipart/form-data">
                    <div class="card bg-dark text-light">
                        <div class="card-header bg-secondary text-light">
                            <h4>Edit Profile</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <input class="form-control" type="text" name="Name" placeholder="Your name here" id="title" value="">
                               
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" name="Headline" placeholder="Headline" id="title" value="">
                                <small class="text-muted">Add a professional headline like,'Jay Shree Ram' at ayodha in UP</small>
                                 <span class="text-danger">Not more than 30 characters</span>
                            </div>
                           
                            <div class="form-group">
                            <textarea  placeholder="Bio" class="form-control" id="Post" name="Bio" id="" cols="80" rows="8"></textarea>
                            </div>

                            <!-- for the image select div -->
                            <div class="form-group mb-1">
                            <div class="custom-file">
                            <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                            <label for="imageSelect" class="custom-file-label">Select Image</label>
                            </div>
                            </div>
                            <!-- for  -->
                            
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Dashboard.php" class="btn btn-warning btn-block"><i
                                            class="fas fa-arrow-left"></i>Back To Dashboard</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="Submit" class="btn btn-success btn-block">
                                        <i class="fas fa-check"></i>Publish
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </section>


    <!--  END MAIN AREA -->

    <!-- FOOTER -->

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