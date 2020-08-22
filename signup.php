<?php
$mysqli = new mysqli("localhost", "webaccounts_user", "webaccounts_password", "webaccounts_database");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
		header("location: login.php");

		$stmt->close();
    	}
}
?>

<!DOCTYPE html>
<meta charset="UTF-8">
<title>Sign Up</title>
<link rel="stylesheet" href="style.css">

<?php
        if(!empty($error)){
                echo "<div class='error'><b>Error:</b> $error</div>";
        }
?>


<form action="?" method="post">
	<div class="logo">&#128100;</div>

	<p>
        	<label>Username</label>
        	<input type="text" name="username" value="<?php echo $username; ?>">
    	</p>
    	<p>
        	<label>Password</label>
        	<input type="password" name="password" value="<?php echo $password; ?>">
	</p>
	<p>
        	<label>Confirm Password</label>
        	<input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>">
	</p>
	<p>
	        <input type="submit" value="Sign Up">
	</p>
    </div>
    <p class="link">¿Ya tiene una cuenta? <a href="login.php">Acceda</a>.</p>
</form>
