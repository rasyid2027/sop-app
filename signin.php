<?php 

session_start();

if( isset($_SESSION['login']) )
{
  header('Location: index.php');
  exit;
}

require "functions.php";

if( isset($_POST['login']) )
{
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $dbh->prepare("SELECT * FROM sop_users WHERE username = ?");
  $stmt->execute([$username]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  
  if( $username == $row['username'] )
  {
    if( password_verify($password, $row['password']) )
    {
      unset( $row['password'] );

      $_SESSION['login'] = $row;

      header('Location: index.php');
      exit;
    } else {
        echo "
                <script>
                  alert('Wrong password')
                  document.location.href = 'signin.php';
                </script>
              ";
    }
  } else {
      header('Location: auth-login.php');
      exit;
  }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta
      name="author"
      content="Mark Otto, Jacob Thornton, and Bootstrap contributors"
    />
    <meta name="generator" content="Jekyll v4.1.1" />
    <title>Login &mdash; QODR SOP</title>

    <link
      rel="canonical"
      href="https://getbootstrap.com/docs/4.5/examples/sign-in/"
    />
    <!-- Bootstrap CSS CDN -->
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
      integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4"
      crossorigin="anonymous"
    />

    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet" />
  </head>
  <body class="text-center">
    <div class="container mt-5">
      <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
          <form method="POST" action="" class="form-signin">
            <img class="mb-5" src="img/ini logo qodr doang.svg" alt="" width="100" />
            <label for="inputUsername" class="sr-only">Username</label>
            <input
              type="text"
              id="inputUsername"
              class="form-control"
              name="username"
              placeholder="Username"
              required
              autofocus
            />
            <label for="inputPassword" class="sr-only">Password</label>
            <input
              type="password"
              id="inputPassword"
              class="form-control"
              name="password"
              placeholder="Password"
              required
            />
            <div class="checkbox mb-3">
              <label>
                <input type="checkbox" value="remember-me" /> Remember me
              </label>
            </div>
            <button class="btn btn-lg btn-success btn-block" type="submit" name="login">
              Sign in
            </button>
          </form>
          <p class="mt-5 mb-3 text-muted">
            Copyright &copy; 2020 <a href="https://qodr.or.id">qodr.or.id</a>
          </p>
        </div>
      </div>
    </div>
    
  </body>
</html>
