<?php 

require 'includes/config/database.php';
$db =conectarDB();

$consulta= "SELECT * FROM profesores";
$resultadoConsulta =mysqli_query($db,$consulta);

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




    <!-- Team Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="text-center pb-2">
                <p class="section-title px-5"><span class="px-2">Nuestros Profesores</span></p>
                <h1 class="mb-4">Conoce a Nuestros Profesores</h1>
            </div>
            <div class="row">
            <?php while($profesor = mysqli_fetch_assoc($resultadoConsulta)):?>
                <div class="col-md-6 col-lg-3 text-center team mb-5">
                    <div class="position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                        <img class="img-fluid w-100" src="/imagenes/<?php echo $profesor['imagen'] ?>" alt="imagen profesor">
                        
                       
                    </div>
                    <h4><?php echo $profesor['nombre_completo'] . " " .$profesor['apellidos_completos'] ?></h4>
                    <i>Carrera: <?php echo $profesor['especialidad'] ?></i>
                </div>
            <?php endwhile;?>   
            </div>
        </div>
    </div>
    <!-- Team End -->

    <?php 
  include './includes/templates/footer.php';
?>
<?php else: header('location: /grupoUCV/login.php'); endif; ?>