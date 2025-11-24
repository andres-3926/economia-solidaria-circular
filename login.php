<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login - Reciclando Juntas</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap y estilos -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        .card-login { max-width: 400px; margin: 80px auto; }
        #forgot-form { display: none; margin-top: 15px; }
        /* Centrado vertical en móviles */
        @media (max-width: 991.98px) {
            .owl-carousel-item.position-relative {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .container, .row.justify-content-center {
                height: 100%;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .container-fluid.mb-5 {
                margin-bottom: 0 !important;
            }
            .footer {
                padding: 0 !important;
                margin: 0 !important;
                min-height: auto !important;
                height: 35px !important;
                overflow: hidden !important;
            }
            .footer .container {
                padding: 0 !important;
                height: 100% !important;
                display: flex !important;
                align-items: center !important;
            }
            .footer .copyright {
                padding: 0 15px !important;
                margin: 0 !important;
                border: none !important;
                height: 35px !important;
                display: flex !important;
                align-items: center !important;
                width: 100% !important;
            }
            .footer .copyright .row {
                margin: 0 !important;
                width: 100% !important;
            }
            .footer .copyright .col-md-6{
                margin: 0 !important;
                padding: 0 !important;
                font-size: 11px !important;
                line-height: 1.2 !important;
                text-align: center !important;
                font-weight: 400 !important;
            }
        }
        /* Para dispositivos moviles muy pequeños */
        @media (max-width: 576px) {            
            .footer {
                height: 180px !important;
                overflow: hidden !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }
            .footer .container {
                height: 100% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 0 !important;
            }
            .footer .copyright {
                height: auto !important;
                padding: 20px 10px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 100% !important;
                margin: 0 !important;
                border: none !important;
            }
            .footer .copyright .row {
                margin: 0 !important;
                width: 100% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                height: auto !important;
            }
            .footer .copyright .col-md-6{
                font-size: 16px !important;
                font-weight: 600 !important;
                color: #ffffff !important;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.8) !important;
                text-align: center !important;
                margin: 0 !important;
                padding: 20px !important;
                line-height: 1.4 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="inicio.php" class="navbar-brand d-flex align-items-center px-2 px-lg-5">
            <h2 class="m-0 text-shadow titulo-navbar text-break" style="color: #43be16;">
                <i class="fa-solid fa-recycle fa-beat fa-xl me-2"></i>Economía Solidaria y Circular
            </h2>
        </a>
    </nav>

    <!-- Login Form -->
    
<div class="container-fluid p-0 mb-5">
    <div class="owl-carousel header-carousel position-relative">
        <div class="owl-carousel-item position-relative">
            <img class="img-fluid" src="img/portada.jpg" alt="">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                <div class="container">
                    <div class="row justify-content-center"> <!-- Cambiado a center para mejor alineación -->
                        <div class="col-sm-12 col-lg-4">
                            <!-- Mostrar mensaje de éxito (mensaje) o error (error) en el mismo toast -->
                            <?php
                            if (isset($_GET['mensaje']) || isset($_GET['error'])) {
                                $mensaje = $_GET['mensaje'] ?? $_GET['error'];
                                
                                // Detectar si es un mensaje de error usando los emojis o palabras clave
                                if (
                                    strpos($mensaje, '❌') !== false || 
                                    strpos($mensaje, '⚠️') !== false ||
                                    isset($_GET['error'])
                                ) {
                                    $color = '#f44336'; // rojo
                                } elseif (strpos($mensaje, '✅') !== false) {
                                    $color = '#4caf50'; // verde
                                } else {
                                    $color = '#4caf50'; // verde por defecto para otros mensajes de exito
                                }

                                echo '<div id="toast-alert" style="
                                    position: fixed;
                                    top: 20px;
                                    right: 20px;
                                    background-color: ' . $color . ';
                                    color: #fff;
                                    padding: 0.4rem 0.8rem;
                                    border-radius: 0.4rem;
                                    box-shadow: 0 2px 6px rgba(0,0,0,0.25);
                                    font-size: 0.8rem;
                                    font-weight: 500;
                                    z-index: 1060;
                                    opacity: 0;
                                    transform: translateX(120%);
                                    transition: opacity 0.5s ease, transform 0.5s ease;
                                ">
                                        ' . htmlspecialchars($mensaje) . '
                                    </div>';
                            }
                            ?>
                            <!-- Formulario de Registro -->
                            <div class="card bg-light rounded-3 shadow-lg">                                                       
                                <div class="card-header py-2 text-center" style="background-color: #43be16;">
                                    <h3 class="m-0 text-white"><i class="fa-solid fa-user me-2"></i>Iniciar Sesión</h3>
                                </div>
                                <div class="card-body p-3">
                                    <!-- Formulario de login -->
                                    <form action="procesar_login.php" method="POST">
                                        <div class="mb-3">
                                            <label for="documento" class="form-label">Numero de Documento</label>
                                            <input type="text" class="form-control" id="documento" name="documento" placeholder="Ingrese su numero de documento" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="contrasena" class="form-label">Contraseña</label>
                                            <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Ingrese su contraseña" required>
                                        </div>
                                            <button type="submit" name="login" class="btn w-100 text-white py-2" style="background-color: #43be16;">
                                                Ingresar
                                            </button>
                                    </form>

                                    <!-- Enlace Olvidé mi contraseña -->
                                    <div class="text-center mt-3">
                                        <a href="#" id="forgot-link" class="text-success fw-bold">¿Olvidaste tu contraseña?</a>
                                    </div>

                                    <!-- Formulario de recuperación -->
                                    <div id="forgot-form">
                                        <div class="alert alert-info mt-3" style="font-size: 12px;">
                                            <i class="fa-solid fa-shield-halved me-1"></i>
                                            <strong>Verificación de identidad:</strong> Ingresa tus datos exactamente como están registrados.
                                        </div>
                                        <form method="POST" action="recuperar_contrasena.php">
                                            <div class="mb-3">
                                                <label for="nombre_recuperar" class="form-label">Nombre Completo</label>
                                                <input type="text" class="form-control" id="nombre_recuperar" name="nombre_recuperar" placeholder="Ingrese su nombre completo" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="documento_recuperar" class="form-label">Número de Documento</label>
                                                <input type="text" class="form-control" id="documento_recuperar" name="documento_recuperar" placeholder="Ingrese su numero de documento" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="celular_recuperar" class="form-label">Número de Celular</label>
                                                <input type="text" class="form-control" id="celular_recuperar" name="celular_recuperar" placeholder="Ingrese su numero de celular" maxlength="10" required>
                                            </div>
                                            <button type="submit" class="btn w-100 text-white py-2" style="background-color: #43be16;">
                                                <i class="fa-solid fa-shield-halved me-1"></i>Verificar Identidad
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <p class="mb-0">¿No tienes cuenta? <a href="registro.php" class="text-success fw-bold">Regístrate aquí</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>                               
    </div>

    
    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-4">
            <!-- Información del SENA -->
            <div class="row g-4 mb-4">
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-white mb-3">
                        <i class="fas fa-graduation-cap me-2"></i>Servicio Nacional de Aprendizaje
                    </h5>
                    <p class="mb-2">
                        <i class="fas fa-building me-2" style="color: #43be16;"></i>
                        <strong>SENA - REGIONAL VALLE</strong>
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-users me-2" style="color: #43be16;"></i>
                        <strong>Centro de Gestión Tecnológico de Servicios (CGTS) - Valle</strong>
                    </p>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-white mb-3">
                        <i class="fas fa-recycle me-2"></i>Proyecto
                    </h5>
                    <p class="mb-2">
                        <strong>Economía Solidaria y Circular</strong>
                    </p>
                    <p class="mb-0">
                        Promoviendo prácticas sostenibles en unidades productivas de Cali
                    </p>
                </div>
                
                <div class="col-lg-4 col-md-12">
                    <h5 class="text-white mb-3">
                        <i class="fas fa-info-circle me-2"></i>Contacto
                    </h5>
                    <p class="mb-2">
                        <i class="fas fa-envelope me-2" style="color: #43be16;"></i>
                        info@sena.edu.co
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-phone me-2" style="color: #43be16;"></i>
                        +57 (2) 620 00 00
                    </p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social me-2" href="https://www.facebook.com/SENA" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="btn btn-outline-light btn-social me-2" href="https://twitter.com/SENAComunica" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="btn btn-outline-light btn-social" href="https://www.youtube.com/user/SENATV" target="_blank">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Línea divisoria -->
            <hr style="border-color: rgba(255,255,255,0.2);">
            
            <!-- Copyright -->
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <p class="mb-0">
                            &copy; 2025 
                            <a class="border-bottom" href="https://www.sena.edu.co" target="_blank" style="color: #43be16; text-decoration: none;">
                                SENA - Regional Valle
                            </a>
                            - Todos los derechos reservados.
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <p class="mb-0">
                            Desarrollado por 
                            <a class="border-bottom" href="#" style="color: #43be16; text-decoration: none;">
                                CGTS Valle
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>


    <!-- Script para mostrar/ocultar recuperación -->
    <script>
        document.getElementById('forgot-link').addEventListener('click', function(e){
            e.preventDefault();
            var form = document.getElementById('forgot-form');
            form.style.display = (form.style.display === 'none') ? 'block' : 'none';
        });
    </script>

    <script>
        const toast = document.getElementById('toast-alert');
            if (toast) {
            // Mostrar con animación
            setTimeout(() => {
                toast.style.opacity = "1";
                toast.style.transform = "translateX(0)";
            }, 100);

            // Desaparecer después de 4 segundos
            setTimeout(() => {
                toast.style.opacity = "0";
                toast.style.transform = "translateX(120%)";
                setTimeout(() => toast.remove(), 500);
            }, 4000);
        }
    </script>


    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="/economia-solidaria-circular/js/bootstrap.bundle.min.js"></script>
</body>
</html>
