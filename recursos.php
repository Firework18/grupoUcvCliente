<?php
require 'includes/config/database.php';
$db = conectarDB();


$consulta = "SELECT * FROM tipos_recursos";
$resultadoConsulta = mysqli_query($db, $consulta);
$tipo = mysqli_fetch_assoc($resultadoConsulta);

$consulta = "SELECT * FROM recursos INNER JOIN tipos_recursos tipo ON tipo.id = recursos.id_tipo_recurso";
$resultadoConsulta = mysqli_query($db, $consulta);
require './includes/templates/funciones.php';
$auth = estaAutenticado();
$rol = $_SESSION['rol'] ?? null;


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


    <div class="container-fluid pt-5">
        <div class="container">
            <div class="text-center pb-2">
                <p class="section-title px-5"><span class="px-2">Recursos</span></p>
                <h1 class="mb-4">Últimos Recursos Compartidos</h1>
            </div>
            <div class="row">

                <?php while ($recurso = mysqli_fetch_assoc($resultadoConsulta)) : ?>
                    <div class="col-lg-4 mb-5">
                        <div class="card border-0 bg-light shadow-sm pb-2">

                            <div class="card-body text-center">
                                <h4 class="card-title"><?php echo $recurso['titulo'] ?></h4>
                                <p class="card-text"><?php echo $recurso['descripcion'] ?></p>
                            </div>
                            <div class="card-footer bg-transparent py-4 px-5">

                                <div class="row border-bottom">
                                    <div class="col-6 py-1 text-right border-right"><strong>Carrera</strong></div>
                                    <div class="col-6 py-1"><?php echo $recurso['carrera'] ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-6 py-1 text-right border-right"><strong>Tipo</strong></div>
                                    <div class="col-6 py-1"><?php echo $recurso['tipo'] ?></div>
                                </div>
                            </div>
                            <a href="<?php echo $recurso['enlace'] ?>" class="btn btn-primary px-4 mx-auto mb-4">Ver</a>
                        </div>
                    </div>

                <?php endwhile; ?>
            </div>
        </div>
    </div>


    <?php
    include './includes/templates/footer.php';
    ?>
<?php else : header('location: /grupoUCV/login.php');
endif; ?>