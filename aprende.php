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
            "tipo" => "contenido_con_actividad",
            "titulo" => "¡Los Residuos son Oportunidades!",
            "texto" => "¡De la <span style='color: #FFD700;'>cáscara de plátano</span> al <span style='color: #32CD32;'>abono para tus plantas</span>, del <span style='color: #FF6B6B;'>retazo</span> a una <span style='color: #4ECDC4;'>nueva creación</span>!",
            "actividad_titulo" => "Actividad del Tema 2: ¿Qué Residuo Ves Tú?",
            "actividad_descripcion" => "Observa tu espacio de trabajo (o tu casa). Nombra <b>3 tipos de residuos</b> que generas con frecuencia y piensa en una forma diferente de verlos (¿podría ser un recurso?).",
            "fondo" => "img/transformacion-residuos.jpg",
        ],
        [
            "tipo" => "actividad",           
            "texto" => "Introduce la idea de que lo que antes se botaba, ahora es un <b>recurso valioso</b>. ¡De la <span style='color: #FFD700;'>cáscara de plátano</span> al <span style='color: #32CD32;'>abono para tus plantas</span>, del <span style='color: #FF6B6B;'>retazo</span> a una <span style='color: #4ECDC4;'>nueva creación</span>!",
            "actividad_titulo" => "Reto del Tema 2: ¿Qué Residuo Ves Tú?",
            "actividad_instruccion" => "Observa tu espacio de trabajo (o tu casa). Nombra <b>3 tipos de residuos</b> que generas con frecuencia y piensa en una forma diferente de verlos (¿podría ser un recurso?).",
            "fondo" => "img/transformacion-residuos.jpg",
        ],
        [
            "tipo" => "contenido",
            "titulo" => "La Economía Circular: Un Círculo de Oportunidades",
            "texto" => "
                <div class='row g-1'>
                    <div class='col-md-6'>
                        <div class='text-center mb-1'>
                            <h6 class='mb-1' style='color: #000033; font-weight: 900; font-size: 0.9rem; text-shadow: 2px 2px 4px rgba(255,255,255,1);'>
                                <i class='fas fa-arrow-down me-1'></i>Economía Lineal
                            </h6>
                            <div class='d-flex flex-column align-items-center'>
                                <div class='economia-step-micro mb-1' style='background: linear-gradient(135deg, #ff6b6b, #ee5a52); color: #000033; padding: 0.3rem 0.6rem; border-radius: 8px; font-weight: 900; box-shadow: 0 1px 3px rgba(238,90,82,0.3); font-size: 0.7rem; border: 1px solid rgba(0,0,0,0.2);'>
                                    <i class='fas fa-mountain me-1'></i>Extraer
                                </div>
                                <i class='fas fa-arrow-down mb-1' style='font-size: 0.8rem; color: #000033; text-shadow: 1px 1px 2px rgba(255,255,255,1);'></i>
                                <div class='economia-step-micro mb-1' style='background: linear-gradient(135deg, #4ecdc4, #44a08d); color: #000033; padding: 0.3rem 0.6rem; border-radius: 8px; font-weight: 900; box-shadow: 0 1px 3px rgba(68,160,141,0.3); font-size: 0.7rem; border: 1px solid rgba(0,0,0,0.2);'>
                                    <i class='fas fa-cogs me-1'></i>Producir
                                </div>
                                <i class='fas fa-arrow-down mb-1' style='font-size: 0.8rem; color: #000033; text-shadow: 1px 1px 2px rgba(255,255,255,1);'></i>
                                <div class='economia-step-micro mb-1' style='background: linear-gradient(135deg, #45b7d1, #96c93d); color: #000033; padding: 0.3rem 0.6rem; border-radius: 8px; font-weight: 900; box-shadow: 0 1px 3px rgba(69,183,209,0.3); font-size: 0.7rem; border: 1px solid rgba(0,0,0,0.2);'>
                                    <i class='fas fa-shopping-cart me-1'></i>Usar
                                </div>
                                <i class='fas fa-arrow-down mb-1' style='font-size: 0.8rem; color: #000033; text-shadow: 1px 1px 2px rgba(255,255,255,1);'></i>
                                <div class='economia-step-micro' style='background: linear-gradient(135deg, #6c5ce7, #a29bfe); color: #000033; padding: 0.3rem 0.6rem; border-radius: 8px; font-weight: 900; box-shadow: 0 1px 3px rgba(108,92,231,0.3); font-size: 0.7rem; border: 1px solid rgba(0,0,0,0.2);'>
                                    <i class='fas fa-trash me-1'></i>Botar
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='text-center mb-1'>
                            <h6 class='mb-1' style='color: #000033; font-weight: 900; font-size: 0.9rem; text-shadow: 2px 2px 4px rgba(255,255,255,1);'>
                                <i class='fas fa-recycle me-1'></i>Economía Circular
                            </h6>
                            <div class='position-relative mx-auto' style='width: 140px; height: 140px;'>
                                <div class='position-absolute top-50 start-50 translate-middle text-center' style='z-index: 10;'>
                                    <div style='background: linear-gradient(135deg, #43be16, #38a01c); color: #000033; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; font-weight: 900; box-shadow: 0 2px 8px rgba(67,190,22,0.4); border: 1px solid rgba(0,0,0,0.2);'>
                                        <i class='fas fa-leaf' style='font-size: 0.8rem;'></i>
                                    </div>
                                </div>
                                
                                <div class='position-absolute' style='top: 0px; left: 50%; transform: translateX(-50%);'>
                                    <div class='text-center' style='background: linear-gradient(135deg, #e74c3c, #c0392b); color: #000033; padding: 0.15rem 0.3rem; border-radius: 4px; font-size: 0.55rem; font-weight: 900; box-shadow: 0 1px 3px rgba(231,76,60,0.3); border: 1px solid rgba(0,0,0,0.2);'>
                                        <i class='fas fa-minus-circle me-1'></i>Reducir
                                    </div>
                                </div>
                                
                                <div class='position-absolute' style='top: 15px; right: 0px;'>
                                    <div class='text-center' style='background: linear-gradient(135deg, #f39c12, #e67e22); color: #000033; padding: 0.15rem 0.3rem; border-radius: 4px; font-size: 0.55rem; font-weight: 900; box-shadow: 0 1px 3px rgba(243,156,18,0.3); border: 1px solid rgba(0,0,0,0.2);'>
                                        <i class='fas fa-redo me-1'></i>Reutilizar
                                    </div>
                                </div>
                                
                                <div class='position-absolute' style='bottom: 40px; right: 0px;'>
                                    <div class='text-center' style='background: linear-gradient(135deg, #27ae60, #2ecc71); color: #000033; padding: 0.15rem 0.3rem; border-radius: 4px; font-size: 0.55rem; font-weight: 900; box-shadow: 0 1px 3px rgba(39,174,96,0.3); border: 1px solid rgba(0,0,0,0.2);'>
                                        <i class='fas fa-recycle me-1'></i>Reciclar
                                    </div>
                                </div>
                                
                                <div class='position-absolute' style='bottom: 15px; left: 50%; transform: translateX(-50%);'>
                                    <div class='text-center' style='background: linear-gradient(135deg, #8e44ad, #9b59b6); color: #000033; padding: 0.15rem 0.3rem; border-radius: 4px; font-size: 0.55rem; font-weight: 900; box-shadow: 0 1px 3px rgba(142,68,173,0.3); border: 1px solid rgba(0,0,0,0.2);'>
                                        <i class='fas fa-tools me-1'></i>Reparar
                                    </div>
                                </div>
                                
                                <div class='position-absolute' style='bottom: 40px; left: 0px;'>
                                    <div class='text-center' style='background: linear-gradient(135deg, #3498db, #2980b9); color: #000033; padding: 0.15rem 0.3rem; border-radius: 4px; font-size: 0.55rem; font-weight: 900; box-shadow: 0 1px 3px rgba(52,152,219,0.3); border: 1px solid rgba(0,0,0,0.2);'>
                                        <i class='fas fa-heart me-1'></i>Recuperar
                                    </div>
                                </div>
                                
                                <div class='position-absolute' style='top: 15px; left: 0px;'>
                                    <div class='text-center' style='background: linear-gradient(135deg, #e91e63, #ad1457); color: #000033; padding: 0.15rem 0.3rem; border-radius: 4px; font-size: 0.55rem; font-weight: 900; box-shadow: 0 1px 3px rgba(233,30,99,0.3); border: 1px solid rgba(0,0,0,0.2);'>
                                        <i class='fas fa-lightbulb me-1'></i>Rediseñar
                                    </div>
                                </div>
                                
                                <div class='position-absolute top-50 start-50 translate-middle' style='width: 110px; height: 110px; border: 2px dashed #000033; border-radius: 50%; opacity: 0.8;'></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class='text-center mt-1'>
                    <p class='fw-bold' style='font-size: 0.8rem; color: #000033; line-height: 1.2; margin-bottom: 0.3rem; text-shadow: 2px 2px 4px rgba(255,255,255,1);'>
                        <i class='fas fa-arrow-right me-1'></i>
                        En la <b>Economía Circular</b>, los recursos nunca se desperdician, siempre encuentran una nueva vida útil.
                    </p>
                </div>
            ",
            "fondo" => "img/imagen_economia_circular.webp",
            "logo" => "img/Logo-sena-blanco-sin-fondo.webp"
        ],
        [
            "tipo" => "contenido",
            "titulo" => "Beneficios en Tu Negocio y Tu Hogar",
            "texto" => "<ul>
                <li><b><span style=\"color: #007bff;\">Ahorro Directo:</span></b> Menos compra de insumos, menos pago por recolección de basura.</li>
                <li><b><span style=\"color: #007bff;\">Nuevos Ingresos:</span></b> Venta de reciclables, creación de productos únicos.</li>
                <li><b><span style=\"color: #007bff;\">Cuidado del Ambiente:</span></b> Menos contaminación en agua, aire y suelo.</li>
                <li><b><span style=\"color: #007bff;\">Reputación:</span></b> Tu negocio se destaca por ser sostenible.</li>
            </ul>",
            "fondo" => "img/imagen_ahorro.webp",
            "logo" => "img/Logo-sena-blanco-sin-fondo.webp"
        ],
        [
            "tipo" => "contenido",
            "titulo" => "Construyendo Juntas el Futuro",
            "texto" => "Esta página está lista para agregar el siguiente contenido de la cartilla. Aquí puedes continuar desarrollando los temas de economía solidaria y circular para emprendedoras.",
            "fondo" => "img/construccion-futuro.jpg",
            "logo" => "img/Logo-sena-blanco-sin-fondo.webp"
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
    if (isset($cartilla[$pagina]['texto']) && strpos($cartilla[$pagina]['texto'], '<li>') !== false) {
        preg_match_all('/<li>(.*?)<\/li>/s', $cartilla[$pagina]['texto'], $matches);
        $puntos_de_beneficio = $matches[1];

        $texto_con_iconos = '<ul class="list-unstyled mx-auto" style="max-width: 700px; padding: 0 1rem;">';

        foreach ($puntos_de_beneficio as $index => $punto) {
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
        $texto_con_iconos = $cartilla[$pagina]['texto'] ?? '';
    }

    // Configuración de altura por página
    $height_bloque = '75vh';

    if ($pagina == 2) { $height_bloque = '78vh'; }
    if ($pagina == 3) { $height_bloque = '66vh'; } 
    if ($pagina == 4) { $height_bloque = '66vh'; } 
    if ($pagina == 5) { $height_bloque = '78vh'; } 
    if ($pagina == 6) { $height_bloque = '40vh'; }
    if ($pagina == 7) { $height_bloque = '63vh'; } 
    if ($pagina == 8) { $height_bloque = '78vh'; }
    if ($pagina == 9) { $height_bloque = '75vh'; }

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
        /* Estilos para el cuadro semitransparente con fondo azul claro */
        .cuadro-texto {
            background: rgba(173, 216, 230, 0.35) !important;
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
            border-radius: 20px;
            padding: 1.2rem 2rem;
            margin: 0.3rem 0;
            box-shadow: 
                0 10px 25px rgba(0, 0, 0, 0.15),
                0 3px 10px rgba(173, 216, 230, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.4);
            max-width: 800px;
            color: #000033;
            position: relative;
        }

        .cuadro-texto::before {
            display: none;
        }

        .cuadro-texto h3 {
            color: #001122;
            margin-bottom: 1rem;
            font-weight: 900;
            text-shadow: 
                3px 3px 6px rgba(255,255,255,1),
                1px 1px 3px rgba(255,255,255,0.9),
                -1px -1px 2px rgba(255,255,255,0.8);
        }

        .cuadro-texto .texto-contenido {
            font-size: 1.1rem;
            line-height: 1.5;
            color: #000022;
            font-weight: 700;
            text-shadow: 
                2px 2px 4px rgba(255,255,255,1),
                1px 1px 3px rgba(255,255,255,0.95),
                -1px -1px 2px rgba(255,255,255,0.9),
                0px 0px 5px rgba(255,255,255,0.7);
        }

        .cuadro-texto .texto-contenido b {
            color: #000011;
            font-weight: 900;
            text-shadow: 
                3px 3px 6px rgba(255,255,255,1),
                1px 1px 3px rgba(255,255,255,0.95),
                -1px -1px 2px rgba(255,255,255,0.9),
                0px 0px 6px rgba(255,255,255,0.8);
        }

        .cuadro-texto .texto-contenido span[style*="color"] {
            font-weight: 900;
            text-shadow: 
                3px 3px 7px rgba(255,255,255,1),
                1px 1px 4px rgba(255,255,255,0.95),
                -1px -1px 3px rgba(255,255,255,0.9),
                0px 0px 8px rgba(255,255,255,0.8);
        }

        .cuadro-texto .list-unstyled li {
            margin-bottom: 0.8rem;
            transition: all 0.3s ease;
            padding: 0.3rem;
            border-radius: 8px;
            color: #000022;
            font-weight: 700;
        }

        .cuadro-texto .list-unstyled li div {
            color: #000022 !important;
            font-weight: 700 !important;
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

        .cuadro-texto:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
            background: rgba(173, 216, 230, 0.45) !important;
            box-shadow: 
                0 15px 30px rgba(0, 0, 0, 0.2),
                0 5px 15px rgba(173, 216, 230, 0.3);
        }

        /* Cuadro especial para actividades */
        .cuadro-actividad {
            background: rgba(135, 206, 250, 0.4) !important;
            border: 2px solid rgba(70, 130, 180, 0.6);
        }

        .cuadro-actividad:hover {
            background: rgba(135, 206, 250, 0.5) !important;
            border-color: rgba(70, 130, 180, 0.8);
        }

        .cuadro-actividad h3 {
            color: #001122;
            font-weight: 900;
        }

        .cuadro-actividad .texto-contenido {
            color: #000022;
            font-weight: 700;
        }

        .cuadro-actividad label {
            color: #001122 !important;
            font-weight: 800;
            text-shadow: 
                2px 2px 4px rgba(255,255,255,1),
                1px 1px 3px rgba(255,255,255,0.9);
        }

        .cuadro-actividad .text-muted {
            color: #000044 !important;
            font-weight: 600;
            text-shadow: 1px 1px 3px rgba(255,255,255,0.9);
        }

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

        /* ESTILOS PARA INFOGRAFÍA DE ECONOMÍA CIRCULAR */
        .economia-step-micro {
            transition: all 0.3s ease;
            min-width: 60px;
        }

        .economia-step-micro:hover {
            transform: scale(1.03);
            box-shadow: 0 2px 6px rgba(0,0,0,0.3) !important;
        }

        @keyframes pulseArrow {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .fa-arrow-down {
            animation: pulseArrow 2s infinite;
        }

        /* ESTILOS ESPECÍFICOS PARA PÁGINA 7 - TEXTO GRANDE E INFOGRAFÍA AMPLIADA */
        .pagina-7-compacta .cuadro-texto {
            max-width: 1200px !important; 
            padding: 1rem 4rem !important; 
            margin: 0.5rem auto !important; 
            width: 98% !important; 
        }

        .pagina-7-compacta .cuadro-texto .texto-contenido {
            text-align: center;
            margin: 0 auto;
            font-size: 2rem !important; /* TEXTO GRANDE - OBJETIVO ALCANZADO */
            line-height: 2.2 !important;
            font-weight: 800 !important;
            max-width: 100% !important;
            padding: 0 2rem !important;
        }

        .pagina-7-compacta .position-relative {
            width: 180px !important; /* INFOGRAFÍA GRANDE - OBJETIVO ALCANZADO */
            height: 180px !important;
        }

        .pagina-7-compacta .translate-middle div {
            width: 45px !important; /* CÍRCULO CENTRAL AMPLIADO */
            height: 45px !important;
        }

        .pagina-7-compacta .fa-leaf {
            font-size: 1.1rem !important;
        }

        .pagina-7-compacta .economia-step-micro {
            padding: 0.5rem 0.8rem !important;
            font-size: 0.85rem !important;
            min-width: 75px !important;
        }

        .pagina-7-compacta .position-absolute div {
            padding: 0.25rem 0.5rem !important;
            font-size: 0.7rem !important;
        }

        /* RESPONSIVE DESIGN OPTIMIZADO */
        @media (max-width: 768px) {
            .cuadro-texto {
                padding: 1.5rem;
                margin: 0.5rem;
                border-radius: 15px;
                background: rgba(173, 216, 230, 0.45) !important;
            }
            
            .cuadro-texto .texto-contenido {
                font-size: 1rem;
                line-height: 1.6;
                font-weight: 800;
                text-shadow: 
                    3px 3px 6px rgba(255,255,255,1),
                    1px 1px 4px rgba(255,255,255,0.95),
                    0px 0px 6px rgba(255,255,255,0.8);
            }
            
            .cuadro-texto h3 {
                font-weight: 900;
                text-shadow: 
                    4px 4px 8px rgba(255,255,255,1),
                    2px 2px 5px rgba(255,255,255,0.9);
            }
            
            /* PÁGINA 7 EN TABLET */
            .pagina-7-compacta .cuadro-texto {
                max-width: 95% !important; 
                width: 95% !important;
                padding: 1rem !important;
                margin: 0.3rem auto !important;
                background: rgba(173, 216, 230, 0.45) !important; 
            }
            
            .pagina-7-compacta .cuadro-texto .texto-contenido {
                font-size: 1.8rem !important;
            }
            
            .pagina-7-compacta .position-relative {
                width: 140px !important;
                height: 140px !important;
            }
            
            .pagina-7-compacta .translate-middle div {
                width: 35px !important;
                height: 35px !important;
            }

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
            .cuadro-texto {
                padding: 1.2rem;
                margin: 0.3rem;
                background: rgba(173, 216, 230, 0.55) !important;
            }
            
            .cuadro-actividad {
                background: rgba(135, 206, 250, 0.55) !important;
                padding: 1rem !important;
                margin: 0.1rem 0 !important;
            }
            
            .cuadro-texto .texto-contenido {
                font-weight: 900;
                text-shadow: 
                    4px 4px 8px rgba(255,255,255,1),
                    2px 2px 6px rgba(255,255,255,0.95),
                    0px 0px 8px rgba(255,255,255,0.8);
            }

            /* PÁGINA 7 EN MÓVIL */
            .pagina-7-compacta .cuadro-texto {
                max-width: 98% !important; 
                width: 98% !important;
                padding: 0.8rem 2rem !important;
                margin: 0.2rem auto !important;
                background: rgba(173, 216, 230, 0.55) !important; 
            }
            
            .pagina-7-compacta .cuadro-texto .texto-contenido {
                font-size: 1.6rem !important;
            }
            
            .pagina-7-compacta .position-relative {
                width: 120px !important;
                height: 120px !important;
            }
            
            .pagina-7-compacta .translate-middle div {
                width: 30px !important;
                height: 30px !important;
            }
            
            .cuadro-actividad textarea {
                min-height: 55px !important;
            }
            
            .btn-lg {
                font-size: 0.9rem !important;
                padding: 0.5rem 1rem !important;
                min-width: 100px !important;
            }
        }

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

        @media (max-width: 480px) {
            .pagina-7-compacta .cuadro-texto {
                background: rgba(173, 216, 230, 0.6) !important;
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
                    echo '<a href="logout.php" class="btn py-4 px-lg-5 d-none d-lg-block text-white" style="background-color: #43be16;">Cerrar sesión<i class="fa fa-arrow-right ms-3"></i></a>';
                    echo '<a href="logout.php" class="btn btn-success d-block d-lg-none my-3 w-100 text-white text-center justify-content-center align-items-center d-flex" style="background-color: #43be16;">'
                        .'<span class="mx-auto">Cerrar sesión</span>'
                        .'<i class="fa fa-arrow-right ms-2"></i>'
                    .'</a>';
                } else {
                    echo '<a href="registro.php" class="btn py-4 px-lg-5 d-none d-lg-block text-white" style="background-color: #43be16;">Regístrate Ahora<i class="fa fa-arrow-right ms-3"></i></a>';
                }
                ?>
            </div>
        </div>
    </nav>

    <!-- Cartilla Virtual: Portada y páginas siguientes -->
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
    <!-- Template para Páginas de Actividad -->
    <div class="container-fluid header-aprende"
        style="position: relative;
            background-image: url('<?php echo $cartilla[$pagina]['fondo']; ?>');
            background-size: cover;
            background-position: center;
            min-height: 100vh;">
            
        <div class="container-fluid h-100 p-0">
            <div class="row g-0 justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-lg-10 mx-auto px-3 py-4 d-flex flex-column"> 
                    <?php if (isset($cartilla[$pagina]['texto'])): ?>
                        <div class="cuadro-texto mx-auto mb-3" style="max-width: 900px; padding: 1.5rem; margin: 0.5rem 0;">
                            <div class="texto-contenido text-center" style="font-size: 1rem; line-height: 1.5;">
                                <?php echo $cartilla[$pagina]['texto']; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="cuadro-texto cuadro-actividad mx-auto flex-grow-1" style="max-width: 950px; padding: 1.8rem;">
                        <h3 class="text-center mb-3" style="font-size: 1.4rem;">
                            <i class="fas fa-tasks me-2"></i>
                            <?php echo $cartilla[$pagina]['actividad_titulo']; ?>
                        </h3>
                        <p class="texto-contenido mb-4 text-center" style="font-size: 1rem; line-height: 1.5;">
                            <?php echo $cartilla[$pagina]['actividad_instruccion']; ?>
                        </p>
                        
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
                        
                        <div id="mensajeExito" class="alert alert-info text-center mt-3 mb-2" style="display: none; background-color: rgba(135, 206, 250, 0.8); border-color: #003d82; color: #001a4d; padding: 0.8rem; font-size: 0.95rem;">
                            <i class="fas fa-trophy me-2"></i>
                            ¡Excelente! Has completado la actividad. Cada residuo es una nueva oportunidad.
                        </div>
                    </div>
                    
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
                <div class="col-12 col-lg-10 mx-auto px-4 pt-4">
                    <h1 class="display-3 text-white animated slideInDown mb-3 text-center text-shadow-custom">
                        <?php echo $cartilla[$pagina]['titulo']; ?>
                    </h1>
                </div>
                <div class="col-12 col-lg-8 mx-auto px-4 d-flex flex-column justify-content-end" style="height: <?php echo $height_bloque; ?>;"> 
                    <?php if (isset($cartilla[$pagina]['texto'])): ?>
                        <div class="cuadro-texto mx-auto">
                            <div class="texto-contenido text-center">
                                <?php echo $cartilla[$pagina]['texto']; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="cuadro-texto cuadro-actividad mx-auto">
                        <h3 class="text-center mb-3">
                            <i class="fas fa-lightbulb me-2"></i>
                            <?php echo $cartilla[$pagina]['actividad_titulo']; ?>
                        </h3>
                        <p class="texto-contenido mb-4 text-center">
                            <?php echo $cartilla[$pagina]['actividad_descripcion']; ?>
                        </p>
                        
                        <div class="text-center">
                            <a href="aprende.php?pagina=<?php echo $pagina+1; ?>" class="btn btn-primary btn-lg px-5 py-3" style="background-color: #43be16; border-color: #43be16; font-weight: 700; font-size: 1.2rem;">
                                <i class="fas fa-play-circle me-2"></i>
                                ¡Realizar Actividad Interactiva!
                            </a>
                        </div>
                        
                        <div class="text-center mt-3">
                            <small class="text-white" style="background: rgba(0,0,0,0.3); padding: 0.5rem 1rem; border-radius: 15px; font-weight: 600;">
                                <i class="fas fa-clock me-1"></i>
                                Tiempo estimado: 5 minutos
                            </small>
                        </div>
                    </div>
                    
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
                <div class="col-12 col-lg-10 mx-auto px-4 pt-4">
                    <h1 class="display-3 text-white animated slideInDown mb-3 text-center text-shadow-custom">
                        <?php echo $cartilla[$pagina]['titulo']; ?>
                    </h1>
                </div>
                <div class="col-12 col-lg-8 mx-auto px-4 d-flex flex-column justify-content-end" style="height: <?php echo $height_bloque; ?>;"> 
                    <!-- APLICAR CLASE ESPECIAL PARA PÁGINA 7 -->
                    <?php if (isset($cartilla[$pagina]['texto'])): ?>
                        <div class="<?php echo ($pagina == 7) ? 'pagina-7-compacta ' : ''; ?>cuadro-texto mx-auto">
                            <div class="texto-contenido">
                                <?php echo $texto_con_iconos; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
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
            localStorage.setItem('actividad_residuos', JSON.stringify({
                residuo1, uso1, residuo2, uso2, residuo3, uso3, 
                fecha: new Date().toISOString()
            }));
            
            document.getElementById('mensajeExito').style.display = 'block';
            
            document.getElementById('mensajeExito').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
            
            setTimeout(() => {
                const paginaActual = <?php echo $pagina; ?>;
                const totalPaginas = <?php echo $total_paginas; ?>;
                
                if (paginaActual < totalPaginas - 1) {
                    window.location.href = 'aprende.php?pagina=' + (paginaActual + 1);
                } else {
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