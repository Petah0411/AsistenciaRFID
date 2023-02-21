<?php
session_start();
if (isset($_SESSION['Admin-name'])) {
  header("location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inicio de Sesión</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="images/favicon.png">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <script src="js/jquery-2.2.3.min.js"></script>
    <script>
      $(window).on("load resize ", function() {
          var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
          $('.tbl-header').css({'padding-right':scrollWidth});
      }).resize();
    </script>
    <script type="text/javascript">
      $(document).ready(function(){
        $(document).on('click', '.message', function(){
          $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
          $('h1').animate({height: "toggle", opacity: "toggle"}, "slow");
        });
      });
    </script>
</head>
<body>
<?php include'header.php'; ?> 
<main>
  <h1 class="slideInDown animated">Por favor, inicie sesión con el <strong>Email</strong> y <strong>Contraseña</strong> del administrador</h1>
  <h1 class="slideInDown animated" id="reset">Por favor, ingrese su Email para enviar el link para reestablecer su contraseña</h1>
<!-- Inicio de Sesión -->
<section>
  <div class="slideInDown animated">
    <div class="login-page">
      <div class="form">
        <?php  
          if (isset($_GET['error'])) {
            if ($_GET['error'] == "invalidEmail") {
                echo '<div class="alert alert-danger">
                        Este email no es válido!!
                      </div>';
            }
            elseif ($_GET['error'] == "sqlerror") {
                echo '<div class="alert alert-danger">
                        Hay un error en la base de datos!!
                      </div>';
            }
            elseif ($_GET['error'] == "wrongpassword") {
                echo '<div class="alert alert-danger">
                        Contraseña incorrecta!!
                      </div>';
            }
            elseif ($_GET['error'] == "nouser") {
                echo '<div class="alert alert-danger">
                        Este E-mail no existe!!
                      </div>';
            }
          }
          if (isset($_GET['reset'])) {
            if ($_GET['reset'] == "success") {
                echo '<div class="alert alert-success">
                        Verifique su E-mail!
                      </div>';
            }
          }
          if (isset($_GET['account'])) {
            if ($_GET['account'] == "activated") {
                echo '<div class="alert alert-success">
                        Por favor, inicie sesión
                      </div>';
            }
          }
          if (isset($_GET['active'])) {
            if ($_GET['active'] == "success") {
                echo '<div class="alert alert-success">
                        El link de activación ha sido enviado!
                      </div>';
            }
          }
        ?>
        <div class="alert1"></div>
        <form class="reset-form" action="reset_pass.php" method="post" enctype="multipart/form-data">
          <input type="email" name="email" placeholder="E-mail" required/>
          <button type="submit" name="reset_pass">Reiniciar</button>
          <p class="message"><a href="#">Iniciar Sesión</a></p>
        </form>
        <form class="login-form" action="ac_login.php" method="post" enctype="multipart/form-data">
          <input type="email" name="email" id="email" placeholder="E-mail" required/>
          <input type="password" name="pwd" id="pwd" placeholder="Contraseña" required/>
          <button type="submit" name="login" id="login">Iniciar Sesión</button>
          <p class="message">¿Olvidaste la contraseña? <a href="#">Reestablecer su contraseña</a></p>
        </form>
      </div>
    </div>
  </div>
</section>
</main>
</body>
</html>