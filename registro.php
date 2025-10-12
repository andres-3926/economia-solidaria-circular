<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Reciclando Juntas, Produciendo Futuro</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="inicio.php" class="navbar-brand d-flex align-items-center px-2 px-lg-5">
        <h2 class="m-0 text-shadow titulo-navbar text-break" style="color: #43be16;"><i class="fa-solid fa-recycle fa-beat fa-xl me-2"></i>Economía Solidaria y Circular</h2>
        </a>
    </nav>
    <!-- Navbar End -->


   <!-- Carousel Start -->
<div class="container-fluid p-0 mb-5" style="min-height: 100vh;">
    <div class="owl-carousel header-carousel position-relative">
        <div class="owl-carousel-item position-relative">
            <img class="img-fluid" src="img/portada.jpg" alt="">
            <div class="overlay-carrusel" style="background: rgba(24, 29, 56, .7);">
                <div class="container">
                    <div class="row justify-content-center"> <!-- Cambiado a center para mejor alineación -->
                        <div class="col-sm-12 col-lg-7">
                            <!-- Formulario de Registro -->
                            <div class="card bg-light rounded-3 shadow-lg">
                                <div class="card-header py-3 text-center" style="background-color: #43be16;">
                                    <h3 class="m-0 text-white"><i class="fa-solid fa-user me-2"></i>Registro de Usuario</h3>
                                </div>
                                <div class="card-body p-4">
                                    <form action="procesar_registro.php" method="POST">
                                        <!-- Fila 1: Tipo Documento y Número Documento -->
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label for="tipo_documento" class="form-label">Tipo de Documento *</label>
                                                <select class="form-select" id="tipo_documento" name="tipo_documento" required>
                                                    <option value="">Seleccionar</option>
                                                    <option value="CC">Cédula de Ciudadanía</option>
                                                    <option value="CE">Cédula de Extranjería</option>
                                                    <option value="PPT">Permiso por Protección Temporal</option>
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <label for="numero_documento" class="form-label">Número de Documento *</label>
                                                <input type="text" class="form-control" id="numero_documento" name="numero_documento" required placeholder="Ingrese su número de documento">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="celular" class="form-label">Celular *</label>
                                                <input type="tel" class="form-control" id="celular" name="celular" required placeholder="Ingrese número">
                                            </div>
                                        </div>

                                        <!-- Fila 2: Nombre Completo -->
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="nombre_completo" class="form-label">Nombre Completo *</label>
                                                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" required placeholder="Nombres y apellidos completos">
                                            </div>
                                        </div>

                                        <!-- Fila 3: Email y Contraseña -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="email" class="form-label">Correo Electrónico</label>
                                                <input type="email" class="form-control" id="email" name="email" required placeholder="ejemplo@correo.com">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="password" class="form-label">Contraseña *</label>
                                                <input type="password" class="form-control" id="contrasena" name="contrasena" required placeholder="Mínimo 8 caracteres">
                                            </div>
                                        </div>

                                        <!-- Fila: Nombre del Emprendimiento -->
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="emprendimiento" class="form-label">Nombre del Emprendimiento *</label>
                                                <input type="text" class="form-control" id="emprendimiento" name="emprendimiento" required placeholder="Nombre de tu emprendimiento" required>
                                            </div>
                                        </div>

                                        <!-- Dirección -->
                                        <div class="mb-3">
                                            <label for="direccion" class="form-label">Dirección *</label>
                                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                                        </div>

                                        <!-- Fila 4: Comuna y Barrio -->
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="comuna" class="form-label">Comuna *</label>
                                                <select class="form-control" id="comuna" name="comuna" required>
                                                    <option value="">Seleccionar comuna</option>
                                                    <option value="1">Comuna 1</option>
                                                    <option value="2">Comuna 2</option>
                                                    <option value="3">Comuna 3</option>
                                                    <option value="4">Comuna 4</option>
                                                    <option value="5">Comuna 5</option>
                                                    <option value="6">Comuna 6</option>
                                                    <option value="7">Comuna 7</option>
                                                    <option value="8">Comuna 8</option>
                                                    <option value="9">Comuna 9</option>
                                                    <option value="10">Comuna 10</option>
                                                    <option value="11">Comuna 11</option>
                                                    <option value="12">Comuna 12</option>
                                                    <option value="13">Comuna 13</option>
                                                    <option value="14">Comuna 14</option>
                                                    <option value="15">Comuna 15</option>
                                                    <option value="16">Comuna 16</option>
                                                    <option value="17">Comuna 17</option>
                                                    <option value="18">Comuna 18</option>
                                                    <option value="19">Comuna 19</option>
                                                    <option value="20">Comuna 20</option>
                                                    <option value="21">Comuna 21</option>
                                                    <option value="22">Comuna 22</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="barrio" class="form-label">Barrio o Sector *</label>
                                                <input type="text" class="form-control" id="barrio" name="barrio" required placeholder="Nombre de barrio o sector">
                                            </div>
                                        </div>

                                        <!-- Términos y Condiciones -->
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="terminos" required>
                                                    <label class="form-check-label" for="terminos">
                                                        Acepto los <a href="#" class="text-success">términos y condiciones</a> y el <a href="#" class="text-success">tratamiento de datos</a> *
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Botón de Registro -->
                                        <div class="row">
                                            <div class="col-12">
                                                <button type="submit" class="btn w-100 text-white py-2" style="background-color: #43be16; font-size: 1.1rem;">
                                                    <i class="fa-solid fa-user me-2"></i>Registrarse
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    <!-- Enlace para login -->
                                    <div class="text-center mt-3">
                                        <p class="mb-0">¿Ya tienes cuenta? <a href="login.php" class="text-success fw-bold">Inicia sesión aquí</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Carousel End -->


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
                    <h4 class="text-white mb-3">Gallery</h4>
                    <div class="row g-2 pt-2">
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-1.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-2.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-3.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-2.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-3.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/course-1.jpg" alt="">
                        </div>
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


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>

