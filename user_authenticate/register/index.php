<?php
session_start();
if(isset($_SESSION["isLoggedIn"])){
    header("Location: welcome.php");
    exit();
}
require_once "../../config/config.php";


$firstName_err = $lastName_err = $email_err = $password_err = $confirm_password_err = $register_err = "";

if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["submit"])){
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    
    if(empty(trim($firstName))){
        $firstName_err = "First name field cannot be empty";
    }
    if(empty(trim($lastName))){
        $lastName_err = "Last name field cannot be empty";
    }
    if(empty(trim($email))){
        $email_err = "Email field cannot be empty";
    }else{
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid Email address.";
        }else{

        
        $sql = "SELECT `id` FROM `users` WHERE email='$email'";
        $fire = mysqli_query($conn,$sql);
        if(mysqli_num_rows($fire)==1){
            $email_err="Provided Email is already taken.";
            $register_err = "If you have already registered then <a href='login.php'>click here</a> to login.";
        }
    }
}
    
    if(empty(trim($password))){
        $password_err = "Password field cannot be empty";
    }else{
        // regex for password
        // Length
        $re_password_length = '~^[\w!@#$%^&+_]{6,20}$~';

        preg_match($re_password_length, $password, $password_length, PREG_OFFSET_CAPTURE, 0);

        if (count($password_length) == 0) {
            $password_err = "Please enter password of minimum length of 6 and maximum of 20.<br>";
        }
    // Atleast one lowercase letter
    $re_password_lower = '~[a-z]+~';

    preg_match($re_password_lower, $password, $password_lower, PREG_OFFSET_CAPTURE, 0);

    if (count($password_lower) == 0) {
    $password_err .= "Password should have atleast one lowercase letter.<br>";
    }

    // Atleast one uppercase letter
    $re_password_upper = '~[A-Z]+~';

    preg_match($re_password_upper, $password, $password_upper, PREG_OFFSET_CAPTURE, 0);

    if (count($password_upper) == 0) {
    $password_err .= "Password should have atleast one uppercase letter.<br>";
    }

    // Atleast one digit letter
    $re_password_digit = '~[0-9]+~';

    preg_match($re_password_digit, $password, $password_digit, PREG_OFFSET_CAPTURE, 0);

    if (count($password_digit) == 0) {
    $password_err .= "Password should have atleast one digit.<br>";
    }

    // Atleast one special letter
    $re_password_special = '~[!@#$%^&+_]+~';

    preg_match($re_password_special, $password, $password_special, PREG_OFFSET_CAPTURE, 0);

    if (count($password_special) == 0) {
    $password_err .= "Password should have atleast one special character i.e. !@#$%^&+_ <br>";
        }
    
    }

    if(empty(trim($confirm_password))){
        $confirm_password_err = "Confirm password field cannot be empty";
    }else{
        if(trim($password) != trim($confirm_password)){
            $confirm_password_err = "Confirm password should match.";   
        }
    }

    if(empty($firstName_err) && empty($lastName_err) && empty($email_err) &&empty($password_err) && empty($confirm_password_err)){
        $password = password_hash($password,PASSWORD_DEFAULT);
        $sql = "INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `password`, `stamp`) VALUES (NULL, '$firstName', '$lastName', '$email', '$password', current_timestamp())";
        $fire = mysqli_query($conn, $sql);
        session_start();
        $_SESSION["isRegistered"] = true;
        header("Location: /MyNotes/user_authenticate/login/index.php?registered=true");
        exit();
        
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
    <title>Register</title>

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
                <li class="nav-item active">
                    <a class="nav-link" href="/MyNotes/user_authenticate/register">Register <span
                            class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/MyNotes/user_authenticate/login">Log In</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        <h3>User Registeration</h3>
        <hr>
        <form method="post">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" name="firstName" id="firstName"
                    value="<?php if(isset($_POST["firstName"])) echo $_POST["firstName"] ?>">

                <?php if(!empty($firstName_err)): ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?php echo $firstName_err; ?>
                </div>
                <?php endif; ?>



            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" name="lastName" id="lastName"
                    value="<?php if(isset($_POST["lastName"])) echo $_POST["lastName"] ?>">
                <?php if(!empty($lastName_err)): ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?php echo $lastName_err; ?>
                </div>
                <?php endif; ?>

            </div>
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
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                    value="<?php if(isset($_POST["confirm_password"])) echo $_POST["confirm_password"] ?>">

                <?php if(!empty($confirm_password_err)): ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?php echo $confirm_password_err; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php if(!empty($register_err)): ?>
            <div class="alert alert-primary mt-3" role="alert">
                <?php echo $register_err; ?>
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