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
            "titulo" => "¡Nuestro Entorno y Nuestras Riquezas!",            
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
        [
            "tipo" => "contenido_con_actividad", // NUEVO TIPO para mostrar contenido + botón de actividad
            "titulo" => "¡Los Residuos son Oportunidades!",
            "texto" => "¡De la <span style='color: #FFD700;'>cáscara de plátano</span> al <span style='color: #32CD32;'>abono para tus plantas</span>, del <span style='color: #FF6B6B;'>retazo</span> a una <span style='color: #4ECDC4;'>nueva creación</span>!",
            "actividad_titulo" => "Actividad del Tema 2: ¿Qué Residuo Ves Tú?",
            "actividad_descripcion" => "Observa tu espacio de trabajo (o tu casa). Nombra <b>3 tipos de residuos</b> que generas con frecuencia y piensa en una forma diferente de verlos (¿podría ser un recurso?).",
            "fondo" => "img/transformacion-residuos.jpg",
        ],
        [
            "tipo" => "actividad", // Página de actividad interactiva            
            "texto" => "Introduce la idea de que lo que antes se botaba, ahora es un <b>recurso valioso</b>. ¡De la <span style='color: #FFD700;'>cáscara de plátano</span> al <span style='color: #32CD32;'>abono para tus plantas</span>, del <span style='color: #FF6B6B;'>retazo</span> a una <span style='color: #4ECDC4;'>nueva creación</span>!",
            "actividad_titulo" => "Reto del Tema 2: ¿Qué Residuo Ves Tú?",
            "actividad_instruccion" => "Observa tu espacio de trabajo (o tu casa). Nombra <b>3 tipos de residuos</b> que generas con frecuencia y piensa en una forma diferente de verlos (¿podría ser un recurso?).",
            "fondo" => "img/transformacion-residuos.jpg",
        ],
        [
            "tipo" => "contenido",
            "titulo" => "¿Qué Son los Residuos y Por Qué Nos Importan?",
            "texto" => "El <b>residuo</b> es material desechado que aún puede ser <b>reciclado o reutilizado</b>. Su gestión es vital porque <b>evita la contaminación</b>, conserva los <b>recursos naturales</b> y es la base de la <b>Economía Circular</b>, asegurando un futuro más sostenible.",
            "texto2" => "La mala gestión de <b>residuos</b> genera rápidamente <b>malos olores</b> y <b>plagas</b>, comprometiendo la <b>salud pública</b>. Además, contamina gravemente el <b>agua</b>, el <b>suelo</b> y el <b>aire</b>, empeorando el impacto ambiental.",
            "fondo" => "img/residuos.jpg",
        ],
        [
            "tipo" => "contenido",
            "titulo" => "¿Qué Son los Residuos y Por Qué Nos Importan?",
            "texto" => "El <b>residuo</b> es material desechado que aún puede ser <b>reciclado o reutilizado</b>. Su gestión es vital porque <b>evita la contaminación</b>, conserva los <b>recursos naturales</b> y es la base de la <b>Economía Circular</b>, asegurando un futuro más sostenible.",
            "texto2" => "La mala gestión de <b>residuos</b> genera rápidamente <b>malos olores</b> y <b>plagas</b>, comprometiendo la <b>salud pública</b>. Además, contamina gravemente el <b>agua</b>, el <b>suelo</b> y el <b>aire</b>, empeorando el impacto ambiental.",
            "fondo" => "img/residuos.jpg",
        ]
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
        $height_bloque = '78vh';
    }
    if ($pagina == 3) { // Página 3 (contenido 2) 
        $height_bloque = '66vh'; 
    }
    if ($pagina == 4) { // Página 4 (contenido 3) 
        $height_bloque = '66vh'; 
    }
    if ($pagina == 5) { // Página 5 (contenido 4) 
        $height_bloque = '78vh'; 
    }
    if ($pagina == 6) { // Página 5 (contenido 5)
        $height_bloque = '40vh';
    }

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Aprende - Economía Solidaria y Circular</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="economía circular, reciclaje, emprendimiento, Cali" name="keywords">
    <meta content="Cartilla virtual de economía solidaria y circular para emprendedoras de Cali" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

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

    <style>
        /* Estilos para el cuadro semitransparente con fondo azul claro - MÁS TRANSPARENTE */
        .cuadro-texto {
            background: rgba(173, 216, 230, 0.35) !important; /* MUCHO más transparente: 35% */
            backdrop-filter: blur(3px); /* Menos blur para ver más la imagen */
            -webkit-backdrop-filter: blur(3px);
            border-radius: 20px;
            padding: 2rem;
            margin: 1rem 0;
            box-shadow: 
                0 10px 25px rgba(0, 0, 0, 0.15),
                0 3px 10px rgba(173, 216, 230, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.4);
            max-width: 800px;
            color: #000033; /* Color mucho más oscuro - azul marino profundo */
            position: relative;
        }

        /* Eliminar el pseudo-elemento que podría estar causando opacidad */
        .cuadro-texto::before {
            display: none;
        }

        .cuadro-texto h3 {
            color: #001122; /* Azul muy oscuro, casi negro */
            margin-bottom: 1rem;
            font-weight: 900; /* MÁS GRUESO - peso máximo */
            text-shadow: 
                3px 3px 6px rgba(255,255,255,1), /* Sombra blanca fuerte */
                1px 1px 3px rgba(255,255,255,0.9),
                -1px -1px 2px rgba(255,255,255,0.8); /* Sombra en múltiples direcciones */
        }

        .cuadro-texto .texto-contenido {
            font-size: 1.1rem;
            line-height: 1.7;
            color: #000022; /* Azul oscuro casi negro para máximo contraste */
            font-weight: 700; /* MÁS GRUESO - de 500 a 700 */
            text-shadow: 
                2px 2px 4px rgba(255,255,255,1), /* Sombra blanca sólida */
                1px 1px 3px rgba(255,255,255,0.95),
                -1px -1px 2px rgba(255,255,255,0.9),
                0px 0px 5px rgba(255,255,255,0.7); /* Resplandor blanco */
        }

        .cuadro-texto .texto-contenido b {
            color: #000011; /* Negro azulado para texto en negrita */
            font-weight: 900; /* MÁS GRUESO - peso máximo */
            text-shadow: 
                3px 3px 6px rgba(255,255,255,1),
                1px 1px 3px rgba(255,255,255,0.95),
                -1px -1px 2px rgba(255,255,255,0.9),
                0px 0px 6px rgba(255,255,255,0.8);
        }

        .cuadro-texto .texto-contenido span[style*="color"] {
            font-weight: 900; /* MÁS GRUESO - peso máximo */
            text-shadow: 
                3px 3px 7px rgba(255,255,255,1),
                1px 1px 4px rgba(255,255,255,0.95),
                -1px -1px 3px rgba(255,255,255,0.9),
                0px 0px 8px rgba(255,255,255,0.8);
        }

        /* Ajustes para los iconos en listas */
        .cuadro-texto .list-unstyled li {
            margin-bottom: 1.2rem;
            transition: all 0.3s ease;
            padding: 0.3rem;
            border-radius: 8px;
            color: #000022; /* Color oscuro para lista */
            font-weight: 700; /* MÁS GRUESO - de 500 a 700 */
        }

        .cuadro-texto .list-unstyled li div {
            color: #000022 !important; /* Forzar color oscuro en el contenido de la lista */
            font-weight: 700 !important; /* MÁS GRUESO - forzar peso */
            text-shadow: 
                2px 2px 4px rgba(255,255,255,1),
                1px 1px 3px rgba(255,255,255,0.95),
                0px 0px 5px rgba(255,255,255,0.7);
        }

        .cuadro-texto .list-unstyled li:hover {
            transform: translateX(8px);
            background: rgba(135, 206, 250, 0.3);
            border-radius: 12px;
            padding: 0.8rem;
            margin-left: -0.5rem;
        }

        .cuadro-texto .list-unstyled .me-1 {
            margin-top: 0.2rem;
            filter: drop-shadow(3px 3px 6px rgba(255,255,255,0.9));
        }

        /* Efecto hover para todo el cuadro */
        .cuadro-texto:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
            background: rgba(173, 216, 230, 0.45) !important; /* Solo un poco más opaco en hover */
            box-shadow: 
                0 15px 30px rgba(0, 0, 0, 0.2),
                0 5px 15px rgba(173, 216, 230, 0.3);
        }

        /* Cuadro especial para actividades - azul más intenso pero MUY transparente */
        .cuadro-actividad {
            background: rgba(135, 206, 250, 0.4) !important; /* Más transparente: 40% */
            border: 2px solid rgba(70, 130, 180, 0.6);
        }

        .cuadro-actividad:hover {
            background: rgba(135, 206, 250, 0.5) !important; /* Solo 50% en hover */
            border-color: rgba(70, 130, 180, 0.8);
        }

        .cuadro-actividad h3 {
            color: #001122; /* Color muy oscuro para actividades */
            font-weight: 900; /* MÁS GRUESO */
        }

        .cuadro-actividad .texto-contenido {
            color: #000022; /* Color muy oscuro para texto de actividades */
            font-weight: 700; /* MÁS GRUESO */
        }

        /* Mejorar contraste en formularios */
        .cuadro-actividad label {
            color: #001122 !important;
            font-weight: 800; /* MÁS GRUESO - de 700 a 800 */
            text-shadow: 
                2px 2px 4px rgba(255,255,255,1),
                1px 1px 3px rgba(255,255,255,0.9);
        }

        .cuadro-actividad .text-muted {
            color: #000044 !important; /* Menos "muted", más oscuro */
            font-weight: 600; /* MÁS GRUESO - de 500 a 600 */
            text-shadow: 1px 1px 3px rgba(255,255,255,0.9);
        }

        /* Responsivo - manteniendo ALTA transparencia pero mejor contraste y MÁS GRUESO */
        @media (max-width: 768px) {
            .cuadro-texto {
                padding: 1.5rem;
                margin: 0.5rem;
                border-radius: 15px;
                background: rgba(173, 216, 230, 0.45) !important; /* Un poco más opaco en móvil */
            }
            
            .cuadro-texto .texto-contenido {
                font-size: 1rem;
                line-height: 1.6;
                font-weight: 800; /* MÁS GRUESO - de 600 a 800 en móvil */
                text-shadow: 
                    3px 3px 6px rgba(255,255,255,1),
                    1px 1px 4px rgba(255,255,255,0.95),
                    0px 0px 6px rgba(255,255,255,0.8);
            }
            
            .cuadro-texto h3 {
                font-weight: 900; /* Mantener peso máximo */
                text-shadow: 
                    4px 4px 8px rgba(255,255,255,1),
                    2px 2px 5px rgba(255,255,255,0.9);
            }
        }

        @media (max-width: 480px) {
            .cuadro-texto {
                padding: 1.2rem;
                margin: 0.3rem;
                background: rgba(173, 216, 230, 0.55) !important;
            }
            
            .cuadro-actividad {
                background: rgba(135, 206, 250, 0.55) !important;
            }
            
            .cuadro-texto .texto-contenido {
                font-weight: 900;
                text-shadow: 
                    4px 4px 8px rgba(255,255,255,1),
                    2px 2px 6px rgba(255,255,255,0.95),
                    0px 0px 8px rgba(255,255,255,0.8);
            }
        }

        /* AGREGAR AQUÍ LOS NUEVOS ESTILOS PARA ACTIVIDADES */
        
        /* OPTIMIZACIONES ESPECÍFICAS PARA ACTIVIDADES */
        .cuadro-actividad .form-control {
            border: 2px solid rgba(70, 130, 180, 0.3);
            background: rgba(255, 255, 255, 0.95);
            transition: all 0.3s ease;
        }

        .cuadro-actividad .form-control:focus {
            border-color: #43be16;
            box-shadow: 0 0 10px rgba(67, 190, 22, 0.3);
            background: rgba(255, 255, 255, 1);
        }

        .cuadro-actividad textarea.form-control {
            resize: vertical;
            min-height: 65px;
        }

        /* Responsivo mejorado para actividades */
        @media (max-width: 992px) {
            .cuadro-actividad {
                padding: 1.5rem !important;
                margin: 0.3rem 0 !important;
            }
            
            .cuadro-actividad h3 {
                font-size: 1.2rem !important;
            }
            
            .cuadro-actividad .texto-contenido {
                font-size: 0.95rem !important;
            }
            
            .cuadro-actividad .form-control {
                font-size: 0.85rem !important;
            }
            
            .cuadro-actividad label {
                font-size: 0.9rem !important;
            }
            
            .cuadro-actividad small {
                font-size: 0.8rem !important;
            }
        }

        @media (max-width: 768px) {
            .cuadro-actividad {
                padding: 1.2rem !important;
                margin: 0.2rem 0 !important;
            }
            
            .cuadro-actividad .row.g-3 {
                gap: 1rem;
            }
            
            .cuadro-actividad h3 {
                font-size: 1.1rem !important;
                margin-bottom: 0.8rem !important;
            }
            
            .cuadro-actividad .btn-lg {
                font-size: 1rem !important;
                padding: 0.6rem 1.5rem !important;
            }
        }

        @media (max-width: 576px) {
            .cuadro-actividad {
                padding: 1rem !important;
                margin: 0.1rem 0 !important;
            }
            
            .cuadro-actividad textarea {
                min-height: 55px !important;
            }
            
            /* Navegación más compacta en móvil */
            .btn-lg {
                font-size: 0.9rem !important;
                padding: 0.5rem 1rem !important;
                min-width: 100px !important;
            }
        }
    </style>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Cargando...</span>
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
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link fw-bold<?php echo $pagina_activa === 'inicio' ? ' active text-primary' : ' text-dark'; ?>">Inicio</a>
                <a href="trueques.php#trueques" class="nav-item nav-link fw-bold<?php echo $pagina_activa === 'trueques' ? ' active text-primary' : ' text-dark'; ?>">Trueques</a>
                <a href="aprende.php" class="nav-item nav-link fw-bold<?php echo $pagina_activa === 'aprende' ? ' active text-primary' : ' text-dark'; ?>">Aprende</a>
                <?php
                if (isset($_SESSION['numero_documento'])) {
                    echo '<a href="perfil.php" class="nav-item nav-link fw-bold'.($pagina_activa === 'perfil' ? ' active text-primary' : ' text-dark').'">Perfil</a>';
                    // Botón de cerrar sesión escritorio
                    echo '<a href="logout.php" class="btn py-4 px-lg-5 d-none d-lg-block text-white" style="background-color: #43be16;">Cerrar sesión<i class="fa fa-arrow-right ms-3"></i></a>';
                    // Botón de cerrar sesión móvil (hamburguesa)
                    echo '<a href="logout.php" class="btn btn-success d-block d-lg-none my-3 w-100 text-white text-center justify-content-center align-items-center d-flex" style="background-color: #43be16;">'
                        .'<span class="mx-auto">Cerrar sesión</span>'
                        .'<i class="fa fa-arrow-right ms-2"></i>'
                    .'</a>';
                } else {
                    // Botón registrate ahora solo si NO está logueado
                    echo '<a href="registro.php" class="btn py-4 px-lg-5 d-none d-lg-block text-white" style="background-color: #43be16;">Regístrate Ahora<i class="fa fa-arrow-right ms-3"></i></a>';
                }
                ?>
            </div>
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

    <?php elseif ($cartilla[$pagina]['tipo'] === 'actividad'): ?>
    <!-- Template OPTIMIZADO para Páginas de Actividad -->
    <div class="container-fluid header-aprende"
        style="position: relative;
            background-image: url('<?php echo $cartilla[$pagina]['fondo']; ?>');
            background-size: cover;
            background-position: center;
            min-height: 100vh;">
            
        <div class="container-fluid h-100 p-0">
            <div class="row g-0 justify-content-center" style="min-height: 100vh;">
                <!-- Contenido de actividad OPTIMIZADO para mejor distribución -->
                <div class="col-12 col-lg-10 mx-auto px-3 py-4 d-flex flex-column"> 
                    <!-- Cuadro de texto principal - MÁS COMPACTO -->
                    <?php if (isset($cartilla[$pagina]['texto'])): ?>
                        <div class="cuadro-texto mx-auto mb-3" style="max-width: 900px; padding: 1.5rem; margin: 0.5rem 0;">
                            <div class="texto-contenido text-center" style="font-size: 1rem; line-height: 1.5;">
                                <?php echo $cartilla[$pagina]['texto']; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Sección de Actividad PRINCIPAL - OPTIMIZADA -->
                    <div class="cuadro-texto cuadro-actividad mx-auto flex-grow-1" style="max-width: 950px; padding: 1.8rem;">
                        <h3 class="text-center mb-3" style="font-size: 1.4rem;">
                            <i class="fas fa-tasks me-2"></i>
                            <?php echo $cartilla[$pagina]['actividad_titulo']; ?>
                        </h3>
                        <p class="texto-contenido mb-4 text-center" style="font-size: 1rem; line-height: 1.5;">
                            <?php echo $cartilla[$pagina]['actividad_instruccion']; ?>
                        </p>
                        
                        <!-- Formulario de Actividad OPTIMIZADO -->
                        <form id="actividadForm" class="mt-3">
                            <div class="row g-3">
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label class="form-label fw-bold" style="color: #003d82; font-size: 0.95rem;">Residuo 1:</label>
                                    <input type="text" class="form-control" name="residuo1" placeholder="Ej: Cáscara de plátano" style="font-size: 0.9rem;">
                                    <small class="text-muted" style="font-size: 0.85rem;">¿Cómo podrías reutilizarlo?</small>
                                    <textarea class="form-control mt-1" name="uso1" rows="2" placeholder="Ej: Como abono para plantas" style="font-size: 0.9rem;"></textarea>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label class="form-label fw-bold" style="color: #003d82; font-size: 0.95rem;">Residuo 2:</label>
                                    <input type="text" class="form-control" name="residuo2" placeholder="Ej: Retazos de tela" style="font-size: 0.9rem;">
                                    <small class="text-muted" style="font-size: 0.85rem;">¿Cómo podrías reutilizarlo?</small>
                                    <textarea class="form-control mt-1" name="uso2" rows="2" placeholder="Ej: Para hacer bolsas reutilizables" style="font-size: 0.9rem;"></textarea>
                                </div>
                                <div class="col-lg-4 col-md-12 mb-3">
                                    <label class="form-label fw-bold" style="color: #003d82; font-size: 0.95rem;">Residuo 3:</label>
                                    <input type="text" class="form-control" name="residuo3" placeholder="Ej: Botellas plásticas" style="font-size: 0.9rem;">
                                    <small class="text-muted" style="font-size: 0.85rem;">¿Cómo podrías reutilizarlo?</small>
                                    <textarea class="form-control mt-1" name="uso3" rows="2" placeholder="Ej: Como macetas para plantas" style="font-size: 0.9rem;"></textarea>
                                </div>
                            </div>
                            <div class="text-center mt-4 mb-3">
                                <button type="button" class="btn btn-primary btn-lg px-4 py-2" onclick="guardarActividad()" style="background-color: #003d82; border-color: #003d82; font-size: 1.1rem;">
                                    <i class="fas fa-check-circle me-2"></i>
                                    ¡Completar Actividad!
                                </button>
                            </div>
                        </form>
                        
                        <!-- Mensaje de éxito COMPACTO -->
                        <div id="mensajeExito" class="alert alert-info text-center mt-3 mb-2" style="display: none; background-color: rgba(135, 206, 250, 0.8); border-color: #003d82; color: #001a4d; padding: 0.8rem; font-size: 0.95rem;">
                            <i class="fas fa-trophy me-2"></i>
                            ¡Excelente! Has completado la actividad. Cada residuo es una nueva oportunidad.
                        </div>
                    </div>
                    
                    <!-- Navegación SIMPLIFICADA - Solo botón Anterior -->
                    <div class="d-flex justify-content-start mt-3 px-2" style="flex-shrink: 0;">
                        <a href="aprende.php?pagina=<?php echo $pagina-1; ?>" class="btn btn-lg text-white shadow-sm" style="background-color: #43be16; z-index: 10; min-width: 120px;">
                            <i class="fa fa-arrow-left me-2"></i> Anterior
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php elseif ($cartilla[$pagina]['tipo'] === 'contenido_con_actividad'): ?>
    <!-- Template para Páginas de Contenido con Botón de Actividad -->
    <div class="container-fluid header-aprende"
        style="position: relative;
            background-image: url('<?php echo $cartilla[$pagina]['fondo']; ?>');
            background-size: cover;
            background-position: center;
            min-height: 100vh;">
            
        <div class="container-fluid h-100 p-0">
            <div class="row g-0 justify-content-center" style="height: 100vh;">
                <!-- Título arriba -->
                <div class="col-12 col-lg-10 mx-auto px-4 pt-4">
                    <h1 class="display-3 text-white animated slideInDown mb-3 text-center text-shadow-custom">
                        <?php echo $cartilla[$pagina]['titulo']; ?>
                    </h1>
                </div>
                <!-- Contenido y botón de actividad -->
                <div class="col-12 col-lg-8 mx-auto px-4 d-flex flex-column justify-content-end" style="height: <?php echo $height_bloque; ?>;"> 
                    <!-- Cuadro de texto principal -->
                    <?php if (isset($cartilla[$pagina]['texto'])): ?>
                        <div class="cuadro-texto mx-auto">
                            <div class="texto-contenido text-center">
                                <?php echo $cartilla[$pagina]['texto']; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Cuadro con información de la actividad -->
                    <div class="cuadro-texto cuadro-actividad mx-auto">
                        <h3 class="text-center mb-3">
                            <i class="fas fa-lightbulb me-2"></i>
                            <?php echo $cartilla[$pagina]['actividad_titulo']; ?>
                        </h3>
                        <p class="texto-contenido mb-4 text-center">
                            <?php echo $cartilla[$pagina]['actividad_descripcion']; ?>
                        </p>
                        
                        <!-- Botón para ir a la actividad interactiva -->
                        <div class="text-center">
                            <a href="aprende.php?pagina=<?php echo $pagina+1; ?>" class="btn btn-primary btn-lg px-5 py-3" style="background-color: #43be16; border-color: #43be16; font-weight: 700; font-size: 1.2rem;">
                                <i class="fas fa-play-circle me-2"></i>
                                ¡Realizar Actividad Interactiva!
                            </a>
                        </div>
                        
                        <div class="text-center mt-3">
                            <small class="text-white" style="background: rgba(0,0,0,0.3); padding: 0.5rem 1rem; border-radius: 15px; font-weight: 600;">
                                <i class="fas fa-clock me-1"></i>
                                Tiempo estimado: 5-10 minutos
                            </small>
                        </div>
                    </div>
                    
                    <!-- Navegación -->
                    <div class="d-flex justify-content-between align-items-end mt-3">
                        <a href="aprende.php?pagina=<?php echo $pagina-1; ?>" class="btn btn-lg text-white" style="background-color: #43be16; z-index: 10;">
                            <i class="fa fa-arrow-left me-2"></i> Anterior
                        </a>
                        <div class="text-white-50 text-center text-shadow-custom fs-6" style="flex-grow: 1;">
                            Página <?php echo $pagina+1; ?> de <?php echo $total_paginas; ?>
                        </div>
                        <div class="d-flex align-items-end">
                            <a href="aprende.php?pagina=<?php echo $pagina+2; ?>" class="btn btn-lg text-white" style="background-color: #43be16; z-index: 10;">
                                Siguiente <i class="fa fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php else: ?>
    <!-- Template para Páginas de Contenido -->
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
                    <!-- Cuadro de texto principal -->
                    <?php if (isset($cartilla[$pagina]['texto'])): ?>
                        <div class="cuadro-texto mx-auto">
                            <div class="texto-contenido">
                                <?php echo $texto_con_iconos; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Cuadro de texto secundario -->
                    <?php if (isset($cartilla[$pagina]['texto2'])): ?>
                        <div class="cuadro-texto mx-auto">
                            <div class="texto-contenido">
                                <?php echo $cartilla[$pagina]['texto2']; ?>
                            </div>
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
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; 2025 Economía Solidaria y Circular - Todos los derechos reservados.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>

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
    function guardarActividad() {
        const residuo1 = document.querySelector('input[name="residuo1"]').value;
        const uso1 = document.querySelector('textarea[name="uso1"]').value;
        const residuo2 = document.querySelector('input[name="residuo2"]').value;
        const uso2 = document.querySelector('textarea[name="uso2"]').value;
        const residuo3 = document.querySelector('input[name="residuo3"]').value;
        const uso3 = document.querySelector('textarea[name="uso3"]').value;
        
        if (residuo1 && uso1 && residuo2 && uso2 && residuo3 && uso3) {
            // Guardar en localStorage (opcional)
            localStorage.setItem('actividad_residuos', JSON.stringify({
                residuo1, uso1, residuo2, uso2, residuo3, uso3, 
                fecha: new Date().toISOString()
            }));
            
            // Mostrar mensaje de éxito
            document.getElementById('mensajeExito').style.display = 'block';
            
            // Scroll hacia el mensaje
            document.getElementById('mensajeExito').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
            
            // Redirigir a la página siguiente (página 7) después de 3 segundos
            setTimeout(() => {
                // Verificar si existe la página siguiente antes de redirigir
                const paginaActual = <?php echo $pagina; ?>;
                const totalPaginas = <?php echo $total_paginas; ?>;
                
                if (paginaActual < totalPaginas - 1) {
                    // Ir a la página siguiente
                    window.location.href = 'aprende.php?pagina=' + (paginaActual + 1);
                } else {
                    // Si es la última página, ir a la portada
                    window.location.href = 'aprende.php?pagina=0';
                }
            }, 3000);
        } else {
            alert('Por favor, completa todos los campos para finalizar la actividad.');
        }
    }
    </script>
    
</body>
</html>