<?php

require 'includes/config/database.php';
$db = conectarDB();

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
	$password = mysqli_real_escape_string($db, $_POST['password']);

	if (!$email) {
		$errores[] = "El correo es obligatorio";
	}
	if (!$password) {
		$errores[] = "La contraseña es obligatoria";
	}

	if (empty($errores)) {
		$query = "SELECT * FROM usuarios_new WHERE email = '$email'";
		$resultado = mysqli_query($db, $query);

		if ($resultado->num_rows) {
			$usuario = mysqli_fetch_assoc($resultado);

			// Verificar la contraseña
			$auth = password_verify($password, $usuario['clave']);

			if ($auth) {
				session_start();	
				$_SESSION['id'] = $usuario['id'];
				$_SESSION['usuario'] = $usuario['email'];
				$_SESSION['nombre'] = $usuario['nombre'];
				$_SESSION['apellido'] = $usuario['apellido'];
				$_SESSION['telefono'] = $usuario['telefono'];
				
				$_SESSION['nombre_usuario'] = $usuario['usser'];
				$_SESSION['login'] = true;
				$_SESSION['rol'] = $usuario['rol'];

				// Actualizar estado de conexión
				$queryUpdate = "UPDATE usuarios_new SET conectado = 1 WHERE id = {$usuario['id']}";
				mysqli_query($db, $queryUpdate);

				// Redirigir según el rol del usuario
				if ($usuario['rol'] == 0) {
					header('location: /grupoUCV/index.php');
				}
				exit;
			} else {
				$errores[] = "El password es incorrecto";
			}
		} else {
			$errores[] = "El usuario no existe";
		}
	}
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Animated Login Form</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<img class="wave-effect" src="img/wave.png">
	<div class="login-container">
		<div class="login-img">
			<img src="img/bg.svg">
		</div>
		<div class="login-content">
			
			<form method="POST">
				<img src="img/avatar.svg">
				<?php foreach ($errores as $error) : ?>
				<div class="alerta error">
					<?php echo $error ?>
				</div>
			<?php endforeach ?>
				<h2 class="title">Bienvenido</h2>
				<div class="input-group one">
					<div class="input-icon">
						<i class="fas fa-user"></i>
					</div>
					<div class="input-div">

						<input type="text" class="input" id="email" name="email" placeholder="Usuario">
					</div>
				</div>
				<div class="input-group password">
					<div class="input-icon">
						<i class="fas fa-lock"></i>
					</div>
					<div class="input-div">
						<input type="password" class="input" id="password" name="password" placeholder="Contraseña">
					</div>
				</div>
				<a href="#" class="link">Olvidó su contraseña?</a>
				<input type="submit" class="btn btn-primary px4" value="Ingresar">
				<hr>
				<a href="registrar.php" class="btn btn-primary px4">¿No tienes una cuenta? Registrate</a>
			</form>
		</div>
	</div>
	<script type="text/javascript" src="js/main.js"></script>
</body>

</html>