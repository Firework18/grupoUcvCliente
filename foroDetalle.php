<?php
require './includes/templates/funciones.php';
$auth = estaAutenticado();
$rol = $_SESSION['rol'] ?? null;

require 'includes/config/database.php';
$db = conectarDB();
$resultado = $_GET['resultado'] ?? null;
$consulta = "SELECT * FROM temas LEFT JOIN usuarios_new usuario ON usuario.id = temas.usuario_id WHERE id_tema = $resultado";
$resultadoConsulta = mysqli_query($db, $consulta);
$tema = mysqli_fetch_assoc($resultadoConsulta);
$tema_id = $resultado;


$mensaje = '';
$usuario = $_SESSION['id'];
$imagen = $_FILES['imagen'];
$errores = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $mensaje = $_POST['mensaje'];

    $medida = 1000 * 1000;

    if ($imagen['size'] > $medida) {
        $errores[] = "Coloque una imagen menos pesada";
    }

    if (!$mensaje) {
        $errores[] = "Coloque un mensaje";
    }


    if (empty($errores)) {

        //Crear Carpeta
        $carpetaImagenes = '../grupoUCV/imagenes';
        //is_dir verifica si la carpeta existe
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        $nombreImagen = '';

        if ($imagen['name']) {

            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . "/" . $nombreImagen);
        }

        $query = "INSERT INTO comentarios (tema_id, mensaje, usuario_id,imagen_comentario) VALUES ('$tema_id','$mensaje','$usuario','$nombreImagen');";


        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('location: /grupoUCV/foroDetalle.php?resultado=' . $tema_id);
        }
    }
}


if ($auth && $rol == '0') :
    require './includes/templates/header.php';
?>

    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
        <div class="navbar-nav font-weight-bold mx-auto py-0">
            <a href="index.php" class="nav-item nav-link active">Inicio</a>
            <a href="nosotros.php" class="nav-item nav-link">Sobre Nosotros</a>
            <a href="sesion.php" class="nav-item nav-link">Sesiones</a>
            <a href="profesores.php" class="nav-item nav-link">Profesores</a>
            <a href="registrarSesion.php" class="nav-item nav-link">Solicitar Sesión</a>
            <a href="foro.php" class="nav-item nav-link">Foro de Discusión</a>
            <a href="recursos.php" class="nav-item nav-link">Recursos</a>

            <a href="contact.php" class="nav-item nav-link">Contáctanos</a>
        </div>
        <a href="perfil.php?resultado=<?php echo $_SESSION['id'] ?>" class="nav-item nav-link"><i class="fas fa-cog"></i></a>
        <a href="cerarSesion.php" class="btn btn-primary px-4">Cerrar Sesion</a>
    </div>
    </nav>
    </div>




    <!-- Detail Start -->
    <div class="container py-5">
        <div class="row pt-5">
            <div class="col-lg-8">
                <div class="d-flex flex-column text-left mb-3">
                    <a href="foro.php" class="btn btn-primary px-4 mx-auto my-2">Volver</a>
                    <p class="section-title pr-5"><span class="pr-2">Detalle del Tema</span></p>
                    <h1 class="mb-3"><?php echo $tema['titulo']; ?></h1>
                </div>

                <div class="mb-5">
                    <p><?php echo $tema['mensaje']; ?></p>

                    <!-- Mostrar la imagen del tema -->
                    <?php if (!empty($tema['imagen_tema'])) : ?>
                        <div class="mb-3">
                            <img src="imagenes/<?php echo $tema['imagen_tema']; ?>" alt="Imagen del tema" class="img-fluid rounded" style="max-width: 100%; height: auto; max-height: 400px;">
                        </div>
                    <?php endif; ?>
                </div>



                <!-- Comment List -->
                <div class="mb-5">

                    <h2 class="mb-4">Commentarios</h2>
                    <?php
                    $consulta = "SELECT * FROM comentarios INNER JOIN usuarios_new usuario ON usuario.id = comentarios.usuario_id WHERE comentarios.tema_id = $tema_id
                        ORDER BY comentarios.fecha ASC";
                    $resultadoConsulta = mysqli_query($db, $consulta);

                    while ($comentario = mysqli_fetch_assoc($resultadoConsulta)) : ?>
                        <div class="media mb-4">
                            <img src="imagenes/<?php echo $comentario['imagen_usuario'] ?>" alt="Image" class="img-fluid rounded-circle mr-3 mt-1" style="width: 45px;">
                            <div class="media-body">
                                <h6><?php echo $comentario['usser'] ?> <small><i><?php echo $comentario['fecha'] ?></i></small></h6>
                                <p><?php echo $comentario['mensaje'] ?></p>
                                <?php if ($comentario['imagen_comentario']) : ?>
                                    <img src="imagenes/<?php echo $comentario['imagen_comentario']; ?>" alt="Imagen del comentario" class="img-fluid mt-2" style="max-width: 100%; height: auto; width: 100px; height: 100px; object-fit: cover;" data-id="<?php echo ($comentario['imagen_comentario']); ?>">
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Comment Form -->
                <div class="bg-light p-5">
                    <?php foreach ($errores as $error) : ?>
                        <div class="alerta error">
                            <?php echo $error ?>
                        </div>
                    <?php endforeach ?>
                    <h2 class="mb-4">Deja un comentario</h2>
                    <form method="POST" enctype="multipart/form-data" action="foroDetalle.php?resultado=<?php echo $tema_id ?>">
                        <div class="form-group">
                            <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">
                            <label for="mensaje">Mensaje</label>
                            <textarea id="mensaje" name="mensaje" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="imagen">Subir imagen</label>
                            <input type="file" id="imagen" name="imagen" class="form-control">
                        </div>
                        <div class="form-group mb-0">
                            <input type="submit" value="Comentar" class="btn btn-primary px-3">
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4 mt-5 mt-lg-0">
                <!-- Author Bio -->
                <div class="d-flex flex-column text-center bg-primary rounded mb-5 py-5 px-4">
                    <img src="imagenes/<?php echo $tema['imagen_usuario'] ?>" class="img-fluid rounded-circle mx-auto mb-3" style="width: 100px;">
                    <h3 class="text-secondary mb-3"><?php echo $tema['usser'] ?></h3>
                    <p class="text-white m-0"><?php echo $tema['descripcion'] ?></p>
                </div>


            </div>
        </div>
    </div>
    <!-- Detail End -->


    <?php
    include './includes/templates/footer.php';
    ?>
<?php else : header('location: /grupoUCV/login.php');
endif; ?>