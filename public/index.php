<?php
session_start();
//require_once "../config/config.php";
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

    .black {
        color: black;
        font-size: 1.5rem;
        font-weight: bold;

    }

    @media only screen and (max-width:600px) {
        .bg-text {
            top: 70%;

        }
    }
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

    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../images/notepad.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5 class="black">My notepad knows my deepest thoughts.</h5>
                    <a href="/MyNotes/notes" class="btn btn-primary">Create your note!</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../images/notepad2.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5 class="black">My notepad is my best friend, it knows me in and out yet never judges me.</h5>
                    <a href="/MyNotes/notes" class="btn btn-primary">Create your note!</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../images/notepad3.jfif" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5 class="black">If not now then when??</h5>
                    <a href="/MyNotes/notes" class="btn btn-primary">Create your note!</a>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <hr class="my-4">
    <h2 class="container">
        MyNotes by
    </h2>
    <hr class="my-4">


    <div class="container text-center">

        <!-- Three columns of text below the carousel -->
        <div class="row">
            <div class="col-lg-4">
                <div class="container profile">
                    <div class="container ptext">
                        HS
                    </div>
                </div>
                <h2>Harsh Sachala</h2>
                <p>
                <ul style="text-align: left;">
                    <li>
                        Roll Number: 1814105
                    </li>
                    <li>
                        Batch: B2
                    </li>
                </ul>
                </p>

            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
                <div class="container profile">
                    <div class="container ptext">
                        KP
                    </div>
                </div>
                <h2>Kshitij Prabhu</h2>
                <p>
                <ul style="text-align: left;">
                    <li>
                        Roll Number: 1814101
                    </li>
                    <li>
                        Batch: B2
                    </li>
                </ul>
                </p>

            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
                <div class="container profile">
                    <div class="container ptext">
                        PP
                    </div>
                </div>
                <h2>Preet Porwal</h2>
                <p>
                <ul style="text-align: left;">
                    <li>
                        Roll Number: 1814100
                    </li>
                    <li>
                        Batch: B2
                    </li>
                </ul>
                </p>

            </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->


    </div>
    <hr class="my-4">


    <footer class="container p-4">
        <p class="float-right"><a href="#">Back to top</a></p>
        <p>© 2017-2020 Company, Inc. · <a href="#">Privacy</a> · <a href="#">Terms</a></p>
    </footer>
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