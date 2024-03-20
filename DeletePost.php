<?php  require_once("Includes/DB.php"); ?>
<?php  require_once("Includes/Functions.php"); ?>
<?php  require_once("Includes/Sessions.php"); ?>
<?php  Confirm_Login();?>
<?php 
$SearchQueryParameter = $_GET['id'];
//Fetching Existing Content According to our post
global $ConnectingDB;
$sql = "SELECT *   FROM posts WHERE id ='$SearchQueryParameter'";
$stmt = $ConnectingDB->query($sql);
while ($DataRows=$stmt->fetch())
{
   $TitleToBeDeleted    = $DataRows['title'];
   $CategoryToBeDeleted = $DataRows['category'];
   $ImageToBeDeleted    = $DataRows['image'];
   $PostToBeDeleted     = $DataRows['post'];
   # code...
}
// echo $ImageToBeUpdated;
if(isset($_POST["Submit"]))
{

    // query to Delete  post in DB when everything is fine
    global $ConnectingDB;
   $sql = "DELETE FROM posts WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);
   
    // var_dump($Execute);
    if($Execute)
    {
        $Target_Path_To_DELETE_Image = "Uploads/$ImageToBeDeleted";
        unlink($Target_Path_To_DELETE_Image);
        $_SESSION["SuccessMessage"]= "Post Deleted  Successfully";
        Redirect_to("Posts.php");
    }
    else
    {
        $_SESSION["ErrorMessage"]= "Something went wrong.Try Again !";
        Redirect_to("Posts.php");
    }
}


 // Ending of Submit Button If -Condition

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
    <title>Delete Post</title>
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
                        <a href="MyProfile.php" class="nav-link"> <i class="fa-solid fa-user text-success"></i> My
                            Profile</a>
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
                    <h1><i class="fas fa-edit" style="color: yellow;"></i> Delete Post</h1>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END -->

    <!--   MAIN AREA -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10" style="min-height:500px";>
            <!-- Calling out the  error and success function in the sessions.php file -->
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            
            ?>
                <form class="" action="DeletePost.php?id=<?php echo $SearchQueryParameter; ?>" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3 ">
                        
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"> <span class="FieldInfo"> Post:Title: </span></label>
                                <input disabled class="form-control" type="text" name="PostTitle" placeholder="Type title here"
                                    id="title" value="<?php echo $TitleToBeDeleted; ?>">
                            </div>
                            <div class="form-group">
                                <span class="FieldInfo">Existing Category:</span>
                                <?php echo $CategoryToBeDeleted; ?>
                                <br>                          
                            </div>
                            <!-- for the image select div -->
                            <div class="form-group">
                            <span class="FieldInfo">Existing Image:</span>
                            <img class="mb-1" src="Uploads/<?php echo $ImageToBeDeleted; ?>" width=170px; height="70px">
                            </div>
                            <!-- for  -->
                            <div class="form-group">
                            <label for="Post"> <span class="FieldInfo"> Post: </span></label>
                            <textarea disabled class="form-control" id="Post" name="PostDescription" id="" cols="80" rows="8">
                                <?php echo $PostToBeDeleted; ?>
                            </textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Dashboard.php" class="btn btn-warning btn-block"><i
                                            class="fas fa-arrow-left"></i>Back To Dashboard</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="Submit" class="btn btn-danger btn-block">
                                        <i class="fas fa-trash"></i>Delete
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