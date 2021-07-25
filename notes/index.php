<?php
session_start();
if(!$_SESSION["isLoggedIn"]){
    header("Location: /MyNotes/user_authenticate/login");
    exit();
}
require_once "../config/config.php";
$user_id = $_SESSION["id"];
$insert = false;
$update = false;
$delete = false;

$sql_select = "SELECT * FROM `users` WHERE `id`=$_SESSION[id]";
$execute = mysqli_query($conn, $sql_select);
$user = mysqli_fetch_assoc($execute);
$name = $user["firstName"] . " " . $user["lastName"];

// Basic validation
if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["submit"])){
    $title = $_POST["title"];
    $content = $_POST["content"];
    
    $sql_insert = "INSERT INTO `notes`(`id`, `title`, `content`, `stamp`, `user_id`) VALUES (NULL,'$title','$content',current_timestamp(),'$user_id')";
    $fire = mysqli_query($conn, $sql_insert);
    $insert = true;
}

if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["submitEdit"])){
    $titleEdit = $_POST["titleEdit"];
    $contentEdit = $_POST["contentEdit"];
    $idEdit = $_POST["idEdit"];
    $sql_update = "UPDATE `notes` SET `title` = '$titleEdit', `content` = '$contentEdit', `stamp` = current_timestamp() WHERE `notes`.`id` = $idEdit AND `notes`.`user_id` = $user_id";
    $fire = mysqli_query($conn, $sql_update);
    $update = true;
}

if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["submitDelete"])){
    $idDelete = $_POST["deleteNote"];
    $sql_delete = "DELETE FROM `notes` WHERE `notes`.`id` = $idDelete";
    $fire = mysqli_query($conn, $sql_delete);
    $delete = true;
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">

    <title>My Notes</title>
    <style>
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
                    <a class="nav-link active" href="/MyNotes/notes">My Notes <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/MyNotes/user_authenticate/logout.php">Log Out</a>
                </li>
                <li class="nav-item ml-lg-4">
                    <a class="nav-link" href="/MyNotes/profile">
                        <?php echo $_SESSION["email"]; ?>
                    </a>
                </li>

            </ul>
        </div>
    </nav>


    <?php if($insert):?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Note has been added successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif;?>
    <?php if($update):?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        Note has been updated successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif;?>
    <?php if($delete):?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        Note has been deleted successfully!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif;?>
    <div class="container my-4">
        <div class="container create-note text-center my-4">
            <!-- Button trigger create note modal -->
            <button type="button" id="createNote" class="btn btn-primary" data-toggle="modal"
                data-target="#createNoteModal">
                Create Note
            </button>

        </div>
        <hr class="my-4">
        <h3>Notes by <?php echo $name; ?></h3>
        <hr class="my-4">
        <div class="container my-notes">
            <table class="table" id="myNotes">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Content</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM `notes` WHERE user_id='$user_id'";
                        $notes = mysqli_query($conn, $sql);
                        while($note = mysqli_fetch_assoc($notes)):
                    ?>
                    <tr>
                        <td><?php echo $note['title'] ;?></td>
                        <td><?php echo $note['content'] ;?></td>
                        <td>
                            <button class="btn btn-outline-dark mx-4 edit" id="<?php echo $note["id"] ?>">Edit</button>
                            <button class="btn btn-outline-danger delete" id="<?php echo $note["id"] ?>">Delete</button>
                        </td>
                    </tr>
                    <?php endWhile; ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- Create Note Modal -->
    <div class="modal fade" id="createNoteModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="createNoteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createNoteModalLabel">Create Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="addNoteForm">

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" id="title" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content" id="content" cols="30" rows="10" class="form-control"
                                style="resize: none;" required></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Add Note</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Note Modal -->
    <div class="modal fade" id="updateNoteModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="updateNoteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateNoteModalLabel">Update Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="updateNoteForm">
                        <input type="hidden" name="idEdit" id="idEdit">
                        <div class="form-group">
                            <label for="titleEdit">Title</label>
                            <input type="text" name="titleEdit" class="form-control" id="titleEdit" required>
                        </div>
                        <div class="form-group">
                            <label for="contentEdit">Content</label>
                            <textarea name="contentEdit" id="contentEdit" cols="30" rows="10" class="form-control"
                                style="resize: none;" required></textarea>
                        </div>
                        <button type="submit" name="submitEdit" class="btn btn-dark">Update Note</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteNoteModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="deleteNoteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteNoteModalLabel">This operation cannot be undone!!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this note forever?
                    <form action="" method="post" id="deleteNoteForm">
                        <input type="hidden" name="deleteNote" id="deleteNote">
                        <hr class="mt-2">
                        <button type="submit" class="btn btn-danger" name="submitDelete">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js">
    </script>

    <script>
    window.addEventListener("load", () => {
        document.querySelector("#loading").style.display = "none";
    })
    $(document).ready(function() {
        $('#myNotes').DataTable();
    });

    const edits = document.querySelectorAll(".edit")
    edits.forEach(edit => {
        edit.addEventListener("click", e => {
            const tableRow = e.target.parentNode.parentNode;
            const title = tableRow.getElementsByTagName("td")[0].innerText;
            const content = tableRow.getElementsByTagName("td")[1].innerText;
            const id = e.target.id;
            $("#updateNoteModal").modal("toggle")
            document.querySelector("#titleEdit").value = title
            document.querySelector("#contentEdit").value = content
            document.querySelector("#idEdit").value = id
        })
    })

    const deletes = document.querySelectorAll(".delete")
    deletes.forEach(deleteBtn => {
        deleteBtn.addEventListener("click", e => {
            const id = e.target.id;
            $("#deleteNoteModal").modal("toggle")
            document.querySelector("#deleteNote").value = id;
        })
    })
    </script>
</body>

</html>