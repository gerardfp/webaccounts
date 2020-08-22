<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
	header("location: login.php");
	exit;
}

$mysqli = new mysqli("localhost", "webaccounts_user", "webaccounts_password", "webaccounts_database");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    	if (empty($_POST["new_password"])) {
        	$error = "Introduzca la nueva contraseña.";
    	}
	elseif (strlen($_POST["new_password"]) < 6) {
        	$error = "La contraseña debe tener al menos 6 caracteres.";
    	}
	elseif (empty($_POST["confirm_password"])) {
        	$error = "Por favor, confirme la contraseña.";
    	}
	elseif ($_POST['new_password'] != $_POST['confirm_password']) {
        	$error = "Las contraseñas no coinciden.";
    	}

    	if (empty($error)) {
        	$stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE id = ?");

		$stmt->bind_param("si", $password_hashed, $_SESSSION['id']);

		$password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

        	$stmt->execute();

        	session_destroy();
        	header("location: login.php");
        	exit();
    	}
}
?>

<!DOCTYPE html>
<meta charset="UTF-8">
<title>Reestablecer contraseña</title>
<link rel="stylesheet" href="style.css">

<?php
        if(!empty($error)){
                echo "<div class='error'><b>Error:</b> $error</div>";
        }
?>

<form action="?" method="post">
	<div class="logo">&#128100;</div>
	<p>
        	<label for="new_password">Nueva contraseña</label>
        	<input type="password" name="new_password" value="<?php echo $new_password; ?>">
	</p>
	<p>
        	<label for="confirm_password">Confirme la contraseña</label>
        	<input type="password" name="confirm_password">
	</p>
	<p>
	        <input type="submit" value="Reestablecer contraseña">
	</p>
	<p class="link"><a href="welcome.php">Cancelar</a></p>
</form>
</div>
