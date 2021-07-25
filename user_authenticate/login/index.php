<?php
session_start();
if(isset($_SESSION["isLoggedIn"])){
    header("Location: /MyNotes/public");
    exit();
}
require_once "../../config/config.php";

$email_err = $password_err = $login_err = "";


if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["submit"])){
    
    
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    
    
    if(empty(trim($email))){
        $email_err = "Email field cannot be empty";
    }else{
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid Email address.";
        }
    }
    
    if(empty(trim($password))){
        $password_err = "Password field cannot be empty";
    }
    if(empty($email_err) && empty($password_err)){
        $sql = "SELECT * FROM `users` WHERE email='$email'";
        $fire = mysqli_query($conn, $sql);
        if(mysqli_num_rows($fire)==1){
            $data = mysqli_fetch_assoc($fire);
            // Password verify takes two arguments
            //one is password entered not the hashed one
            // another is hashed password from the database
            if(password_verify($password,$data["password"])){
                session_start();
                $_SESSION["email"] = $email;
                $_SESSION["id"] = $data["id"];
                $_SESSION["isLoggedIn"] = true;

                // redirect user to welcome page.
                header("Location: /MyNotes/public");
                exit();
            }
            else{
                $password_err = "Incorrect password.";
            }
        }else{
            $login_err = "You are not a registered user please <a href='register.php'>click here</a> to register.";
        }
        
    }
    
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <style>
    body,
    html {
        height: 100%;
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
    }

    #loading {
        position: absolute;
        top: 50%;
        left: 50%;

    }
    </style>
    <title>Login</title>

</head>

<body>
    <div class="d-flex justify-content-center">
        <div class="spinner-border text-primary" id="loading" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/MyNotes/public">MyNotes</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/MyNotes/public">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/MyNotes/contact_us">Contact us</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/MyNotes/user_authenticate/register">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="/MyNotes/user_authenticate/login">Log In <span
                            class="sr-only">(current)</span></a>
                </li>



            </ul>
        </div>
    </nav>

    <?php if(isset($_GET["registered"]) && $_SESSION["isRegistered"]): ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        Please Log In with the registered credentials.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php $_SESSION["isRegistered"]=false; endif; ?>

    <div class="container mt-4">
        <h3>User Login</h3>
        <hr>

        <form method="post">

            <div class="form-group">
                <label for="email">Email address</label>
                <input type="text" class="form-control" name="email" id="email"
                    value="<?php if(isset($_POST["email"])) echo $_POST["email"] ?>">
                <?php if(!empty($email_err)): ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?php echo $email_err; ?>
                </div>
                <?php endif; ?>

            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password"
                    value="<?php if(isset($_POST["password"])) echo $_POST["password"] ?>">
                <?php if(!empty($password_err)): ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?php echo $password_err; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php if(!empty($login_err)): ?>
            <div class="alert alert-primary mt-3" role="alert">
                <?php echo $login_err; ?>
            </div>
            <?php endif; ?>

            <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <script>
    window.addEventListener("load", () => {
        document.querySelector("#loading").style.display = "none";
    })
    </script>
</body>

</html>