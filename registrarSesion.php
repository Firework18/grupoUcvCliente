<?php 

require 'includes/config/database.php';
$db =conectarDB();

  
  $fecha = '';
  $hora_inicio = '';
  $hora_fin = '';
  $carrera = '';
  $tema = '';
  $descripcion = '';
  $enlace = '';
  $valido = '0';
  $nombre = '';
  $experiencia = '';
  $creado = '1';
  $errores = []; 

  $resultado= $_GET['resultado'] ?? null;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $fecha = $_POST['fecha'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];
    $carrera = $_POST['carrera'];
    $tema = $_POST['tema'];
    $descripcion = $_POST['descripcion'];
    $enlace = $_POST['enlace_zoom'];
    $nombre = $_POST['nombre'];
    $experiencia = $_POST['experiencia'];

    if (!$fecha) {
      $errores[] = "Coloque la fecha";
    }
    if (!$hora_inicio) {
      $errores[] = "Coloque el horario de inicio";
    }
    if (!$hora_fin) {
      $errores[] = "Coloque el horario de fin";
    }
    if (!$carrera) {
      $errores[] = "Coloque la carrera";
    }
    if (!$tema) {
      $errores[] = "Coloque el tema";
    }
    if (!$descripcion) {
      $errores[] = "Coloque la descripcion";
    }
    if (!$enlace) {
      $errores[] = "Coloque el enlace";
    }
    if (!$nombre) {
        $errores[] = "Coloque el nombre";
      }
    if (!$experiencia) {
        $errores[] = "Coloque la experiencia";
      }
  
    if (empty($errores)) {
  
   
      $query = "INSERT INTO sesiones (fecha, hora_inicio, hora_fin, tema_estudio,descripcion,enlace_zoom,carrera,valido,nombre,creado,experiencia) VALUES ('$fecha','$hora_inicio','$hora_fin'
          ,'$tema','$descripcion','$enlace','$carrera','$valido','$nombre','$creado','$experiencia');";

      $resultado = mysqli_query($db, $query);
  
      if ($resultado) {
        header('location: /grupoUCV/registrarSesion.php?resultado=1');
      }
    }
  }
  
  require './includes/templates/funciones.php';
  $auth = estaAutenticado();
  $rol = $_SESSION['rol'] ?? null;
    

  if ($auth && $rol == '0'):
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


    <div class="container-fluid pt-5">
        <div class="container">
        <?php if($resultado == 1): ?>
            <p class="alerta exito">Sesion solicitada correctamente</p>
            <?php endif ?>      
        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error ?>
            </div>
            <?php endforeach ?>
            <h2>Registrar sesión a solicitar</h2>
            <form method="POST" action="/grupoUCV/registrarSesion.php" >
                <fieldset>
                    <legend>Detalles de la Sesión</legend>
                    <div class="formulario-login__campo">
                        <label for="fecha" class="formulario-login__label">Fecha</label>
                        <input type="date" class="formulario-login__input" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
                    </div>
                    <div class="formulario-login__campo">
                        <label for="hora_inicio" class="formulario-login__label">Hora de Inicio</label>
                        <input type="time" class="formulario-login__input" id="hora_inicio" name="hora_inicio" value="<?php echo $hora_inicio; ?>">
                    </div>
                    <div class="formulario-login__campo">
                        <label for="hora_fin" class="formulario-login__label">Hora de Fin</label>
                        <input type="time" class="formulario-login__input" id="hora_fin" name="hora_fin" value="<?php echo $hora_fin; ?>">
                    </div>
                    <div class="formulario-login__campo">
                        <label for="carrera" class="formulario-login__label">Carrera</label>
                        <input type="text" class="formulario-login__input" id="carrera" name="carrera" placeholder="Carrera del curso" value="<?php echo $carrera; ?>">
                    </div>
                    <div class="formulario-login__campo">
                        <label for="tema" class="formulario-login__label">Tema de Estudio</label>
                        <input type="text" class="formulario-login__input" id="tema" name="tema" placeholder="Tema que se estudiará" value="<?php echo $tema; ?>">
                    </div>
                    <div class="formulario-login__campo">
                        <label for="descripcion" class="formulario-login__label">Descripción</label>
                        <textarea class="formulario-login__input" id="descripcion" name="descripcion" placeholder="Breve descripción de la sesión"><?php echo $descripcion; ?></textarea>
                    </div>
                    <div class="formulario-login__campo">
                        <label for="enlace_zoom" class="formulario-login__label">Enlace de Zoom</label>
                        <input type="url" class="formulario-login__input" id="enlace_zoom" name="enlace_zoom" placeholder="Enlace de la reunión en Zoom" value="<?php echo $enlace; ?>">
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Datos del Tutor</legend>
                    <div class="formulario-login__campo">
                        <label for="nombre" class="formulario-login__label">Nombres</label>
                        <input type="text" class="formulario-login__input" id="nombre" name="nombre" placeholder="Nombres del tutor" value="<?php echo $nombre; ?>">
                    </div>
                    <div class="formulario-login__campo">
                        <label for="experiencia" class="formulario-login__label">Experiencia</label>
                        <input type="text" class="formulario-login__input" id="experiencia" name="experiencia" placeholder="Experiencia del tutor" value="<?php echo $nombre; ?>">
                    </div>
                </fieldset>

                <input type="submit" class="formulario-login__submit" value="Registrar Sesión">
            </form>
        </div>

    </div>

    <?php 
  include './includes/templates/footer.php';
?>
<?php else: header('location: /grupoUCV/login.php'); endif; ?>