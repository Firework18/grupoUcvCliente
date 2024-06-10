<?php
require 'includes/templates/funciones.php';
$auth = estaAutenticado();
$rol = $_SESSION['rol'] ?? null;

$usuario_id = $_SESSION['id'];
require 'includes/config/database.php';
$db = conectarDB();
$query = "SELECT * FROM usuarios_new WHERE id = ${usuario_id};";
$resultado = mysqli_query($db,$query);
$usuario = mysqli_fetch_assoc($resultado);


$resultado= $_GET['resultado'] ?? null;

$nombreUsuario= $usuario['usser'];
$nombre= $usuario['nombre'];
$apellido= $usuario['apellido'];
$telefono= $usuario['telefono'];
$descripcion= $usuario['descripcion'];
$imagen = $usuario['imagen_usuario'];

$errores = [];



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombreUsuario= $_POST['usuario'];
    $nombre= $_POST['nombre'];
    $apellido= $_POST['apellido'];
    $telefono= $_POST['telefono'];
    $descripcion= $_POST['descripcion'];
    $imagen = $_FILES['imagen'];


    if (!$nombre) {
        $errores[] = "Coloque el nombre";
    }
    if (!$apellido) {
        $errores[] = "Coloque el apellido";
    }

    if (!$telefono) {
        $errores[] = "Coloque el telefono";
    }

    $medida = 1000*100;

    if($imagen['size']>$medida){
        $errores[]= "Coloque una imagen menos pesada";
    }


    if (empty($errores)) {

        //Crear Carpeta
        $carpetaImagenes= '../grupoUCV/imagenes';
        //is_dir verifica si la carpeta existe
        if(!is_dir($carpetaImagenes)){
            mkdir($carpetaImagenes);
        }

        $nombreImagen = '';

        if($imagen['name']){
            //eliminar la imagen previa
       
            unlink($carpetaImagenes."/".$usuario['imagen_usuario']);
            
            //generar nombre unico
            $nombreImagen = md5(uniqid(rand(),true)).".jpg";
            
            move_uploaded_file($imagen['tmp_name'],$carpetaImagenes."/".$nombreImagen);
        }else{
            $nombreImagen = $usuario['imagen_usuario'];
        }

        $query = "UPDATE usuarios_new SET nombre='${nombre}',apellido='${apellido}',telefono='${telefono}',descripcion='${descripcion}',imagen_usuario='${nombreImagen}',usser='${nombreUsuario}' WHERE id = ${usuario_id} ;";

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('location: /grupoUCV/perfil.php?resultado='.$usuario_id);
        }
    }
}

if ($auth && $rol == '0') :
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Configuración</title>
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <!-- Navbar Start -->
        <div class="container-fluid bg-light position-relative shadow">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
                <a href="index.php" class="navbar-brand font-weight-bold text-secondary" style="font-size: 50px;">

                    <span class="text-primary">Grupo de apoyo ucv</span>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav font-weight-bold mx-auto py-0">
                        <a href="index.php" class="nav-item nav-link active">Inicio</a>
                        <a href="nosotros.php" class="nav-item nav-link">Sobre Nosotros</a>
                        <div class="nav-item dropdown">
                            <a href="sesion.php" class="nav-link dropdown-toggle" data-toggle="dropdown">Sesiones</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="sesion.php" class="dropdown-item">Sesiones</a>
                                <a href="sesionE.php" class="dropdown-item">Sesiones creadas por estudiantes</a>
                            </div>
                        </div>
                        <a href="profesores.php" class="nav-item nav-link">Profesores</a>
                        <a href="registrarSesion.php" class="nav-item nav-link">Solicitar Sesión</a>
                        <a href="foro.php" class="nav-item nav-link">Foro de Discusión</a>
                        <a href="recursos.php" class="nav-item nav-link">Recursos</a>

                        <a href="contact.php" class="nav-item nav-link">Contáctanos</a>
                    </div>
                    <a href="perfil.php" class="nav-item nav-link"><i class="fas fa-cog"></i></a>
                    <a href="cerrarSesion.php" class="btn btn-primary px-4">Cerrar Sesion</a>
                </div>
            </nav>
        </div>
        <!-- Navbar End -->

        <!-- Navbar End -->

        <div class="container light-style flex-grow-1 container-p-y">
        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
            <?php endforeach ?>
            <h4 class="font-weight-bold py-3 mb-4">
                Configuración de cuenta
            </h4>
            <div class="card overflow-hidden">
                <div class="row no-gutters row-bordered row-border-light">
                    <div class="col-md-3 pt-0">
                        <div class="list-group list-group-flush account-settings-links">
                            <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>

                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content">
                            <form method="POST" enctype="multipart/form-data">
                                <hr class="border-light m-0">
                                <div class="card-body">

                                    <div class="tab-pane fade active show" id="account-general">
                                        <div class="card-body media align-items-center">
                                            <img class='profile-image' src="<?php if($usuario['imagen_usuario']) : echo 'imagenes/'.$usuario['imagen_usuario']; else : echo 'img/testimonial-1.jpg' ; endif; ?>" alt='imagenUsuario' >
                                            <div class="media-body ml-4">
                                                <input type="file" class="account-settings-fileinput" name="imagen">
                                            </div>
                                        </div>

                                        <div class="form-group" met>
                                            <label class="form-label">Nombre de Usuario</label>
                                            <input type="text" class="form-control" name='usuario' value="<?php echo $nombreUsuario?>">
                                        </div>

                                        <div class="form-group" met>
                                            <label class="form-label">Nombres Completos</label>
                                            <input type="text" class="form-control" name='nombre' value="<?php echo $usuario['nombre'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Apellidos Completos</label>
                                            <input type="text" class="form-control" name='apellido' value="<?php echo $usuario['apellido'] ?>">
                                        </div>
                                      
                                        <div class="form-group">
                                            <label class="form-label">Telefono</label>
                                            <input type="tel" class="form-control" name='telefono' value="<?php echo $usuario['telefono'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Bio</label>
                                            <textarea class="form-control" name="descripcion"><?php echo $usuario['descripcion'] ?></textarea>
                                        </div>

                                        <div class="text-right mt-3">
                                            <input type="submit" class="btn btn-primary px-4" value="Actualizar">
                                            <button type="button" class="btn btn-primary px-4">Volver</button>
                                        </div><br>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
            <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
            <script type="text/javascript">

            </script>
    </body>

    </html>
<?php else : header('location: login.php');
endif; ?>