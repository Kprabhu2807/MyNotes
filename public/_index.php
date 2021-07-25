<?php
session_start();
require_once "../config/config.php";
$loggedInNav = false;

if(isset($_SESSION["isLoggedIn"])){
    $loggedInNav = true;
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

    <title>MyNotes</title>
    <style>
    body,
    html {
        height: 100%;
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
    }

    * {
        box-sizing: border-box;
    }

    .bg-image {
        /* The image used */
        background-image: url("../images/myimage2.jpg");

        /* Add the blur effect */
        filter: blur(8px);
        -webkit-filter: blur(8px);

        /* Full height */
        height: 100%;

        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;


    }

    .bg-text {
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/opacity/see-through */
        color: white;
        font-weight: bold;
        border: 3px solid #f1f1f1;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        /* z-index: 2; */
        width: 80%;
        padding: 20px;
        text-align: center;
        font-size: large;
    }

    .sim-button .button1 {

        color: white;
        font-weight: bold;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        /* z-index: 2; */
        width: 80%;
        padding: 20px;
        text-align: right;
    }


    /* .overlay {
        position: absolute;
        top: 100px;
        left: 0;
        bottom: 0;
        right: 0;
        height: 75%;
        width: 100%;
        opacity: 0;
        transition: .5s ease;
        align: center;
    } */

    /* .container:hover .overlay {
        opacity: 1;
    } */

    .sim-button {
        line-height: 50px;
        height: 50px;
        text-align: center;
        margin-right: auto;
        margin-left: auto;
        margin-top: 125px;
        width: 11%;
        cursor: pointer;
    }

    .button1 {
        color: black;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
        -o-transition: all 0.5s;
        transition: all 0.5s;
        position: relative;
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .button1 a {
        color: rgba(51, 51, 51, 1);
        text-decoration: none;
        display: block;
    }

    .button1:hover {
        background-color: #7B68EE;
        -webkit-border-radius: 25px;
        -moz-border-radius: 25px;
        border-radius: 25px;
    }

    #loading {
        position: absolute;
        top: 50%;
        left: 50%;
        z-index: 10;
    }

    /* @media only screen and (max-width:600px) {
        .overlay {
            top: 300px;
        }
    } */
    </style>
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
                <li class="nav-item active">
                    <a class="nav-link" href="/MyNotes/public">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/MyNotes/contact_us">Contact us</a>
                </li>
                <?php if($loggedInNav):?>
                <li class="nav-item">
                    <a class="nav-link" href="/MyNotes/notes">My Notes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/MyNotes/user_authenticate/logout.php">Log Out</a>
                </li>
                <li class="nav-item ml-lg-4">
                    <a class="nav-link" href="/MyNotes/profile">
                        <?php echo $_SESSION["email"]; ?>
                    </a>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="/MyNotes/user_authenticate/register">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/MyNotes/user_authenticate/login">Log In</a>
                </li>
                <?php endif;?>


            </ul>
        </div>
    </nav>

    <div class="bg-image"></div>

    <div class="container">
        <div class="overlay">
            <div class="bg-text">I've thrown away lots of my old diaries - you never know who might get their hands on
                them. But I have kept a few notes on the good old days.<div>
                    <div class="">
                        <a href="/MyNotes/notes" class="btn btn-primary my-4">Create a note</a>
                    </div>
                </div>
            </div>

            <!-- Optional JavaScript; choose one of the two! -->

            <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
                crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
                crossorigin="anonymous"></script>
            <script>
            window.addEventListener("load", () => {
                document.querySelector("#loading").style.display = "none";
            })
            </script>
</body>

</html>