<?php 
require "db.php";
$error = null;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"]) || empty($_POST["password"])) {
        $error = "Please fill all the fields.";
    } else if (!str_contains($_POST["email"], "@")) {
        $error = "Email invalid";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->bindParam(":email", $_POST["email"]);
        $stmt->execute();
        
        if ($stmt->rowCount() == 0) {
            $error = "Invalid credentials";
        } else {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!password_verify($_POST["password"], $user["password"])) {
                $error = "Invalid credentials";
            } else {
                session_start();
                unset($user["password"]);
                $_SESSION["user"] = $user;
                header("Location: home.php");
                exit();  
            }
        }
    }
}
?>
<?php require "partials/header.php" ?>

<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Login</div>
        <div class="card-body">
          <?php if ($error): ?>
            <p class="danger">
              <?= htmlspecialchars($error) ?>
            </p>  
          <?php endif ?>
          <form method="POST" action="login.php">
            <div class="mb-3 row">
              <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
              <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus>
              </div>
            </div>
            
            <div class="mb-3 row">
              <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
              <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required autocomplete="password">
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
