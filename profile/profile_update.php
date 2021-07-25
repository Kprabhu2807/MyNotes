<?php 
    require_once "../config/config.php";
    session_start();
    if(!$_SESSION["isLoggedIn"]){
        header("Location: /MyNotes/user_authenticate/login");
    }elseif ($_SESSION["id"] != $_GET["id"]) {
        header("Location: /MyNotes/profile");
    }else{
        $id_get = $_GET["id"];
        $sql = "SELECT * FROM `users` WHERE id='$id_get'";
        $fire = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($fire);
        $id = $data["id"];
        $firstName = $data["firstName"];
        $lastName = $data["lastName"];
        $email = $data["email"];
        $_SESSION["isUpdated"] = false;
    }
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["update"])){
            $firstName = $_POST["firstName"];
            $lastName = $_POST["lastName"];
            $email = $_POST["email"];
            $id_post = $_POST["id"];
            $firstName_err = $lastName_err = $email_err = "";
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
        
                
                $sql = "SELECT * FROM `users` WHERE email='$email'";
                $fire = mysqli_query($conn,$sql);
                $data = mysqli_fetch_assoc($fire);
                if(mysqli_num_rows($fire)==1 && $data["id"] != $id_post){
                    $email_err="Provided Email is already taken.";
                }
            }
        }
        if(empty($firstName_err) && empty($lastName_err) && empty($email_err) && ($_SESSION["id"]==$id)&&($id==$_GET["id"])){
            $sql = "UPDATE `users` SET `firstName`='$firstName',`lastName`='$lastName',`email`='$email' WHERE id='$id_post'";
            $fire = mysqli_query($conn, $sql);
            $_SESSION["isUpdated"] = true;
            $_SESSION["email"] = $email;
            header("Location: /MyNotes/profile/index.php?update=true");
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <style>
    .profile {
        width: 8em;
        height: 8em;
        background-color: #b19cd9;
        border-radius: 50%;
    }

    .ptext {
        position: relative;
        margin: 0;
        padding: 0;
        top: 20%;
        font-size: 50px;
        font-weight: bold;
    }

    #loading {
        position: absolute;
        top: 50%;
        left: 50%;
        z-index: 10;
    }
    </style>
    <title>Update Details</title>
</head>

<body>
    <div class="d-flex justify-content-center">
        <div class="spinner-border text-primary" id="loading" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Navbar -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="font-family: Arial, Helvetica, sans-serif;">
        <a class="navbar-brand" href="/MyNotes/public">MyNotes</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/MyNotes/public">Home </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/MyNotes/contact_us">Contact us</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/MyNotes/notes">My Notes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/MyNotes/user_authenticate/logout.php">Log Out</a>
                </li>
                <li class="nav-item active ml-lg-4">
                    <a class="nav-link" href="profile.php">
                        <?php echo $_SESSION["email"]; ?>
                        <span class="sr-only">(current)</span>
                    </a>
                </li>

            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        <h3>Update User Details</h3>
        <div class="container text-center">
            <div class="container profile">
                <div class="container ptext">
                    <?php 
                        $initials = $firstName[0].$lastName[0];
                        echo strtoupper($initials) ; ?>
                </div>
            </div>
        </div>
        <hr>
        <form method="post">
            <input hidden value="<?php echo $id; ?>" name="id" />
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" name="firstName" id="firstName"
                    value="<?php echo $firstName; ?>">
                <?php if(!empty($firstName_err)): ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?php echo $firstName_err; ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" name="lastName" id="lastName" value="<?php echo $lastName; ?>">
                <?php if(!empty($lastName_err)): ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?php echo $lastName_err; ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="text" class="form-control" name="email" id="email" value="<?php echo $email; ?>">
                <?php if(!empty($email_err)): ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?php echo $email_err; ?>
                </div>
                <?php endif; ?>
            </div>
            <input type="submit" class="btn btn-warning mb-2" value="Update" name="update" />
        </form>
    </div>



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