<?php  require_once("Includes/DB.php"); ?>
<?php  require_once("Includes/Functions.php"); ?>
<?php  require_once("Includes/Sessions.php"); ?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login();?>
<?php 
if(isset($_POST["Submit"]))
{
    $PostTitle = $_POST["PostTitle"];
    $Category  = $_POST["Category"];
    $Image     = $_FILES["Image"]["name"];
    $Target    = "Uploads/".basename($_FILES["Image"]["name"]);
    $PostText  = $_POST["PostDescription"];
    $Admin = $_SESSION["Username"];
    date_default_timezone_set("Asia/Mumbai");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y  %H:%M:%S" , $CurrentTime);

if(empty($PostTitle))
{
    $_SESSION["ErrorMessage"] = "Title Cannot be empyt" ;
    Redirect_to("AddNewPost.php");
}
elseif (strlen($PostTitle)<5){
    $_SESSION["ErrorMessage"] = "Post Title should be greater than 5 characters" ;
    Redirect_to("AddNewPost.php");
}
elseif (strlen($PostDescription)>9999){
    $_SESSION["ErrorMessage"] = "Post Description should be less than 1000 characters" ;
    Redirect_to("AddNewPost.php");
}
else
{
    // query to insert category to the DB when everything is fine
    global $ConnectingDB;
    $sql = "INSERT INTO posts(datetime,title,category,author,image,post)";
    $sql .= "VALUES(:dateTime,:postTitle,:categoryName,:adminName,:imageName,:postDescription)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':dateTime',$DateTime);
    $stmt->bindValue(':postTitle',$PostTitle);
    $stmt->bindValue(':categoryName',$Category);
    $stmt->bindValue(':adminName',$Admin);
    $stmt->bindValue(':imageName',$Image);
    $stmt->bindValue(':postDescription',$PostText);
    $Execute=$stmt->execute();
    move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);

    if($Execute)
    {
        $_SESSION["SuccessMessage"]= "Post with id : ".$ConnectingDB->lastInsertId()." added Successfully";
        Redirect_to("AddNewPost.php");
    }
    else
    {
        $_SESSION["ErrorMessage"]= "Something went wrong.Try Again !";
        Redirect_to("AddNewPost.php");
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
    <title>Add New Post</title>
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
                        <a href="ManageAdmins.php" class="nav-link">Manage Admins</a>
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
                    <h1><i class="fas fa-edit" style="color: yellow;"></i> Add New Post</h1>
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
                <form class="" action="AddNewPost.php" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3 ">
                        
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"> <span class="FieldInfo"> Post:Title: </span></label>
                                <input class="form-control" type="text" name="PostTitle" placeholder="Type title here"
                                    id="title" value="">
                            </div>
                            <div class="form-group">
                                <label for="CategoryTitle"> <span class="FieldInfo"> Chose Category </span></label>
                                <select class="form-control" id="CategoryTitle" name="Category">
                                   <?php
                                // Fetching all the categories  from category table
                                global $ConnectingDB;
                                $sql = "SELECT id,title FROM category";
                                $stmt = $ConnectingDB->query($sql);
                                while ($DataRows = $stmt->fetch()) {
                                    $Id = $DataRows["id"];
                                    $CategoryName = $DataRows["title"];   
                                
                                ?>
                                <option > <?php echo $CategoryName; ?></option>
                            <?php } ?>
                            </select>                                    
                            </div>
                            <!-- for the image select div -->
                            <div class="form-group mb-1">
                            <div class="custom-file">
                            <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                            <label for="imageSelect" class="custom-file-label">Select Image</label>
                            </div>
                            </div>
                            <!-- for  -->
                            <div class="form-group">
                            <label for="Post"> <span class="FieldInfo"> Post: </span></label>
                            <textarea class="form-control" id="Post" name="PostDescription" id="" cols="80" rows="8"></textarea>
                            </div>
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