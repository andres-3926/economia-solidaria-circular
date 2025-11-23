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

// Array de páginas de la cartilla
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
        "tipo" => "actividad_quiz",           
        "texto" => "¡Los residuos que antes botabas ahora son <b>recursos valiosos</b>! Demuestra que sabes identificarlos correctamente.",
        "actividad_titulo" => "Reto del Tema 2: Identifica el Residuo Correcto",
        "actividad_instruccion" => "Se mostrarán 6 residuos, uno por uno. <b>Selecciona la clasificación correcta para cada residuo. Necesitas al menos 4 respuestas correctas de 6 para aprobar.</b>",
        "fondo" => "img/transformacion-residuos.jpg",
        "preguntas" => [
            [
                "id" => 1,
                "categoria" => "Gastronomía",
                "pregunta" => "🍌 ¿Qué tipo de residuo son las Cáscaras de plátano?", 

                "opciones" => [
                    "Orgánico para compost",
                    "Reutilizable para artesanías",
                    "Reciclable (plástico, vidrio, papel)"
                ],
                "respuesta_correcta" => "Orgánico para compost"
            ],
            [
                "id" => 2,
                "categoria" => "Gastronomía",
                "pregunta" => "☕ ¿Qué tipo de residuo es la Borra de café?",
                "opciones" => [
                    "Orgánico para compost",
                    "Reutilizable para artesanías",
                    "Reciclable (plástico, vidrio, papel)"
                ],
                "respuesta_correcta" => "Orgánico para compost"
            ],
            [
                "id" => 3,
                "categoria" => "Gastronomía",
                "pregunta" => "🛢️ ¿Qué tipo de residuo es el Aceite de cocina usado?",
                "opciones" => [
                    "Orgánico para compost",
                    "Reutilizable para artesanías",
                    "Reciclable (plástico, vidrio, papel)"
                ],
                "respuesta_correcta" => "Reutilizable para artesanías"
            ],
            [
                "id" => 4,
                "categoria" => "Artesanías",
                "pregunta" => "🧵 ¿Qué tipo de residuo son los Retazos de tela?",
                "opciones" => [
                    "Orgánico para compost",
                    "Reutilizable para artesanías",
                    "Reciclable (plástico, vidrio, papel)"
                ],
                "respuesta_correcta" => "Reutilizable para artesanías"
            ],
            [
                "id" => 5,
                "categoria" => "Artesanías",
                "pregunta" => "📦 ¿Qué tipo de residuo es el Cartón o papel kraft?",
                "opciones" => [
                    "Orgánico para compost",
                    "Reutilizable para artesanías",
                    "Reciclable (plástico, vidrio, papel)"
                ],
                "respuesta_correcta" => "Reciclable (plástico, vidrio, papel)"
            ],
            [
                "id" => 6,
                "categoria" => "Artesanías",
                "pregunta" => "🧶 ¿Qué tipo de residuo son los Hilos sobrantes?",
                "opciones" => [
                    "Orgánico para compost",
                    "Reutilizable para artesanías",
                    "Reciclable (plástico, vidrio, papel)"
                ],
                "respuesta_correcta" => "Reutilizable para artesanías"
            ]
        ]
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
        "titulo" => "¡Manos a la Obra! Tu Guía Práctica",
        "texto" => "Es hora de pasar de la teoría a la acción. Aquí te enseñaremos cómo gestionar tus residuos de manera sencilla y efectiva.",
        "fondo" => "img/mujeres_reciclando.jpeg"
    ],
    [
        "tipo" => "separacion_fuente",
        "titulo" => "Separación en la Fuente: ¡Cada cosa en su lugar!",
        "subtitulo" => "¿Por qué separar? Beneficios claros.",
        "texto" => "La <b>separación en la fuente</b> es el primer paso para aprovechar tus residuos. Al clasificarlos correctamente desde el inicio, facilitas el reciclaje, reduces la contaminación y contribuyes a la economía circular.",
        "fondo" => "img/residuos-cocina-1.jpg",
        "recuadro" => [
            "titulo" => "Orgánicos (¡Para tu compostera!)",
            "icono" => "🍃",
            "color" => "#43be16",
            "que_si" => [
                "titulo" => "Qué SÍ va:",
                "items" => [
                    ["texto" => "Restos de frutas y verduras", "emoji" => "🍌"],
                    ["texto" => "Cáscaras y trozos", "emoji" => "🥕"],
                    ["texto" => "Borra de café", "emoji" => "☕"],
                    ["texto" => "Bolsitas de té", "emoji" => "🍵"],
                    ["texto" => "Restos de pan", "emoji" => "🍞"]
                ]
            ],
            "que_no" => [
                "titulo" => "Qué NO va:",
                "items" => [
                    ["texto" => "Carnes", "emoji" => "🥩"],
                    ["texto" => "Lácteos", "emoji" => "🧀"],
                    ["texto" => "Huesos", "emoji" => "🦴"],
                    ["texto" => "Grasas y aceites", "emoji" => "🛢️"],
                    ["texto" => "Alimentos cocidos muy grasosos", "emoji" => "🍔"]
                ]
            ],
            "consejo" => "💡 <b>Consejo:</b> Ten un recipiente pequeño con tapa en tu área de trabajo para los orgánicos, vacíalo con frecuencia."
        ]
    ],
    [
        "tipo" => "separacion_reciclables",
        "titulo" => "Separación: Plásticos, Papel/Cartón, Vidrio, Aceites y Textiles",
        "subtitulo" => "Guía completa para reciclar y reutilizar",
        "texto" => "Aprende a <b>separar correctamente</b> los materiales reciclables. Cada categoría tiene un proceso específico que facilita su aprovechamiento y contribuye a la <b>economía circular</b>.",
        "fondo" => "img/residuos-cocina-1.jpg",
        "categorias" => [
            // 1. PLÁSTICOS
            [
                "titulo" => "♻️ Plásticos",
                "color" => "#2196F3",
                "columna_izq" => [
                    "titulo" => "Qué SÍ va al reciclaje:",
                    "items" => [
                        ["texto" => "Botellas plásticas", "emoji" => "🍾"],
                        ["texto" => "Envases de limpieza", "emoji" => "🧴"],
                        ["texto" => "Bolsas limpias", "emoji" => "🛍️"],
                        ["texto" => "Empaques flexibles limpios", "emoji" => "📦"]
                    ]
                ],
                "columna_der" => [
                    "titulo" => "Preparación:",
                    "color_borde" => "#4CAF50",
                    "items" => [
                        ["texto" => "Lavar y secar", "emoji" => "💧"],
                        ["texto" => "Aplastar botellas para ahorrar espacio", "emoji" => "👊"]
                    ]
                ]
            ],
            
            // 2. PAPEL Y CARTÓN
            [
                "titulo" => "📄 Papel y Cartón",
                "color" => "#0D47A1",
                "columna_izq" => [
                    "titulo" => "Qué SÍ va al reciclaje:",
                    "items" => [
                        ["texto" => "Periódicos", "emoji" => "📰"],
                        ["texto" => "Revistas", "emoji" => "📖"],
                        ["texto" => "Cajas de cartón", "emoji" => "📦"],
                        ["texto" => "Empaques de papel limpios", "emoji" => "🎁"]
                    ]
                ],
                "columna_der" => [
                    "titulo" => "No incluir:",
                    "color_borde" => "#e74c3c",
                    "items" => [
                        ["texto" => "Papel mojado", "emoji" => "💦"],
                        ["texto" => "Papel con grasa", "emoji" => "🍕"]
                    ]
                ]
            ],
            
            // 3. VIDRIO
            [
                "titulo" => "🍾 Vidrio",
                "color" => "#1eca26ff",
                "columna_izq" => [
                    "titulo" => "Qué SÍ va al reciclaje:",
                    "items" => [
                        ["texto" => "Botellas de vidrio", "emoji" => "🍷"],
                        ["texto" => "Frascos limpios sin tapa", "emoji" => "🫙"]
                    ]
                ],
                "columna_der" => [
                    "titulo" => "Precaución:",
                    "color_borde" => "#FF5722",
                    "items" => [
                        ["texto" => "Manipular con cuidado", "emoji" => "⚠️"]
                    ]
                ]
            ],
            
            // 4. ACEITES DE COCINA
            [
                "titulo" => "🛢️ Aceites de Cocina Usados",
                "color" => "#2c2308ff",
                "columna_izq" => [
                    "titulo" => "Qué SÍ hacer:",
                    "items" => [
                        ["texto" => "Recolectar en un recipiente con tapa", "emoji" => "🫙"]
                    ]
                ],
                "columna_der" => [
                    "titulo" => "Qué NO hacer jamás:",
                    "color_borde" => "#e74c3c",
                    "items" => [
                        ["texto" => "Verter por el desagüe", "emoji" => "🚫"],
                        ["texto" => "(Obstruye tuberías y afecta fuentes de agua)", "emoji" => "💧"]
                    ]
                ]
            ],
            
            // 5. TEXTILES
            [
                "titulo" => "👗 Textiles y Retazos",
                "color" => "#9C27B0",
                "columna_unica" => [
                    "titulo" => "Ideas para reutilizar:",
                    "items" => [
                        ["texto" => "Elaboración de accesorios", "emoji" => "👜"],
                        ["texto" => "Rellenos para cojines", "emoji" => "🛋️"],
                        ["texto" => "Aplicaciones decorativas", "emoji" => "🎨"],
                        ["texto" => "Nuevos productos artesanales", "emoji" => "✨"]
                    ]
                ]
            ]
        ]
    ],
    [
        "tipo" => "contenido",
        "titulo" => "Construyendo Juntas el Futuro",
        "texto" => "Esta página está lista para agregar el siguiente contenido de la cartilla. Aquí puedes continuar desarrollando los temas de economía solidaria y circular para emprendedoras.",
        "fondo" => "img/construccion-futuro.jpg",
        "logo" => "img/Logo-sena-blanco-sin-fondo.webp"
    ],
    [
        "tipo" => "contenido",
        "titulo" => "Construyendo Juntas el Futuro",
        "texto" => "Esta página está lista para agregar el siguiente contenido de la cartilla. Aquí puedes continuar desarrollando los temas de economía solidaria y circular para emprendedoras.",
        "fondo" => "img/construccion-futuro.jpg",
        "logo" => "img/Logo-sena-blanco-sin-fondo.webp"
    ],
];

