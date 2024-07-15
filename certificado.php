<?php 
session_start();
if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}
if (!isset($_SESSION["exam_passed"]) || !$_SESSION["exam_passed"]) {
  header("Location: home.php");
  return;
}
?>

<?php require "partials/header.php" ?>
<div class="container pt-4 p-3">
    <div class="row">
      
        <div class="col-md-4 mx-auto">
          <div class="card card-body text-center">
            <p class="btn-succes">Felicidades <?php echo htmlspecialchars($_SESSION["user"]["name"]); ?>, ¡pasaste!</p>
            <a href="fpdf/generate_certificate.php">Descargar certificado!</a>
          </div>
        </div>
   
</div>
<?php require "partials/footer.php" ?>
