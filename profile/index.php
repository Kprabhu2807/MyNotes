<?php 
require_once "../config/config.php";
session_start();
if(!$_SESSION["isLoggedIn"]){
    header("Location: /MyNotes/user_authenticate/login");
}else{
    $email = $_SESSION["email"];
    $sql = "SELECT * FROM users WHERE email='$email'";
    $fire = mysqli_query($conn, $sql);
    if(mysqli_num_rows($fire)==1){
        $user = mysqli_fetch_assoc($fire);
        $firstName = $user["firstName"];
        $lastName = $user["lastName"];
    }

    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
                    <a class="nav-link" href="/MyNotes/profile">
                        <?php echo $_SESSION["email"]; ?>
                        <span class="sr-only">(current)</span>
                    </a>
                </li>

            </ul>
        </div>
    </nav>

    <?php if(isset($_GET["update"]) && $_SESSION["isUpdated"]) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Your profile was updated successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php $_SESSION["isUpdated"]= false; endif ;?>
    <div class="container mt-4">
        <h3>User Details</h3>
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
        <form action="profile_update.php?id=<?php echo $_SESSION["id"]; ?>" method="post">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" readonly class="form-control" name="firstName" id="firstName"
                    value="<?php echo $firstName; ?>">

            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" readonly class="form-control" name="lastName" id="lastName"
                    value="<?php echo $lastName; ?>">

            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="text" readonly class="form-control" name="email" id="email" value="<?php echo $email; ?>">


            </div>
            <input type="submit" class="btn btn-outline-primary mb-2" value="Edit" name="edit" />
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