// Página actual
$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 0;
$total_paginas = count($cartilla);

// Validación de bounds
if ($pagina < 0 || $pagina >= $total_paginas) {
    $pagina = 0;
}

$iconos = ['💰', '📈', '🌍', '🤝'];

// Inyección de iconos
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

// Altura dinámica
$height_bloque = '75vh';
if ($pagina == 2) { $height_bloque = '78vh'; }
if ($pagina == 3) { $height_bloque = '66vh'; } 
if ($pagina == 4) { $height_bloque = '66vh'; } 
if ($pagina == 5) { $height_bloque = '78vh'; } 
if ($pagina == 6) { $height_bloque = '40vh'; }
if ($pagina == 7) { $height_bloque = '66vh'; } 
if ($pagina == 8) { $height_bloque = '78vh'; }
if ($pagina == 9) { $height_bloque = '78vh'; }
if ($pagina == 10) { $height_bloque = '83vh'; } 
if ($pagina == 11) { $height_bloque = '75vh'; }
if ($pagina == 12) { $height_bloque = '70vh'; }
if ($pagina == 13) { $height_bloque = '70vh'; }

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Aprende - Economía Solidaria y Circular</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
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
            max-width: 800px !important; 
            padding: 1.5rem 3rem !important; 
            margin: 0.5rem auto !important; 
            width: 90% !important; 
        }

        .pagina-7-compacta .cuadro-texto .texto-contenido {
            text-align: center;
            margin: 0 auto;
            font-size: 2rem !important; /* TEXTO GRANDE - OBJETIVO ALCANZADO */
            line-height: 2.2 !important;
            font-weight: 800 !important;
            max-width: 90% !important;
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
            /* HABILITAR SCROLL EN MÓVILES Y TABLETS */
            .container-fluid.header-aprende {
                min-height: 100vh !important;
                height: auto !important;
                overflow-y: auto !important;
            }
            
            /* Altura flexible para el contenido */
            .container-fluid.header-aprende .row {
                min-height: 100vh !important;
                height: auto !important;
            }
            
            /* Permitir que el contenido fluya naturalmente */
            .d-flex.flex-column.justify-content-end {
                height: auto !important;
                min-height: auto !important;
                padding-bottom: 2rem !important;
            }
            
            /* Ajustar padding superior para más espacio */
            .col-12.col-lg-10.mx-auto.px-4.pt-4,
            .col-12.col-lg-11.mx-auto.px-3.pt-2 {
                padding-top: 1.5rem !important;
            }
            
            /* PÁGINA 8 - ECONOMÍA CIRCULAR */
            .pagina-7-compacta .cuadro-texto {
                max-width: 98% !important;
                padding: 0.8rem 1rem !important;
                margin: 0.5rem auto !important;
            }
            
            .pagina-7-compacta .cuadro-texto .texto-contenido {
                font-size: 1.4rem !important;
                line-height: 1.6 !important;
            }
            
            .pagina-7-compacta .position-relative {
                width: 130px !important;
                height: 130px !important;
                margin: 1rem auto !important;
            }
            
            .pagina-7-compacta .economia-step-micro {
                font-size: 0.65rem !important;
                padding: 0.3rem 0.5rem !important;
                min-width: 55px !important;
            }
            
            .pagina-7-compacta .position-absolute div {
                font-size: 0.55rem !important;
                padding: 0.2rem 0.35rem !important;
            }
            
            /* PÁGINA 10 - SEPARACIÓN EN LA FUENTE */
            .cuadro-texto h1 {
                font-size: 1.3rem !important;
                line-height: 1.2 !important;
                margin-bottom: 0.5rem !important;
            }
            
            .cuadro-texto h3 {
                font-size: 1rem !important;
                margin-bottom: 0.5rem !important;
            }
            
            .cuadro-texto h4 {
                font-size: 0.85rem !important;
            }
            
            /* Ajustar padding de cuadros */
            .cuadro-texto[style*="max-width: 1150px"],
            .cuadro-texto[style*="max-width: 1250px"] {
                max-width: 98% !important;
                width: 98% !important;
                padding: 0.6rem !important;
                margin: 0.5rem auto !important;
            }
            
            /* Reducir tamaño de emojis */
            .cuadro-texto ul.list-unstyled li span:first-child {
                font-size: 1.1rem !important;
            }
            
            /* Texto más pequeño */
            .cuadro-texto ul.list-unstyled li span:last-child {
                font-size: 0.75rem !important;
            }
            
            /* Ajustar row gaps */
            .row.g-2 {
                gap: 0.5rem !important;
            }
            
            /* Navegación fija en la parte inferior */
            .d-flex.justify-content-between.align-items-end {
                position: sticky !important;
                bottom: 0 !important;
                background: rgba(0, 0, 0, 0.7) !important;
                padding: 0.5rem 1rem !important;
                margin: 0 -1rem !important;
                z-index: 100 !important;
            }
        }

        @media (max-width: 768px) {
            /* SCROLL HABILITADO COMPLETAMENTE */
            body {
                overflow-y: auto !important;
            }
            
            .container-fluid.header-aprende {
                height: auto !important;
                min-height: 100vh !important;
                overflow: visible !important;
            }
            
            /* PÁGINA 8 */
            .pagina-7-compacta .cuadro-texto {
                padding: 0.6rem 0.8rem !important;
                margin: 0.3rem auto !important;
            }
            
            .pagina-7-compacta .cuadro-texto .texto-contenido {
                font-size: 1.2rem !important;
            }
            
            .pagina-7-compacta .position-relative {
                width: 110px !important;
                height: 110px !important;
            }
            
            .pagina-7-compacta .translate-middle div {
                width: 28px !important;
                height: 28px !important;
            }
            
            .pagina-7-compacta .fa-leaf {
                font-size: 0.7rem !important;
            }
            
            /* PÁGINA 10 Y SIGUIENTES */
            .cuadro-texto h1 {
                font-size: 1.1rem !important;
            }
            
            .cuadro-texto h3 {
                font-size: 0.9rem !important;
            }
            
            .cuadro-texto[style*="padding: 0.5rem 1rem"] {
                padding: 0.4rem 0.6rem !important;
            }
            
            .cuadro-texto[style*="padding: 0.4rem 0.8rem"] {
                padding: 0.3rem 0.5rem !important;
            }
            
            .cuadro-texto .texto-contenido {
                font-size: 0.8rem !important;
                line-height: 1.3 !important;
            }
            
            /* Reducir márgenes entre elementos */
            .mb-1 {
                margin-bottom: 0.3rem !important;
            }
            
            .mb-2 {
                margin-bottom: 0.5rem !important;
            }
            
            .mt-2 {
                margin-top: 0.5rem !important;
            }
            
            /* Botones más pequeños */
            .btn-lg {
                font-size: 0.85rem !important;
                padding: 0.4rem 0.7rem !important;
            }
            
            /* Ajustar íconos */
            .fa-check-circle,
            .fa-times-circle {
                font-size: 0.8rem !important;
            }
        }

        @media (max-width: 576px) {
            /* EXTRA PEQUEÑO - SCROLL COMPLETO */
            .container-fluid.header-aprende {
                padding-bottom: 4rem !important;
            }
            
            .cuadro-texto {
                padding: 0.5rem !important;
                margin: 0.3rem auto !important;
            }
            
            .cuadro-texto h1 {
                font-size: 1rem !important;
            }
            
            .cuadro-texto h3 {
                font-size: 0.85rem !important;
            }
            
            .cuadro-texto h4 {
                font-size: 0.75rem !important;
            }
            
            .cuadro-texto .texto-contenido {
                font-size: 0.75rem !important;
            }
            
            .cuadro-texto ul.list-unstyled li span:first-child {
                font-size: 1rem !important;
                margin-right: 0.3rem !important;
            }
            
            .cuadro-texto ul.list-unstyled li span:last-child {
                font-size: 0.7rem !important;
            }
            
            /* Reducir padding de recuadros internos */
            div[style*="padding: clamp"] {
                padding: 0.4rem !important;
            }
            
            /* Botones extra pequeños */
            .btn-lg {
                font-size: 0.8rem !important;
                padding: 0.35rem 0.6rem !important;
            }
            
            /* Ajustar padding lateral */
            .col-12.col-lg-11.mx-auto.px-3 {
                padding-left: 0.5rem !important;
                padding-right: 0.5rem !important;
            }
        }

        @media (max-width: 480px) {
            /* PANTALLAS MUY PEQUEÑAS */
            .cuadro-texto {
                padding: 0.4rem !important;
                margin: 0.2rem auto !important;
            }
            
            .cuadro-texto h1 {
                font-size: 0.95rem !important;
            }
            
            .cuadro-texto h3 {
                font-size: 0.8rem !important;
            }
            
            .cuadro-texto h4 {
                font-size: 0.7rem !important;
            }
            
            .cuadro-texto .texto-contenido {
                font-size: 0.7rem !important;
            }
            
            .cuadro-texto ul.list-unstyled li span:first-child {
                font-size: 0.9rem !important;
            }
            
            .cuadro-texto ul.list-unstyled li span:last-child {
                font-size: 0.65rem !important;
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
    <!-- PORTADA -->
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

    <?php elseif ($cartilla[$pagina]['tipo'] === 'actividad_quiz'): ?>
    <!-- QUIZ INTERACTIVO (PÁGINA 6) - SOLO 2 PREGUNTAS -->
    <div class="container-fluid header-aprende" style="position: relative; background-image: url('<?php echo $cartilla[$pagina]['fondo']; ?>'); background-size: cover; background-position: center; min-height: 100vh;">
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
                    
                    <div class="cuadro-texto cuadro-actividad mx-auto flex-grow-1" style="max-width: 1000px; padding: 1.8rem;">
                        <h3 class="text-center mb-3" style="font-size: 1.4rem;">
                            <i class="fas fa-clipboard-list me-2"></i>
                            <?php echo $cartilla[$pagina]['actividad_titulo']; ?>
                        </h3>
                        <p class="texto-contenido mb-4 text-center" style="font-size: 1rem; line-height: 1.5;">
                            <?php echo $cartilla[$pagina]['actividad_instruccion']; ?>
                        </p>
                        
                        <!-- QUIZ FORM -->
                        <form id="quizForm" class="mt-2">
                            <div class="accordion" id="accordionQuiz">
                                <?php 
                                $preguntas = $cartilla[$pagina]['preguntas'];
                                foreach ($preguntas as $index => $pregunta): 
                                    $numero = $index + 1;
                                    $isFirst = ($index === 0);
                                ?>
                                <div class="accordion-item mb-3" style="border: 2px solid rgba(70, 130, 180, 0.4); border-radius: 10px; overflow: hidden;">
                                    <h2 class="accordion-header" id="heading<?php echo $numero; ?>">
                                        <button class="accordion-button <?php echo $isFirst ? '' : 'collapsed'; ?>" 
                                                type="button" 
                                                data-bs-toggle="collapse" 
                                                data-bs-target="#collapse<?php echo $numero; ?>" 
                                                aria-expanded="<?php echo $isFirst ? 'true' : 'false'; ?>" 
                                                style="background: rgba(255, 255, 255, 0.95); color: #003d82; font-weight: 700; font-size: 1rem;">
                                            <span class="badge bg-primary me-2"><?php echo $numero; ?></span>
                                            <span class="badge bg-info me-2"><?php echo $pregunta['categoria']; ?></span>
                                            <?php echo $pregunta['pregunta']; ?>
                                        </button>
                                    </h2>
                                    <div id="collapse<?php echo $numero; ?>" 
                                         class="accordion-collapse collapse <?php echo $isFirst ? 'show' : ''; ?>">
                                        <div class="accordion-body" style="background: rgba(255, 255, 255, 0.9); padding: 1.5rem;">
                                            <?php foreach ($pregunta['opciones'] as $opcionIndex => $opcion): ?>
                                            <div class="form-check mb-3 opcion-item" style="padding: 1rem; border-radius: 8px; cursor: pointer;">
                                                <input class="form-check-input" 
                                                       type="radio" 
                                                       name="pregunta_<?php echo $numero; ?>" 
                                                       id="p<?php echo $numero; ?>_op<?php echo $opcionIndex; ?>" 
                                                       value="<?php echo htmlspecialchars($opcion); ?>"
                                                       required
                                                       style="cursor: pointer; width: 20px; height: 20px;">
                                                <label class="form-check-label" 
                                                       for="p<?php echo $numero; ?>_op<?php echo $opcionIndex; ?>" 
                                                       style="cursor: pointer; font-weight: 600; color: #001a4d; margin-left: 0.5rem; font-size: 0.95rem;">
                                                    <?php echo $opcion; ?>
                                                </label>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="text-center mt-4 mb-3">
                                <button type="button" 
                                        id="btnEnviarReto"
                                        class="btn btn-primary btn-lg px-5 py-3" 
                                        onclick="enviarReto()" 
                                        style="background-color: #003d82; border-color: #003d82; font-size: 1.1rem; font-weight: 700;">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    ¡Enviar Reto!
                                </button>
                            </div>
                        </form>
                        
                        <div id="mensajeResultado" class="alert text-center mt-3 mb-2" style="display: none; padding: 1.5rem; font-size: 1rem; border-radius: 15px;"></div>
                    </div>
                    
                    <div class="d-flex justify-content-start mt-3 px-2">
                        <a href="aprende.php?pagina=<?php echo $pagina-1; ?>" class="btn btn-lg text-white" style="background-color: #43be16;">
                            <i class="fa fa-arrow-left me-2"></i> Anterior
                        </a>
                    </div>
                </div>
            </div>
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
                <div class="col-12 col-lg-11 mx-auto px-3 pt-2">
                    <div class="cuadro-texto text-center mb-1" style="padding: 0.5rem 1rem; max-width: 1100px; margin: 0 auto;">
                        <h1 class="mb-1" style="font-size: clamp(1.2rem, 3.3vw, 1.6rem); line-height: 1.2; color: #001122; font-weight: 900;">
                            <?php echo $cartilla[$pagina]['titulo']; ?>
                        </h1>
                        <h3 class="mb-0" style="font-size: clamp(0.9rem, 2vw, 1.1rem); font-weight: 700; color: #003366;">
                            <?php echo $cartilla[$pagina]['subtitulo']; ?>
                        </h3>
                    </div>
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

    <?php elseif ($cartilla[$pagina]['tipo'] === 'separacion_fuente'): ?>
    <!-- PÁGINA 10: SEPARACIÓN EN LA FUENTE -->
    <div class="container-fluid header-aprende"
        style="position: relative;
            background-image: url('<?php echo $cartilla[$pagina]['fondo']; ?>');
            background-size: cover;
            background-position: center;
            min-height: 100vh;">
            
        <div class="container-fluid h-100 p-0">
            <div class="row g-0 justify-content-center" style="height: 100vh;">
                <!-- Títulos con fondo semitransparente - MÁS COMPACTO -->
                <div class="col-12 col-lg-11 mx-auto px-3 pt-2">
                    <div class="cuadro-texto text-center mb-1" style="padding: 0.5rem 1rem; max-width: 1100px; margin: 0 auto;">
                        <h1 class="mb-1" style="font-size: clamp(1.2rem, 3.3vw, 1.6rem); line-height: 1.2; color: #001122; font-weight: 900;">
                            <?php echo $cartilla[$pagina]['titulo']; ?>
                        </h1>
                        <h3 class="mb-0" style="font-size: clamp(0.9rem, 2vw,  1.1rem); font-weight: 700; color: #003366;">
                            <?php echo $cartilla[$pagina]['subtitulo']; ?>
                        </h3>
                    </div>
                </div>
                
                <!-- Contenido principal - ALTURA REDUCIDA -->
                <div class="col-12 col-lg-11 mx-auto px-3 d-flex flex-column justify-content-end" style="height: <?php echo $height_bloque; ?>;"> 
                    <!-- Texto introductorio muy compacto -->
                    <?php if (isset($cartilla[$pagina]['texto'])): ?>
                        <div class="cuadro-texto mx-auto mb-1" style="max-width: 1150px; padding: 0.4rem 0.8rem; width: 95%;">
                            <div class="texto-contenido text-center" style="font-size: clamp(0.7rem, 1.5vw, 0.85rem); line-height: 1.2;">
                                <?php echo $cartilla[$pagina]['texto']; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Recuadro de Orgánicos MÁS COMPACTO -->
                    <?php if (isset($cartilla[$pagina]['recuadro'])): 
                        $recuadro = $cartilla[$pagina]['recuadro'];
                    ?>
                        <div class="cuadro-texto mx-auto mb-1" style="max-width: 1250px; padding: clamp(0.5rem, 1.5vw, 0.9rem); background: rgba(67, 190, 22, 0.25) !important; border: 2px solid rgba(67, 190, 22, 0.5); width: 98%;">
                            <!-- Título del recuadro compacto -->
                            <h3 class="text-center mb-2" style="font-size: clamp(0.9rem, 2.5vw, 1.2rem); color: #001122; line-height: 1.1; font-weight: 900;">
                                <span style="font-size: clamp(1.3rem, 3.3vw, 1.7rem); margin-right: 0.3rem;"><?php echo $recuadro['icono']; ?></span>
                                <?php echo $recuadro['titulo']; ?>
                            </h3>
                            
                            <div class="row g-2">
                                <!-- QUÉ SÍ VA -->
                                <div class="col-md-6">
                                    <div style="background: rgba(255, 255, 255, 0.9); padding: clamp(0.5rem, 1.1vw, 0.7rem); border-radius: 8px; border: 2px solid #43be16; height: 100%;">
                                        <h4 class="mb-2" style="color: #43be16; font-weight: 800; text-align: center; font-size: clamp(0.75rem, 1.7vw, 0.95rem);">
                                            <i class="fas fa-check-circle me-1"></i><?php echo $recuadro['que_si']['titulo']; ?>
                                        </h4>
                                        <ul class="list-unstyled mb-0">
                                            <?php foreach ($recuadro['que_si']['items'] as $item): ?>
                                            <li class="mb-1 d-flex align-items-center" style="padding: 0.2rem; border-radius: 5px;">
                                                <span style="font-size: clamp(1rem, 2.1vw, 1.25rem); margin-right: 0.4rem; flex-shrink: 0;"><?php echo $item['emoji']; ?></span>
                                                <span style="color: #001122; font-weight: 700; font-size: clamp(0.65rem, 1.6vw, 0.8rem); line-height: 1.1;"><?php echo $item['texto']; ?></span>
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                                
                                <!-- QUÉ NO VA -->
                                <div class="col-md-6">
                                    <div style="background: rgba(255, 255, 255, 0.9); padding: clamp(0.5rem, 1.1vw, 0.7rem); border-radius: 8px; border: 2px solid #e74c3c; height: 100%;">
                                        <h4 class="mb-2" style="color: #e74c3c; font-weight: 800; text-align: center; font-size: clamp(0.75rem, 1.7vw, 0.95rem);">
                                            <i class="fas fa-times-circle me-1"></i><?php echo $recuadro['que_no']['titulo']; ?>
                                        </h4>
                                        <ul class="list-unstyled mb-0">
                                            <?php foreach ($recuadro['que_no']['items'] as $item): ?>
                                            <li class="mb-1 d-flex align-items-center" style="padding: 0.2rem; border-radius: 5px;">
                                                <span style="font-size: clamp(1rem, 2.1vw, 1.25rem); margin-right: 0.4rem; flex-shrink: 0;"><?php echo $item['emoji']; ?></span>
                                                <span style="color: #001122; font-weight: 700; font-size: clamp(0.65rem, 1.6vw, 0.8rem); line-height: 1.1;"><?php echo $item['texto']; ?></span>
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- CONSEJO muy compacto -->
                            <div class="mt-2" style="background: rgba(255, 193, 7, 0.9); padding: clamp(0.45rem, 1.1vw, 0.7rem); border-radius: 8px; border: 2px solid #ffc107;">
                                <p class="mb-0 text-center" style="color: #001122; font-weight: 700; font-size: clamp(0.7rem, 1.6vw, 0.9rem); line-height: 1.2;">
                                    <?php echo $recuadro['consejo']; ?>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Navegación compacta -->
                    <div class="d-flex justify-content-between align-items-end mt-2">
                        <a href="aprende.php?pagina=<?php echo $pagina-1; ?>" class="btn btn-lg text-white" style="background-color: #43be16; z-index: 10; padding: 0.4rem 0.85rem; font-size: clamp(0.8rem, 1.8vw, 0.95rem);">
                            <i class="fa fa-arrow-left me-1"></i> Anterior
                        </a>
                        <div class="text-white text-center text-shadow-custom d-none d-md-block" style="font-size: clamp(0.7rem, 1.3vw, 0.85rem);">
                            Página <?php echo $pagina+1; ?> de <?php echo $total_paginas; ?>
                        </div>
                        <div class="d-flex align-items-end">
                            <?php if ($pagina < $total_paginas-1): ?>
                                <a href="aprende.php?pagina=<?php echo $pagina+1; ?>" class="btn btn-lg text-white" style="background-color: #43be16; z-index: 10; padding: 0.4rem 0.85rem; font-size: clamp(0.8rem, 1.8vw, 0.95rem);">
                                    Siguiente <i class="fa fa-arrow-right ms-1"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php elseif ($cartilla[$pagina]['tipo'] === 'separacion_reciclables'): ?>
    <!-- PÁGINA 11: SEPARACIÓN DE RECICLABLES - 5 CUADROS INDEPENDIENTES -->
    <div class="container-fluid header-aprende"
        style="position: relative;
            background-image: url('<?php echo $cartilla[$pagina]['fondo']; ?>');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            padding-bottom: 6rem;">
            
        <div class="container-fluid h-100 p-0">
            <div class="row g-0 justify-content-center">
                <!-- Títulos principales -->
                <div class="col-12 col-lg-11 mx-auto px-3 pt-3 pb-2">
                    <div class="cuadro-texto text-center mb-2" style="padding: 0.8rem 1.5rem; max-width: 1100px; margin: 0 auto;">
                        <h1 class="mb-2" style="font-size: clamp(1.3rem, 3.5vw, 1.8rem); line-height: 1.3; color: #001122; font-weight: 900;">
                            <?php echo $cartilla[$pagina]['titulo']; ?>
                        </h1>
                        <h3 class="mb-0" style="font-size: clamp(1rem, 2.2vw, 1.3rem); font-weight: 700; color: #003366;">
                            <?php echo $cartilla[$pagina]['subtitulo']; ?>
                        </h3>
                    </div>
                </div>
                
                <!-- Contenido con scroll automático -->
                <div class="col-12 col-lg-11 mx-auto px-3" style="max-height: none; overflow-y: visible;"> 
                    <!-- Texto introductorio -->
                    <?php if (isset($cartilla[$pagina]['texto'])): ?>
                        <div class="cuadro-texto mx-auto mb-3" style="max-width: 1150px; padding: 0.8rem 1.2rem; width: 95%;">
                            <div class="texto-contenido text-center" style="font-size: clamp(0.85rem, 1.8vw, 1rem); line-height: 1.4;">
                                <?php echo $cartilla[$pagina]['texto']; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- 5 CUADROS INDEPENDIENTES DE CATEGORÍAS -->
                    <?php if (isset($cartilla[$pagina]['categorias'])): 
                        foreach ($cartilla[$pagina]['categorias'] as $index => $categoria): 
                    ?>
                        <!-- CUADRO INDIVIDUAL POR CATEGORÍA -->
                        <div class="cuadro-texto mx-auto mb-3" style="max-width: 1250px; padding: 1.2rem; width: 98%; background: rgba(255, 255, 255, 0.35) !important; border: 3px solid <?php echo $categoria['color']; ?>; box-shadow: 0 8px 20px rgba(0,0,0,0.2);">
                            
                            <!-- TÍTULO DE LA CATEGORÍA CON EMOJI -->
                            <h3 class="text-center mb-3" style="font-size: clamp(1.1rem, 3vw, 1.6rem); color: <?php echo $categoria['color']; ?>; line-height: 1.3; font-weight: 900; text-shadow: 3px 3px 8px rgba(255,255,255,1);">
                                <?php echo $categoria['titulo']; ?>
                            </h3>
                            
                            <?php if (isset($categoria['columna_unica'])): ?>
                                <!-- TEXTILES - UNA SOLA COLUMNA -->
                                <div style="background: rgba(255, 255, 255, 0.95); padding: 1rem; border-radius: 12px; border: 2px solid <?php echo $categoria['color']; ?>;">
                                    <h4 class="mb-3 text-center" style="color: <?php echo $categoria['color']; ?>; font-weight: 800; font-size: clamp(0.95rem, 2.1vw, 1.2rem);">
                                        <i class="fas fa-lightbulb me-2"></i><?php echo $categoria['columna_unica']['titulo']; ?>
                                    </h4>
                                    <ul class="list-unstyled mb-0">
                                        <?php foreach ($categoria['columna_unica']['items'] as $item): ?>
                                        <li class="mb-2 d-flex align-items-start" style="padding: 0.5rem; border-radius: 8px; background: rgba(255,255,255,0.5);">
                                            <span style="font-size: clamp(1.3rem, 2.8vw, 1.7rem); margin-right: 0.7rem; flex-shrink: 0;"><?php echo $item['emoji']; ?></span>
                                            <span style="color: #001122; font-weight: 700; font-size: clamp(0.85rem, 1.9vw, 1.05rem); line-height: 1.4;"><?php echo $item['texto']; ?></span>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            
                            <?php else: ?>
                                <!-- PLÁSTICOS, PAPEL, VIDRIO, ACEITES - DOS COLUMNAS -->
                                <div class="row g-3">
                                    <!-- COLUMNA IZQUIERDA -->
                                    <div class="col-md-6">
                                        <div style="background: rgba(255, 255, 255, 0.95); padding: 1rem; border-radius: 12px; border: 2px solid <?php echo $categoria['color']; ?>; height: 100%; min-height: 200px;">
                                            <h4 class="mb-3 text-center" style="color: <?php echo $categoria['color']; ?>; font-weight: 800; font-size: clamp(0.95rem, 2.1vw, 1.2rem);">
                                                <i class="fas fa-check-circle me-2"></i><?php echo $categoria['columna_izq']['titulo']; ?>
                                            </h4>
                                            <ul class="list-unstyled mb-0">
                                                <?php foreach ($categoria['columna_izq']['items'] as $item): ?>
                                                <li class="mb-2 d-flex align-items-start" style="padding: 0.5rem; border-radius: 8px; background: rgba(255,255,255,0.5);">
                                                    <span style="font-size: clamp(1.3rem, 2.8vw, 1.7rem); margin-right: 0.7rem; flex-shrink: 0;"><?php echo $item['emoji']; ?></span>
                                                    <span style="color: #001122; font-weight: 700; font-size: clamp(0.85rem, 1.9vw, 1.05rem); line-height: 1.4;"><?php echo $item['texto']; ?></span>
                                                </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <!-- COLUMNA DERECHA -->
                                    <div class="col-md-6">
                                        <?php 
                                        $color_borde_der = $categoria['columna_der']['color_borde'];
                                        $icono_der = ($color_borde_der == '#e74c3c') ? 'times' : (($color_borde_der == '#FF5722') ? 'exclamation-triangle' : 'info');
                                        ?>
                                        <div style="background: rgba(255, 255, 255, 0.95); padding: 1rem; border-radius: 12px; border: 2px solid <?php echo $color_borde_der; ?>; height: 100%; min-height: 200px;">
                                            <h4 class="mb-3 text-center" style="color: <?php echo $color_borde_der; ?>; font-weight: 800; font-size: clamp(0.95rem, 2.1vw, 1.2rem);">
                                                <i class="fas fa-<?php echo $icono_der; ?>-circle me-2"></i><?php echo $categoria['columna_der']['titulo']; ?>
                                            </h4>
                                            <ul class="list-unstyled mb-0">
                                                <?php foreach ($categoria['columna_der']['items'] as $item): ?>
                                                <li class="mb-2 d-flex align-items-start" style="padding: 0.5rem; border-radius: 8px; background: rgba(255,255,255,0.5);">
                                                    <span style="font-size: clamp(1.3rem, 2.8vw, 1.7rem); margin-right: 0.7rem; flex-shrink: 0;"><?php echo $item['emoji']; ?></span>
                                                    <span style="color: #001122; font-weight: 700; font-size: clamp(0.85rem, 1.9vw, 1.05rem); line-height: 1.4;"><?php echo $item['texto']; ?></span>
                                                </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                        </div>
                        <!-- FIN CUADRO INDIVIDUAL -->
                    <?php 
                        endforeach;
                    endif; 
                    ?>
                    
                    <!-- Navegación SIN FONDO OSCURO Y PEGADA A LOS BORDES -->
                    <div class="container-fluid px-0 mt-4 mb-3">
                        <div class="row g-0 w-100">
                            <div class="col-12 d-flex justify-content-between align-items-center px-2" style="background: transparent;">
                                <a href="aprende.php?pagina=<?php echo $pagina-1; ?>" class="btn btn-lg text-white" style="background-color: #43be16; padding: 0.6rem 1.2rem; font-size: clamp(0.9rem, 2vw, 1.05rem);">
                                    <i class="fa fa-arrow-left me-2"></i> Anterior
                                </a>
                                <div class="text-white text-center d-none d-md-block" style="font-size: clamp(0.8rem, 1.5vw, 0.95rem); text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">
                                    Página <?php echo $pagina+1; ?> de <?php echo $total_paginas; ?>
                                </div>
                                <?php if ($pagina < $total_paginas-1): ?>
                                    <a href="aprende.php?pagina=<?php echo $pagina+1; ?>" class="btn btn-lg text-white" style="background-color: #43be16; padding: 0.6rem 1.2rem; font-size: clamp(0.9rem, 2vw, 1.05rem);">
                                        Siguiente <i class="fa fa-arrow-right ms-2"></i>
                                    </a>
                                <?php else: ?>
                                    <div style="width: 120px;"></div>
                                <?php endif; ?>
                            </div>
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
                    <!-- APLICAR CLASE ESPECIAL PARA PÁGINA  7 -->
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
    // HABILITAR SCROLL EN DISPOSITIVOS MÓVILES
    $(document).ready(function() {
        function ajustarScrollMobile() {
            const isMobile = window.innerWidth <= 992;
            
            if (isMobile) {
                // Remover restricciones de altura
                $('.container-fluid.header-aprende').css({
                    'height': 'auto',
                    'min-height': '100vh',
                    'overflow-y': 'visible'
                });
                
                $('.container-fluid.header-aprende .row').css({
                    'height': 'auto',
                    'min-height': '100vh'
                });
                
                $('.d-flex.flex-column.justify-content-end').css({
                    'height': 'auto',
                    'min-height': 'auto',
                    'justify-content': 'flex-start',
                    'padding-top': '1rem',
                    'padding-bottom': '5rem'
                });
                
                // Habilitar scroll en body
                $('body').css({
                    'overflow-y': 'auto',
                    'height': 'auto'
                });
                
                console.log('✅ Scroll habilitado para móviles');
            } else {
                // Restaurar comportamiento desktop
                $('.d-flex.flex-column.justify-content-end').css({
                    'justify-content': 'flex-end'
                });
            }
        }
        
        // Ejecutar al cargar
        ajustarScrollMobile();
        
        // Ejecutar al cambiar tamaño
        let resizeTimer;
        $(window).resize(function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(ajustarScrollMobile, 250);
        });
    });

    // RESPUESTAS CORRECTAS DEL QUIZ
    const respuestasCorrectas = <?php 
        if (isset($cartilla[$pagina]['preguntas'])) {
            $respuestas = [];
            foreach ($cartilla[$pagina]['preguntas'] as $index => $p) {
                $respuestas[$index + 1] = $p['respuesta_correcta'];
            }
            echo json_encode($respuestas);
        } else {
            echo '{}';
        }
    ?>;
    
    let tiempoInicio = Date.now();
    
    function enviarReto() {
        const totalPreguntas = Object.keys(respuestasCorrectas).length;
        let respuestasUsuario = {};
        let faltanRespuestas = false;
        
        for (let i = 1; i <= totalPreguntas; i++) {
            const respuesta = document.querySelector(`input[name="pregunta_${i}"]:checked`);
            if (!respuesta) {
                faltanRespuestas = true;
                document.getElementById(`collapse${i}`).classList.add('show');
            } else {
                respuestasUsuario[i] = respuesta.value;
            }
        }
        
        if (faltanRespuestas) {
            alert('⚠️ Por favor responde todas las preguntas antes de enviar el reto.');
            return;
        }
        
        let correctas = 0;
        for (let i = 1; i <= totalPreguntas; i++) {
            if (respuestasUsuario[i] === respuestasCorrectas[i]) {
                correctas++;
            }
        }
        
        const porcentaje = (correctas / totalPreguntas) * 100;
        const aprobado = correctas >= 4; // MÍNIMO 4 DE 6 CORRECTAS
        const tiempoSegundos = Math.round((Date.now() - tiempoInicio) / 1000);
        
        const btnEnviar = document.getElementById('btnEnviarReto');
        const textoOriginal = btnEnviar.innerHTML;
        btnEnviar.disabled = true;
        btnEnviar.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enviando...';
        
        $.ajax({
            url: 'guardar_reto.php',
            method: 'POST',
            dataType: 'json',
            data: {
                pagina: <?php echo $pagina; ?>,
                respuesta_1: respuestasUsuario[1],
                respuesta_2: respuestasUsuario[2],
                respuesta_3: respuestasUsuario[3],
                respuesta_4: respuestasUsuario[4],
                respuesta_5: respuestasUsuario[5],
                respuesta_6: respuestasUsuario[6],
                respuestas_correctas: correctas,
                total_preguntas: totalPreguntas,
                porcentaje_acierto: porcentaje.toFixed(2),
                tiempo_segundos: tiempoSegundos
            },
            success: function(response) {
                console.log('✅ Respuesta:', response);
                mostrarResultado(correctas, totalPreguntas, porcentaje, aprobado, tiempoSegundos);
            },
            error: function(xhr, status, error) {
                console.error('❌ Error:', error);
                alert('❌ Error al guardar el reto.');
                btnEnviar.disabled = false;
                btnEnviar.innerHTML = textoOriginal;
            }
        });
    }
    
    function mostrarResultado(correctas, total, porcentaje, aprobado, tiempo) {
        const mensajeDiv = document.getElementById('mensajeResultado');
        const minutos = Math.floor(tiempo / 60);
        const segundos = tiempo % 60;
        const tiempoTexto = minutos > 0 ? `${minutos}m ${segundos}s` : `${segundos}s`;
        
        if (aprobado) {
            let mensaje = correctas === total ? '¡PERFECTO! 🎉 Acertaste todas' : '¡FELICITACIONES! 🎊';
            mensajeDiv.innerHTML = `
                <div style="background: linear-gradient(135deg, #43be16, #38a01c); color: white; padding: 2rem; border-radius: 15px;">
                    <i class="fas fa-trophy fa-3x mb-3" style="color: #FFD700;"></i>
                    <h3 class="mb-3"><b>${mensaje}</b></h3>
                    <h4 class="mb-3">Has aprobado el reto</h4>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <div style="background: rgba(255,255,255,0.2); padding: 1rem; border-radius: 10px;">
                                <h5>${correctas}/${total}</h5>
                                <small>Respuestas correctas</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="background: rgba(255,255,255,0.2); padding: 1rem; border-radius: 10px;">
                                <h5>${porcentaje.toFixed(1)}%</h5>
                                <small>Acierto</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="background: rgba(255,255,255,0.2); padding: 1rem; border-radius: 10px;">
                                <h5>${tiempoTexto}</h5>
                                <small>Tiempo</small>
                            </div>
                        </div>
                    </div>
                    <small>Redirigiendo en 5 segundos...</small>
                </div>
            `;
        } else {
            mensajeDiv.innerHTML = `
                <div style="background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; padding: 2rem; border-radius: 15px;">
                    <i class="fas fa-times-circle fa-3x mb-3"></i>
                    <h3 class="mb-3"><b>Reto No Aprobado</b></h3>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <h5>${correctas}/${total}</h5>
                            <small>Respuestas correctas</small>
                        </div>
                        <div class="col-md-6">
                            <h5>${porcentaje.toFixed(1)}%</h5>
                            <small>Acierto</small>
                        </div>
                    </div>
                    <p>Necesitas al menos 4 respuestas correctas de 6</p>
                    <button class="btn btn-light btn-lg mt-2" onclick="location.reload()">
                        <i class="fas fa-redo me-2"></i>Intentar de Nuevo
                    </button>
                </div>
            `;
        }
        
        mensajeDiv.style.display = 'block';
        mensajeDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        if (aprobado) {
            setTimeout(() => {
                if (<?php echo $pagina; ?> < <?php echo $total_paginas; ?> - 1) {
                    window.location.href = 'aprende.php?pagina=' + (<?php echo $pagina; ?> + 1);
                } else {
                    window.location.href = 'aprende.php?pagina=0';
                }
            }, 5000);
        }
    }
    
    $(document).ready(function() {
        $('.opcion-item').hover(
            function() { $(this).css('background', 'rgba(135, 206, 250, 0.2)'); },
            function() { $(this).css('background', 'transparent'); }
        );
        
        $('input[type="radio"]').change(function() {
            const pregunta = $(this).attr('name');
            $(`input[name="${pregunta}"]`).parent('.opcion-item').css({
                'background': 'transparent',
                'border-left': '0px'
            });
            $(this).parent('.opcion-item').css({
                'background': 'rgba(67, 190, 22, 0.15)',
                'border-left': '4px solid #43be16'
            });
        });
    });
    
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