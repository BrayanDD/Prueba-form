<?php
require "db.php";
$error = null;
session_start();
if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (!isset($_POST["q1"]) || !isset($_POST["q2"]) || !isset($_POST["q3"])) {
    $error = "Por favor, responde todas las preguntas.";
  } else {
    $puntaje = 0;
    if ($_POST["q1"] == 2) {
      $puntaje++;
    }
    if ($_POST["q2"] == 4) {
      $puntaje++;
    }
    if ($_POST["q3"] == 6) {
      $puntaje++;
    }
    if ($puntaje >= 2) {
      $_SESSION["exam_passed"] = true;
      header("Location: certificado.php");
      return;
    } else {
      $error = "No pasaste el examen.";
    }
  }
}
?>
<?php require "partials/header.php" ?>

<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Examen</div>
        <div class="card-body">
          <?php if ($error) : ?>
            <p class="danger">
              <?= $error ?>
            </p>
          <?php endif ?>
          <form method="POST" action="add.php">
            <div class="mb-3 row">
              <h2>Cuanto es 1 + 1</h2>
              <select class="form-select" name="q1" required aria-label="Default select example">
                <option selected disabled>Selecionar</option>
                <option value="1">One</option>
                <option value="2">2</option>
                <option value="3">Three</option>
              </select>

            </div>

            <div class="mb-3 row">
              <h2>Cuanto es 2 + 2</h2>
              <select class="form-select" required name="q2" aria-label="Default select example">
                <option selected disabled>Selecionar</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="4">4</option>
              </select>
            </div>
            <div class="mb-3 row">
              <h2>Cuanto es 3 + 3</h2>
              <select class="form-select" required name="q3" aria-label="Default select example">
                <option selected  disabled>Selecionar</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="6">6</option>
              </select>
            </div>
            <button class="btn btn-primary">Enviar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require "partials/footer.php" ?>
