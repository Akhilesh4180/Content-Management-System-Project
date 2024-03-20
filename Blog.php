<?php  require_once("Includes/DB.php"); ?>
<?php  require_once("Includes/Functions.php"); ?>
<?php  require_once("Includes/Sessions.php"); ?>
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
    <title>Blog page</title>
    <style media="screen">
    .heading{
    font-family: Bitter,Georgia, 'Times New Roman', Times, serif;
    font-weight: bold;
    color: #005E90;
}
.heading:hover {
    color: #0090DB;
}
    </style>
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
   <div class="container">
    <div class="row mt-4">

    <!-- main area start -->
        <div class="col-sm-8">
        <h1>The Complete Resoponse CMS Blog</h1>
        <h1 class="lead">The Complete blog by using PHP by Akhilesh Yadav</h1>
        <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
        <?php 
        global $ConnectingDB;
        //Sql query when Search button is active
        if(isset($_GET["SearchButton"])){
            $Search = $_GET["Search"];
            $sql =  "SELECT * FROM  posts
            WHERE datetime LIKE :search
            OR title LIKE :search
            OR category LIKE :search
            OR post LIKE :search";
            $stmt = $ConnectingDB->prepare($sql);
            $stmt->bindValue(':search','%'.$Search.'%'); 
            $stmt->execute();
        }
        //Query when pagination is active i.e Blog.php?page=1
        elseif (isset($_GET["page"]))
        {
            $Page = $_GET["page"];
            if($Page==0 || $Page<1)
            {
                $ShowPostFrom = 0;
            }
            else
            {
                $ShowPostFrom=($Page*5)-5;
            }
            $sql = "SELECT * FROM posts  ORDER BY id desc LIMIT $ShowPostFrom,5";
            $stmt = $ConnectingDB->query($sql);
        }
        //Query when category is active in the URL tab
        elseif (isset($_GET["category"]))
        {
            $Category = $_GET["category"];
            $sql = "SELECT * FROM posts WHERE category='$Category' ORDER BY id desc";
            $stmt = $ConnectingDB->query($sql);
        }
        //The default sql query
       else{ 
        $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,3";
        $stmt = $ConnectingDB->query($sql);
       }
        
        while ($DataRows = $stmt->fetch()) {
            $PostId           = $DataRows["id"] ;
            $DateTime         = $DataRows["datetime"] ;
            $PostTitle        = $DataRows["title"] ;
            $Category         = $DataRows["category"] ;
            $Admin            = $DataRows["author"] ;
            $Image            = $DataRows["image"] ;
            $PostDescription  = $DataRows["post"] ;
        
        ?>
        <div class="card">
            <img src="Uploads/<?php echo htmlentities($Image); ?>" style="max-height:450px;" class="img-fluid card-img-top" />
            <div class="card-body">
                <h4 class="card-title"><?php  echo htmlentities($PostTitle); ?></h4>
                <small class="text-muted">Category: <span class="text-dark"> <a href="Blog.php?category=<?php echo htmlentities($Category); ?>"> <?php echo  htmlentities($Category); ?> </a> </span>  &  Written by <span class="text-dark"> <a href="Profile.php?username=<?php echo htmlentities($Admin); ?>"><?php echo htmlentities($Admin); ?></a> </span> On <span class="text-dark"><?php echo htmlentities($DateTime); ?></small>
                <span style="float:right;" class="badge badge-dark text-ligh">Comments 
                <?php echo ApproveCommentAccordingtoPost($PostId); ?>
            </span>
                <hr>
                <p class="card-text">
                    <?php if(strlen($PostDescription)>150){   $PostDescription = substr ($PostDescription,0,150)."..."; } echo htmlentities($PostDescription); ?></p>
                <a href="FullPost.php?id=<?php echo $PostId; ?>" style="float:right;">
                <span class="btn btn-info">Read More >> </span>
                </a>
            </div>
        </div>
        <?php } ?>

        <!-- Pagination -->
        <nav>
            <ul class="pagination pagination-lg">
                <!-- Backward buuton  start-->
            <?php 
            if(isset($Page))
            {
                if ($Page>1) {?>
                <li class="page-item ">
                   <a href="Blog.php?page=<?php echo $Page-1; ?>" class="page-link">&laquo;</a>
                </li>
             <?php } } ?>
            <!-- Backward buuton  end-->
            <?php
            global $ConnectingDB;
            $sql = "SELECT COUNT(*) FROM posts";
            $stmt=$ConnectingDB->query($sql);
            $RowPagination=$stmt->fetch();
            $TotalPosts=array_shift($RowPagination);
            // echo $TotalPosts."<br>";
            $PostPaginaton=$TotalPosts/5;
            $PostPaginaton=ceil($PostPaginaton);
            // echo $PostPaginaton;
            for ($i=1; $i <= $PostPaginaton ; $i++) 
            { 
                if(isset($Page))   
                {
                    if ($i==$Page)
                    {
                ?>
                    <li class="page-item active">
                        <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                    </li>
                    <?php
                    }
                    else 
                    {
                    ?> 
                       <li class="page-item ">
                        <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                    </li>

            <?php  
                  }
            } }   
            
            ?>

            <!-- Creating the Forward button -->
            <?php 
            if(isset($Page)&&!empty($Page))
            {
                if ($Page+1<=$PostPaginaton) {?>
                <li class="page-item ">
                   <a href="Blog.php?page=<?php echo $Page+1; ?>" class="page-link">&raquo;</a>
                </li>
             <?php } } ?>

            </ul>
        </nav>

        </div>
        <!-- Main area End -->


        <!-- Side area start -->
        <div class=" col-sm-4">
        <div class="card mt-4">
            <div class="card-body">
                <img src="Images/blog3.jpg" class="d-block img-fluid mb-3" alt="">
                <div class="text-center">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste sed accusamus aperiam ipsum quos, illo nemo fugit, quis expedita accusantium laudantium. Consequatur nesciunt voluptate nihil inventore tenetur. Quaerat, ut beatae.
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quis quidem dolore esse, sequi nobis cumque praesentium reiciendis, repudiandae asperiores provident animi itaque, odit facere aliquid! Pariatur ducimus consequatur quo, necessitatibus praesentium accusamus. Doloribus soluta fugiat nemo odit temporibus molestias corrupti, voluptatibus voluptatem eaque dolorum laborum quasi, tempora praesentium id rerum?
                </div>
            </div>
        </div>
        <br>
        <div class="card">
        <div class="card-header bg-dark text-light">
            <h2 class="lead">Sing Up !</h2>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-success btn-block text-center text-white mb-4" name="button">
                Join the Forum
            </button>
            <button type="button" class="btn btn-danger btn-block text-center text-white mb-4" name="button">
                    Login
            </button>
            <div class="input-group mb-3">
                    <input type="text" class="form-control" name="" placeholder="Enter your email" value="">
                    <div class="input-group-append">
                <button type="button" class="btn btn-primary btn-sm text-centre text-white" name="button">
                    Subscribe Now 
                </button>
            </div>
            </div>    
        </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header bg-primary text-light">
                <h2 class="lead">Categories</h2>
                </div>
                <div class="card-body">
                    <?php
                    global $ConnectingDB;
                    $sql="SELECT * FROM category ORDER BY id desc";
                    $stmt = $ConnectingDB->query($sql);
                    while ($DataRows=$stmt->fetch())
                    {
                        $CategoryId = $DataRows["id"];
                        $CategoryName = $DataRows["title"];
                    ?>
                  <a href="Blog.php?category=<?php echo $CategoryName; ?>">  <span class="heading"><?php echo $CategoryName; ?></span></a><br>
                    <?php } ?>
            </div>
        </div>
        <br>
        <div class="card">
            <div class="card-header bg-info text-white">
                        <h2 class="lead">Recent Post</h2>
            </div>
            <div class="card-body">
                <?php 
                    global $ConnectingDB;
                    $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                    $stmt = $ConnectingDB->query($sql);
                    while ($DataRows=$stmt->fetch())
                    {
                        $Id         =$DataRows["id"];
                        $Title      =$DataRows["title"];
                        $DateTime   =$DataRows["datetime"];
                        $Image      =$DataRows["image"];
                    
                ?>
                <div class="media">
                    <img src="Uploads/<?php  echo $Image; ?>" class="d-block img-fluid aligh-self-start" width="90" height="94" alt="">
                    <div class="media-body ml-2">
                        <a href=""></a><h6 class="lead"><?php echo $Title;?></h6>
                        <p class="small"><?php echo $DateTime;?></p>
                    </div>
                </div>
                <hr>
                <?php  } ?>
            </div>
        </div>

        </div>
        <!-- side area end -->
    </div>
   </div>

    <!-- HEADER END -->
<br>    
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