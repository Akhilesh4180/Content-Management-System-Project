<?php  require_once("Includes/DB.php"); ?>
<?php  require_once("Includes/Functions.php"); ?>
<?php  require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login();?>
<?php 
if(isset($_POST["Submit"]))
{ 
    $Category  = $_POST["CategoryTitle"];
    $Admin = $_SESSION["Username"];
    date_default_timezone_set("Asia/Mumbai");
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y  %H:%M:%S" , $CurrentTime);

if(empty($Category))
{
    $_SESSION["ErrorMessage"] = "All fields must be filled out" ;
    Redirect_to("Categories.php");
}
elseif (strlen($Category)<3){
    $_SESSION["ErrorMessage"] = "Category Title should be greater than 2 characters" ;
    Redirect_to("Categories.php");
}
elseif (strlen($Category)>49){
    $_SESSION["ErrorMessage"] = "Category title should be less than 50 characters" ;
    Redirect_to("Categories.php");
}
else
{
    // query to insert category to the DB when everything is fine
    global $ConnectingDB;
    $sql = "INSERT INTO category(title,author,datetime)";
    $sql .= "VALUES(:categoryName,:adminName,:datetime)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':categoryName',$Category);
    $stmt->bindValue(':adminName',$Admin);
    $stmt->bindValue(':datetime',$DateTime);
    $Execute=$stmt->execute();
    if($Execute)
    {
        $_SESSION["SuccessMessage"]= "Category with id : ".$ConnectingDB->lastInsertId()." added Successfully";
        Redirect_to("Categories.php");
    }
    else
    {
        $_SESSION["ErrorMessage"]= "Something went wrong.Try Again !";
        Redirect_to("Categories.php");
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
    <title>Categories</title>
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
                        <a href="MyProfile.php" class="nav-link"> <i class="fa-solid fa-user text-success"></i> Manage
                            Categories</a>
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
                <form class="" action="Categories.php" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3 ">
                        <div class="card-header">
                            <h1>Add New Category</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"> <span class="FieldInfo"> Category:Title: </span></label>
                                <input class="form-control" type="text" name="CategoryTitle" placeholder="Type title here"
                                    id="title" value="">
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
                <h2>Existing Categories</h2>
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>No. </th>
                    <th>Date&Time</th>
                    <th>Category Name</th>
                    <th>Creator Name</th>
                    <th>Action</th>   
                </tr>
                </thead>
            <?php
                    global $ConnectingDB;
                    $sql = "SELECT * FROM category  ORDER BY id desc";
                    $Execute = $ConnectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $Execute->fetch()) 
                    {
                        $CategoryId = $DataRows["id"];
                        $CategoryDate = $DataRows["datetime"];
                        $CategoryName = $DataRows["title"];
                        $CreatorName = $DataRows["author"];
                        $SrNo++;                    
            ?>
            <tbody>
            <tr>
                <td><?php echo htmlentities($SrNo) ; ?></td>
                <td><?php echo htmlentities($CategoryDate); ?></td>
                <td><?php echo htmlentities($CategoryName); ?></td>
                <td><?php echo htmlentities($CreatorName); ?></td>
                <td> <a href="DeleteCategory.php?id=<?php echo $CategoryId; ?>" class="btn btn-danger">Delete</a></td>
                
            </tr>
            </tbody>
            <?php } ?>
            </table>
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