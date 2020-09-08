<?php

session_start();
require "functions.php";

if (!isset($_SESSION['login'])) {
    header('Location: signin.php');
    exit;
}

$stmt = $dbh->prepare("SELECT * FROM sop");
$stmt->execute();
$contents = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>QODR SOP</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="style4.css">

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
                    <img src="img/Ni Logo dah Putih.svg" width="150" height="30" alt="" loading="lazy">
                </a>
            </div>

            <ul class="list-unstyled components">
                
            </ul>
        </nav>

        <nav id="sdbr"></nav>

        <!-- Page Content  -->
        <div id="header" class="container-fluid" style="width: 100%;">
            <nav class="navbar navbar-expand-md navbar-light bg-light">
                <?php $role = 'admin' ?>
                <?php if( $_SESSION['login']['role'] === $role ) { ?>
                <ul class="navbar-nav mr-3">
                    <li><a class="btn btn-sm ml-3" href="edit.php?id=<?= $contents[0]['id'] ?>" role="button">EDIT SOP</a></li>
                </ul>
                <?php } ?>
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

            <div id="content">
                
            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        var regex = /<br\s*[\/]?>/gi;
        var str = '<?= $contents[0]['sop'] ?>';
        document.getElementById('content').innerHTML = marked(str.replace(regex, "\n"));
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            var texts = document.getElementsByTagName("h1");
            var text;
            for(text of texts){
                let menuText = $(text).text()
                let menuHref = menuText.toLowerCase().replace(' ', '-')
                $("#sidebar ul").append(`<li><a href="#${menuHref}">${menuText}</a></li>`)
            }
        })
    </script>
</body>

</html>