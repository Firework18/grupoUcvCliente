<?php 
  require './includes/templates/funciones.php';
  $auth = estaAutenticado();
  $rol = $_SESSION['rol'] ?? null;
    

  if ($auth && $rol == '0'):
    require './includes/templates/header.php';
    require 'includes/config/database.php';

    $db = conectarDB();

    $querySesiones = "SELECT * FROM sesiones LEFT JOIN profesores ON profesores.id_profesor = sesiones.id_profesor LIMIT 3";
    $resultadoSesiones = mysqli_query($db,$querySesiones);

    $queryProfesores = "SELECT * FROM profesores LIMIT 4";
    $resultadoProfesores = mysqli_query($db,$queryProfesores);

    $queryRecursos = "SELECT * FROM recursos INNER JOIN tipos_recursos tipo ON tipo.id = recursos.id_tipo_recurso LIMIT 3";
    $resultadoRecursos = mysqli_query($db,$queryRecursos);
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


    <!-- Header Start -->
    <header class="header">
        <div class="header__contenedor">
          <div class="header__contenido">
            <a href="index.php">
              <h1 class="header__logotipo">Grupo de Apoyo UCV</h1>
            </a>
  
            <p>Juntos aprendemos, Juntos crecemos.</p>
          </div>
        </div>
      </header>
    <!-- Header End -->


    <!-- Facilities Start -->
    <div class="container-fluid pt-5">
        <div class="container pb-3">
            <div class="row">
                <div class="col-lg-4 col-md-6 pb-1">
                    <div class="d-flex bg-light shadow-sm border-top rounded mb-4" style="padding: 30px;">
                        <i class="flaticon-022-drum h1 font-weight-normal text-primary mb-3"></i>
                        <div class="pl-4">
                            <h4>Habla con otros estudiantes</h4>
                            <p class="m-0">Resuelve tus dudas respecto a diferentes temas de tus cursos de la carrera con otros estudiantes...</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 pb-1">
                    <div class="d-flex bg-light shadow-sm border-top rounded mb-4" style="padding: 30px;">
                        <i class="flaticon-030-crayons h1 font-weight-normal text-primary mb-3"></i>
                        <div class="pl-4">
                            <h4>Recursos y Materiales</h4>
                            <p class="m-0">Accede a una amplia variedad de recursos y materiales para estudiar, diseñados para mejorar tu comprensión de los temas...</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 pb-1">
                    <div class="d-flex bg-light shadow-sm border-top rounded mb-4" style="padding: 30px;">
                        <i class="flaticon-047-backpack h1 font-weight-normal text-primary mb-3"></i>
                        <div class="pl-4">
                            <h4>Sesiones en Línea</h4>
                            <p class="m-0">Participa en sesiones en línea con tutores expertos desde la comodidad de tu hogar, ajustadas a tu horario...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Facilities Start -->


<!-- About Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <img class="img-fluid rounded mb-5 mb-lg-0" src="img/estudio.jpg" alt="Grupo de Apoyo UCV">
            </div>
            <div class="col-lg-7">
                <p class="section-title pr-5"><span class="pr-2">Conócenos</span></p>
                <h1 class="mb-4">Grupo de Apoyo UCV</h1>
                <p>El Grupo de Apoyo de la Universidad César Vallejo está dedicado a brindar apoyo académico a los estudiantes. Nos comprometemos a ayudar a los estudiantes a alcanzar su máximo potencial a través de tutorías personalizadas, recursos educativos y sesiones de apoyo.</p>
                <div class="row pt-2 pb-4">
                    <div class="col-6 col-md-4">
                        <img class="img-fluid rounded" src="img/Consejos-para-estudiar-en-grupo-1200x628.jpg" alt="Sesión de Tutoría">
                    </div>
                    <div class="col-6 col-md-8">
                        <ul class="list-inline m-0">
                            <li class="py-2 border-top border-bottom"><i class="fa fa-check text-primary mr-3"></i>Tutorías personalizadas y grupales</li>
                            <li class="py-2 border-bottom"><i class="fa fa-check text-primary mr-3"></i>Recursos y materiales actualizados</li>
                            <li class="py-2 border-bottom"><i class="fa fa-check text-primary mr-3"></i>Sesiones de apoyo académico</li>
                        </ul>
                    </div>
                </div>
                <a href="nosotros.php" class="btn btn-primary mt-2 py-2 px-4">Más Información</a>
            </div>
        </div>
    </div>
