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
                                        <form method="POST" action="recuperar_contrasena.php">
                                            <div class="mb-3 mt-2">
                                                <label for="documento_recuperar" class="form-label">Número de Documento</label>
                                                <input type="text" class="form-control" id="documento_recuperar" name="documento_recuperar" placeholder="Ingrese su numero de documento" required>
                                            </div>
                                                <button type="submit" class="btn w-100 text-white py-2" style="background-color: #43be16;">
                                                    Recuperar contraseña
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
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Quick Link</h4>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Privacy Policy</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">FAQs & Help</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Contact</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Newsletter</h4>
                    <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved.

                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a><br><br>
                        Distributed By <a class="border-bottom" href="https://themewagon.com">ThemeWagon</a>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="">Home</a>
                            <a href="">Cookies</a>
                            <a href="">Help</a>
                            <a href="">FQAs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


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
