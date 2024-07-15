<?php
require "db.php";
$error = null;
session_start();
if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // if (empty($_POST["name"]) || empty($_POST["phone_number"])) {
  //   $error = "Please fill all the fields.";
  // } else {
    $name = $_POST["name"];
    $phoneNumber = $_POST["phone_number"];
    $statement = $conn->prepare("INSERT INTO contacts (name, phone_number, user_id) VALUES (:name, :phone_number, :user_id)");
    $statement->bindParam(":name", $name);
    $statement->bindParam(":phone_number", $phoneNumber);
    $statement->bindParam(":user_id", $_SESSION['user']['id']);
    $statement->execute();

    $_SESSION["flash"] = ["mensaje" => "Contact {$_POST['name']}  added."];
    header("Location: home.php");
    return;
  // }
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
              <select class="form-select"  require aria-label="Default select example">
                <option selected>Selecionar</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>

            </div>

            <div class="mb-3 row">
              <h2>Cuanto es 2 + 2</h2>
              <select class="form-select" require  aria-label="Default select example">
                <option selected>Selecionar</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="4">4</option>
              </select>
            </div>
            <div class="mb-3 row">
              <h2>Cuanto es 3 + 3</h2>
              <select class="form-select"  require  aria-label="Default select example">
                <option selected>Selecionar</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="6">6</option>
              </select>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require "partials/footer.php" ?>
