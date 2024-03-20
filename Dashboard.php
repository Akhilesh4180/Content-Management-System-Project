<?php  require_once("Includes/DB.php"); ?>
<?php  require_once("Includes/Functions.php"); ?>
<?php  require_once("Includes/Sessions.php"); ?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
// echo $_SESSION["TrackingURL"];
Confirm_Login();?>
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
    <title>Dashboard</title>
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
                    <h1><i class="fas fa-cog" style="color: yellow;"></i>Dashboard</h1>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="AddNewPost.php" class="btn btn-primary btn-block">
                        <i class="fas fa-edit"></i>Add New Post
                    </a>


                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Categories.php" class="btn btn-info btn-block">
                        <i class="fas fa-folder-plus"></i>Add New Category
                    </a>


                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Admins.php" class="btn btn-warning btn-block">
                        <i class="fas fa-user-plus"></i>Add New Admin
                    </a>


                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Comments.php" class="btn btn-success btn-block">
                        <i class="fas fa-check"></i>Approve Comments
                    </a>


                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END -->

    <!--   MAIN AREA -->
    <section class="container py-2 mb-4">
        <div class="row">
            <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <!-- Left side Area Start -->
            <div class="col-lg-2 d-none d-md-block">
                <!-- Posts -->
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Posts</h1>
                        <h4 class="display-5">
                            <i class="fab fa-readme"></i>
                            <?php  TotalPosts();   ?>
                        </h4>
                    </div>
                </div>
                <!-- Categories -->
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Categories</h1>
                        <h4 class="display-5">
                            <i class="fas fa-folder"></i>
                            <?php  TotalCategories();   ?>
                        </h4>
                    </div>
                </div>
                <!-- Admins -->
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Admins</h1>
                        <h4 class="display-5">
                            <i class="fas fa-users"></i>
                            <?php  TotalAdmins();   ?>
                        </h4>
                    </div>
                </div>
                <!-- Comments -->
                <div class="card text-center bg-dark text-white mb-3">
                    <div class="card-body">
                        <h1 class="lead">Comments</h1>
                        <h4 class="display-5">
                            <i class="fas fa-comments"></i>
                            <?php  TotalComments();   ?>
                        </h4>
                    </div>

                </div>
            </div>
            <!-- Left side Area Start -->

            <!-- Right side ara start -->
            <div class="col-lg-10">
                <h1>Top Posts</h1>
                <table class="table table-stripped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Date&Time</th>
                            <th>Author</th>
                            <th>Comments</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <?php 
                        $SrNo = 0;
                        global $ConnectingDB;
                        $sql = "SELECT * FROM  posts ORDER BY id desc LIMIT 0,5";
                        $stmt = $ConnectingDB->query($sql);
                        while ($DataRows=$stmt->fetch())
                        {
                            $PostId = $DataRows["id"];
                            $DateTime = $DataRows["datetime"];
                            $Author = $DataRows["author"];
                            $Title = $DataRows["title"];
                            $SrNo++;
                            # code...
                        
                    ?>
                    <tbody>
                        <tr>
                            <td>
                                <?php echo $SrNo; ?>
                            </td>
                            <td>
                                <?php echo $Title;?>
                            </td>
                            <td>
                                <?php echo $DateTime?>
                            </td>
                            <td>
                                <?php echo $Author;?>
                            </td>
                            <td>

                           <?php 
                                $Total=ApproveCommentAccordingtoPost($PostId);
                                if ($Total>0) 
                                {
                            ?>
                                <span class="badge badge-success">
                                    <?php echo $Total; ?>
                                </span>
                                <!-- ending of if below -->
                                <?php  } ?>
                                
                                </span>

                            <?php 
                                 $Total=DisApproveCommentAccordingtoPost($PostId);
                                if ($Total>0) 
                                {
                             ?>
                                <span class="badge badge-danger">
                                    <?php echo $Total; ?>
                                </span>
                                <!-- ending of if below -->
                                <?php  } ?>
                                
                                </span>
                            </td>
                            <td>
                                <a target="_blank" href="FullPost.php?id=<?php echo $PostId;?>">
                                    <span class="btn btn-info">Preview</span>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                    <?php } ?>
                </table>
            </div>
            <!-- Right side ara end -->
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