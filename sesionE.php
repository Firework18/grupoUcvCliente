<?php

require 'includes/config/database.php';
$db = conectarDB();

$consulta = "SELECT * FROM sesiones WHERE valido = 1 AND creado = 1";
$resultadoConsulta = mysqli_query($db, $consulta);

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
                <a href="cerarSesion.php" class="btn btn-primary px-4">Cerrar Sesion</a>
            </div>
        </nav>
    </div>


    <!-- Class Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="text-center pb-2">
                <p class="section-title px-5"><span class="px-2">Próximas Sesiones</span></p>
                <h1 class="mb-4">Sesiones Creadas Por Alumnos</h1>
            </div>
            <div class="row">

                <?php while ($sesiones = mysqli_fetch_assoc($resultadoConsulta)) : ?>
                    <div class="col-lg-4 mb-5">
                        <div class="card border-0 bg-light shadow-sm pb-2">
                            <img class="card-img-top mb-2" src="img/img5.jpg" alt="Química">
                            <div class="card-body text-center">
                                <h4 class="card-title"><?php echo $sesiones['tema_estudio'] ?></h4>
                                <p class="card-text"><?php echo $sesiones['descripcion'] ?></p>
                            </div>
                            <div class="card-footer bg-transparent py-4 px-5">
                                <div class="row border-bottom">
                                    <div class="col-6 py-1 text-right border-right"><strong>Fecha</strong></div>
                                    <div class="col-6 py-1"><?php echo $sesiones['fecha'] ?></div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-6 py-1 text-right border-right"><strong>Tutor</strong></div>
                                    <div class="col-6 py-1"><?php echo $sesiones['nombre'] ?></div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-6 py-1 text-right border-right"><strong>Experiencia</strong></div>
                                    <div class="col-6 py-1"><?php echo $sesiones['experiencia'] ?></div>
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-6 py-1 text-right border-right"><strong>Carrera</strong></div>
                                    <div class="col-6 py-1"><?php echo $sesiones['carrera'] ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-6 py-1 text-right border-right"><strong>Horario</strong></div>
                                    <div class="col-6 py-1"><?php echo $sesiones['hora_inicio'] . "-" .  $sesiones['hora_fin'] ?></div>
                                </div>
                            </div>
                            <a href="" class="btn btn-primary px-4 mx-auto mb-4">Inscribirse</a>
                        </div>
                    </div>

                <?php endwhile; ?>
            </div>


        </div>

    </div>




    <?php 
  include './includes/templates/footer.php';
?>
<?php else: header('location: /grupoUCV/login.php'); endif; ?>