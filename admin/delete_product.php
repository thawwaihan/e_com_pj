<?php
require_once "../database/db.php";
$sql="DELETE FROM products WHERE id=:id";
$stmt=$pdo->prepare($sql);
$stmt->execute(['id' => $_GET['id']]);
header("Location: products.php");
exit();
?>