</div>
<!-- About End -->



    <!-- Class Start -->
   <div class="container-fluid pt-5">
    <div class="container">
        <div class="text-center pb-2">
            <p class="section-title px-5"><span class="px-2">Próximas Clases</span></p>
            <h1 class="mb-4">Clases Disponibles</h1>
        </div>
        <div class="row">
        <?php while ($sesiones = mysqli_fetch_assoc($resultadoSesiones)) : ?>
                    <div class="col-lg-4 mb-5">
                        <div class="card border-0 bg-light shadow-sm pb-2">
                            <img class="card-img-top mb-2" src="/imagenes/<?php echo $sesiones['imagen_sesion'] ?>" alt="Química">
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
                                    <div class="col-6 py-1 text-right border-right"><strong>Profesor</strong></div>
                                    <?php if($sesiones['creado']): ?>
                                        <div class="col-6 py-1"><?php echo $sesiones['nombre'] ?></div>  
                                    <?php else : ?>
                                        <div class="col-6 py-1"><?php echo $sesiones['nombre_completo'] .' '. $sesiones['apellidos_completos'] ?></div>
                                    <?php endif ?> 
                                    
                                    
                                </div>
                                <div class="row border-bottom">
                                    <div class="col-6 py-1 text-right border-right"><strong>Creado por</strong></div>
                                    <?php if($sesiones['creado']): ?>
                                        <div class="col-6 py-1"><?php echo 'Alumno' ?></div>  
                                    <?php else : ?>
                                        <div class="col-6 py-1"><?php echo 'Admin' ?></div>
                                    <?php endif ?> 
                                    
                                    
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
            <a href="./sesion.php" class="btn btn-primary mt-2 py-2 px-4">Ver Más</a>
            
        </div>
        
    </div>
</div>
<!-- Class End -->

  

  <!-- Team Start -->
<div class="container-fluid pt-5">
    <div class="container">
        <div class="text-center pb-2">
            <p class="section-title px-5"><span class="px-2">Nuestros Profesores</span></p>
            <h1 class="mb-4">Conoce a Nuestros Profesores</h1>
        </div>
        <div class="row">
        <?php while($profesor = mysqli_fetch_assoc($resultadoProfesores)):?>
                <div class="col-md-6 col-lg-3 text-center team mb-5">
                    <div class="position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                        <img class="img-fluid w-100" src="/imagenes/<?php echo $profesor['imagen'] ?>" alt="imagen profesor">
                        
                        <div class="team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
                            <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px;" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px;" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light text-center px-0" style="width: 38px; height: 38px;" href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <h4><?php echo $profesor['nombre_completo'] . " " .$profesor['apellidos_completos'] ?></h4>
                    <i>Carrera: <?php echo $profesor['especialidad'] ?></i>
                </div>
            <?php endwhile;?>  
            
            <a href="profesores.php" class="btn btn-primary mt-2 py-2 px-4">Ver más</a>
        </div>
        
    </div>
</div>
<!-- Team End -->



    <!-- Blog Start -->
 <!-- Resources Start -->
<div class="container-fluid pt-5">
    <div class="container">
        <div class="text-center pb-2">
            <p class="section-title px-5"><span class="px-2">Recursos Destacados</span></p>
            <h1 class="mb-4">Últimos Recursos Compartidos</h1>
        </div>
        <div class="row pb-3">
        <?php while ($recurso = mysqli_fetch_assoc($resultadoRecursos)) : ?>
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
            <a href="recursos.php" class="btn btn-primary mt-2 py-2 px-4">Ver Más</a>
        </div>
    </div>
</div>
<!-- Resources End -->


<?php 
  include './includes/templates/footer.php';
?>
<?php else: header('location: /grupoUCV/login.php'); endif; ?>