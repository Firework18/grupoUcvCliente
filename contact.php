<?php 
  require 'includes/templates/funciones.php';
  $auth = estaAutenticado();
  $rol = $_SESSION['rol'] ?? null;
    

  if ($auth && $rol == '0'):
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

    

    <!-- Contact Start -->
    <div class="container-fluid py-5">
        <div class="container">
            
            <div class="text-center pb-2">
                <p class="section-title px-5"><span class="px-2">Mantente en Contacto</span></p>
                <h1 class="mb-4">Contactanos por cualquier consulta</h1>
            </div>
                <div class="col-lg-7">
                    <div class="contact-form">
                        <div id="success"></div>
                        <form name="sentMessage" id="contactForm" novalidate="novalidate">
                            <div class="control-group">
                                <input type="text" class="form-control" id="name" placeholder="Alessandro Del Carpio" required="required" data-validation-required-message="Please enter your name" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <input type="email" class="form-control" id="email" placeholder="ale@gmail.com" required="required" data-validation-required-message="Please enter your email" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <input type="text" class="form-control" id="subject" placeholder="Asunto" required="required" data-validation-required-message="Please enter a subject" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <textarea class="form-control" rows="6" id="message" placeholder="Mensaje" required="required" data-validation-required-message="Please enter your message"></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                            <div>
                                <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton">Enviar Correo</button>
                            </div>
                        </form>
                    </div>
                </div>
                
        </div>
    </div>
    <!-- Contact End -->

    <?php 
  include './includes/templates/footer.php';
?>
<?php else: header('location: login.php'); endif; ?>