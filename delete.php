<?php 
require "db.php";
$id =$_GET["id"];
session_start();
if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}
$sttm = $conn->prepare("SELECT * FROM contacts WHERE id= :id LIMIT 1 ");
$sttm->execute([":id" => $id]);

if($sttm->rowCount() == 0){
  http_response_code(404);
  echo("HTTP 404 NOT FOUND");
  return;
}
$contact = $sttm->fetch(PDO::FETCH_ASSOC);
if($contact["user_id"] !== $_SESSION["user"]["id"]){
  http_response_code(403);
  echo("HTTP 403 UNAUTHORIZED");
  return;
}

$conn->prepare(("DELETE FROM contacts WHERE id= :id "))->execute([":id" => $id]);

$_SESSION["flash"] = ["mensaje" => "Contact {$contat['name']}  deleted."];

header("Locaction: home.php")
?>
