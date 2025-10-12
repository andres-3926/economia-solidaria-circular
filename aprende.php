<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pagina_activa = 'aprende';
session_start();
include("conexion.php");

if (!isset($_SESSION['numero_documento'])) {
    header('Location: login.php');
    exit;
}

    // Array de páginas de la cartilla, incluyendo la portada como página 0
    $cartilla = [
        [
            "tipo" => "portada",
            "titulo" => 'Reciclando Juntas Produciendo Futuro',
            "subtitulo" => 'Economía Solidaria y Circular para Unidades Productivas de Cali.',
            "frase" => 'El SENA te acompaña en la construcción de un futuro más próspero y sostenible.',
            "logo" => "img/Logo-sena-blanco-sin-fondo.webp",
            "fondo" => "img/reciclando.png" 
        ],
        [
            "tipo" => "contenido",
            "titulo" => "¡Hola, Emprendedora!",
            "texto" => "Sabemos que tu esfuerzo diario construye futuro. Esta guía está diseñada para acompañarte en un viaje donde cada residuo se convierte en una nueva oportunidad para tu negocio y tu comunidad. ¡Juntas vamos a transformar Cali!",
            "fondo" => "img/artesana-1.jpg",
        ],
        [
            "tipo" => "contenido",
            "titulo" => "¿Por Qué Esta Guía Es Para Ti?",
            "texto" => "<ul>
                <li><b><span style=\"color: #007bff;\">Reduce Costos:</span></b> Menos gastos en materiales nuevos, menos dinero en basura.</li>
                <li><b><span style=\"color: #007bff;\">Genera Ingresos Extra:</span></b> Transforma residuos en productos o vendiendo reciclables.</li>
                <li><b><span style=\"color: #007bff;\">Mejora tu Entorno:</span></b> Contribuye a una comunidad más limpia y sana.</li>
                <li><b><span style=\"color: #007bff;\">Fortalece Tu Comunidad:</span></b> Trabaja en equipo y conecta con otras emprendedoras.</li>
            </ul>",
            "fondo" => "img/guia_economia_circular.webp",
            "logo" => "img/Logo-sena-blanco-sin-fondo.webp"
        ],
        [
            "tipo" => "contenido",
            "titulo" => "¡Nuestro Entorno y Nuestras Riquezas",            
            "texto" => "El dinamismo económico de Cali se sostiene en microeconomías barriales, con la mujer como pilar fundamental en la <b>gastronomía popular</b> y <b>artesanías</b>, preservando la cultura y el sustento familiar. Para asegurar la sostenibilidad, es vital adoptar la <b>economía circular</b>; el <b>reciclaje</b> es el motor de este cambio, pues genera empleo formal y reduce la extracción de recursos, ofreciendo grandes <b>beneficios socioeconómicos y ambientales</b> a toda la comunidad.",
            "fondo" => "img/pagina-4.jpg",
        ],
        [
            "tipo" => "contenido",
            "titulo" => "¿Qué Son los Residuos y Por Qué Nos Importan?",
            "texto" => "El <b>residuo</b> es material desechado que aún puede ser <b>reciclado o reutilizado</b>. Su gestión es vital porque <b>evita la contaminación</b>, conserva los <b>recursos naturales</b> y es la base de la <b>Economía Circular</b>, asegurando un futuro más sostenible.",
            "texto2" => "La mala gestión de <b>residuos</b> genera rápidamente <b>malos olores</b> y <b>plagas</b>, comprometiendo la <b>salud pública</b>. Además, contamina gravemente el <b>agua</b>, el <b>suelo</b> y el <b>aire</b>, empeorando el impacto ambiental.",
            "fondo" => "img/residuos.jpg",
        ],
    ];

    // Página actual (por defecto 0 = portada)
    $pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 0;
    $total_paginas = count($cartilla);

    $iconos = [
        '💰', // Icono para Reduce Costos / Ahorro
        '📈', // Icono para Genera Ingresos Extra / Crecimiento
        '🌍', // Icono para Mejora tu Entorno / Planeta/Comunidad
        '🤝'  // Icono para Fortalece Tu Comunidad / Trabajo en equipo
    ];

    // 1. Convertir el texto de la lista a un array de puntos
    // Esto nos permite iterar sobre los puntos e inyectar el ícono.
    // Solo procesamos si el campo 'texto' existe para evitar errores en páginas sin texto (como algunas portadas)
    if (isset($cartilla[$pagina]['texto']) && strpos($cartilla[$pagina]['texto'], '<li>') !== false) {
        preg_match_all('/<li>(.*?)<\/li>/s', $cartilla[$pagina]['texto'], $matches);
        $puntos_de_beneficio = $matches[1];

        $texto_con_iconos = '<ul class="list-unstyled mx-auto" style="max-width: 700px; padding: 0 1rem;">';

        // 2. Iterar e inyectar el ícono correspondiente a cada punto
        foreach ($puntos_de_beneficio as $index => $punto) {
            // Usamos d-flex para alinear el ícono y el texto, y mb-4 para dar buen espacio vertical
            // Verificamos si hay un ícono disponible para evitar un error de índice
            $icono = $iconos[$index] ?? ''; 
            $texto_con_iconos .= '
                <li class="d-flex align-items-start mb-1">
                    <span class="me-1 flex-shrink-0" style= "font-size: 2rem;">' . $icono . '</span>
                    <div>' . $punto . '</div>
                </li>
            ';
        }

        $texto_con_iconos .= '</ul>';
    } else {
        // Si no es una lista, usamos el texto plano directamente, si existe.
        $texto_con_iconos = $cartilla[$pagina]['texto'] ?? '';
    }

    // Valor por defecto
    $height_bloque = '75vh';

    // Personaliza por página (ejemplo: página 4 más arriba, página 2 más abajo)
    if ($pagina == 2) { // Página 2 (contenido 1)
        $height_bloque = '75vh';
    }
    if ($pagina == 3) { // Página 3 (contenido 2)
        $height_bloque = '60vh';
    }
    if ($pagina == 4) { // Página 4 (contenido 3)
        $height_bloque = '60vh';
    }
    if ($pagina == 5) { // Página 5 (contenido 4)
        $height_bloque = '40vh';
    }

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
        <a href="index.php" class="navbar-brand d-flex align-items-center px-2 px-lg-5">
        <h2 class="m-0 text-shadow titulo-navbar text-break" style="color: #43be16;"><i class="fa-solid fa-recycle fa-beat fa-xl me-2"></i>Economía Solidaria y Circular</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ms-auto p-4 p-lg-0">
                <li class="nav-item">
                    <a href="index.php" class="nav-link<?php echo $pagina_activa === 'inicio' ? ' active text-primary' : ' text-dark'; ?>">Inicio</a>
                </li>
                <li class="nav-item">
                    <a href="trueques.php#trueques" class="nav-link<?php echo $pagina_activa === 'trueques' ? ' active text-primary' : ' text-dark'; ?>">Trueques</a>
                </li>  
                <li class="nav-item">
                    <a href="aprende.php" class="nav-link<?php echo $pagina_activa === 'aprende' ? ' active text-primary' : ' text-dark'; ?>">Aprende</a>
                </li>            
                <?php
                if(isset($_SESSION['numero_documento'])) {
                    $clase_perfil = $pagina_activa === 'perfil' ? ' active text-primary' : ' text-dark';
                    echo '<li class="nav-item"><a href="perfil.php" class="nav-link' . $clase_perfil . '">Perfil</a></li>';
                }
                ?>
                <?php
                if (isset($_SESSION['numero_documento'])) {
                    // Escritorio
                    echo '<li class="nav-item d-none d-lg-block">
                        <a href="logout.php" class="btn btn-success cerrar-sesion-btn mx-auto px-4 py-2" style="background-color: #43be16; min-width: 150px;">
                            Cerrar sesión <i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    </li>';
                    // Móvil
                    echo '<li class="nav-item d-block d-lg-none">
                        <a href="logout.php" class="btn btn-success cerrar-sesion-btn mx-auto my-4 px-4 py-2" style="background-color: #43be16; min-width: 150px;">
                            Cerrar sesión <i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    </li>';
                } else {
                    // Escritorio
                    echo '<li class="nav-item d-none d-lg-block">
                        <a href="registro.php" class="btn btn-success cerrar-sesion-btn mx-auto px-4 py-2" style="background-color: #43be16; min-width: 150px;">
                            Registrate Ahora <i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    </li>';
                    // Móvil
                    echo '<li class="nav-item d-block d-lg-none">
                        <a href="registro.php" class="btn btn-success cerrar-sesion-btn mx-auto my-4 px-4 py-2" style="background-color: #43be16; min-width: 150px;">
                            Registrate Ahora <i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    </li>';
                }
                ?>
            </ul>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Cartilla Virtual: Portada y páginas siguientes con mismo estilo -->
    <?php if ($cartilla[$pagina]['tipo'] === 'portada'): ?>
    <div class="container-fluid header-aprende"
        style="position: relative; background-image: url('<?php echo $cartilla[$pagina]['fondo']; ?>'); background-size: cover; background-position: center;">
        <div class="container-fluid pt-0 m-0 contenido-header" style="background: transparent;">
            <div class="row g-0 justify-content-center mt-4">    
                <div class="col-12 col-lg-10 mx-auto px-0">
                    <h1 class="display-3 text-white animated slideInDown mb-5 mt-4 text-center">
                        <?php echo $cartilla[$pagina]['titulo']; ?>
                    </h1>
                    <h2 class="text-white mb-5 mt-4 text-center">
                        <?php echo $cartilla[$pagina]['subtitulo']; ?>
                    </h2>                    
                    <div class="text-end boton-siguiente-margen" style="padding-right: 1rem;">
                        <a href="aprende.php?pagina=1" class="btn btn-lg text-white" style="background-color: #43be16;">
                            Siguiente <i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-aprende-botton d-flex justify-content-end align-items-end mt-5" style="min-height: 120px;">
            <h3 class="text-white mb-4 header-aprende-h3" style="margin-left: 40px; margin-bottom: 0;"><?php echo $cartilla[$pagina]['frase']; ?></h3>                    
            <img src="<?php echo $cartilla[$pagina]['logo']; ?>" alt="Logo SENA" class="logo-sena-header" style="height: 150px; margin-right: 40px;">            
        </div>
    </div>
    <?php else: ?>
    <div class="container-fluid header-aprende"
        style="position: relative;
            background-image: url('<?php echo $cartilla[$pagina]['fondo']; ?>');
            background-size: cover;
            background-position: center;
            min-height: 100vh;">
            
        <div class="container-fluid h-100 p-0">
            <div class="row g-0 justify-content-center" style="height: 100vh;">
                <!-- Título arriba, columna independiente -->
                <div class="col-12 col-lg-10 mx-auto px-4 pt-4">
                    <h1 class="display-3 text-white animated slideInDown mb-3 text-center text-shadow-custom">
                        <?php echo $cartilla[$pagina]['titulo']; ?>
                    </h1>
                </div>
                <!-- Texto largo y botones abajo, columna independiente -->
                <div class="col-12 col-lg-8 mx-auto px-4 d-flex flex-column justify-content-end" style="height: <?php echo $height_bloque; ?>;"> 
                    <?php if (isset($cartilla[$pagina]['texto'])): ?>
                        <div class="text-white fs-5 text-start text-shadow-custom mb-2" style="max-width: 700px;">
                            <?php echo $texto_con_iconos; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($cartilla[$pagina]['texto2'])): ?>
                        <div class="text-white fs-5 text-start text-shadow-custom mb-2" style="max-width: 700px;">
                            <?php echo $cartilla[$pagina]['texto2']; ?>
                        </div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-between align-items-end mt-3">
                        <a href="aprende.php?pagina=<?php echo $pagina-1; ?>" class="btn btn-lg text-white" style="background-color: #43be16; z-index: 10;">
                            <i class="fa fa-arrow-left me-2"></i> Anterior
                        </a>
                        <div class="text-white-50 text-center text-shadow-custom fs-6" style="flex-grow: 1;">
                            Página <?php echo $pagina+1; ?> de <?php echo $total_paginas; ?>
                        </div>
                        <div class="d-flex align-items-end">
                            <?php if (isset($cartilla[$pagina]['logo'])): ?>
                                <img src="<?php echo $cartilla[$pagina]['logo']; ?>"
                                    style="height: 80px; margin-right: 15px; z-index: 10;"
                                    alt="Logo SENA"
                                    class="logo-sena-header d-none d-md-block">
                            <?php endif; ?>
                            <?php if ($pagina < $total_paginas-1): ?>
                                <a href="aprende.php?pagina=<?php echo $pagina+1; ?>" class="btn btn-lg text-white" style="background-color: #43be16; z-index: 10;">
                                    Siguiente <i class="fa fa-arrow-right ms-2"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
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