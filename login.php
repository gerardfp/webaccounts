<?php

session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    	header("location: welcome.php");
    	exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$mysqli = new mysqli("localhost", "webaccounts_user", "webaccounts_password", "webaccounts_database");

    	if (empty($_POST["username"])) {
        	$error = "Introduzca el nombre de usuario.";
    	}
    	elseif (empty($_POST["password"])) {
        	$error = "Introduzca la contraseña.";
    	}

    	if (empty($error)) {
		$stmt = $mysqli->prepare("SELECT id, username, password FROM users WHERE username = ?");

		$stmt->bind_param("s", $_POST['username']);

		$stmt->execute();

		$stmt->store_result();

		if ($stmt->num_rows == 1) {
			$stmt->bind_result($id, $username, $hashed_password);
			$stmt->fetch();

                	if (password_verify($_POST['password'], $hashed_password)) {
                    		session_start();

                    		$_SESSION["loggedin"] = true;
                    		$_SESSION["id"] = $id;
                    		$_SESSION["username"] = $username;

                    		header("location: welcome.php");
                	}
			else {
                    		$error = "La contraseña introducida no es correcta.";
                	}
		}
		else {
			$error = "No existe la cuenta con el nombre usuario introducido.";
		}

		$stmt->close();
    	}
}
?>

<!DOCTYPE html>
<meta charset="UTF-8">
<title>Acceder</title>
<link rel="stylesheet" href="style.css">

<?php
        if(!empty($error)){
                echo "<div class='error'><b>Error:</b> $error</div>";
        }
?>

<form action="?" method="post">
	<div class="logo">&#128100;</div>
	<p>
        	<label for="username">Usuario</label>
        	<input name="username" value="<?php echo $_POST['username']; ?>">
	</p>
	<p>
	        <label for="password">Contraseña</label>
        	<input type="password" name="password">
	</p>
        <p>
		<input type="submit" value="Acceder">
	</p>
	<p class="link">¿No tiene una cuenta? <a href="signup.php">Regístrese ahora</a>.</p>
</form>
