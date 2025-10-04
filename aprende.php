<?php
$pagina_activa = 'aprende';
session_start();
include("conexion.php");

    // Array de páginas de la cartilla, incluyendo la portada como página 0
    $cartilla = [
        [
            "tipo" => "portada",
            "titulo" => '"Reciclando Juntas Produciendo Futuro"',
            "subtitulo" => '"Economía Solidaria y Circular para Unidades Productivas de Cali".',
            "frase" => '"El SENA te acompaña en la construcción de un futuro más próspero y sostenible."',
            "logo" => "img/Logo-sena-blanco-sin-fondo.webp"
        ],
        [
            "tipo" => "contenido",
            "titulo" => "¡Hola, Emprendedora!",
            "texto" => "Sabemos que tu esfuerzo diario construye futuro. Esta guía está diseñada para acompañarte en un viaje donde cada residuo se convierte en una nueva oportunidad para tu negocio y tu comunidad. ¡Juntas vamos a transformar Cali!",
            "imagen" => "img/bienvenida.jpg"
        ],
        [
            "tipo" => "contenido",
            "titulo" => "Por Qué Esta Guía Es Para Ti",
            "texto" => "<ul>
                <li><b>Reduce Costos:</b> Menos gastos en materiales nuevos, menos dinero en basura.</li>
                <li><b>Genera Ingresos Extra:</b> Transforma residuos en productos o vendiendo reciclables.</li>
                <li><b>Mejora tu Entorno:</b> Contribuye a una comunidad más limpia y sana.</li>
                <li><b>Fortalece Tu Comunidad:</b> Trabaja en equipo y conecta con otras emprendedoras.</li>
            </ul>",
            "logo" => "img/Logo-sena-blanco-sin-fondo.webp"
        ]
        // ...agrega el resto de páginas aquí...
    ];

    // Página actual (por defecto 0 = portada)
    $pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 0;
    $total_paginas = count($cartilla);
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Aprende</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="/economia-solidaria-circular/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="/economia-solidaria-circular/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/economia-solidaria-circular/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/economia-solidaria-circular/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="/economia-solidaria-circular/css/style.css" rel="stylesheet">
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
        <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="m-0 text-shadow" style="color: #43be16;"><i class="fa-solid fa-recycle fa-beat fa-xl me-4"></i>Economía Solidaria y Circular</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link<?php echo $pagina_activa === 'inicio' ? ' active text-primary' : ' text-dark'; ?>">Inicio</a>
                <a href="trueques.php#trueques" class="nav-item nav-link<?php echo $pagina_activa === 'trueques' ? ' active text-primary' : ' text-dark'; ?>">Trueques</a>
                <a href="aprende.php" class="nav-item nav-link<?php echo $pagina_activa === 'aprende' ? ' active text-primary' : ' text-dark'; ?>">Aprende</a>                
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle<?php echo $pagina_activa === 'comunidades' ? ' active text-primary' : ' text-dark'; ?>" data-bs-toggle="dropdown">Comunidades</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="team.html" class="dropdown-item">Our Team</a>
                        <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                        <a href="404.html" class="dropdown-item">404 Page</a>
                    </div>
                </div>
                <?php
                if(isset($_SESSION['numero_documento'])) {
                    $clase_perfil = $pagina_activa === 'perfil' ? ' active text-primary' : ' text-dark';
                    echo '<a href="perfil.php" class="nav-item nav-link' . $clase_perfil . '">Perfil</a>';
                }
                ?>
                <?php
                if (isset($_SESSION['numero_documento'])) {
                    //Boton de cerrar sesión
                    echo '<a href="logout.php" class="btn py-4 px-lg-5 d-none d-lg-block text-white" style="background-color: #43be16;">Cerrar sesión<i class="fa fa-arrow-right ms-3"></i></a>';
                }else {
                    //Boton registrate ahora solo si NO está logueado
                    echo '<a href="registro.php" class="btn py-4 px-lg-5 d-none d-lg-block text-white" style="background-color: #43be16;">Registrate Ahora<i class="fa fa-arrow-right ms-3"></i></a>';  
                }
                ?>    
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Cartilla Virtual: Portada y páginas siguientes con mismo estilo -->
    <?php if ($cartilla[$pagina]['tipo'] === 'portada'): ?>
    <div class="container-fluid bg-primary py-5 mb-5 page-header header-aprende" style="position: relative;">
        <div class="container pt-0 py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown mb-2" style="margin-top: -20px;"><?php echo $cartilla[$pagina]['titulo']; ?></h1>  
                    <h2 class="text-white mb-4" style="margin-top: 40px;"><?php echo $cartilla[$pagina]['subtitulo']; ?></h2>                                      
                    <nav aria-label="breadcrumb" class="position-relative">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="index.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="trueques.php">Trueques</a></li>
                        </ol>
                        <a href="aprende.php?pagina=1" class="btn btn-lg text-white position-absolute end-0 top-50 translate-middle-y" style="background-color: #43be16; z-index: 2;">
                            Siguiente <i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    </nav>
                    <div class="header-aprende-botton d-flex justify-content-end align-items-end mt-5" style="min-height: 120px;">
                        <h3 class="text-white mb-4 header-aprende-h3" style="margin-right: 60px;"><?php echo $cartilla[$pagina]['frase']; ?></h3>                    
                        <img src="<?php echo $cartilla[$pagina]['logo']; ?>" alt="Logo SENA" class="logo-sena-header" style="height: 150px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="container-fluid bg-primary py-5 mb-5 page-header header-aprende" style="position: relative;">
        <div class="container pt-0 py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-5 text-white animated slideInDown mb-2"><?php echo $cartilla[$pagina]['titulo']; ?></h1>
                    <?php if (!empty($cartilla[$pagina]['subtitulo'])): ?>
                        <h2 class="text-white mb-4" style="margin-top: 40px;"><?php echo $cartilla[$pagina]['subtitulo']; ?></h2>
                    <?php endif; ?>
                    <?php if (isset($cartilla[$pagina]['imagen'])): ?>
                        <img src="<?php echo $cartilla[$pagina]['imagen']; ?>" class="img-fluid mb-4 rounded" alt="Imagen de la sección" style="max-height: 300px;">
                    <?php endif; ?>
                    <?php if (isset($cartilla[$pagina]['texto'])): ?>
                        <div class="mb-3 text-white fs-5 text-start d-inline-block" style="max-width: 700px;"><?php echo $cartilla[$pagina]['texto']; ?></div>
                    <?php endif; ?>
                    <?php if (isset($cartilla[$pagina]['logo'])): ?>
                        <div class="mt-3">
                            <img src="<?php echo $cartilla[$pagina]['logo']; ?>" style="height: 60px;" alt="Logo SENA">
                        </div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <a href="aprende.php?pagina=<?php echo $pagina-1; ?>" class="btn btn-lg text-white" style="background-color: #43be16;">
                            <i class="fa fa-arrow-left me-2"></i> Anterior
                        </a>
                        <?php if ($pagina < $total_paginas-1): ?>
                            <a href="aprende.php?pagina=<?php echo $pagina+1; ?>" class="btn btn-lg text-white" style="background-color: #43be16;">
                                Siguiente <i class="fa fa-arrow-right ms-2"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="mt-2 text-white-50">Página <?php echo $pagina+1; ?> de <?php echo $total_paginas; ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <!-- Fin Cartilla Virtual -->

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

    <script>
    document.getElementById('btn-siguiente-header').onclick = function() {
        window.location.href = "categorias.php";
    };
    </script>
</body>
</html>