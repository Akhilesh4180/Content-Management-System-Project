<?php  require_once("Includes/DB.php"); ?>
<?php  require_once("Includes/Functions.php"); ?>
<?php  require_once("Includes/Sessions.php"); ?>
<?php 

if(isset($_SESSION["User_ID"]))
{
    Redirect_to("Dashboard.php");
}

if(isset($_POST["Submit"]))
{
    $UserName = $_POST["Username"];
    $Password = $_POST["Password"];
    if (empty($UserName)||empty($Password))
    {
        $_SESSION["ErrorMessage"] = "All the fields must be filled out" ;
        Redirect_to("Login.php");
    }
    else
    {
        //  code Checking for  username and password  form the database
        $Found_Account = Login_Attempt($UserName,$Password);
        if ($Found_Account) 
        {
            $_SESSION["User_ID"]=$Found_Account["id"];
            $_SESSION["Username"]=$Found_Account["username"];
            $_SESSION["AdminName"]=$Found_Account["aname"];
            $_SESSION["SuccessMessage"] = "Welcome " .$_SESSION["AdminName"];
            if(isset($_SESSION["TrackingURL"]))
            {
                Redirect_to($_SESSION["TrackingURL"]);

            }
            else
            {

                Redirect_to("Dashboard.php");
            }
        }
        else
        {
            $_SESSION["ErrorMessage"] = "Incorrect Username and Password";
            Redirect_to("Login.php");
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
    <title>Login Page</title>
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
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->
    <!-- Main Area Start  -->

    <section class="container py-2 mb-4">
    <div class="row">
        <div class=" offset-sm-3 col-sm-6" style="min-height:550px;">
        <br><br><br><br>
        <?php
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
        <div class="card bg-secondary text-light">
            <div class="card-header">
                <h4>Welcome Back !</h4>
                </div>
                <div class="card-body bg-dark">
                
                <form  class="" action="Login.php" method="post">
                    <!-- username -->
                    <div class="form-group">
                        <label for="username"><span class="FieldInfo">Username:</span></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" name="Username" id="username" value="">
                        </div>
                    </div>
                    <!-- Password -->
                    <div class="form-group">
                        <label for="password"><span class="FieldInfo">Password:</span></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control" name="Password" id="password" value="">
                        </div>
                    </div>
                    <input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
                </form>
            </div>

        </div>
        </div>
    </div>
    </section>
    <!-- Main Area end  -->
   
    <br><br>

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