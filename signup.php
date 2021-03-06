<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$mysqli = new mysqli("localhost", "webaccounts_user", "webaccounts_password", "webaccounts_database");

	if (empty($_POST["username"])) {
		$error = "Introduzca un nombre de usuario.";
	}
	else {
		$stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ?");

		$stmt->bind_param("s", $_POST["username"]);

		$stmt->execute();

		$stmt->store_result();

		if ($stmt->num_rows == 1) {
			$error = "El nombre de usuario no está disponible.";
		}

		$stmt->close();
	}

	if (empty($error)) {
		if (empty($_POST["password"])) {
			$error = "Introduzca una contraseña.";
		}
		elseif (strlen($_POST["password"]) < 6) {
			$error = "La contraseña debe tener al menos 6 caracteres.";
		}
		elseif (empty($_POST["confirm_password"])) {
			$error = "Por favor, confirme la contraseña.";
		}
		elseif ($_POST['password'] != $_POST['confirm_password']) {
			$error = "Las contraseñas no coinciden.";
		}
	}

	if (empty($error)) {

		$stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");

		$stmt->bind_param("ss", $_POST['username'], $password_hashed);

		$password_hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);

		$stmt->execute();
		$stmt->close();

		header("location: login.php");
		exit;
	}
}
?>

<!DOCTYPE html>
<meta charset="UTF-8">
<title>Registrarse</title>
<link rel="stylesheet" href="style.css">

<?php
if (!empty($error)) {
	echo "<div class='error'><b>Error:</b> $error</div>";
}
?>

<form action="?" method="post">
	<div class="logo">&#128100;</div>

	<p>
		<label for="username">Usuario</label>
		<input type="text" name="username" value="<?php echo $_POST['username']; ?>">
	</p>
	<p>
		<label for="password">Contraseña</label>
		<input type="password" name="password">
	</p>
	<p>
		<label for="confirm_password">Confirme contraseña</label>
		<input type="password" name="confirm_password">
	</p>
	<p><input type="submit" value="Registrarse"></p>
    <p class="link">¿Ya tiene una cuenta? <a href="login.php">Acceda</a>.</p>
</form>