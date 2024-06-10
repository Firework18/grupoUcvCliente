<?php

require 'includes/config/database.php';
$db = conectarDB();
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($db, $_POST['apellido']);
    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $telefono = mysqli_real_escape_string($db, $_POST['telefono']);

    if (!$nombre) {
        $errores[] = "Ingrese un nombre";
    }
    if (!$apellido) {
        $errores[] = "Ingrese un apellido";
    }
    if (!$email) {
        $errores[] = "Ingrese un correo electrónico válido";
    }
    if (!$telefono) {
        $errores[] = "Ingrese un teléfono";
    }
    if (!$password) {
        $errores[] = "Ingrese una contraseña";
    }

    if (empty($errores)) {
        // Hashear la contraseña
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Insertar el nuevo usuario en la base de datos
        $query = "INSERT INTO usuarios_new (nombre, apellido, email, telefono, clave, rol) 
                  VALUES ('$nombre','$apellido','$email','$telefono','$passwordHash', '0');";

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            // Iniciar sesión automáticamente
            session_start();
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['usuario'] = $usuario['email'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['apellido'] = $usuario['apellido'];
            $_SESSION['telefono'] = $usuario['telefono'];

            $_SESSION['nombre_usuario'] = $usuario['usser'];
            $_SESSION['login'] = true;
            $_SESSION['rol'] = $usuario['rol'];

            if ($usuario['rol'] == 0) {
                header('location: /grupoUCV/index.php');
            }
            exit;
        } else {
            $errores[] = "Error al registrar el usuario";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Registro de Usuario</title>
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
            <form action="/grupoUCV/registrar.php" class="login-form" method="POST">
                <img src="img/avatar.svg">
                <h2 class="title">Registro</h2>
                <?php foreach ($errores as $error) : ?>
                    <div class="alerta error">
                        <?php echo $error ?>
                    </div>
                <?php endforeach ?>
                <div class="input-group one">
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="input-div">
                        <input type="text" class="input" placeholder="Nombres" name="nombre" required>
                    </div>
                </div>
                <div class="input-group one">
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="input-div">
                        <input type="text" class="input" placeholder="Apellidos" name="apellido" required>
                    </div>
                </div>
                <div class="input-group one">
                    <div class="input-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="input-div">
                        <input type="email" class="input" placeholder="Codigo de alumno" name="email" required>
                    </div>
                </div>
                <div class="input-group one">
                    <div class="input-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="input-div">
                        <input type="tel" class="input" placeholder="Teléfono" name="telefono" required>
                    </div>
                </div>
                <div class="input-group password">
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="input-div">
                        <input type="password" class="input" placeholder="Contraseña" name="password" required>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary px4" value="Registrarse">
                <hr>
                <p>¿Ya tienes una cuenta? <a href="login.php" class="btn btn-primary px4">Inicia sesión</a></p>
            </form>

        </div>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>

</html>