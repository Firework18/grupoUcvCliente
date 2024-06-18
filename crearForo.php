<?php
require 'includes/templates/funciones.php';
$auth = estaAutenticado();
$rol = $_SESSION['rol'] ?? null;
require 'includes/config/database.php';
$db = conectarDB();
$errores = [];
$usuario_id = $_SESSION['id'];
$imagen = $_FILES['imagen'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $titulo = $_POST['titulo'];
  $mensaje = $_POST['mensaje'];
  


  if (!$titulo) {
    $errores[] = "Coloque el titulo";
  }
  if (!$mensaje) {
    $errores[] = "Coloque el mensaje";
  }

  $medida = 1000 * 1000;

  if ($imagen['size'] > $medida) {
    $errores[] = "Coloque una imagen menos pesada";
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
         
         $nombreImagen = md5(uniqid(rand(),true)).".jpg";
         
         move_uploaded_file($imagen['tmp_name'],$carpetaImagenes."/".$nombreImagen);
     }



    $query = "INSERT INTO temas (titulo, mensaje, usuario_id,imagen_tema) VALUES ('$titulo','$mensaje','$usuario_id','$nombreImagen');";

    $resultado = mysqli_query($db, $query);

    if ($resultado) {
      header('location: /grupoUCV/foro.php?resultado=1');
    }
  }
}

if ($auth && $rol == '0') :
  include 'includes/templates/header.php';
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

  <div class="container-fluid pt-5">
    <div class="container">
      <a href="foro.php" class="btn btn-primary px-4 mx-auto my-2">Volver</a>
      <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
          <?php echo $error ?>
        </div>
      <?php endforeach ?>
      <h2>Nuevo Tema</h2>
      <form method="POST" enctype="multipart/form-data" action="/grupoUCV/crearForo.php">
        <div class="formulario-login__campo">
          <label for="titulo" class="formulario-login__label">Titulo</label>
          <input type="text" class="formulario-login__input" id="titulo" name="titulo">
        </div>

        <div class="formulario-login__campo">
          <label for="mensaje">Mensaje</label>
          <textarea id="mensaje" name="mensaje" class="formulario-login__input"></textarea>
        </div>

        <div class="formulario-login__campo">
          <label for="imagen">Subir Imagen</label>
          <input type="file" class="formulario-login__input" id="imagen" name="imagen">
        </div>

        <input type="submit" class="btn btn-primary px-4" value="Crear Tema">
      </form>
    </div>
  </div>




  <?php
  include './includes/templates/footer.php';
  ?>
<?php else : header('location: login.php');
endif; ?>