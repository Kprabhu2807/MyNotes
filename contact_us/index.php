<?php 
session_start();
require_once "../config/config.php";


// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

$loggedInNav = false;
$emailSent = false;
if(isset($_SESSION["isLoggedIn"])){
	$loggedInNav = true;
	$sql = "SELECT * FROM `users` WHERE `id`=$_SESSION[id]";
	$fire = mysqli_query($conn,$sql);
	$data = mysqli_fetch_assoc($fire);
	$name = $data["firstName"] ." ". $data["lastName"];
	$email = $data["email"];
}

if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["submit"])){
    $name_user = $_POST["name"];
    $email_query = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    $mail = new PHPMailer(true);
    // basic try catch block to ensure normal flow of the code
    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'harsh.sachala@somaiya.edu';                     // SMTP username
        $mail->Password   = 'dkluzuckyitnbsdc';                               // SMTP password 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                 // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        

        // From address details
        $mail->setFrom('harsh.sachala@somaiya.edu', 'Harsh Sachala');
        
        // To address details 
        $mail->addAddress("sach46229@gmail.com", "");               // Name is optional
        

        // Body of the message to be added later this is just for the test
        $body = "<p>Query from $name_user having mail $email_query<br>Query is : $message</p>";
        
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;
        // Here i am stripping the tags for the email which dont support 
        // HTML tags in the body.
        $mail->AltBody = strip_tags($body);

        // Sending the email
        $mail->send();  
        $emailSent = true;              
        
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Contact us</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="../css/util.css">
    <link rel="stylesheet" type="text/css" href="../css/main.css">

    <style>
    #loading {
        position: absolute;
        top: 50%;
        left: 50%;

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
                    <a class="nav-link active" href="/MyNotes/contact_us">Contact us <span
                            class="sr-only">(current)</span></a>
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


    <?php if($emailSent):?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Thank you for contacting us, we will get back to you.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <div class="contact1">
        <div class="container-contact1">
            <div class="contact1-pic js-tilt" data-tilt>
                <img src="../images/contact.png" alt="IMG">
            </div>

            <form class="contact1-form validate-form" method="post" action=''>
                <span class="contact1-form-title">
                    Get in touch
                </span>

                <div class="wrap-input1 validate-input" data-validate="Name is required">
                    <input required class="input1" type="text" name="name" placeholder="Name"
                        value="<?php if(isset($name)){echo $name;}?>">
                    <span class="shadow-input1"></span>
                </div>

                <div class="wrap-input1 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                    <input required class="input1" type="text" name="email" placeholder="Email"
                        value="<?php if(isset($email)){echo $email;} ?>">
                    <span class="shadow-input1"></span>
                </div>

                <div class="wrap-input1 validate-input" data-validate="Subject is required">
                    <input required class="input1" type="text" name="subject" placeholder="Subject">
                    <span class="shadow-input1"></span>
                </div>

                <div class="wrap-input1 validate-input" data-validate="Message is required">
                    <textarea required style="resize: none;" class="input1" name="message"
                        placeholder="Message"></textarea>
                    <span class="shadow-input1"></span>
                </div>

                <div class="container-contact1-form-btn">
                    <input type="submit" class="contact1-form-btn" value="Send Mail" name="submit">
                </div>
            </form>
        </div>
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