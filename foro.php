<?php
require 'includes/config/database.php';
$db = conectarDB();

$consulta = "SELECT * FROM temas INNER JOIN usuarios_new usuario ON usuario.id = temas.usuario_id";
$resultadoConsulta = mysqli_query($db, $consulta);

require './includes/templates/funciones.php';
$auth = estaAutenticado();
$rol = $_SESSION['rol'] ?? null;

$resultado = $_GET['resultado'] ?? null;

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



    <!-- Blog Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="text-center pb-2">
                <?php if ($resultado == 1) : ?>
                    <p class="alerta exito">Tema creado correctamente</p>
                <?php endif ?>
                <p class="section-title px-5"><span class="px-2">Temas disponibles</span></p>
                <h1 class="mb-4">Foro de Discusión</h1>
                <a href="crearForo.php" class="btn btn-primary px-4 mx-auto my-2">Crear nuevo tema</a>
            </div>
            <div class="row pb-3">
                <?php while ($tema = mysqli_fetch_assoc($resultadoConsulta)) : ?>

                    <div class="col-lg-4 mb-4">
                        <div class="card border-0 shadow-sm mb-2">
                            <img class="card-img-top mb-2" src="img/blog-1.jpg" alt="">
                            <div class="card-body bg-light text-center p-4">
                                <h4 class=""><?php echo $tema['titulo']?></h4>
                                <div class="d-flex justify-content-center mb-3">
                                    <small class="mr-3"><i class="fa fa-user text-primary"></i> <?php echo $tema['usser'] ?></small>

                                </div>
                                <p><?php echo $tema['mensaje'] ?></p>
                                <a href="foroDetalle.php?resultado=<?php echo $tema['id_tema'] ?>" class="btn btn-primary px-4 mx-auto my-2">Leer Más</a>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
            </div>
        </div>
    </div>
    <!-- Blog End -->

    <?php
    include './includes/templates/footer.php';
    ?>
<?php else : header('location: /grupoUCV/login.php');
endif; ?>