<?php

session_start();
require 'functions.php';

if (!isset($_SESSION['login'])) {
    header('Location: signin.php');
    exit;
}

if ( $_SESSION['login']['role'] !== 'admin' ) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$stmt = $dbh->prepare("SELECT * FROM sop WHERE id = ?");
$stmt->execute([$id]);
$content = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $content = trim(preg_replace('/\s\s+/', ' ', nl2br($_POST['content'])));
    $query = "UPDATE sop SET sop = ? WHERE id = ?";

    $stmt = $dbh->prepare($query);
    $stmt->execute([$content, $id]);
    $sop = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($sop > 0) {
        echo "
            <script>
                alert('successfully added data')
                document.location.href = 'index.php';
            </script>
            ";
    } else {
        echo "
            <script>
                alert('failed to add data')
                document.location.href = 'index.php';
            </script>
            ";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>EDIT SOP</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="edit.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

</head>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <a class="sidebar-brand" href="#">
                    <img src="img/mp logorostchild.png" width="70" alt="" loading="lazy">
                </a>
            </div>
        </nav>

        <nav id="sdbr"></nav>

        <!-- Page Content  -->
        <div id="header" class="container-fluid" style="width: 100%;">
            <form method="post" action="">
                <nav class="navbar navbar-expand-md navbar-light bg-light">
                    <ul class="navbar-nav mr-4">
                        <li><a class="btn btn-danger btn-sm ml-3" href="index.php" role="button">CANCLE</a></li>
                    </ul>
                    <ul class="navbar-nav mr-3">
                        <li><button class="btn btn-info btn-sm ml-3" type="submit" name="submit" role="button">SAVE</button></li>
                    </ul>
                    <div id="navbarCollapse" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="dropdown">
                                <a  href="#" class="nav-link dropdown-toggle nav-link-lg nav-link-user" data-toggle="dropdown">
                                    <img src="img/avatar-2.png" class="rounded-circle mr-1" width="30" height="30" alt="" loading="lazy">
                                    <div class="d-sm-none d-lg-inline-block">Hi, <?=$_SESSION['login']['name']?></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="logout.php" class="dropdown-item has-icon text-danger">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

                <div id="content" class="ml-0 mr-1">
                    <div class="input">
                    <input type="hidden" name="id" value="<?= $content['id'] ?>">
                        <?php 
                        
                        $text = $content['sop'];
                        $breaks = array("<br />","<br>","<br/>");  
                        $text = str_ireplace($breaks, "\r\n", $text); 

                        ?>
                        <textarea class="form-control" name="content" placeholder="Text Editor ..." autofocus><?= $text ?></textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
</body>

</html>
