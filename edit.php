<?php 
require "db.php";
$id =$_GET["id"];
session_start();
if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}
$sttm = $conn->prepare("SELECT * FROM contacts WHERE id= :id LIMIT 1");
$sttm->execute([":id" => $id]);

if($sttm->rowCount() == 0){
  http_response_code(404);
  echo("HTTP 404 NOT FOUND");
  return;
}
$contact = $sttm->fetch(PDO::FETCH_ASSOC);
if($contact["user_id"] != $_SESSION["user"]["id"]){
  http_response_code(403);
  echo("HTTP 403 UNAUTHORIZED");
  return;
}

$error = null;
if($_SERVER["REQUEST_METHOD"]== "POST"){
  if (empty($_POST["name"] || empty($_POST["phone_number"]))) {
    $error = "PLease fill all the fields.";
  }else{
    $name  = $_POST["name"];
    $phoneNumber= $_POST["phone_number"];
    $statement = $conn->prepare("UPDATE contacts SET name = :name , phone_number = :phone_number where id = :id")->execute([
      ":id" => $id,
      ":name" => $_POST["name"],
      ":phone_number" => $_POST["phone_number"],
    ]);
    $_SESSION["flash"] = ["messag0e" => "Contact {$_POST['name']}  updated."];
   
    header("Location: home.php");  
    return;
  }
  
}
?>
<?php require "partials/header.php" ?>

<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Add New Contact</div>
        <div class="card-body">
          <?php if($error): ?>
            <p class="danger">
              <?= $error ?>
            </p>  
          <?php endif ?>
          <form method="POST" action="edit.php?id=<?= $contact["id"]?>">
            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

              <div class="col-md-6">
                <input id="name"  value="<?= $contact["name"] ?>" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="phone_number"  class="col-md-4 col-form-label text-md-end">Phone Number</label>

              <div class="col-md-6">
                <input id="phone_number" value="<?= $contact["phone_number"] ?>" type="tel" class="form-control" name="phone_number" required autocomplete="phone_number" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require "partials/footer.php" ?>
      