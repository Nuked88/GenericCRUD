<?php
include("functions.inc.php");

if (!isLoggedIn()) {
  header("Location: login.php");
  exit();
}
$conn=connectToDb();
$user_id = getUsername($conn);
$table = $_GET['table'];


$id = $_GET['id'];
$query = "DELETE FROM $table WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: table.php?table=$table");
exit();
?>