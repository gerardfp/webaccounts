<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<meta charset="UTF-8">
<title>Welcome</title>
<link rel="stylesheet" href="style.css">

<div class="welcome">
	<div class="logo">&#128100;</div>
	<h1>Bienvenido, <?php echo htmlspecialchars($_SESSION["username"]); ?></h1>
	<p class="link"><a href="reset-password.php" class="btn btn-warning">Reestablecer contraseña</a></p>
	<p class="link"><a href="logout.php" class="btn btn-danger">Cerrar sesión</a></p>
</div>
