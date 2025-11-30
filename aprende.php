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
        "texto" => "¡Lo que antes se botaba ahora puede convertirse en un recurso valioso para tu negocio: desde cascaras que se transforman en abono, hasta retazos que se convierten en nuevas creaciones.!",
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
                                <div style='background: linear-gradient(135deg, #43be16, #38a01c); color: #000033; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; font-weight: 900; box-shadow: 0 2px 8px rgba(67, 190, 22, 0.4); border: 1px solid rgba(0,0,0,0.2);'>
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
        "tipo" => "actividad_quiz",
        "texto" => "Ahora que ya aprendiste a <b>separar correctamente</b>, selecciona la opción adecuada para cada residuo.",
        "actividad_titulo" => "Reto del Tema: ¿Dónde lo pongo?",
        "actividad_instruccion" => "Ahora que conoces cómo separar tus residuos, te invitamos a practicar. <b>Selecciona la opción correcta para cada residuo. Necesitas las 3 respuestas correctas para aprobar.</b>",
        "fondo" => "img/separando_residuos.jpg",
        "preguntas" => [
            [
                "id" => 1,
                "categoria" => "Separación",
                "pregunta" => "🍌 ¿A dónde van las cáscaras de plátano?",
                "opciones" => [
                    "Orgánicos",
                    "Reciclaje",
                    "Reuso / Artesanías"
                ],
                "respuesta_correcta" => "Orgánicos"
            ],
            [
                "id" => 2,
                "categoria" => "Separación",
                "pregunta" => "🍾 ¿A dónde va una botella plástica limpia?",
                "opciones" => [
                    "Orgánicos",
                    "Reciclaje",
                    "Reuso / Artesanías"
                ],
                "respuesta_correcta" => "Reciclaje"
            ],
            [
                "id" => 3,
                "categoria" => "Separación",
                "pregunta" => "🧵 ¿A dónde van los retazos de tela?",
                "opciones" => [
                    "Orgánicos",
                    "Reciclaje",
                    "Reuso / Artesanías"
                ],
                "respuesta_correcta" => "Reuso / Artesanías"
            ]
        ]
    ],
    [
        "tipo" => "kit_compostaje",
        "titulo" => "Tu Kit de Compostaje Casero",
        "subtitulo" => "Transforma tus residuos orgánicos en abono natural",
        "texto" => "Este kit te permitirá transformar tus residuos orgánicos en <b>abono natural</b> para tus plantas o huerta. Aquí puedes ver todo lo que incluye.",
        "fondo" => "img/fondo_cafe_claro.jpg",
        "imagen_kit" => "img/kit_compostera[2].webp", // Foto grande del kit
        "componentes" => [
            [
                "numero" => "1",
                "titulo" => "Compostera plástica con tapa y aireación",
                "descripcion" => "Tu \"mini-fábrica\" de abono. Es transparente para que puedas ver el proceso.",
                "emoji" => "♻️",
                "color" => "#43be16"
            ],
            [
                "numero" => "2",
                "titulo" => "Acelerador Biológico",
                "descripcion" => "Polvo que acelera la descomposición y evita malos olores y mosquitos.",
                "emoji" => "⚗️",
                "color" => "#2196F3"
            ],
            [
                "numero" => "3",
                "titulo" => "Material Secante Vegetal",
                "descripcion" => "Absorbente natural que equilibra la humedad.",
                "emoji" => "🌾",
                "color" => "#FF9800"
            ],
            [
                "numero" => "4",
                "titulo" => "Maceta pequeña en fibra de coco",
                "descripcion" => "Para iniciar tu semillero.",
                "emoji" => "🪴",
                "color" => "#8B4513"
            ],
            [
                "numero" => "5",
                "titulo" => "Semillas agroecológicas (2 frascos)",
                "descripcion" => "Para que siembres usando tu nuevo compost.",
                "emoji" => "🌱",
                "color" => "#4CAF50"
            ],
            [
                "numero" => "6",
                "titulo" => "Herramientas de jardinería",
                "descripcion" => "Rastrillo, pala y trasplantador para mezclar y manejar tu compost.",
                "emoji" => "🛠️",
                "color" => "#607D8B"
            ]
        ]
    ],
    [
        "tipo" => "proceso_compostaje",
        "titulo" => "¡Compost Listo en 10 Días! Paso a Paso",
        "subtitulo" => "Guía práctica para transformar tus residuos en abono natural",
        "fondo" => "img/preparacion_abono.jpg",
        "pasos" => [
            [
                "numero" => "1",
                "titulo" => "Prepara tu compostera",
                "descripcion" => "Límpiala y ubícala en un lugar fresco y ventilado.",
                "emoji" => "🧹",
                "color" => "#2196F3"
            ],
            [
                "numero" => "2",
                "titulo" => "Primera capa",
                "descripcion" => "Pon una base de \"Material Secante Vegetal\".",
                "emoji" => "🌾",
                "color" => "#FF9800"
            ],
            [
                "numero" => "3",
                "titulo" => "Añade residuos orgánicos",
                "descripcion" => "Cáscaras, restos de frutas/verduras, café, pan. Pícalos.",
                "emoji" => "🍌",
                "color" => "#43be16"
            ],
            [
                "numero" => "4",
                "titulo" => "Agrega acelerador y material seco",
                "descripcion" => "Cubre cada capa de orgánicos con el acelerador y luego con \"Material Secante Vegetal\".",
                "emoji" => "⚗️",
                "color" => "#9C27B0"
            ],
            [
                "numero" => "5",
                "titulo" => "Mezcla suavemente",
                "descripcion" => "Usa las herramientas de tu kit cada 1–2 días.",
                "emoji" => "🛠️",
                "color" => "#607D8B"
            ],
            [
                "numero" => "6",
                "titulo" => "¡Compost listo!",
                "descripcion" => "Debe tener olor a tierra, color oscuro y no verse restos de comida.",
                "emoji" => "✨",
                "color" => "#4CAF50"
            ]
        ]
    ],
    [
        "tipo" => "soluciones_compostaje",
        "titulo" => "¿Un Reto con tu Compost? ¡Aquí la Solución!",
        "subtitulo" => "Guía de solución de problemas comunes",
        "fondo" => "img/preparacion_abono.jpg",
        "problemas" => [
            [
                "titulo" => "Mal olor",
                "emoji" => "🤢",
                "color" => "#e74c3c",
                "causa" => "Exceso de húmedo/nitrógeno, falta de aire.",
                "solucion" => "\"Los Increíbles de la Montaña\" y \"Seca Rápido\" están diseñados para esto. Si aún así huele, revisa si pusiste algo que no va o si necesitas más Seca Rápido."
            ],
            [
                "titulo" => "Mosquitos",
                "emoji" => "🦟",
                "color" => "#9C27B0",
                "causa" => "Residuos inadecuados, compost no cubierto.",
                "solucion" => "El acelerador y la capa seca los evitan. Cubre siempre bien tu compostera."
            ],
            [
                "titulo" => "Exceso de líquidos",
                "emoji" => "💧",
                "color" => "#2196F3",
                "causa" => "Demasiados materiales húmedos, falta de absorción.",
                "solucion" => "\"Seca Rápido\" absorbe la humedad. Asegúrate de usarlo bien."
            ]
        ],
        "actividad_reto" => [
            "titulo" => "Reto del Tema 4: ¡Mi Primer Paso con el Compost!",
            "descripcion" => "¡Es hora de empezar! Selecciona <b>al menos 3 residuos orgánicos</b> que planeas compostar primero con tu kit.",
            "items_compostables" => [
                ["id" => 1, "texto" => "Cáscaras de frutas y/o hortalizas", "emoji" => "🍌"],
                ["id" => 2, "texto" => "Borra de café", "emoji" => "☕"],
                ["id" => 3, "texto" => "Cereales y pan", "emoji" => "🍞"],
                ["id" => 4, "texto" => "Cáscaras de huevo", "emoji" => "🥚"],
                ["id" => 5, "texto" => "Filtros de papel de té y café", "emoji" => "📄"],
                ["id" => 6, "texto" => "Bolsitas de té", "emoji" => "🍵"],
                ["id" => 7, "texto" => "Residuos de jardín", "emoji" => "🍂"],
                ["id" => 8, "texto" => "Cartón y papel limpio", "emoji" => "📦"]
            ],
            "minimo_requerido" => 3
        ]
    ],
    [
        "tipo" => "reuso_reciclaje_timeline",
        "titulo" => "Reuso y Reciclaje: ¡Dale una Segunda Vida a Todo!",
        "subtitulo" => "El compostaje es solo el inicio. ¡Muchos otros residuos tienen una segunda oportunidad!",
        "fondo" => "img/imagen_fondo_verde.jpg",
        "categorias" => [
            [
                "titulo" => "Ideas Creativas para Gastronomía",
                "icono" => "🍽️",
                "color" => "#3498db",
                "ideas" => [
                    [
                        "numero" => "1",
                        "emoji" => "📦",
                        "titulo" => "Envases de Plástico",
                        "descripcion" => "Reutiliza envases limpios para guardar tus insumos, especias, harinas y otros ingredientes de manera organizada.",
                        "beneficio" => "Organización + Ahorro",
                        "color" => "#3498db",
                        "imagen" => "img/materos_plasticos.jpg" // ✅ FOTO AÑADIDA
                    ],
                    [
                        "numero" => "2",
                        "emoji" => "🍯",
                        "titulo" => "Frascos de Vidrio",
                        "descripcion" => "Perfectos para almacenar salsas caseras, conservas, aderezos o presentar productos gourmet para la venta.",
                        "beneficio" => "Presentación Premium",
                        "color" => "#e74c3c",
                        "imagen" => "img/ideas_frascos_vidrio.jpg" // ✅ FOTO AÑADIDA
                    ],
                    [
                        "numero" => "3",
                        "emoji" => "🛍️",
                        "titulo" => "Bolsas de Tela",
                        "descripcion" => "Crea bolsas reutilizables con telas recicladas para compras de insumos o entregar productos a clientes.",
                        "beneficio" => "Eco-friendly",
                        "color" => "#43be16",
                        "imagen" => "img/idea_bolsa_tela.jpg" // ✅ FOTO AÑADIDA
                    ]
                ]
            ],
            [
                "titulo" => "Ideas Creativas para Artesanías",
                "icono" => "🎨",
                "color" => "#9C27B0",
                "ideas" => [
                    [
                        "numero" => "4",
                        "emoji" => "🧵",
                        "titulo" => "Retazos de Tela",
                        "descripcion" => "Transforma sobrantes en nuevos diseños: accesorios, patchwork, bordados o productos textiles únicos.",
                        "beneficio" => "Creatividad infinita",
                        "color" => "#9C27B0",
                        "imagen" => "img/imagen_retazos_tela.jpg" // ✅ FOTO AÑADIDA
                    ],
                    [
                        "numero" => "5",
                        "emoji" => "💎",
                        "titulo" => "Plásticos Reciclados",
                        "descripcion" => "Dale nueva vida creando bisutería, decoraciones, macetas o elementos creativos para el hogar.",
                        "beneficio" => "Productos únicos",
                        "color" => "#FF5722",
                        "imagen" => "img/reutilizar_bolsas_plastico.webp" // ✅ FOTO AÑADIDA
                    ],
                    [
                        "numero" => "6",
                        "emoji" => "📐",
                        "titulo" => "Cartón Reciclado",
                        "descripcion" => "Crea maquetas, moldes, empaques personalizados o estructuras para tus productos artesanales.",
                        "beneficio" => "Versátil y económico",
                        "color" => "#8B4513",
                        "imagen" => "img/maqueta_empaque_carton.webp" // ✅ FOTO AÑADIDA
                    ]
                ]
            ]
        ],
        "mensaje_final" => [
            "titulo" => "¡La Creatividad No Tiene Límites!",
            "texto" => "Cada residuo que reutilizas es un paso hacia un emprendimiento más sostenible y rentable. ¡Sigue explorando nuevas formas de dar vida a los materiales!",
            "iconos_3r" => [
                ["emoji" => "♻️", "texto" => "Reduce", "color" => "#43be16"],
                ["emoji" => "🔄", "texto" => "Reutiliza", "color" => "#ffc107"],
                ["emoji" => "🌱", "texto" => "Recicla", "color" => "#2ecc71"]
            ]
        ]
    ],
    [
        "tipo" => "quiz_preguntas_respuestas",
        "titulo" => "Preguntas y Respuestas Comunes",
        "subtitulo" => "Pon a prueba tus conocimientos sobre economía circular",
        "fondo" => "img/imagen_preguntas_respuestas.jpg",
        "preguntas" => [
            // PREGUNTA 1
            [
                "id" => 1,
                "categoria" => "Compostaje",
                "emoji" => "⏱️",
                "pregunta" => "¿Cuánto tiempo tarda el compost con el acelerador biológico?",
                "opciones" => [
                    "10 días aproximadamente",
                    "2 a 4 meses",
                    "6 meses o más"
                ],
                "respuesta_correcta" => "10 días aproximadamente",
                "explicacion" => "Con el kit y el acelerador biológico, el compost está listo en <b>aproximadamente 10 días</b>. Sin acelerador puede tardar entre 2 y 4 meses."
            ],
            // PREGUNTA 2
            [
                "id" => 2,
                "categoria" => "Compostaje",
                "emoji" => "🍌",
                "pregunta" => "¿Puedo compostar cualquier resto de comida?",
                "opciones" => [
                    "Sí, todos los restos de comida",
                    "Solo frutas, verduras y restos vegetales",
                    "Solo carnes y lácteos"
                ],
                "respuesta_correcta" => "Solo frutas, verduras y restos vegetales",
                "explicacion" => "<b>NO todos los restos son aptos.</b> Puedes compostar: frutas, verduras, cáscaras, café, té, pan. <b>NO compostar:</b> carnes, lácteos, huesos, grasas, aceites."
            ],
            // PREGUNTA 3
            [
                "id" => 3,
                "categoria" => "Compostaje",
                "emoji" => "🐜",
                "pregunta" => "¿Qué hago si mi compost atrae hormigas?",
                "opciones" => [
                    "Agregar más agua",
                    "Cubrir con material secante y acelerador",
                    "Dejar al aire libre"
                ],
                "respuesta_correcta" => "Cubrir con material secante y acelerador",
                "explicacion" => "Las hormigas aparecen con exceso de azúcares o sequedad. <b>Solución:</b> Cubre bien con material secante, agrega más acelerador y tapa la compostera."
            ],
            // PREGUNTA 4
            [
                "id" => 4,
                "categoria" => "Reciclaje",
                "emoji" => "🧴",
                "pregunta" => "¿Debo lavar los envases antes de reciclarlos?",
                "opciones" => [
                    "No, se lavan en la planta de reciclaje",
                    "Sí, es fundamental lavarlos",
                    "Solo los de vidrio"
                ],
                "respuesta_correcta" => "Sí, es fundamental lavarlos",
                "explicacion" => "<b>Sí, es fundamental.</b> Los envases sucios contaminan todo el lote de reciclaje. Lávalos con agua y déjalos secar antes de reciclar."
            ],
            // PREGUNTA 5
            [
                "id" => 5,
                "categoria" => "Reciclaje",
                "emoji" => "🛢️",
                "pregunta" => "¿Qué hago con el aceite de cocina usado?",
                "opciones" => [
                    "Verterlo por el desagüe",
                    "Recolectarlo en botella y llevarlo a puntos de acopio",
                    "Tirarlo a la basura común"
                ],
                "respuesta_correcta" => "Recolectarlo en botella y llevarlo a puntos de acopio",
                "explicacion" => "<b>NUNCA lo viertas por el desagüe.</b> Un litro de aceite contamina hasta 1.000 litros de agua. Recolecta en botella y llévalo a puntos de acopio."
            ],
            // PREGUNTA 6
            [
                "id" => 6,
                "categoria" => "Reciclaje",
                "emoji" => "📄",
                "pregunta" => "¿El papel mojado o con grasa se puede reciclar?",
                "opciones" => [
                    "Sí, todo el papel es reciclable",
                    "No, la humedad y grasa lo contaminan",
                    "Solo el papel de oficina"
                ],
                "respuesta_correcta" => "No, la humedad y grasa lo contaminan",
                "explicacion" => "<b>NO.</b> El papel húmedo o con grasa (servilletas usadas, cajas de pizza sucias) no es reciclable. La humedad contamina las fibras."
            ],
            // PREGUNTA 7
            [
                "id" => 7,
                "categoria" => "Reuso",
                "emoji" => "🫙",
                "pregunta" => "¿Qué puedo hacer con frascos de vidrio?",
                "opciones" => [
                    "Solo tirarlos a la basura",
                    "Almacenar alimentos, crear velas, macetas",
                    "Nada, no son reutilizables"
                ],
                "respuesta_correcta" => "Almacenar alimentos, crear velas, macetas",
                "explicacion" => "Los frascos son <b>súper versátiles</b>: almacena especias, granos, salsas caseras, crea velas decorativas, macetas o envases premium."
            ],
            // PREGUNTA 8
            [
                "id" => 8,
                "categoria" => "Reuso",
                "emoji" => "🧵",
                "pregunta" => "¿Los retazos de tela pequeños sirven para algo?",
                "opciones" => [
                    "No, son demasiado pequeños",
                    "Sí, para parches, rellenos, bisutería",
                    "Solo para telas grandes"
                ],
                "respuesta_correcta" => "Sí, para parches, rellenos, bisutería",
                "explicacion" => "¡Absolutamente! Usa retazos para: parches decorativos, rellenos de cojines, bisutería textil, posavasos, bolsitas aromáticas o patchwork."
            ]
        ],
        "minimo_aprobacion" => 6 // De 8 preguntas, mínimo 6 correctas para aprobar
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
$height_bloque = '99vh';
if ($pagina == 2) { $height_bloque = '99vh'; }
if ($pagina == 3) { $height_bloque = '99vh'; } 
if ($pagina == 4) { $height_bloque = '99vh'; } 
if ($pagina == 5) { $height_bloque = '78vh'; } 
if ($pagina == 6) { $height_bloque = '99vh'; }
if ($pagina == 7) { $height_bloque = '99vh'; } 
if ($pagina == 8) { $height_bloque = '99vh'; }
if ($pagina == 9) { $height_bloque = '99vh'; }
if ($pagina == 10) { $height_bloque = '83vh'; } 
if ($pagina == 11) { $height_bloque = '75vh'; }
if ($pagina == 12) { $height_bloque = '70vh'; }
if ($pagina == 13) { $height_bloque = '80vh'; }
if ($pagina == 14) { $height_bloque = '70vh'; }
if ($pagina == 15) { $height_bloque = '70vh'; }
if ($pagina == 16) { $height_bloque = '70vh'; }
if ($pagina == 17) { $height_bloque = '70vh'; }

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
                font-size: 0.6rem !important;
            }
        }

        /* ESTILOS ESPECÍFICOS PARA CUADROS DE CATEGORÍAS EN MÓVILES */
        @media (max-width: 768px) {
            .cuadro-categoria {
                padding: 0.5rem !important;
                margin: 0.5rem auto !important;
                width: 98% !important;
                max-width: 100% !important;
            }
            
            .cuadro-categoria h3 {
                font-size: 0.95rem !important;
                margin-bottom: 0.5rem !important;
                line-height: 1.2 !important;
            }
            
            .cuadro-categoria h4 {
                font-size: 0.8rem !important;
                margin-bottom: 0.4rem !important;
            }
            
            .cuadro-categoria .row > div {
                padding: 0.3rem !important;
            }
            
            .cuadro-categoria ul.list-unstyled li {
                margin-bottom: 0.3rem !important;
                padding: 0.2rem !important;
            }
            
            .cuadro-categoria ul.list-unstyled li span:first-child {
                font-size: 1.1rem !important;
                margin-right: 0.4rem !important;
            }
            
            .cuadro-categoria ul.list-unstyled li span:last-child {
                font-size: 0.7rem !important;
                line-height: 1.2 !important;
            }
            
            .cuadro-categoria > div[style*="border-radius"] {
                padding: 0.4rem !important;
                min-height: 100px !important;
            }
        }

        @media (max-width: 576px) {
            .cuadro-categoria {
                padding: 0.4rem !important;
                margin: 0.4rem auto !important;
                border-width: 2px !important;
            }
            
            .cuadro-categoria h3 {
                font-size: 0.85rem !important;
                margin-bottom: 0.4rem !important;
            }
            
            .cuadro-categoria h4 {
                font-size: 0.75rem !important;
                margin-bottom: 0.3rem !important;
            }
            
            .cuadro-categoria ul.list-unstyled li {
                margin-bottom: 0.2rem !important;
                padding: 0.15rem !important;
            }
            
            .cuadro-categoria ul.list-unstyled li span:first-child {
                font-size: 1rem !important;
                margin-right: 0.3rem !important;
            }
            
            .cuadro-categoria ul.list-unstyled li span:last-child {
                font-size: 0.65rem !important;
                line-height: 1.15 !important;
            }
            
            .cuadro-categoria > div[style*="border-radius"] {
                padding: 0.3rem !important;
                border-radius: 8px !important;
                min-height: 80px !important;
            }
            
            .cuadro-categoria .fas {
                font-size: 0.7rem !important;
            }
        }

        @media (max-width: 480px) {
            .cuadro-categoria {
                padding: 0.3rem !important;
                margin: 0.3rem auto !important;
            }
            
            .cuadro-categoria h3 {
                font-size: 0.8rem !important;
            }
            
            .cuadro-categoria h4 {
                font-size: 0.7rem !important;
            }
            
            .cuadro-categoria ul.list-unstyled li span:first-child {
                font-size: 0.9rem !important;
            }
            
            .cuadro-categoria ul.list-unstyled li span:last-child {
                font-size: 0.6rem !important;
            }
        }
        /* Efectos hover para las opciones */
        .opcion-pregunta:hover {
            background-color: rgba(67, 190, 22, 0.1) !important;
            border-color: #43be16 !important;
            transform: translateX(5px);
        }

        .opcion-pregunta input:checked ~ label {
            color: #43be16 !important;
            font-weight: 900 !important;
        }

        .opcion-pregunta:has(input:checked) {
            background-color: rgba(67, 190, 22, 0.15) !important;
            border-color: #43be16 !important;
            border-width: 3px !important;
        }

        /* Retroalimentación correcta */
        .retroalimentacion-correcta {
            background: rgba(67, 190, 22, 0.9) !important;
            border: 3px solid #43be16;
            color: #001122;
        }

        /* Retroalimentación incorrecta */
        .retroalimentacion-incorrecta {
            background: rgba(231, 76, 60, 0.9) !important;
            border: 3px solid #e74c3c;
            color: white;
        }
        /* Compactar contenido y navegación en móviles */
        @media (max-width: 768px) {
            .container-fluid.header-aprende,
            .container-fluid.header-aprende .row,
            .container-fluid.header-aprende .col-12.col-lg-11.mx-auto.px-3.py-4.d-flex.flex-column {
                min-height: unset !important;
                height: auto !important;
                padding-bottom: 0.3rem !important;
            }
            .cuadro-texto {
                margin-bottom: 0.3rem !important;
            }
            .container-fluid.header-aprende .container-fluid.px-0 {
                margin-top: 0 !important;
                margin-bottom: 0 !important;
                padding-bottom: 0 !important;
            }
            .footer {
                margin-top: 0 !important;
                padding-top: 1rem !important;
            }
        }
        @media (max-width: 768px) {
            /* SOLO en la página 6 */
            body[data-pagina="6"] .header-aprende .col-12.col-lg-10.mx-auto.px-3.py-4.d-flex.flex-column {
                background: transparent !important;
                box-shadow: none !important;
                border: none !important;
            }
            body[data-pagina="6"] .header-aprende .d-flex.justify-content-start,
            body[data-pagina="6"] .header-aprende .d-flex.justify-content-start.mt-3.px-2 {
                background: transparent !important;
                box-shadow: none !important;
                border: none !important;
            }
        }
        @media (max-width: 992px) {
            /* Elimina fondo oscuro en TODOS los bloques de navegación */
            .d-flex.justify-content-between.align-items-end,
            .d-flex.justify-content-start,
            .d-flex.justify-content-between.align-items-center,
            .d-flex.justify-content-between,
            .d-flex.justify-content-center {
                background: transparent !important;
                box-shadow: none !important;
                border: none !important;
            }
        }
        @media (max-width: 768px) {
            body[data-pagina="6"] .header-aprende .col-12.col-lg-10.mx-auto.px-3.py-4.d-flex.flex-column,
            body[data-pagina="7"] .header-aprende .col-12.col-lg-10.mx-auto.px-3.py-4.d-flex.flex-column {
                min-height: 100vh !important;
                max-height: 100vh !important;
                display: flex !important;
                flex-direction: column !important;
                overflow-y: auto !important;
            }
            body[data-pagina="6"] .header-aprende .d-flex.justify-content-start,
            body[data-pagina="7"] .header-aprende .d-flex.justify-content-start {
                margin-top: auto !important;
                padding-bottom: 0.5rem !important;
            }
            /* Opcional: reduce el padding de los cuadros para liberar espacio */
            body[data-pagina="6"] .cuadro-texto,
            body[data-pagina="7"] .cuadro-texto,
            body[data-pagina="6"] .cuadro-actividad,
            body[data-pagina="7"] .cuadro-actividad {
                padding: 0.7rem 0.5rem !important;
                margin-bottom: 0.2rem !important;
                max-width: 98vw !important;
            }
        }
    </style>
</head>

<body data-pagina="<?php echo $pagina; ?>" style="padding-top:75px;">
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
                    $nombre_usuario = '';
                    $sql_nombre = "SELECT nombre_completo FROM usuarios WHERE numero_documento = ?";
                    $stmt_nombre = $conn->prepare($sql_nombre);
                    $stmt_nombre->bind_param("s", $_SESSION['numero_documento']);
                    $stmt_nombre->execute();
                    $res_nombre = $stmt_nombre->get_result();
                    if ($row_nombre = $res_nombre->fetch_assoc()) {
                        $nombre_usuario = $row_nombre['nombre_completo'];
                    }
                    $stmt_nombre->close();
                    echo '<a href="perfil.php" class="nav-item nav-link fw-bold'.($pagina_activa === 'perfil' ? ' active text-primary' : ' text-dark').'" style="color:#43be16 !important;font-weight:bold !important;">'.($nombre_usuario ? htmlspecialchars($nombre_usuario) : 'Perfil').'</a>';
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
        style="position: relative; background-image: url('<?php echo $cartilla[$pagina]['fondo']; ?>'); background-size: cover; background-position: center; min-height: 100vh;">
        <div class="container-fluid pt-0 m-0 contenido-header" style="background: transparent;">
            <div class="row g-0 justify-content-center mt-4">    
                <div class="col-12 col-lg-10 mx-auto px-0">
                    <h1 class="display-3 text-white animated slideInDown mb-5 mt-4 text-center">
                        <?php echo $cartilla[$pagina]['titulo']; ?>
                    </h1>
                    <h2 class="text-white mb-5 mt-4 text-center">
                        <?php echo $cartilla[$pagina]['subtitulo']; ?>
                    </h2>
                        <!-- Frase central eliminada para evitar duplicado -->
                    <div class="text-end boton-siguiente-margen" style="padding-right: 1rem;">
                        <div class="d-block d-sm-none" style="width: 100%; text-align: right; margin-bottom: 0.5rem;">
                            <a href="aprende.php?pagina=1" class="btn btn-lg text-white" style="background-color: #43be16; position: absolute; right: 40px; bottom: 60px; z-index: 1100;">
                                Siguiente <i class="fa fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                        <div class="d-none d-sm-block" style="position: absolute; right: 120px; top: 87%; transform: translateY(-50%); z-index: 1100;">
                            <a href="aprende.php?pagina=1" class="btn btn-lg text-white" style="background-color: #43be16;">
                                Siguiente <i class="fa fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="position: absolute; right: 160px; bottom: 10px; display: flex; align-items: center; margin: 0;">
            <h3 class="mb-0 header-aprende-h3 text-end d-none d-sm-block" style="font-size: 2rem; color: #fff !important; font-weight: 900; margin: 0; background: none !important; padding: 0; border-radius: 0; opacity: 1 !important; filter: none !important; text-shadow: 0 0 0 #fff !important; mix-blend-mode: normal !important; max-width: none !important; position: relative; z-index: 1000;">
                 <?php echo $cartilla[$pagina]['frase']; ?>
             </h3>
        </div>
        <img src="<?php echo $cartilla[$pagina]['logo']; ?>" alt="Logo SENA" class="logo-sena-header" style="height: 100px; position: absolute; right: 40px; bottom: 10px; margin: 0;">
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
                <div class="col-12 col-lg-11 mx-auto px-3 pt-3 pb-2">
                    <div class="cuadro-texto text-center mb-2" style="padding: 0.8rem 1.5rem; max-width: 1100px; margin: 0 auto;">
                        <?php if (isset($cartilla[$pagina]['titulo'])): ?>
                            <h1 class="mb-2" style="font-size: clamp(1.3rem, 3.5vw, 1.8rem); line-height: 1.3; color: #001122; font-weight: 900;">
                                <?php echo $cartilla[$pagina]['titulo']; ?>
                            </h1>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-12 col-lg-8 mx-auto px-4 d-flex flex-column justify-content-end" style="height: <?php echo $height_bloque; ?>;"> 
                    <?php if (isset($cartilla[$pagina]['texto'])): ?>
                        <div class="cuadro-texto mx-auto">
                            <div class="texto-contenido text-center">
                                <?php echo $texto_con_iconos; ?>
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
                    
                    <div class="d-flex justify-content-start mt-3 px-2" style="flex-shrink: 0;">
                        <a href="aprende.php?pagina=<?php echo $pagina-1; ?>" class="btn btn-lg text-white shadow-sm" style="background-color: #43be16; z-index: 10; min-width: 120px;">
                            <i class="fa fa-arrow-left me-2"></i> Anterior
                        </a>
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
            min-height: 100vh;
            padding-bottom: 0.5rem;">
            
            
        <div class="container-fluid h-100 p-0">
            <div class="row g-0 justify-content-center" style="height: 100vh;">
                <!-- Títulos con fondo semitransparente - MÁS COMPACTO -->
                <div class="col-12 col-lg-11 mx-auto px-3 pt-2">
                    <div class="cuadro-texto text-center mb-1" style="padding: 0.5rem 1rem; max-width: 1100px; margin: 0 auto;">
                        <h1 class="mb-1" style="font-size: clamp(1.2rem, 3.3vw, 1.6rem); line-height: 1.2; color: #001122; font-weight: 900;">
                            <?php echo $cartilla[$pagina]['titulo']; ?>
                        </h1>
                        <h3 class="mb-0" style="font-size: clamp(0.9rem,  2vw, 1.1rem); font-weight: 700; color: #003366;">
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
                    <div class="d-flex justify-content-between align-items-end mt-2" style="padding: 0;">
                        <a href="aprende.php?pagina=<?php echo $pagina-1; ?>" 
                        class="btn btn-lg text-white" 
                        style="background-color: #43be16; 
                                z-index: 10; 
                                padding: 0.4rem 0.85rem; 
                                font-size: clamp(0.8rem, 1.8vw, 0.95rem);">
                            <i class="fa fa-arrow-left me-1"></i> Anterior
                        </a>
                        
                        <div class="text-white text-center d-none d-md-block" 
                            style="font-size: clamp(0.7rem, 1.3vw, 0.85rem); 
                                    text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">
                            Página <?php echo $pagina+1; ?> de <?php echo $total_paginas; ?>
                        </div>
                        
                        <div class="d-flex align-items-end">
                            <?php if ($pagina < $total_paginas-1): ?>
                                <a href="aprende.php?pagina=<?php echo $pagina+1; ?>" 
                                class="btn btn-lg text-white" 
                                style="background-color: #43be16; 
                                        z-index: 10; 
                                        padding: 0.4rem 0.85rem; 
                                        font-size: clamp(0.8rem, 1.8vw, 0.95rem);">
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
    <!-- PÁGINA 11: SEPARACIÓN DE RECICLABLES -->
    <div class="container-fluid header-aprende"
        style="position: relative;
            background-image: url('<?php echo $cartilla[$pagina]['fondo']; ?>');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            padding-bottom: 0.5rem;">
            
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
                    <!-- Cuadros por categoría -->
                    <?php foreach ($cartilla[$pagina]['categorias'] as $categoria): ?>
                        <div class="cuadro-texto mx-auto mb-3" style="max-width: 1250px; padding: 1.2rem; width: 98%; background: rgba(255, 255, 255, 0.35) !important; border: 3px solid <?php echo $categoria['color']; ?>; box-shadow: 0 8px 20px rgba(0,0,0,0.2);">
                            <h3 class="text-center mb-3" style="font-size: clamp(1.1rem, 3vw, 1.6rem); color: <?php echo $categoria['color']; ?>; line-height: 1.3; font-weight: 900; text-shadow: 3px 3px 8px rgba(255,255,255,1);">
                                <?php echo $categoria['titulo']; ?>
                            </h3>
                            <div class="row g-3">
                                <?php if (isset($categoria['columna_izq'])): ?>
                                    <div class="col-md-6">
                                        <div style="background: rgba(255, 255, 255, 0.95); padding: 1rem; border-radius: 12px; border: 2px solid <?php echo $categoria['color']; ?>; height: 100%; min-height: 200px;">
                                            <h4 class="mb-3 text-center" style="color: <?php echo $categoria['color']; ?>; font-weight: 800; font-size: clamp(0.95rem, 2.1vw, 1.2rem);">
                                                <i class="fas fa-check-circle me-2"></i><?php echo $categoria['columna_izq']['titulo']; ?>
                                            </h4>
                                            <ul class="list-unstyled mb-0">
                                                <?php foreach ($categoria['columna_izq']['items'] as $item): ?>
                                                    <li class="mb-2 d-flex align-items-start" style="padding: 0.5rem; border-radius: 8px; background: rgba(255,255,255,0.5);">
                                                        <span style="font-size: clamp(1rem, 2.1vw, 1.25rem); margin-right: 0.4rem; flex-shrink: 0;"><?php echo $item['emoji']; ?></span>
                                                        <span style="color: #001122; font-weight: 700; font-size: clamp(0.85rem, 1.9vw, 1.05rem); line-height: 1.4;"><?php echo $item['texto']; ?></span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($categoria['columna_der'])): ?>
                                    <div class="col-md-6">
                                        <div style="background: rgba(255, 255, 255, 0.95); padding: 1rem; border-radius: 12px; border: 2px solid <?php echo $categoria['columna_der']['color_borde'] ?? '#003366'; ?>; height: 100%; min-height: 200px;">
                                            <h4 class="mb-3 text-center" style="color: <?php echo $categoria['columna_der']['color_borde'] ?? '#003366'; ?>; font-weight: 800; font-size: clamp(0.95rem, 2.1vw, 1.2rem);">
                                                <i class="fas fa-info-circle me-2"></i><?php echo $categoria['columna_der']['titulo']; ?>
                                            </h4>
                                            <ul class="list-unstyled mb-0">
                                                <?php foreach ($categoria['columna_der']['items'] as $item): ?>
                                                    <li class="mb-2 d-flex align-items-start" style="padding: 0.5rem; border-radius: 8px; background: rgba(255,255,255,0.5);">
                                                        <span style="font-size: clamp(1rem, 2.1vw, 1.25rem); margin-right: 0.4rem; flex-shrink: 0;"><?php echo $item['emoji']; ?></span>
                                                        <span style="color: #001122; font-weight: 700; font-size: clamp(0.85rem, 1.9vw, 1.05rem); line-height: 1.4;"><?php echo $item['texto']; ?></span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($categoria['columna_unica'])): ?>
                                    <div class="col-12">
                                        <div style="background: rgba(255, 255, 255, 0.95); padding: 1rem; border-radius: 12px; border: 2px solid <?php echo $categoria['color']; ?>;">
                                            <h4 class="mb-3 text-center" style="color: <?php echo $categoria['color']; ?>; font-weight: 800; font-size: clamp(0.95rem, 2.1vw, 1.2rem);">
                                                <i class="fas fa-lightbulb me-2"></i><?php echo $categoria['columna_unica']['titulo']; ?>
                                            </h4>
                                            <ul class="list-unstyled mb-0">
                                                <?php foreach ($categoria['columna_unica']['items'] as $item): ?>
                                                    <li class="mb-2 d-flex align-items-start" style="padding: 0.5rem; border-radius: 8px; background: rgba(255,255,255,0.5);">
                                                        <span style="font-size: clamp(1rem, 2.1vw, 1.25rem); margin-right: 0.4rem; flex-shrink: 0;"><?php echo $item['emoji']; ?></span>
                                                        <span style="color: #001122; font-weight: 700; font-size: clamp(0.85rem, 1.9vw, 1.05rem); line-height: 1.4;"><?php echo $item['texto']; ?></span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <!-- Navegación -->
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
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php elseif ($cartilla[$pagina]['tipo'] === 'kit_compostaje'): ?>
    <!-- PÁGINA 13: KIT DE COMPOSTAJE CASERO CON LÍNEA DE TIEMPO -->
    <div class="container-fluid header-aprende"
        style="position: relative;
            background-image: url('<?php echo $cartilla[$pagina]['fondo']; ?>');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            padding-bottom: 0.5rem;">
            
        <div class="container-fluid h-100 p-0">
            <div class="row g-0 justify-content-center">
                <!-- Títulos principales -->
                <div class="col-12 col-lg-11 mx-auto px-3 pt-3 pb-2">
                    <div class="cuadro-texto text-center mb-2" style="padding: 0.8rem 1.5rem; max-width: 1100px; margin: 0 auto;">
                        <h1 class="mb-2" style="font-size: clamp(1.3rem, 3.5vw, 1.8rem); line-height: 1.3; color: #001122; font-weight: 900;">
                            <span style="font-size: clamp(1.8rem, 4vw, 2.3rem); margin-right: 0.5rem;">♻️</span>
                            <?php echo $cartilla[$pagina]['titulo']; ?>
                        </h1>
                        <h3 class="mb-0" style="font-size: clamp(1rem, 2.2vw, 1.3rem); font-weight: 700; color: #003366;">
                            <?php echo $cartilla[$pagina]['subtitulo']; ?>
                        </h3>
                    </div>
                </div>
                
                <!-- Contenido principal -->
                <div class="col-12 col-lg-11 mx-auto px-3">
                    <!-- Texto introductorio -->
                    <div class="cuadro-texto mx-auto mb-3" style="max-width: 1150px; padding: 0.8rem 1.2rem; width: 95%;">
                        <div class="texto-contenido text-center" style="font-size: clamp(0.85rem, 1.8vw, 1rem); line-height: 1.4;">
                            <?php echo $cartilla[$pagina]['texto']; ?>
                        </div>
                    </div>
                    
                    <!-- IMAGEN GRANDE DEL KIT COMPLETO -->
                    <?php if (isset($cartilla[$pagina]['imagen_kit'])): ?>
                    <div class="cuadro-texto mx-auto mb-4" style="max-width: 900px; padding: 1rem; width: 95%; background: rgba(255, 255, 255, 0.45) !important;">
                        <div class="text-center">
                            <img src="<?php echo $cartilla[$pagina]['imagen_kit']; ?>" 
                                alt="Kit de Compostaje Completo" 
                                class="img-fluid" 
                                style="max-height: 350px; border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.3); border: 3px solid #43be16;">
                            <p class="mt-2 mb-0" style="font-size: clamp(0.75rem, 1.6vw, 0.9rem); color: #001122; font-weight: 700;">
                                <i class="fas fa-box-open me-2"></i>Kit Completo de Compostaje Casero
                            </p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- TÍTULO DE COMPONENTES -->
                    <div class="cuadro-texto mx-auto mb-3" style="max-width: 1150px; padding: 0.6rem 1rem; width: 95%; background: rgba(67, 190, 22, 0.35) !important; border: 2px solid #43be16;">
                        <h2 class="text-center mb-0" style="font-size: clamp(1.1rem, 2.8vw, 1.5rem); color: #001122; font-weight: 900;">
                            <i class="fas fa-list-ul me-2"></i>Componentes del Kit
                        </h2>
                    </div>
                    
                    <!-- LÍNEA DE TIEMPO VISUAL DE COMPONENTES -->
                    <div class="row g-3 px-2 position-relative">
                        <!-- Línea vertical conectora (solo desktop) -->
                        <div class="d-none d-md-block position-absolute" style="left: 50%; top: 50px; bottom: 50px; width: 4px; background: linear-gradient(180deg, #43be16 0%, #2196F3 25%, #FF9800 50%, #8B4513 75%, #4CAF50 100%); transform: translateX(-50%); z-index: 0; border-radius: 10px;"></div>
                        
                        <?php foreach ($cartilla[$pagina]['componentes'] as $index => $componente): 
                            $isLeft = ($index % 2 == 0);
                        ?>
                        <!-- COMPONENTE <?php echo $componente['numero']; ?> -->
                        <div class="col-12">
                            <div class="row g-0 align-items-center position-relative" style="z-index: 1;">
                                <!-- Contenido del componente (alterna izquierda/derecha en desktop) -->
                                <div class="col-md-5 <?php echo $isLeft ? 'order-md-1' : 'order-md-2 offset-md-1'; ?>">
                                    <div class="cuadro-texto h-100" style="padding: 1.2rem; background: rgba(255, 255, 255, 0.45) !important; border: 3px solid <?php echo $componente['color']; ?>; border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.3); position: relative;">
                                        <!-- Flecha apuntando al círculo (solo desktop) -->
                                        <div class="d-none d-md-block position-absolute" style="<?php echo $isLeft ? 'right: -20px;' : 'left: -20px;'; ?> top: 50%; transform: translateY(-50%); width: 0; height: 0; border-top: 15px solid transparent; border-bottom: 15px solid transparent; <?php echo $isLeft ? 'border-left: 20px solid ' . $componente['color'] : 'border-right: 20px solid ' . $componente['color']; ?>;"></div>
                                        
                                        <!-- Emoji y título -->
                                        <div class="d-flex align-items-center mb-2">
                                            <span style="font-size: clamp(2rem, 4vw, 2.5rem); margin-right: 0.8rem; filter: drop-shadow(3px 3px 6px rgba(0,0,0,0.3));">
                                                <?php echo $componente['emoji']; ?>
                                            </span>
                                            <h3 class="mb-0" style="font-size: clamp(1rem, 2.3vw, 1.3rem); color: #001122; font-weight: 900; line-height: 1.2; text-shadow: 2px 2px 4px rgba(255,255,255,1);">
                                                <?php echo $componente['numero']; ?>. <?php echo $componente['titulo']; ?>
                                            </h3>
                                        </div>
                                        
                                        <!-- Descripción -->
                                        <p class="mb-0" style="font-size: clamp(0.85rem, 1.8vw, 1rem); color: #001122; font-weight: 700; line-height: 1.4; text-shadow: 1px 1px 3px rgba(255,255,255,0.9);">
                                            <?php echo $componente['descripcion']; ?>
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Círculo numerado en el centro (solo desktop) -->
                                <div class="d-none d-md-flex col-md-2 justify-content-center align-items-center order-md-1" style="z-index:  10;">
                                    <div style="background: <?php echo $componente['color']; ?>; 
                                                    color: white; 
                                                    width: 60px; height: 60px; 
                                                    border-radius: 50%; 
                                                    display: flex; 
                                                    align-items: center; 
                                                    justify-content: center; 
                                                    font-weight: 900; 
                                                    font-size: 1.8rem; 
                                                    box-shadow: 0 6px 15px rgba(0,0,0,0.4); 
                                                    border: 4px solid white;">
                                        <?php echo $componente['numero']; ?>
                                    </div>
                                </div>
                                
                                <!-- Espacio vacío en el otro lado (solo desktop) -->
                                <div class="d-none d-md-block col-md-5 <?php echo $isLeft ? 'order-md-2' : 'order-md-1'; ?>"></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Nota final motivacional -->
                    <div class="cuadro-texto mx-auto mt-4 mb-3" style="max-width: 1150px; padding: 1rem 1.5rem; width: 95%; background: rgba(67, 190, 22, 0.4) !important; border: 3px solid #43be16;">
                        <div class="text-center">
                            <h4 class="mb-2" style="font-size: clamp(1rem, 2.3vw, 1.3rem); color: #001122; font-weight: 900;">
                                <i class="fas fa-seedling me-2"></i>¡Todo listo para comenzar!
                            </h4>
                            <p class="mb-0" style="font-size: clamp(0.85rem, 1.8vw, 1rem); color: #001122; font-weight: 700; line-height: 1.4;">
                                Con este kit completo podrás transformar tus residuos orgánicos en abono natural en solo 10 días. <b>¡Estás lista para cuidar el planeta!</b> 🌱♻️
                            </p>
                        </div>
                    </div>
                    
                    <!-- Navegación -->
                    <div class="container-fluid px-0 mt-3 mb-0">
                        <div class="row g-0">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center px-3 py-2" style="background: transparent; border-radius: 10px; max-width: 100%;">
                                    <!-- Botón Anterior -->
                                    <a href="aprende.php?pagina=<?php echo $pagina-1; ?>" 
                                    class="btn btn-lg text-white" 
                                    style="background-color: #43be16; 
                                            padding: 0.6rem 1.2rem; 
                                            font-size: clamp(0.9rem, 2vw, 1rem);
                                            flex-shrink: 0;">
                                        <i class="fa fa-arrow-left me-2"></i> Anterior
                                    </a>
                                    
                                    <!-- Indicador de página (solo desktop) -->
                                    <div class="text-white text-center flex-grow-1 d-none d-md-block" 
                                        style="font-size: clamp(0.75rem, 1.4vw, 0.9rem); 
                                                text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
                                                padding: 0 1rem;">
                                        Página <?php echo $pagina+1; ?> de <?php echo $total_paginas; ?>
                                    </div>
                                    
                                    <!-- Botón Siguiente -->
                                    <?php if ($pagina < $total_paginas-1): ?>
                                        <a href="aprende.php?pagina=<?php echo $pagina+1; ?>" 
                                        class="btn btn-lg text-white" 
                                        style="background-color: #43be16; 
                                                padding: 0.6rem 1.2rem; 
                                                font-size: clamp(0.9rem, 2vw, 1rem);
                                                flex-shrink: 0;">
                                            Siguiente <i class="fa fa-arrow-right ms-2"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="aprende.php?pagina=0" 
                                        class="btn btn-lg text-white" 
                                        style="background-color: #003d82; 
                                                padding: 0.6rem 1.2rem; 
                                                font-size: clamp(0.9rem, 2vw, 1rem);
                                                flex-shrink: 0;">
                                            <i class="fa fa-home me-2"></i> Inicio
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php elseif ($cartilla[$pagina]['tipo'] === 'proceso_compostaje'): ?>
    <!-- PÁGINA 14: PROCESO DE COMPOSTAJE PASO A PASO -->
    <div class="container-fluid header-aprende"
        style="position: relative;
            background-image: url('img/preparacion_abono.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            padding-bottom: 0.5rem;">

        <div class="container-fluid h-100 p-0">
            <div class="row g-0 justify-content-center">
                <!-- Títulos principales -->
                <div class="col-12 col-lg-11 mx-auto px-3 pt-3 pb-2">
                    <div class="cuadro-texto text-center mb-2" style="padding: 0.8rem 1.5rem; max-width: 1100px; margin: 0 auto;">
                        <h1 class="mb-2" style="font-size: clamp(1.3rem, 3.5vw, 1.8rem); line-height: 1.3; color: #001122; font-weight: 900;">
                            <span style="font-size: clamp(1.8rem, 4vw, 2.3rem); margin-right: 0.5rem;">⏱️</span>
                            ¡Compost Listo en 10 Días! Paso a Paso
                        </h1>
                        <h3 class="mb-0" style="font-size: clamp(1rem, 2.2vw, 1.3rem); font-weight: 700; color: #003366;">
                            Guía práctica para transformar tus residuos en abono natural
                        </h3>
                    </div>
                </div>
                <!-- Contenido principal -->
                <div class="col-12 col-lg-11 mx-auto px-3">
                    <!-- LÍNEA DE TIEMPO VISUAL -->
                    <div class="row g-3 px-2 position-relative">
                        <!-- Línea vertical conectora (solo desktop) -->
                        <div class="d-none d-md-block position-absolute" style="left: 50%; top: 50px; bottom: 50px; width: 4px; background: linear-gradient(180deg, #43be16 0%, #2196F3 50%, #4CAF50 100%); transform: translateX(-50%); z-index: 0; border-radius: 10px;"></div>
                        
                        <!-- PASO 1 -->
                        <div class="col-12">
                            <div class="row g-0 align-items-center position-relative" style="z-index: 1;">
                                <div class="col-md-5 order-md-1">
                                    <div class="cuadro-texto h-100" style="padding: 1.2rem; background: rgba(255,255,255,0.45) !important; border: 3px solid #2196F3; border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.3); position: relative;">
                                        <div class="d-none d-md-block position-absolute" style="right: -20px; top: 50%; transform: translateY(-50%); width: 0; height: 0; border-top: 15px solid transparent; border-bottom: 15px solid transparent; border-left: 20px solid #2196F3;"></div>
                                        <div class="d-flex align-items-center mb-2">
                                            <span style="font-size: clamp(2rem, 4vw, 2.5rem); margin-right: 0.8rem; filter: drop-shadow(3px 3px 6px rgba(0,0,0,0.3));">🧹</span>
                                            <h3 class="mb-0" style="font-size: clamp(1rem, 2.3vw, 1.3rem); color: #001122; font-weight: 900; line-height: 1.2; text-shadow: 2px 2px 4px rgba(255,255,255,1);">Paso 1: Prepara tu compostera</h3>
                                        </div>
                                        <p class="mb-0" style="font-size: clamp(0.85rem, 1.8vw, 1rem); color: #001122; font-weight: 700; line-height: 1.4; text-shadow: 1px 1px 3px rgba(255,255,255,0.9);">Límpiala y ubícala en un lugar fresco y ventilado.</p>
                                    </div>
                                </div>
                                <div class="d-none d-md-flex col-md-2 justify-content-center align-items-center order-md-1" style="z-index: 10;">
                                    <div style="background: #2196F3; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.8rem; box-shadow: 0 6px 15px rgba(0,0,0,0.4); border: 4px solid white;">1</div>
                                </div>
                                <div class="d-none d-md-block col-md-5 order-md-2"></div>
                            </div>
                        </div>
                        <!-- PASO 2 -->
                        <div class="col-12">
                            <div class="row g-0 align-items-center position-relative" style="z-index: 1;">
                                <div class="col-md-5 order-md-2 offset-md-1">
                                    <div class="cuadro-texto h-100" style="padding: 1.2rem; background: rgba(255,255,255,0.45) !important; border: 3px solid #FF9800; border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.3); position: relative;">
                                        <div class="d-none d-md-block position-absolute" style="left: -20px; top: 50%; transform: translateY(-50%); width: 0; height: 0; border-top: 15px solid transparent; border-bottom: 15px solid transparent; border-right: 20px solid #FF9800;"></div>
                                        <div class="d-flex align-items-center mb-2">
                                            <span style="font-size: clamp(2rem, 4vw, 2.5rem); margin-right: 0.8rem; filter: drop-shadow(3px 3px 6px rgba(0,0,0,0.3));">🌾</span>
                                            <h3 class="mb-0" style="font-size: clamp(1rem, 2.3vw, 1.3rem); color: #001122; font-weight: 900; line-height: 1.2; text-shadow: 2px 2px 4px rgba(255,255,255,1);">Paso 2: Primera capa</h3>
                                        </div>
                                        <p class="mb-0" style="font-size: clamp(0.85rem, 1.8vw, 1rem); color: #001122; font-weight: 700; line-height: 1.4; text-shadow: 1px 1px 3px rgba(255,255,255,0.9);">Pon una base de \"Material Secante Vegetal\".</p>
                                    </div>
                                </div>
                                <div class="d-none d-md-flex col-md-2 justify-content-center align-items-center order-md-1" style="z-index: 10;">
                                    <div style="background: #FF9800; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.8rem; box-shadow: 0 6px 15px rgba(0,0,0,0.4); border: 4px solid white;">2</div>
                                </div>
                                <div class="d-none d-md-block col-md-5 order-md-1"></div>
                            </div>
                        </div>
                        <!-- PASO 3 -->
                        <div class="col-12">
                            <div class="row g-0 align-items-center position-relative" style="z-index: 1;">
                                <div class="col-md-5 order-md-1">
                                    <div class="cuadro-texto h-100" style="padding: 1.2rem; background: rgba(255,255,255,0.45) !important; border: 3px solid #43be16; border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.3); position: relative;">
                                        <div class="d-none d-md-block position-absolute" style="right: -20px; top: 50%; transform: translateY(-50%); width: 0; height: 0; border-top: 15px solid transparent; border-bottom: 15px solid transparent; border-left: 20px solid #43be16;"></div>
                                        <div class="d-flex align-items-center mb-2">
                                            <span style="font-size: clamp(2rem, 4vw, 2.5rem); margin-right: 0.8rem; filter: drop-shadow(3px 3px 6px rgba(0,0,0,0.3));">🍌</span>
                                            <h3 class="mb-0" style="font-size: clamp(1rem, 2.3vw, 1.3rem); color: #001122; font-weight: 900; line-height: 1.2; text-shadow: 2px 2px 4px rgba(255,255,255,1);">Paso 3: Añade residuos orgánicos</h3>
                                        </div>
                                        <p class="mb-0" style="font-size: clamp(0.85rem, 1.8vw, 1rem); color: #001122; font-weight: 700; line-height: 1.4; text-shadow: 1px 1px 3px rgba(255,255,255,0.9);">Cáscaras, restos de frutas/verduras, café, pan. Pícalos.</p>
                                    </div>
                                </div>
                                <div class="d-none d-md-flex col-md-2 justify-content-center align-items-center order-md-1" style="z-index: 10;">
                                    <div style="background: #43be16; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.8rem; box-shadow: 0 6px 15px rgba(0,0,0,0.4); border: 4px solid white;">3</div>
                                </div>
                                <div class="d-none d-md-block col-md-5 order-md-2"></div>
                            </div>
                        </div>
                        <!-- PASO 4 -->
                        <div class="col-12">
                            <div class="row g-0 align-items-center position-relative" style="z-index: 1;">
                                <div class="col-md-5 order-md-2 offset-md-1">
                                    <div class="cuadro-texto h-100" style="padding: 1.2rem; background: rgba(255,255,255,0.45) !important; border: 3px solid #9C27B0; border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.3); position: relative;">
                                        <div class="d-none d-md-block position-absolute" style="left: -20px; top: 50%; transform: translateY(-50%); width: 0; height: 0; border-top: 15px solid transparent; border-bottom: 15px solid transparent; border-right: 20px solid #9C27B0;"></div>
                                        <div class="d-flex align-items-center mb-2">
                                            <span style="font-size: clamp(2rem, 4vw, 2.5rem); margin-right: 0.8rem; filter: drop-shadow(3px 3px 6px rgba(0,0,0,0.3));">⚗️</span>
                                            <h3 class="mb-0" style="font-size: clamp(1rem, 2.3vw, 1.3rem); color: #001122; font-weight: 900; line-height: 1.2; text-shadow: 2px 2px 4px rgba(255,255,255,1);">Paso 4: Agrega acelerador y material seco</h3>
                                        </div>
                                        <p class="mb-0" style="font-size: clamp(0.85rem, 1.8vw, 1rem); color: #001122; font-weight: 700; line-height: 1.4; text-shadow: 1px 1px 3px rgba(255,255,255,0.9);">Cubre cada capa de orgánicos con el acelerador y luego con \"Material Secante Vegetal\".</p>
                                    </div>
                                </div>
                                <div class="d-none d-md-flex col-md-2 justify-content-center align-items-center order-md-1" style="z-index: 10;">
                                    <div style="background: #9C27B0; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.8rem; box-shadow: 0 6px 15px rgba(0,0,0,0.4); border: 4px solid white;">4</div>
                                </div>
                                <div class="d-none d-md-block col-md-5 order-md-1"></div>
                            </div>
                        </div>
                        <!-- PASO 5 -->
                        <div class="col-12">
                            <div class="row g-0 align-items-center position-relative" style="z-index: 1;">
                                <div class="col-md-5 order-md-1">
                                    <div class="cuadro-texto h-100" style="padding: 1.2rem; background: rgba(255,255,255,0.45) !important; border: 3px solid #607D8B; border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.3); position: relative;">
                                        <div class="d-none d-md-block position-absolute" style="right: -20px; top: 50%; transform: translateY(-50%); width: 0; height: 0; border-top: 15px solid transparent; border-bottom: 15px solid transparent; border-left: 20px solid #607D8B;"></div>
                                        <div class="d-flex align-items-center mb-2">
                                            <span style="font-size: clamp(2rem, 4vw, 2.5rem); margin-right: 0.8rem; filter: drop-shadow(3px 3px 6px rgba(0,0,0,0.3));">🛠️</span>
                                            <h3 class="mb-0" style="font-size: clamp(1rem, 2.3vw, 1.3rem); color: #001122; font-weight: 900; line-height: 1.2; text-shadow: 2px 2px 4px rgba(255,255,255,1);">Paso 5: Mezcla suavemente</h3>
                                        </div>
                                        <p class="mb-0" style="font-size: clamp(0.85rem, 1.8vw, 1rem); color: #001122; font-weight: 700; line-height: 1.4; text-shadow: 1px 1px 3px rgba(255,255,255,0.9);">Usa las herramientas de tu kit cada 1–2 días.</p>
                                    </div>
                                </div>
                                <div class="d-none d-md-flex col-md-2 justify-content-center align-items-center order-md-1" style="z-index: 10;">
                                    <div style="background: #607D8B; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.8rem; box-shadow: 0 6px 15px rgba(0,0,0,0.4); border: 4px solid white;">5</div>
                                </div>
                                <div class="d-none d-md-block col-md-5 order-md-2"></div>
                            </div>
                        </div>
                        <!-- PASO 6 -->
                        <div class="col-12">
                            <div class="row g-0 align-items-center position-relative" style="z-index: 1;">
                                <div class="col-md-5 order-md-2 offset-md-1">
                                    <div class="cuadro-texto h-100" style="padding: 1.2rem; background: rgba(255,255,255,0.45) !important; border: 3px solid #4CAF50; border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.3); position: relative;">
                                        <div class="d-none d-md-block position-absolute" style="left: -20px; top: 50%; transform: translateY(-50%); width: 0; height: 0; border-top: 15px solid transparent; border-bottom: 15px solid transparent; border-right: 20px solid #4CAF50;"></div>
                                        <div class="d-flex align-items-center mb-2">
                                            <span style="font-size: clamp(2rem, 4vw, 2.5rem); margin-right: 0.8rem; filter: drop-shadow(3px 3px 6px rgba(0,0,0,0.3));">✨</span>
                                            <h3 class="mb-0" style="font-size: clamp(1rem, 2.3vw, 1.3rem); color: #001122; font-weight: 900; line-height: 1.2; text-shadow: 2px 2px 4px rgba(255,255,255,1);">Paso 6: ¡Compost listo!</h3>
                                        </div>
                                        <p class="mb-0" style="font-size: clamp(0.85rem, 1.8vw, 1rem); color: #001122; font-weight: 700; line-height: 1.4; text-shadow: 1px 1px 3px rgba(255,255,255,0.9);">Debe tener olor a tierra, color oscuro y no verse restos de comida.</p>
                                    </div>
                                </div>
                                <div class="d-none d-md-flex col-md-2 justify-content-center align-items-center order-md-1" style="z-index: 10;">
                                    <div style="background: #4CAF50; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.8rem; box-shadow: 0 6px 15px rgba(0,0,0,0.4); border: 4px solid white;">6</div>
                                </div>
                                <div class="d-none d-md-block col-md-5 order-md-1"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Nota final motivacional -->
                    <div class="cuadro-texto mx-auto mt-4 mb-3" style="max-width: 1150px; padding: 1rem 1.5rem; width: 95%; background: rgba(67,190,22,0.4) !important; border: 3px solid #43be16;">
                        <div class="text-center">
                            <h4 class="mb-2" style="font-size: clamp(1rem, 2.3vw, 1.3rem); color: #001122; font-weight: 900;">
                                <i class="fas fa-seedling me-2"></i>¡Tu primer compost está listo!
                            </h4>
                            <p class="mb-0" style="font-size: clamp(0.85rem, 1.8vw, 1rem); color: #001122; font-weight: 700; line-height: 1.4;">
                                Ahora puedes usar este abono natural en tus plantas, macetas o huerta. <b>Estás contribuyendo a la economía circular</b> y reduciendo tu huella ambiental. 🌱💚
                            </p>
                        </div>
                    </div>

                    <!-- Navegación -->
                    <div class="container-fluid px-0 mt-3 mb-0">
                        <div class="row g-0">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center px-3 py-2" style="background: transparent; border-radius: 10px; max-width: 100%;">
                                    <!-- Botón Anterior -->
                                    <a href="aprende.php?pagina=<?php echo $pagina-1; ?>" 
                                    class="btn btn-lg text-white" 
                                    style="background-color: #43be16; 
                                            padding: 0.6rem 1.2rem; 
                                            font-size: clamp(0.9rem, 2vw, 1rem);
                                            flex-shrink: 0;">
                                        <i class="fa fa-arrow-left me-2"></i> Anterior
                                    </a>
                                    
                                    <!-- Indicador de página (solo desktop) -->
                                    <div class="text-white text-center flex-grow-1 d-none d-md-block" 
                                        style="font-size: clamp(0.75rem, 1.4vw, 0.9rem); 
                                                text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
                                                padding: 0 1rem;">
                                        Página <?php echo $pagina+1; ?> de <?php echo $total_paginas; ?>
                                    </div>
                                    
                                    <!-- Botón Siguiente -->
                                    <?php if ($pagina < $total_paginas-1): ?>
                                        <a href="aprende.php?pagina=<?php echo $pagina+1; ?>" 
                                        class="btn btn-lg text-white" 
                                        style="background-color: #43be16; 
                                                padding: 0.6rem 1.2rem; 
                                                font-size: clamp(0.9rem, 2vw, 1rem);
                                                flex-shrink: 0;">
                                            Siguiente <i class="fa fa-arrow-right ms-2"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="aprende.php?pagina=0" 
                                        class="btn btn-lg text-white" 
                                        style="background-color: #003d82; 
                                                padding: 0.6rem 1.2rem; 
                                                font-size: clamp(0.9rem, 2vw, 1rem);
                                                flex-shrink: 0;">
                                            <i class="fa fa-home me-2"></i> Inicio
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <?php elseif ($cartilla[$pagina]['tipo'] === 'soluciones_compostaje'): ?>
    <!-- PÁGINA 15: SOLUCIONES COMPOSTAJE + ACTIVIDAD FINAL INTERACTIVA -->
    <div class="container-fluid header-aprende"
        style="position: relative;
            background-image: url('img/preparacion_abono.jpg');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            padding-bottom: 0.5rem;">
            
        <div class="container-fluid h-100 p-0">
            <div class="row g-0 justify-content-center">
                <!-- Títulos principales -->
                <div class="col-12 col-lg-11 mx-auto px-3 pt-3 pb-2">
                    <div class="cuadro-texto text-center mb-2" style="padding: 0.8rem 1.5rem; max-width: 1100px; margin: 0 auto;">
                        <h1 class="mb-2" style="font-size: clamp(1.3rem, 3.5vw, 1.8rem); line-height: 1.3; color: #001122; font-weight: 900;">
                            <span style="font-size: clamp(1.8rem, 4vw, 2.3rem); margin-right: 0.5rem;">🛠️</span>
                            ¿Un Reto con tu Compost? ¡Aquí la Solución!
                        </h1>
                        <h3 class="mb-0" style="font-size: clamp(1rem, 2.2vw, 1.3rem); font-weight: 700; color: #003366;">
                            Guía de solución de problemas comunes
                        </h3>
                    </div>
                </div>
                
                <!-- Contenido principal -->
                <div class="col-12 col-lg-11 mx-auto px-3">
                    <!-- SECCIÓN 1: PROBLEMAS COMUNES (3 TARJETAS) -->
                    <div class="row g-3 px-2 mb-4">
                        <!-- Tarjeta 1 -->
                        <div class="col-md-4">
                            <div class="cuadro-texto h-100" style="padding: 1.2rem; background: rgba(255,255,255,0.45); border: 3px solid #e74c3c; border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                                <div class="text-center mb-2">
                                    <span style="font-size: clamp(2.5rem, 5vw, 3rem); filter: drop-shadow(3px 3px 6px rgba(0,0,0,0.3));">🤢</span>
                                </div>
                                <h3 class="text-center mb-3" style="font-size: clamp(1.1rem, 2.5vw, 1.4rem); color: #e74c3c; font-weight: 900; line-height: 1.2; text-shadow: 2px 2px 4px rgba(255,255,255,1);">
                                    Problema: Mal olor
                                </h3>
                                <div class="mb-3" style="background: rgba(255,193,7,0.8); padding: 0.8rem; border-radius: 10px; border: 2px solid #ffc107;">
                                    <h5 style="font-size: clamp(0.9rem, 2vw, 1.1rem); color: #001122; font-weight: 900; margin-bottom: 0.5rem;">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Causa:
                                    </h5>
                                    <p class="mb-0" style="font-size: clamp(0.8rem, 1.7vw, 0.95rem); color: #001122; font-weight: 700; line-height: 1.3;">
                                        Exceso de húmedo/nitrógeno, falta de aire.
                                    </p>
                                </div>
                                <div style="background: rgba(67,190,22,0.8); padding: 0.8rem; border-radius: 10px; border: 2px solid #43be16;">
                                    <h5 style="font-size: clamp(0.9rem, 2vw, 1.1rem); color: #001122; font-weight: 900; margin-bottom: 0.5rem;">
                                        <i class="fas fa-lightbulb me-2"></i>Solución:
                                    </h5>
                                    <p class="mb-0" style="font-size: clamp(0.8rem, 1.7vw, 0.95rem); color: #001122; font-weight: 700; line-height: 1.3;">
                                        "Los Increíbles de la Montaña" y "Seca Rápido" están diseñados para esto. Si aún así huele, revisa si pusiste algo que no va o si necesitas más Seca Rápido.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Tarjeta 2 -->
                        <div class="col-md-4">
                            <div class="cuadro-texto h-100" style="padding: 1.2rem; background: rgba(255,255,255,0.45); border: 3px solid #9C27B0; border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                                <div class="text-center mb-2">
                                    <span style="font-size: clamp(2.5rem, 5vw, 3rem); filter: drop-shadow(3px 3px 6px rgba(0,0,0,0.3));">🦟</span>
                                </div>
                                <h3 class="text-center mb-3" style="font-size: clamp(1.1rem, 2.5vw, 1.4rem); color: #9C27B0; font-weight: 900; line-height: 1.2; text-shadow: 2px 2px 4px rgba(255,255,255,1);">
                                    Problema: Mosquitos
                                </h3>
                                <div class="mb-3" style="background: rgba(255,193,7,0.8); padding: 0.8rem; border-radius: 10px; border: 2px solid #ffc107;">
                                    <h5 style="font-size: clamp(0.9rem, 2vw, 1.1rem); color: #001122; font-weight: 900; margin-bottom: 0.5rem;">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Causa:
                                    </h5>
                                    <p class="mb-0" style="font-size: clamp(0.8rem, 1.7vw, 0.95rem); color: #001122; font-weight: 700; line-height: 1.3;">
                                        Residuos inadecuados, compost no cubierto.
                                    </p>
                                </div>
                                <div style="background: rgba(67,190,22,0.8); padding: 0.8rem; border-radius: 10px; border: 2px solid #43be16;">
                                    <h5 style="font-size: clamp(0.9rem, 2vw, 1.1rem); color: #001122; font-weight: 900; margin-bottom: 0.5rem;">
                                        <i class="fas fa-lightbulb me-2"></i>Solución:
                                    </h5>
                                    <p class="mb-0" style="font-size: clamp(0.8rem, 1.7vw, 0.95rem); color: #001122; font-weight: 700; line-height: 1.3;">
                                        El acelerador y la capa seca los evitan. Cubre siempre bien tu compostera.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Tarjeta 3 -->
                        <div class="col-md-4">
                            <div class="cuadro-texto h-100" style="padding: 1.2rem; background: rgba(255,255,255,0.45); border: 3px solid #2196F3; border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                                <div class="text-center mb-2">
                                    <span style="font-size: clamp(2.5rem, 5vw, 3rem); filter: drop-shadow(3px 3px 6px rgba(0,0,0,0.3));">💧</span>
                                </div>
                                <h3 class="text-center mb-3" style="font-size: clamp(1.1rem, 2.5vw, 1.4rem); color: #2196F3; font-weight: 900; line-height: 1.2; text-shadow: 2px 2px 4px rgba(255,255,255,1);">
                                    Problema: Exceso de líquidos
                                </h3>
                                <div class="mb-3" style="background: rgba(255,193,7,0.8); padding: 0.8rem; border-radius: 10px; border: 2px solid #ffc107;">
                                    <h5 style="font-size: clamp(0.9rem, 2vw, 1.1rem); color: #001122; font-weight: 900; margin-bottom: 0.5rem;">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Causa:
                                    </h5>
                                    <p class="mb-0" style="font-size: clamp(0.8rem, 1.7vw, 0.95rem); color: #001122; font-weight: 700; line-height: 1.3;">
                                        Demasiados materiales húmedos, falta de absorción.
                                    </p>
                                </div>
                                <div style="background: rgba(67,190,22,0.8); padding: 0.8rem; border-radius: 10px; border: 2px solid #43be16;">
                                    <h5 style="font-size: clamp(0.9rem, 2vw, 1.1rem); color: #001122; font-weight: 900; margin-bottom: 0.5rem;">
                                        <i class="fas fa-lightbulb me-2"></i>Solución:
                                    </h5>
                                    <p class="mb-0" style="font-size: clamp(0.8rem, 1.7vw, 0.95rem); color: #001122; font-weight: 700; line-height: 1.3;">
                                        "Seca Rápido" absorbe la humedad. Asegúrate de usarlo bien.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- SECCIÓN 2: ACTIVIDAD FINAL INTERACTIVA -->
                    <div class="cuadro-texto cuadro-actividad mx-auto mb-4" style="max-width: 1150px; padding: 1.5rem; background: rgba(135,206,250,0.4); border: 3px solid #2196F3;">
                        <h3 class="text-center mb-3" style="font-size: clamp(1.2rem, 3vw, 1.6rem); color: #001122; font-weight: 900;">
                            <i class="fas fa-seedling me-2"></i>
                            Reto del Tema 4: ¡Mi Primer Paso con el Compost!
                        </h3>
                        <p class="texto-contenido text-center mb-4" style="font-size: clamp(0.9rem, 2vw, 1.1rem); line-height: 1.5; color: #001122; font-weight: 700;">
                            ¡Es hora de empezar! Selecciona <b>al menos 3 residuos orgánicos</b> que planeas compostar primero con tu kit.
                        </p>
                        <!-- GRID DE ÍTEMS SELECCIONABLES -->
                        <style>
                            .item-compostable {
                                margin: 12px;
                            }
                        </style>
                        <div class="row g-4 mb-4" id="itemsCompostables">
                            <?php foreach ($cartilla[$pagina]['actividad_reto']['items_compostables'] as $item): ?>
                                <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-stretch">
                                    <div class="item-compostable w-100" data-id="<?php echo $item['id']; ?>" onclick="toggleItem(this)" style="background: #fff; padding: 1.2rem; border-radius: 15px; border: 3px solid #e0e0e0; cursor: pointer; transition: box-shadow 0.2s, border-color 0.2s; text-align: center; box-shadow: 0 4px 16px rgba(0,0,0,0.08); position: relative; display: flex; flex-direction: column; justify-content: center; height: 100%; min-height: 170px;">
                                        <div style="font-size: 2.2rem; margin-bottom: 0.5rem;"><?php echo $item['emoji']; ?></div>
                                        <div style="font-size: 1.1rem; color: #001122; font-weight: 700; line-height: 1.3;"><?php echo $item['texto']; ?></div>
                                        <div class="checkmark" style="display: none; position: absolute; top: 10px; right: 10px; background: #43be16; color: white; width: 30px; height: 30px; border-radius: 50%; align-items: center; justify-content: center; font-size: 1.2rem;">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <!-- Contador de seleccionados -->
                        <div class="text-center mb-3">
                            <div style="background: rgba(255,193,7,0.9); padding: 0.8rem 1.5rem; border-radius: 10px; display: inline-block; border: 2px solid #ffc107;">
                                <span style="color: #001122; font-weight: 900; font-size: clamp(0.9rem, 2vw, 1.1rem);">
                                    <i class="fas fa-list-check me-2"></i>
                                    Seleccionados: <span id="contadorSeleccionados">0</span> / 3 mínimo
                                </span>
                            </div>
                        </div>
                        <!-- Botón de envío -->
                        <div class="text-center mt-4">
                            <button 
                                type="button" 
                                id="btnCompletarReto"
                                class="btn btn-primary btn-lg px-5 py-3" 
                                onclick="guardarRetoCompost()" 
                                style="background-color: #43be16; border-color: #43be16; font-size: clamp(1rem, 2.2vw, 1.2rem); font-weight: 700;">
                                <i class="fas fa-check-circle me-2"></i>
                                ¡Completar Reto Final!
                            </button>
                        </div>
                        <!-- Mensaje de éxito -->
                        <div id="mensajeExitoCompost" class="alert text-center mt-4" style="display: none; background-color: rgba(67,190,22,0.9); border-color: #43be16; color: #001122; padding: 1.5rem; border-radius: 15px; font-size: clamp(0.9rem, 2vw, 1.1rem); font-weight: 700;">
                            <i class="fas fa-trophy me-2" style="font-size: 2rem; color: #FFD700;"></i>
                            <h4 class="mb-2"><b>¡FELICITACIONES! 🎉</b></h4>
                            <p class="mb-2">Has completado toda la cartilla sobre compostaje.</p>
                            <p class="mb-0">¡Ahora estás lista para transformar tus residuos en abono natural!</p>
                            <small class="d-block mt-2">Redirigiendo en 5 segundos...</small>
                        </div>
                    </div>
                    
                    <!-- Navegación -->
                    <div class="container-fluid px-0 mt-3 mb-3">
                        <div class="row g-0 w-100">
                            <div class="col-12 d-flex justify-content-between align-items-center px-2">
                                <a href="aprende.php?pagina=14" class="btn btn-lg text-white" style="background-color: #43be16; padding: 0.6rem 1.2rem; font-size: clamp(0.9rem, 2vw, 1.05rem);">
                                    <i class="fa fa-arrow-left me-2"></i> Anterior
                                </a>
                                <div class="text-white text-center d-none d-md-block" style="font-size: clamp(0.8rem, 1.5vw, 0.95rem); text-shadow: 2px 2px 4px rgba(0,0,0,0.8); position: absolute; left: 50%; transform: translateX(-50%); width: max-content;">
                                    Página 16 de 18
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php elseif ($cartilla[$pagina]['tipo'] === 'reuso_reciclaje_timeline'): ?>
    <!-- PÁGINA 16: REUSO Y RECICLAJE CON FOTOS ALTERNAS -->
    <div class="container-fluid header-aprende"
        style="position: relative;
            background-image: url('img/imagen_fondo_verde.jpg');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            padding-bottom: 0.5rem;">
            
        <div class="container-fluid h-100 p-0">
            <div class="row g-0 justify-content-center">
                <!-- Títulos principales -->
                <div class="col-12 col-lg-11 mx-auto px-3 pt-3 pb-2">
                    <div class="cuadro-texto text-center mb-2" style="padding: 0.8rem 1.5rem; max-width: 1100px; margin: 0 auto;">
                        <h1 class="mb-2" style="font-size: clamp(1.3rem, 3.5vw, 1.8rem); line-height: 1.3; color: #001122; font-weight: 900;">
                            <span style="font-size: clamp(1.8rem, 4vw, 2.3rem); margin-right: 0.5rem;">♻️</span>
                            Reuso y Reciclaje: ¡Dale una Segunda Vida a Todo!                        </h1>
                        <h3 class="mb-0" style="font-size: clamp(1rem, 2.2vw, 1.3rem); font-weight: 700; color: #003366;">
                            El compostaje es solo el inicio. ¡Muchos otros residuos tienen una segunda oportunidad!                        </h3>
                    </div>
                </div>
                
                <!-- Contenido principal -->
                <div class="col-12 col-lg-11 mx-auto px-3">
                                            <!-- TÍTULO DE CATEGORÍA -->
                        <div class="cuadro-texto mx-auto mb-3" style="max-width: 1150px; padding: 0.6rem 1rem; width: 95%; background: rgba(52, 152, 219, 0.35) !important; border: 2px solid #3498db;">
                            <h2 class="text-center mb-0" style="font-size: clamp(1.1rem, 2.8vw, 1.5rem); color: #001122; font-weight: 900;">
                                <span style="font-size: clamp(1.5rem, 3.5vw, 2rem); margin-right: 0.5rem;">🍽️</span>
                                Ideas Creativas para Gastronomía                            </h2>
                        </div>
                        
                        <!-- LÍNEA DE TIEMPO CON FOTOS ALTERNAS -->
                        <div class="row g-3 px-2 position-relative mb-4">
                            <!-- Línea vertical conectora (solo desktop) -->
                            <div class="d-none d-md-block position-absolute" style="left: 50%; top: 50px; bottom: 50px; width: 4px; background: linear-gradient(180deg, #3498db 0%, #e74c3c 50%, #43be16 100%); transform: translateX(-50%); z-index: 0; border-radius: 10px;"></div>
                            
                                                        <!-- IDEA 1 CON FOTO ALTERNA -->
                            <div class="col-12">
                                <div class="row g-2 align-items-center position-relative" style="z-index: 1;">
                                    
                                    <!-- ✅ FOTO (alterna izquierda/derecha) -->
                                    <div class="col-md-5 order-md-1">
                                        <div class="text-center">
                                            <img src="img/materos_plasticos.jpg" 
                                                alt="Envases de Plástico" 
                                                class="img-fluid" 
                                                style="max-height: 250px; 
                                                        border-radius: 15px; 
                                                        box-shadow: 0 8px 20px rgba(0,0,0,0.4); 
                                                        border: 4px solid #3498db; 
                                                        object-fit: cover; 
                                                        width: 100%;">
                                        </div>
                                    </div>
                                    
                                    <!-- Círculo numerado en el centro (solo desktop) -->
                                    <div class="d-none d-md-flex col-md-2 justify-content-center align-items-center order-md-1" style="z-index: 10;">
                                        <div style="background: #3498db; 
                                                    color: white; 
                                                    width: 70px; 
                                                    height: 70px; 
                                                    border-radius: 50%; 
                                                    display: flex; 
                                                    align-items: center; 
                                                    justify-content: center; 
                                                    font-weight: 900; 
                                                    font-size: 2rem; 
                                                    box-shadow: 0 6px 15px rgba(0,0,0,0.4); 
                                                    border: 5px solid white;">
                                            1                                        </div>
                                    </div>
                                    
                                    <!-- ✅ TEXTO (lado opuesto a la foto) -->
                                    <div class="col-md-5 order-md-2">
                                        <div class="cuadro-texto h-100" style="padding: 1.2rem; 
                                                                            background: rgba(255, 255, 255, 0.45) !important; 
                                                                            border: 3px solid #3498db; 
                                                                            border-radius: 15px; 
                                                                            box-shadow: 0 8px 20px rgba(0,0,0,0.3); 
                                                                            position: relative;">
                                            
                                            <!-- Emoji y título -->
                                            <div class="d-flex align-items-center mb-2">
                                                <span style="font-size: clamp(2rem, 4vw, 2.5rem); 
                                                            margin-right: 0.8rem; 
                                                            filter: drop-shadow(3px 3px 6px rgba(0,0,0,0.3));">
                                                    📦                                                </span>
                                                <h3 class="mb-0" style="font-size: clamp(1rem, 2.3vw, 1.3rem); 
                                                                    color: #001122; 
                                                                    font-weight: 900; 
                                                                    line-height: 1.2; 
                                                                    text-shadow: 2px 2px 4px rgba(255,255,255,1);">
                                                    Envases de Plástico                                                </h3>
                                            </div>
                                            
                                            <!-- Descripción -->
                                            <p class="mb-2" style="font-size: clamp(0.85rem, 1.8vw, 1rem); 
                                                                color: #001122; 
                                                                font-weight: 700; 
                                                                line-height: 1.4; 
                                                                text-shadow: 1px 1px 3px rgba(255,255,255,0.9);">
                                                Reutiliza envases limpios para guardar tus insumos, especias, harinas y otros ingredientes de manera organizada.                                            </p>
                                            
                                            <!-- Badge de beneficio -->
                                            <div style="background: rgba(52, 152, 219, 0.15); 
                                                        padding: 0.6rem; 
                                                        border-radius: 8px; 
                                                        border: 2px solid #3498db;">
                                                <small style="color: #001122; 
                                                            font-weight: 700; 
                                                            display: block; 
                                                            text-align: center; 
                                                            font-size: clamp(0.75rem, 1.6vw, 0.9rem);">
                                                    <i class="fas fa-check-circle me-1"></i>Organización + Ahorro                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                                                        <!-- IDEA 2 CON FOTO ALTERNA -->
                            <div class="col-12">
                                <div class="row g-2 align-items-center position-relative" style="z-index: 1;">
                                    
                                    <!-- ✅ FOTO (alterna izquierda/derecha) -->
                                    <div class="col-md-5 order-md-2 offset-md-1">
                                        <div class="text-center">
                                            <img src="img/ideas_frascos_vidrio.jpg" 
                                                alt="Frascos de Vidrio" 
                                                class="img-fluid" 
                                                style="max-height: 250px; 
                                                        border-radius: 15px; 
                                                        box-shadow: 0 8px 20px rgba(0,0,0,0.4); 
                                                        border: 4px solid #e74c3c; 
                                                        object-fit: cover; 
                                                        width: 100%;">
                                        </div>
                                    </div>
                                    
                                    <!-- Círculo numerado en el centro (solo desktop) -->
                                    <div class="d-none d-md-flex col-md-2 justify-content-center align-items-center order-md-1" style="z-index: 10;">
                                        <div style="background: #e74c3c; 
                                                    color: white; 
                                                    width: 70px; 
                                                    height: 70px; 
                                                    border-radius: 50%; 
                                                    display: flex; 
                                                    align-items: center; 
                                                    justify-content: center; 
                                                    font-weight: 900; 
                                                    font-size: 2rem; 
                                                    box-shadow: 0 6px 15px rgba(0,0,0,0.4); 
                                                    border: 5px solid white;">
                                            2                                        </div>
                                    </div>
                                    
                                    <!-- ✅ TEXTO (lado opuesto a la foto) -->
                                    <div class="col-md-5 order-md-1">
                                        <div class="cuadro-texto h-100" style="padding: 1.2rem; 
                                                                            background: rgba(255, 255, 255, 0.45) !important; 
                                                                            border: 3px solid #e74c3c; 
                                                                            border-radius: 15px; 
                                                                            box-shadow: 0 8px 20px rgba(0,0,0,0.3); 
                                                                            position: relative;">
                                            
                                            <!-- Emoji y título -->
                                            <div class="d-flex align-items-center mb-2">
                                                <span style="font-size: clamp(2rem, 4vw, 2.5rem); 
                                                            margin-right: 0.8rem; 
                                                            filter: drop-shadow(3px 3px 6px rgba(0,0,0,0.3));">
                                                    🍯                                                </span>
                                                <h3 class="mb-0" style="font-size: clamp(1rem, 2.3vw, 1.3rem); 
                                                                    color: #001122; 
                                                                    font-weight: 900; 
                                                                    line-height: 1.2; 
                                                                    text-shadow: 2px 2px 4px rgba(255,255,255,1);">
                                                    Frascos de Vidrio                                                </h3>
                                            </div>
                                            
                                            <!-- Descripción -->
                                            <p class="mb-2" style="font-size: clamp(0.85rem, 1.8vw, 1rem); 
                                                                color: #001122; 
                                                                font-weight: 700; 
                                                                line-height: 1.4; 
                                                                text-shadow: 1px 1px 3px rgba(255,255,255,0.9);">
                                                Perfectos para almacenar salsas caseras, conservas, aderezos o presentar productos gourmet para la venta.                                            </p>
                                            
                                            <!-- Badge de beneficio -->
                                            <div style="background: rgba(231, 76, 60, 0.15); 
                                                        padding: 0.6rem; 
                                                        border-radius: 8px; 
                                                        border: 2px solid #e74c3c;">
                                                <small style="color: #001122; 
                                                            font-weight: 700; 
                                                            display: block; 
                                                            text-align: center; 
                                                            font-size: clamp(0.75rem, 1.6vw, 0.9rem);">
                                                    <i class="fas fa-check-circle me-1"></i>Presentación Premium                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                                                        <!-- IDEA 3 CON FOTO ALTERNA -->
                            <div class="col-12">
                                <div class="row g-2 align-items-center position-relative" style="z-index: 1;">
                                    
                                    <!-- ✅ FOTO (alterna izquierda/derecha) -->
                                    <div class="col-md-5 order-md-1">
                                        <div class="text-center">
                                            <img src="img/idea_bolsa_tela.jpg" 
                                                alt="Bolsas de Tela" 
                                                class="img-fluid" 
                                                style="max-height: 250px; 
                                                        border-radius: 15px; 
                                                        box-shadow: 0 8px 20px rgba(0,0,0,0.4); 
                                                        border: 4px solid #43be16; 
                                                        object-fit: cover; 
                                                        width: 100%;">
                                        </div>
                                    </div>
                                    
                                    <!-- Círculo numerado en el centro (solo desktop) -->
                                    <div class="d-none d-md-flex col-md-2 justify-content-center align-items-center order-md-1" style="z-index: 10;">
                                        <div style="background: #43be16; 
                                                    color: white; 
                                                    width: 70px; 
                                                    height: 70px; 
                                                    border-radius: 50%; 
                                                    display: flex; 
                                                    align-items: center; 
                                                    justify-content: center; 
                                                    font-weight: 900; 
                                                    font-size: 2rem; 
                                                    box-shadow: 0 6px 15px rgba(0,0,0,0.4); 
                                                    border: 5px solid white;">
                                            3                                        </div>
                                    </div>
                                    
                                    <!-- ✅ TEXTO (lado opuesto a la foto) -->
                                    <div class="col-md-5 order-md-2">
                                        <div class="cuadro-texto h-100" style="padding: 1.2rem; 
                                                                            background: rgba(255, 255, 255, 0.45) !important; 
                                                                            border: 3px solid #43be16; 
                                                                            border-radius: 15px; 
                                                                            box-shadow: 0 8px 20px rgba(0,0,0,0.3); 
                                                                            position: relative;">
                                            
                                            <!-- Emoji y título -->
                                            <div class="d-flex align-items-center mb-2">
                                                <span style="font-size: clamp(2rem, 4vw, 2.5rem); 
                                                            margin-right: 0.8rem; 
                                                            filter: drop-shadow(3px 3px 6px rgba(0,0,0,0.3));">
                                                    🛍️                                                </span>
                                                <h3 class="mb-0" style="font-size: clamp(1rem, 2.3vw, 1.3rem); 
                                                                    color: #001122; 
                                                                    font-weight: 900; 
                                                                    line-height: 1.2; 
                                                                    text-shadow: 2px 2px 4px rgba(255,255,255,1);">
                                                    Bolsas de Tela                                                </h3>
                                            </div>
                                            
                                            <!-- Descripción -->
                                            <p class="mb-2" style="font-size: clamp(0.85rem, 1.8vw, 1rem); 
                                                                color: #001122; 
                                                                font-weight: 700; 
                                                                line-height: 1.4; 
                                                                text-shadow: 1px 1px 3px rgba(255,255,255,0.9);">
                                                Crea bolsas reutilizables con telas recicladas para compras de insumos o entregar productos a clientes.                                            </p>
                                            
                                            <!-- Badge de beneficio -->
                                            <div style="background: rgba(67, 190, 22, 0.15); 
                                                        padding: 0.6rem; 
                                                        border-radius: 8px; 
                                                        border: 2px solid #43be16;">
                                                <small style="color: #001122; 
                                                            font-weight: 700; 
                                                            display: block; 
                                                            text-align: center; 
                                                            font-size: clamp(0.75rem, 1.6vw, 0.9rem);">
                                                    <i class="fas fa-check-circle me-1"></i>Eco-friendly                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                                                    </div>
                                            <!-- TÍTULO DE CATEGORÍA -->
                        <div class="cuadro-texto mx-auto mb-3" style="max-width: 1150px; padding: 0.6rem 1rem; width: 95%; background: rgba(156, 39, 176, 0.35) !important; border: 2px solid #9C27B0;">
                            <h2 class="text-center mb-0" style="font-size: clamp(1.1rem, 2.8vw, 1.5rem); color: #001122; font-weight: 900;">
                                <span style="font-size: clamp(1.5rem, 3.5vw, 2rem); margin-right: 0.5rem;">🎨</span>
                                Ideas Creativas para Artesanías                            </h2>
                        </div>
                        
                        <!-- LÍNEA DE TIEMPO CON FOTOS ALTERNAS -->
                        <div class="row g-3 px-2 position-relative mb-4">
                            <!-- Línea vertical conectora (solo desktop) -->
                            <div class="d-none d-md-block position-absolute" style="left: 50%; top: 50px; bottom: 50px; width: 4px; background: linear-gradient(180deg, #9C27B0 0%, #FF5722 50%, #8B4513 100%); transform: translateX(-50%); z-index: 0; border-radius: 10px;"></div>
                            
                                                        <!-- IDEA 4 CON FOTO ALTERNA -->
                            <div class="col-12">
                                <div class="row g-2 align-items-center position-relative" style="z-index: 1;">
                                    
                                    <!-- ✅ FOTO (alterna izquierda/derecha) -->
                                    <div class="col-md-5 order-md-1">
                                        <div class="text-center">
                                            <img src="img/imagen_retazos_tela.jpg" 
                                                alt="Retazos de Tela" 
                                                class="img-fluid" 
                                                style="max-height: 250px; 
                                                        border-radius: 15px; 
                                                        box-shadow: 0 8px 20px rgba(0,0,0,0.4); 
                                                        border: 4px solid #9C27B0; 
                                                        object-fit: cover; 
                                                        width: 100%;">
                                        </div>
                                    </div>
                                    
                                    <!-- Círculo numerado en el centro (solo desktop) -->
                                    <div class="d-none d-md-flex col-md-2 justify-content-center align-items-center order-md-1" style="z-index: 10;">
                                        <div style="background: #9C27B0; 
                                                    color: white; 
                                                    width: 70px; 
                                                    height: 70px; 
                                                    border-radius: 50%; 
                                                    display: flex; 
                                                    align-items: center; 
                                                    justify-content: center; 
                                                    font-weight: 900; 
                                                    font-size: 2rem; 
                                                    box-shadow: 0 6px 15px rgba(0,0,0,0.4); 
                                                    border: 5px solid white;">
                                            4                                        </div>
                                    </div>
                                    
                                    <!-- ✅ TEXTO (lado opuesto a la foto) -->
                                    <div class="col-md-5 order-md-2">
                                        <div class="cuadro-texto h-100" style="padding: 1.2rem; 
                                                                            background: rgba(255, 255, 255, 0.45) !important; 
                                                                            border: 3px solid #9C27B0; 
                                                                            border-radius: 15px; 
                                                                            box-shadow: 0 8px 20px rgba(0,0,0,0.3); 
                                                                            position: relative;">
                                            
                                            <!-- Emoji y título -->
                                            <div class="d-flex align-items-center mb-2">
                                                <span style="font-size: clamp(2rem, 4vw, 2.5rem); 
                                                            margin-right: 0.8rem; 
                                                            filter: drop-shadow(3px 3px 6px rgba(0,0,0,0.3));">
                                                    🧵                                                </span>
                                                <h3 class="mb-0" style="font-size: clamp(1rem, 2.3vw, 1.3rem); 
                                                                    color: #001122; 
                                                                    font-weight: 900; 
                                                                    line-height: 1.2; 
                                                                    text-shadow: 2px 2px 4px rgba(255,255,255,1);">
                                                    Retazos de Tela                                                </h3>
                                            </div>
                                            
                                            <!-- Descripción -->
                                            <p class="mb-2" style="font-size: clamp(0.85rem, 1.8vw, 1rem); 
                                                                color: #001122; 
                                                                font-weight: 700; 
                                                                line-height: 1.4; 
                                                                text-shadow: 1px 1px 3px rgba(255,255,255,0.9);">
                                                Transforma sobrantes en nuevos diseños: accesorios, patchwork, bordados o productos textiles únicos.                                            </p>
                                            
                                            <!-- Badge de beneficio -->
                                            <div style="background: rgba(156, 39, 176, 0.15); 
                                                        padding: 0.6rem; 
                                                        border-radius: 8px; 
                                                        border: 2px solid #9C27B0;">
                                                <small style="color: #001122; 
                                                            font-weight: 700; 
                                                            display: block; 
                                                            text-align: center; 
                                                            font-size: clamp(0.75rem, 1.6vw, 0.9rem);">
                                                    <i class="fas fa-check-circle me-1"></i>Creatividad infinita                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                                                        <!-- IDEA 5 CON FOTO ALTERNA -->
                            <div class="col-12">
                                <div class="row g-2 align-items-center position-relative" style="z-index: 1;">
                                    
                                    <!-- ✅ FOTO (alterna izquierda/derecha) -->
                                    <div class="col-md-5 order-md-2 offset-md-1">
                                        <div class="text-center">
                                            <img src="img/reutilizar_bolsas_plastico.webp" 
                                                alt="Plásticos Reciclados" 
                                                class="img-fluid" 
                                                style="max-height: 250px; 
                                                        border-radius: 15px; 
                                                        box-shadow: 0 8px 20px rgba(0,0,0,0.4); 
                                                        border: 4px solid #FF5722; 
                                                        object-fit: cover; 
                                                        width: 100%;">
                                        </div>
                                    </div>
                                    
                                    <!-- Círculo numerado en el centro (solo desktop) -->
                                    <div class="d-none d-md-flex col-md-2 justify-content-center align-items-center order-md-1" style="z-index: 10;">
                                        <div style="background: #FF5722; 
                                                    color: white; 
                                                    width: 70px; 
                                                    height: 70px; 
                                                    border-radius: 50%; 
                                                    display: flex; 
                                                    align-items: center; 
                                                    justify-content: center; 
                                                    font-weight: 900; 
                                                    font-size: 2rem; 
                                                    box-shadow: 0 6px 15px rgba(0,0,0,0.4); 
                                                    border: 5px solid white;">
                                            5                                        </div>
                                    </div>
                                    
                                    <!-- ✅ TEXTO (lado opuesto a la foto) -->
                                    <div class="col-md-5 order-md-1">
                                        <div class="cuadro-texto h-100" style="padding: 1.2rem; 
                                                                            background: rgba(255, 255, 255, 0.45) !important; 
                                                                            border: 3px solid #FF5722; 
                                                                            border-radius: 15px; 
                                                                            box-shadow: 0 8px 20px rgba(0,0,0,0.3); 
                                                                            position: relative;">
                                            
                                            <!-- Emoji y título -->
                                            <div class="d-flex align-items-center mb-2">
                                                <span style="font-size: clamp(2rem, 4vw, 2.5rem); 
                                                            margin-right: 0.8rem; 
                                                            filter: drop-shadow(3px 3px 6px rgba(0,0,0,0.3));">
                                                    💎                                                </span>
                                                <h3 class="mb-0" style="font-size: clamp(1rem, 2.3vw, 1.3rem); 
                                                                    color: #001122; 
                                                                    font-weight: 900; 
                                                                    line-height: 1.2; 
                                                                    text-shadow: 2px 2px 4px rgba(255,255,255,1);">
                                                    Plásticos Reciclados                                                </h3>
                                            </div>
                                            
                                            <!-- Descripción -->
                                            <p class="mb-2" style="font-size: clamp(0.85rem, 1.8vw, 1rem); 
                                                                color: #001122; 
                                                                font-weight: 700; 
                                                                line-height: 1.4; 
                                                                text-shadow: 1px 1px 3px rgba(255,255,255,0.9);">
                                                Dale nueva vida creando bisutería, decoraciones, macetas o elementos creativos para el hogar.                                            </p>
                                            
                                            <!-- Badge de beneficio -->
                                            <div style="background: rgba(255, 87, 34, 0.15); 
                                                        padding: 0.6rem; 
                                                        border-radius: 8px; 
                                                        border: 2px solid #FF5722;">
                                                <small style="color: #001122; 
                                                            font-weight: 700; 
                                                            display: block; 
                                                            text-align: center; 
                                                            font-size: clamp(0.75rem, 1.6vw, 0.9rem);">
                                                    <i class="fas fa-check-circle me-1"></i>Productos únicos                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                                                        <!-- IDEA 6 CON FOTO ALTERNA -->
                            <div class="col-12">
                                <div class="row g-2 align-items-center position-relative" style="z-index: 1;">
                                    
                                    <!-- ✅ FOTO (alterna izquierda/derecha) -->
                                    <div class="col-md-5 order-md-1">
                                        <div class="text-center">
                                            <img src="img/maqueta_empaque_carton.webp" 
                                                alt="Cartón Reciclado" 
                                                class="img-fluid" 
                                                style="max-height: 250px; 
                                                        border-radius: 15px; 
                                                        box-shadow: 0 8px 20px rgba(0,0,0,0.4); 
                                                        border: 4px solid #8B4513; 
                                                        object-fit: cover; 
                                                        width: 100%;">
                                        </div>
                                    </div>
                                    
                                    <!-- Círculo numerado en el centro (solo desktop) -->
                                    <div class="d-none d-md-flex col-md-2 justify-content-center align-items-center order-md-1" style="z-index: 10;">
                                        <div style="background: #8B4513; 
                                                    color: white; 
                                                    width: 70px; 
                                                    height: 70px; 
                                                    border-radius: 50%; 
                                                    display: flex; 
                                                    align-items: center; 
                                                    justify-content: center; 
                                                    font-weight: 900; 
                                                    font-size: 2rem; 
                                                    box-shadow: 0 6px 15px rgba(0,0,0,0.4); 
                                                    border: 5px solid white;">
                                            6                                        </div>
                                    </div>
                                    
                                    <!-- ✅ TEXTO (lado opuesto a la foto) -->
                                    <div class="col-md-5 order-md-2">
                                        <div class="cuadro-texto h-100" style="padding: 1.2rem; 
                                                                            background: rgba(255, 255, 255, 0.45) !important; 
                                                                            border: 3px solid #8B4513; 
                                                                            border-radius: 15px; 
                                                                            box-shadow: 0 8px 20px rgba(0,0,0,0.3); 
                                                                            position: relative;">
                                            
                                            <!-- Emoji y título -->
                                            <div class="d-flex align-items-center mb-2">
                                                <span style="font-size: clamp(2rem, 4vw, 2.5rem); 
                                                            margin-right: 0.8rem; 
                                                            filter: drop-shadow(3px 3px 6px rgba(0,0,0,0.3));">
                                                    📐                                                </span>
                                                <h3 class="mb-0" style="font-size: clamp(1rem, 2.3vw, 1.3rem); 
                                                                    color: #001122; 
                                                                    font-weight: 900; 
                                                                    line-height: 1.2; 
                                                                    text-shadow: 2px 2px 4px rgba(255,255,255,1);">
                                                    Cartón Reciclado                                                </h3>
                                            </div>
                                            
                                            <!-- Descripción -->
                                            <p class="mb-2" style="font-size: clamp(0.85rem, 1.8vw, 1rem); 
                                                                color: #001122; 
                                                                font-weight: 700; 
                                                                line-height: 1.4; 
                                                                text-shadow: 1px 1px 3px rgba(255,255,255,0.9);">
                                                Crea maquetas, moldes, empaques personalizados o estructuras para tus productos artesanales.                                            </p>
                                            
                                            <!-- Badge de beneficio -->
                                            <div style="background: rgba(139, 69, 19, 0.15); 
                                                        padding: 0.6rem; 
                                                        border-radius: 8px; 
                                                        border: 2px solid #8B4513;">
                                                <small style="color: #001122; 
                                                            font-weight: 700; 
                                                            display: block; 
                                                            text-align: center; 
                                                            font-size: clamp(0.75rem, 1.6vw, 0.9rem);">
                                                    <i class="fas fa-check-circle me-1"></i>Versátil y económico                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                                                    </div>
                                        
                    <!-- MENSAJE FINAL MOTIVACIONAL CON LAS 3R -->
                    <div class="cuadro-texto mx-auto mt-4 mb-3" style="max-width: 1150px; padding: 1.5rem 2rem; width: 95%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; border: 3px solid rgba(255,255,255,0.3); box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);">
                        <div class="text-center">
                            <h4 class="mb-3" style="font-size: clamp(1.1rem, 2.5vw, 1.4rem); color: white; font-weight: 900;">
                                <i class="fas fa-star me-2" style="color: #FFD700;"></i>
                                ¡La Creatividad No Tiene Límites!                            </h4>
                            <p class="mb-4" style="font-size: clamp(0.9rem, 2vw, 1.1rem); color: white; font-weight: 700; line-height: 1.5;">
                                Cada residuo que reutilizas es un paso hacia un emprendimiento más sostenible y rentable. ¡Sigue explorando nuevas formas de dar vida a los materiales!                            </p>
                            
                            <!-- ICONOS DE LAS 3R -->
                            <div class="row g-3 justify-content-center">
                                                                <div class="col-4 col-md-2">
                                    <div style="background: rgba(255,255,255,0.2); padding: 1rem; border-radius: 10px; text-align: center;">
                                        <div style="font-size: 2.5rem; filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.3));">
                                            ♻️                                        </div>
                                        <p class="mb-0 mt-2" style="color: white; font-weight: 700; font-size: 0.85rem;">Reduce</p>
                                    </div>
                                </div>
                                                                <div class="col-4 col-md-2">
                                    <div style="background: rgba(255,255,255,0.2); padding: 1rem; border-radius: 10px; text-align: center;">
                                        <div style="font-size: 2.5rem; filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.3));">
                                            🔄                                        </div>
                                        <p class="mb-0 mt-2" style="color: white; font-weight: 700; font-size: 0.85rem;">Reutiliza</p>
                                    </div>
                                </div>
                                                                <div class="col-4 col-md-2">
                                    <div style="background: rgba(255,255,255,0.2); padding: 1rem; border-radius: 10px; text-align: center;">
                                        <div style="font-size: 2.5rem; filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.3));">
                                            🌱                                        </div>
                                        <p class="mb-0 mt-2" style="color: white; font-weight: 700; font-size: 0.85rem;">Recicla</p>
                                    </div>
                                </div>
                                                            </div>
                        </div>
                    </div>
                    
                    <!-- Navegación -->
                    <div class="container-fluid px-0 mt-3 mb-3">
                        <div class="row g-0 w-100">
                            <div class="col-12 d-flex justify-content-between align-items-center px-2">
                                <a href="aprende.php?pagina=15" class="btn btn-lg text-white" style="background-color: #43be16; padding: 0.6rem 1.2rem; font-size: clamp(0.9rem, 2vw, 1.05rem);">
                                    <i class="fa fa-arrow-left me-2"></i> Anterior
                                </a>
                                <div class="text-white text-center d-none d-md-block" style="font-size: clamp(0.8rem, 1.5vw, 0.95rem); text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">
                                    Página 17 de 18                                </div>
                                                                    <a href="aprende.php?pagina=17" class="btn btn-lg text-white" style="background-color: #43be16; padding: 0.6rem 1.2rem; font-size: clamp(0.9rem, 2vw, 1.05rem);">
                                        Siguiente <i class="fa fa-arrow-right ms-2"></i>
                                    </a>
                                                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php elseif ($cartilla[$pagina]['tipo'] === 'quiz_preguntas_respuestas'): ?>
    <!-- PÁGINA 17: QUIZ DE PREGUNTAS Y RESPUESTAS CON 3 OPCIONES -->
    <div class="container-fluid header-aprende"
        style="position: relative;
            background-image: url('<?php echo $cartilla[$pagina]['fondo']; ?>');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            padding-bottom: 0.5rem;">
            
        <div class="container-fluid h-100 p-0">
            <div class="row g-0 justify-content-center">
                <!-- Títulos principales -->
                <div class="col-12 col-lg-11 mx-auto px-3 pt-3 pb-2">
                    <div class="cuadro-texto text-center mb-2" style="padding: 0.8rem 1.5rem; max-width: 1100px; margin: 0 auto;">
                        <h1 class="mb-2" style="font-size: clamp(1.3rem, 3.5vw, 1.8rem); line-height: 1.3; color: #001122; font-weight: 900;">
                            <span style="font-size: clamp(1.8rem, 4vw, 2.3rem); margin-right: 0.5rem;">❓</span>
                            <?php echo $cartilla[$pagina]['titulo']; ?>
                        </h1>
                        <h3 class="mb-0" style="font-size: clamp(1rem, 2.2vw, 1.3rem); font-weight: 700; color: #003366;">
                            <?php echo $cartilla[$pagina]['subtitulo']; ?>
                        </h3>
                    </div>
                </div>
                
                <!-- Contenido principal -->
                <div class="col-12 col-lg-10 mx-auto px-3 py-4 d-flex flex-column">
                    
                    <!-- CUADRO INFORMATIVO -->
                    <div class="cuadro-texto mx-auto mb-3" style="max-width: 1000px; padding: 1rem; background: rgba(67, 190, 22, 0.25) !important; border: 2px solid #43be16;">
                        <p class="texto-contenido text-center mb-0" style="font-size: clamp(0.9rem, 2vw, 1.1rem);">
                            <i class="fas fa-info-circle me-2"></i>
                            Responde las <b><?php echo count($cartilla[$pagina]['preguntas']); ?> preguntas</b>. Necesitas <b><?php echo $cartilla[$pagina]['minimo_aprobacion']; ?> respuestas correctas</b> para aprobar.
                        </p>
                    </div>
                    
                    <!-- QUIZ FORM -->
                    <form id="quizPreguntasForm" class="cuadro-texto cuadro-actividad mx-auto flex-grow-1" style="max-width: 1050px; padding: 1.5rem;">
                        <div class="accordion" id="accordionQuizPreguntas">
                            <?php 
                            $preguntas = $cartilla[$pagina]['preguntas'];
                            foreach ($preguntas as $index => $pregunta): 
                                $numero = $index + 1;
                                $isFirst = ($index === 0);
                                
                                // Determinar color según categoría
                                $colorCategoria = match($pregunta['categoria']) {
                                    'Compostaje' => '#43be16',
                                    'Reciclaje' => '#2196F3',
                                    'Reuso' => '#9C27B0',
                                    default => '#003d82'
                                };
                            ?>
                            <div class="accordion-item mb-3" style="border: 3px solid <?php echo $colorCategoria; ?>; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
                                <h2 class="accordion-header" id="headingPregunta<?php echo $numero; ?>">
                                    <button class="accordion-button <?php echo $isFirst ? '' : 'collapsed'; ?>" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#collapsePregunta<?php echo $numero; ?>" 
                                            aria-expanded="<?php echo $isFirst ? 'true' : 'false'; ?>" 
                                            style="background: rgba(255, 255, 255, 0.95); 
                                                color: #001122; 
                                                font-weight: 800; 
                                                font-size: clamp(0.9rem, 2vw, 1.1rem);
                                                padding: 1rem 1.5rem;
                                                border: none;">
                                        <!-- Emoji grande -->
                                        <span style="font-size: clamp(1.5rem, 3vw, 2rem); margin-right: 0.8rem;">
                                            <?php echo $pregunta['emoji']; ?>
                                        </span>
                                        
                                        <!-- Badges -->
                                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2 w-100">
                                            <span class="badge me-2" style="background-color: <?php echo $colorCategoria; ?>; font-size: 0.85rem; padding: 0.4rem 0.8rem;">
                                                Pregunta <?php echo $numero; ?>
                                            </span>
                                            <span class="badge me-2" style="background-color: rgba(0,0,0,0.6); font-size: 0.8rem; padding: 0.3rem 0.7rem;">
                                                <?php echo $pregunta['categoria']; ?>
                                            </span>
                                            <span class="flex-grow-1" style="font-size: clamp(0.85rem, 1.9vw, 1.05rem);">
                                                <?php echo $pregunta['pregunta']; ?>
                                            </span>
                                        </div>
                                    </button>
                                </h2>
                                
                                <div id="collapsePregunta<?php echo $numero; ?>" 
                                    class="accordion-collapse collapse <?php echo $isFirst ? 'show' : ''; ?>">
                                    <div class="accordion-body" style="background: rgba(255, 255, 255, 0.9); padding: 1.5rem;">
                                        
                                        <!-- OPCIONES DE RESPUESTA -->
                                        <?php foreach ($pregunta['opciones'] as $opcionIndex => $opcion): ?>
                                        <div class="form-check mb-3 opcion-pregunta" 
                                            style="padding: 1rem; 
                                                    border-radius: 10px; 
                                                    cursor: pointer; 
                                                    border: 2px solid #e0e0e0; 
                                                    transition: all 0.3s ease;">
                                            <input class="form-check-input" 
                                                type="radio" 
                                                name="pregunta_<?php echo $numero; ?>" 
                                                id="p<?php echo $numero; ?>_op<?php echo $opcionIndex; ?>" 
                                                value="<?php echo htmlspecialchars($opcion); ?>"
                                                required
                                                style="cursor: pointer; 
                                                        width: 22px; 
                                                        height: 22px; 
                                                        margin-top: 0.2rem;">
                                            <label class="form-check-label w-100" 
                                                for="p<?php echo $numero; ?>_op<?php echo $opcionIndex; ?>" 
                                                style="cursor: pointer; 
                                                        font-weight: 700; 
                                                        color: #001122; 
                                                        margin-left: 0.7rem; 
                                                        font-size: clamp(0.85rem, 1.9vw, 1.05rem);
                                                        line-height: 1.4;">
                                                <span class="badge bg-secondary me-2" style="font-size: 0.8rem;">
                                                    <?php echo chr(65 + $opcionIndex); // A, B, C ?>
                                                </span>
                                                <?php echo $opcion; ?>
                                            </label>
                                        </div>
                                        <?php endforeach; ?>
                                        
                                        <!-- ÁREA DE RETROALIMENTACIÓN (oculta inicialmente) -->
                                        <div class="retroalimentacion-pregunta" 
                                            id="retro_<?php echo $numero; ?>" 
                                            style="display: none; 
                                                    margin-top: 1rem; 
                                                    padding: 1rem; 
                                                    border-radius: 10px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- BOTÓN DE ENVÍO -->
                        <div class="text-center mt-4 mb-3">
                            <button type="button" 
                                    id="btnEnviarQuizPreguntas"
                                    class="btn btn-primary btn-lg px-5 py-3" 
                                    onclick="enviarQuizPreguntas()" 
                                    style="background-color: #43be16; 
                                        border-color: #43be16; 
                                        font-size: clamp(1rem, 2.2vw, 1.2rem); 
                                        font-weight: 700;">
                                <i class="fas fa-paper-plane me-2"></i>
                                ¡Enviar Respuestas!
                            </button>
                        </div>
                    </form>
                    
                    <!-- MENSAJE DE RESULTADO -->
                    <div id="mensajeResultadoQuiz" 
                        class="alert text-center mt-3 mb-2" 
                        style="display: none; 
                                max-width: 1050px; 
                                margin: 0 auto; 
                                padding: 2rem; 
                                font-size: clamp(0.9rem, 2vw, 1.1rem); 
                                border-radius: 15px;">
                    </div>
                    
                    <!-- NAVEGACIÓN -->
                    <div class="d-flex justify-content-start mt-3 px-2">
                        <a href="aprende.php?pagina=<?php echo $pagina-1; ?>" 
                        class="btn btn-lg text-white" 
                        style="background-color: #43be16; 
                                padding: 0.6rem 1.2rem; 
                                font-size: clamp(0.9rem, 2vw, 1.05rem);">
                            <i class="fa fa-arrow-left me-2"></i> Anterior
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php elseif ($cartilla[$pagina]['tipo'] === 'contenido'): ?>
    <!-- TEMPLATE PARA PÁGINAS DE CONTENIDO GENERAL -->
    <div class="container-fluid header-aprende"
        style="position: relative;
            background-image: url('<?php echo $cartilla[$pagina]['fondo']; ?>');
            background-size: cover;
            background-position: center;
            min-height: 100vh;">
            
        <div class="container-fluid h-100 p-0">
            <div class="row g-0 justify-content-center" style="min-height: 100vh;"> 
                <!-- Contenido empujado hacia abajo -->
                <div class="col-12 col-lg-8 mx-auto px-4 d-flex flex-column" style="justify-content: flex-end; min-height: 100vh; padding-bottom: 0.5rem;"> 
                    
                    <!-- ✅ ESPACIADOR GRANDE PARA EMPUJAR TODO HACIA ABAJO -->
                    <div style="flex-grow: 1; min-height: 70vh;"></div>
                    
                    <!-- Título -->
                    <div class="cuadro-texto text-center mx-auto mb-2" style="max-width: 800px;">
                        <h1 class="mb-2" style="font-size: clamp(1.5rem, 4vw, 2.2rem); color: #001122; font-weight: 900; line-height: 1.2;">
                            <?php echo $cartilla[$pagina]['titulo']; ?>
                        </h1>
                    </div>
                    
                    <!-- Texto principal -->
                    <?php if (isset($cartilla[$pagina]['texto'])): ?>
                        <div class="cuadro-texto mx-auto mb-2" style="max-width: 800px;">
                            <div class="texto-contenido">
                                <?php echo $texto_con_iconos; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Texto secundario (si existe) -->
                    <?php if (isset($cartilla[$pagina]['texto2'])): ?>
                        <div class="cuadro-texto mx-auto mb-2" style="max-width: 800px;">
                            <div class="texto-contenido">
                                <?php echo $cartilla[$pagina]['texto2']; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Logo SENA (si existe) -->
                    <?php if (isset($cartilla[$pagina]['logo'])): ?>
                        <div class="text-center mb-2">
                            <img src="<?php echo $cartilla[$pagina]['logo']; ?>" 
                                 alt="Logo SENA" 
                                 style="height: 80px; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));">
                        </div>
                    <?php endif; ?>
                    
                    <!-- ✅ NAVEGACIÓN PEGADA AL BORDE INFERIOR -->
                    <div class="d-flex justify-content-between align-items-center mt-2" style="padding-bottom: 0.1rem;">
                        <?php if ($pagina > 0): ?>
                            <a href="aprende.php?pagina=<?php echo $pagina-1; ?>" class="btn btn-lg text-white" style="background-color: #43be16;">
                                <i class="fa fa-arrow-left me-2"></i> Anterior
                            </a>
                        <?php else: ?>
                            <div style="width: 120px;"></div>
                        <?php endif; ?>
                        
                        <div class="text-white text-center d-none d-md-block" style="font-size: clamp(0.8rem, 1.5vw, 0.95rem); text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">
                            Página <?php echo $pagina+1; ?> de <?php echo $total_paginas; ?>
                        </div>
                        
                        <?php if ($pagina < $total_paginas-1): ?>
                            <a href="aprende.php?pagina=<?php echo $pagina+1; ?>" class="btn btn-lg text-white" style="background-color: #43be16;">
                                Siguiente <i class="fa fa-arrow-right ms-2"></i>
                            </a>
                        <?php else: ?>
                            <a href="aprende.php?pagina=0" class="btn btn-lg text-white" style="background-color: #003d82;">
                                <i class="fa fa-home me-2"></i> Inicio
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php endif; ?>     
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

// RESPUESTAS CORRECTAS DEL QUIZ - CORREGIDO
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

console.log('🔍 Respuestas correctas cargadas:', respuestasCorrectas);
console.log('📊 Total de preguntas:', Object.keys(respuestasCorrectas).length);

let tiempoInicio = Date.now();

function enviarReto() {
    const totalPreguntas = document.querySelectorAll('.accordion-item').length;
    console.log('✅ Total de preguntas detectadas:', totalPreguntas);
    
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
            console.log(`✅ Pregunta ${i}: CORRECTA`);
        } else {
            console.log(`❌ Pregunta ${i}: INCORRECTA (Usuario: "${respuestasUsuario[i]}", Correcta: "${respuestasCorrectas[i]}")`);
        }
    }
    
    const porcentaje = (correctas / totalPreguntas) * 100;
    const minimoCorrectas = totalPreguntas === 3 ? 3 : 4;
    const aprobado = correctas >= minimoCorrectas;
    const tiempoSegundos = Math.round((Date.now() - tiempoInicio) / 1000);
    
    const btnEnviar = document.getElementById('btnEnviarReto');
    const textoOriginal = btnEnviar.innerHTML;
    btnEnviar.disabled = true;
    btnEnviar.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enviando...';
    
    // ✅ NUEVO: Obtener información del quiz desde PHP
    const tituloQuiz = <?php echo json_encode($cartilla[$pagina]['actividad_titulo'] ?? 'Quiz de Residuos'); ?>;
    const tipoQuiz = <?php echo json_encode($cartilla[$pagina]['tipo'] ?? 'actividad_quiz'); ?>;
    const instrucciones = <?php echo json_encode($cartilla[$pagina]['actividad_instruccion'] ?? ''); ?>;
    
    console.log('📋 Metadatos del quiz:');
    console.log('   Título:', tituloQuiz);
    console.log('   Tipo:', tipoQuiz);
    console.log('   Instrucciones:', instrucciones.substring(0, 50) + '...');
    
    // Construir datos dinámicamente
    let datosEnviar = {
        respuestas_correctas: correctas,
        total_preguntas: totalPreguntas,
        porcentaje_acierto: porcentaje.toFixed(2),
        tiempo_segundos: tiempoSegundos,
        titulo_quiz: tituloQuiz,
        tipo_quiz: tipoQuiz,
        instrucciones: instrucciones
    };
    
    // Agregar respuestas según el total
    for (let i = 1; i <= totalPreguntas; i++) {
        datosEnviar[`respuesta_${i}`] = respuestasUsuario[i] || '';
    }
    
    console.log('📤 Datos a enviar:', datosEnviar);
    
    $.ajax({
        url: 'guardar_reto.php',
        method: 'POST',
        dataType: 'json',
        data: datosEnviar,
       
        success: function(response) {
            console.log('✅ Respuesta del servidor:', response);
            if (response.data) {
                console.log('🔍 Debug:', response.data);
            }
            mostrarResultado(correctas, totalPreguntas, porcentaje, aprobado, tiempoSegundos, minimoCorrectas);
        },
        error: function(xhr, status, error) {
            console.error('❌ Error al guardar:', error);
            console.error('📄 Respuesta completa:', xhr.responseText);
            alert('❌ Error al guardar el reto. Revisa la consola (F12).');
            btnEnviar.disabled = false;
            btnEnviar.innerHTML = textoOriginal;
        }
    });
}

function mostrarResultado(correctas, total, porcentaje, aprobado, tiempo, minimo) {
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
                <p>Necesitas ${minimo} respuestas correctas de ${total} para aprobar</p>
                <p class="mb-3">Revisa las explicaciones arriba y vuelve a intentarlo</p>
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

// NUEVA FUNCIONALIDAD: Selección interactiva de ítems para el reto de compost
let itemsSeleccionados = [];
const minimoRequerido = <?php echo isset($cartilla[$pagina]['actividad_reto']['minimo_requerido']) ? $cartilla[$pagina]['actividad_reto']['minimo_requerido'] : 3; ?>;

function toggleItem(elemento) {
    const itemId = elemento.getAttribute('data-id');
    const checkmark = elemento.querySelector('.checkmark');
    
    if (itemsSeleccionados.includes(itemId)) {
        // ✅ DESELECCIONAR
        itemsSeleccionados = itemsSeleccionados.filter(id => id !== itemId);
        elemento.style.borderColor = '#ddd';
        elemento.style.background = 'rgba(255, 255, 255, 0.9)';
        elemento.style.transform = 'scale(1)';
        checkmark.style.display = 'none'; // ✅ OCULTAR CHECKMARK
    } else {
        // ✅ SELECCIONAR
        itemsSeleccionados.push(itemId);
        elemento.style.borderColor = '#43be16';
        elemento.style.background = 'rgba(67, 190, 22, 0.15)';
        elemento.style.transform = 'scale(1.05)';
        checkmark.style.display = 'flex'; // ✅ MOSTRAR CHECKMARK
    }
    
    // Actualizar contador
    document.getElementById('contadorSeleccionados').textContent = itemsSeleccionados.length;
    
    console.log('✅ Ítems seleccionados:', itemsSeleccionados);
}

function guardarRetoCompost() {
    if (itemsSeleccionados.length < minimoRequerido) {
        alert(`⚠️ Debes seleccionar al menos ${minimoRequerido} residuos orgánicos para completar el reto.`);
        return;
    }
    
    const btnCompletar = document.getElementById('btnCompletarReto');
    const textoOriginal = btnCompletar.innerHTML;
    btnCompletar.disabled = true;
    btnCompletar.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';
    
    // Obtener textos de los ítems seleccionados
    const itemsTexto = itemsSeleccionados.map(id => {
        const elemento = document.querySelector(`[data-id="${id}"]`);
        return elemento.textContent.trim();
    });
    
    // ✅ NUEVO: Preparar datos para enviar al servidor
    const datosEnviar = {
        titulo_quiz: 'Reto del Tema 4: ¡Mi Primer Paso con el Compost!',
        tipo_quiz: 'reto_compostaje',
        items_seleccionados: itemsSeleccionados.join(','), // IDs separados por coma
        items_texto: itemsTexto.join(' | '), // Textos separados por |
        total_seleccionados: itemsSeleccionados.length,
        minimo_requerido: minimoRequerido,
        aprobado: itemsSeleccionados.length >= minimoRequerido ? 'SI' : 'NO'
    };
    
    console.log('📤 Datos a enviar al servidor:', datosEnviar);
    
    // ✅ GUARDAR EN BASE DE DATOS VÍA AJAX
    $.ajax({
        url: 'guardar_reto.php',
        method: 'POST',
        dataType: 'json',
        data: datosEnviar,
        success: function(response) {
            console.log('✅ Reto de compost guardado en BD:', response);
            
            // También guardar en localStorage como respaldo
            localStorage.setItem('reto_compost_final', JSON.stringify({
                items_seleccionados: itemsSeleccionados,
                items_texto: itemsTexto,
                total_seleccionados: itemsSeleccionados.length,
                fecha: new Date().toISOString()
            }));
            
            // Mostrar mensaje de éxito
            document.getElementById('mensajeExitoCompost').style.display = 'block';
            document.getElementById('mensajeExitoCompost').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
            
            // Deshabilitar todos los ítems
            document.querySelectorAll('.item-compostable').forEach(item => {
                item.style.pointerEvents = 'none';
                item.style.opacity = '0.7';
            });
            
            // Redirigir después de 5 segundos
            const paginaActual = <?php echo $pagina; ?>;
            const totalPaginas = <?php echo $total_paginas; ?>;
            
            setTimeout(() => {
                if (paginaActual < totalPaginas - 1) {
                    window.location.href = 'aprende.php?pagina=' + (paginaActual + 1);
                } else {
                    window.location.href = 'aprende.php?pagina=0';
                }
            }, 5000);
        },
        error: function(xhr, status, error) {
            console.error('❌ Error al guardar reto de compost:', error);
            console.error('📄 Respuesta del servidor:', xhr.responseText);
            alert('❌ Error al guardar el reto. Por favor, intenta de nuevo.');
            
            // Restaurar botón
            btnCompletar.disabled = false;
            btnCompletar.innerHTML = textoOriginal;
        }
    });
}

// Respuestas correctas del quiz de preguntas
const respuestasCorrectasPreguntas = <?php 
    if (isset($cartilla[$pagina]['preguntas']) && $cartilla[$pagina]['tipo'] === 'quiz_preguntas_respuestas') {
        $respuestas = [];
        foreach ($cartilla[$pagina]['preguntas'] as $p) {
            $respuestas[$p['id']] = $p['respuesta_correcta'];
        }
        echo json_encode($respuestas);
    } else {
        echo '{}';
    }
?>;

// Explicaciones de cada pregunta
const explicacionesPreguntas = <?php 
    if (isset($cartilla[$pagina]['preguntas']) && $cartilla[$pagina]['tipo'] === 'quiz_preguntas_respuestas') {
        $explicaciones = [];
        foreach ($cartilla[$pagina]['preguntas'] as $p) {
            $explicaciones[$p['id']] = $p['explicacion'];
        }
        echo json_encode($explicaciones);
    } else {
        echo '{}';
    }
?>;

const totalPreguntasQuiz = <?php echo isset($cartilla[$pagina]['preguntas']) && $cartilla[$pagina]['tipo'] === 'quiz_preguntas_respuestas' ? count($cartilla[$pagina]['preguntas']) : 0; ?>;
const minimoAprobacion = <?php echo isset($cartilla[$pagina]['minimo_aprobacion']) ? $cartilla[$pagina]['minimo_aprobacion'] : 6; ?>;

let tiempoInicioQuiz = Date.now();

function enviarQuizPreguntas() {
    let respuestasUsuario = {};
    let faltanRespuestas = false;
    
    // Validar que todas las preguntas estén respondidas
    for (let i = 1; i <= totalPreguntasQuiz; i++) {
        const respuesta = document.querySelector(`input[name="pregunta_${i}"]:checked`);
        if (!respuesta) {
            faltanRespuestas = true;
            document.getElementById(`collapsePregunta${i}`).classList.add('show');
        } else {
            respuestasUsuario[i] = respuesta.value;
        }
    }
    
    if (faltanRespuestas) {
        alert('⚠️ Por favor responde todas las preguntas antes de enviar.');
        return;
    }
    
    // Calcular resultados
    let correctas = 0;
    for (let i = 1; i <= totalPreguntasQuiz; i++) {
        const esCorrecta = respuestasUsuario[i] === respuestasCorrectasPreguntas[i];
        if (esCorrecta) {
            correctas++;
        }
        
        // Mostrar retroalimentación inmediata
        const retroDiv = document.getElementById(`retro_${i}`);
        retroDiv.style.display = 'block';
        
        if (esCorrecta) {
            retroDiv.className = 'retroalimentacion-pregunta retroalimentacion-correcta';
            retroDiv.innerHTML = `
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-check-circle fa-2x me-3" style="color: #43be16;"></i>
                    <h5 class="mb-0" style="color: #001122; font-weight: 900;">¡Correcto! ✅</h5>
                </div>
                <p class="mb-0" style="color: #001122; font-weight: 700; font-size: 0.95rem; line-height: 1.4;">
                    ${explicacionesPreguntas[i]}
                </p>
            `;
        } else {
            retroDiv.className = 'retroalimentacion-pregunta retroalimentacion-incorrecta';
            retroDiv.innerHTML = `
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-times-circle fa-2x me-3" style="color: white;"></i>
                    <h5 class="mb-0" style="color: white; font-weight: 900;">Incorrecto ❌</h5>
                </div>
                <p class="mb-2" style="color: white; font-weight: 700; font-size: 0.95rem;">
                    <b>Respuesta correcta:</b> ${respuestasCorrectasPreguntas[i]}
                </p>
                <p class="mb-0" style="color: white; font-weight: 700; font-size: 0.9rem; line-height: 1.4;">
                    ${explicacionesPreguntas[i]}
                </p>
            `;
        }
    }
    
    const porcentaje = (correctas / totalPreguntasQuiz) * 100;
    const aprobado = correctas >= minimoAprobacion;
    const tiempoSegundos = Math.round((Date.now() - tiempoInicioQuiz) / 1000);
    
    // Deshabilitar botón y formulario
    const btnEnviar = document.getElementById('btnEnviarQuizPreguntas');
    btnEnviar.disabled = true;
    btnEnviar.innerHTML = '<i class="fas fa-check-circle me-2"></i>Quiz Completado';
    
    document.querySelectorAll('input[type="radio"]').forEach(input => {
        input.disabled = true;
    });
    
    // Guardar en base de datos
    $.ajax({
        url: 'guardar_reto.php',
        method: 'POST',
        dataType: 'json',
        data: {
            titulo_quiz: 'Preguntas y Respuestas Comunes',
            tipo_quiz: 'quiz_preguntas_respuestas',
            respuestas_correctas: correctas,
            total_preguntas: totalPreguntasQuiz,
            porcentaje_acierto: porcentaje.toFixed(2),
            tiempo_segundos: tiempoSegundos,
            aprobado: aprobado ? 'SI' : 'NO'
        },
        success: function(response) {
            console.log('✅ Quiz guardado:', response);
            mostrarResultadoQuiz(correctas, totalPreguntasQuiz, porcentaje, aprobado, tiempoSegundos);
        },
        error: function(xhr, status, error) {
            console.error('❌ Error al guardar:', error);
            mostrarResultadoQuiz(correctas, totalPreguntasQuiz, porcentaje, aprobado, tiempoSegundos);
        }
    });
}

function mostrarResultadoQuiz(correctas, total, porcentaje, aprobado, tiempo) {
    const mensajeDiv = document.getElementById('mensajeResultadoQuiz');
    const minutos = Math.floor(tiempo / 60);
    const segundos = tiempo % 60;
    const tiempoTexto = minutos > 0 ? `${minutos}m ${segundos}s` : `${segundos}s`;
    
    if (aprobado) {
        let mensaje = correctas === total ? '¡PERFECTO! 🏆 100% de acierto' : '¡FELICITACIONES! 🎊';
        mensajeDiv.innerHTML = `
            <div style="background: linear-gradient(135deg, #43be16, #38a01c); color: white; padding: 2rem; border-radius: 15px;">
                <i class="fas fa-trophy fa-3x mb-3" style="color: #FFD700;"></i>
                <h3 class="mb-3"><b>${mensaje}</b></h3>
                <h4 class="mb-3">Has aprobado el quiz</h4>
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
                <p class="mb-3">Has completado exitosamente la cartilla de Economía Circular</p>
                <small>Redirigiendo al inicio en 5 segundos...</small>
            </div>
        `;
        
        setTimeout(() => {
            window.location.href = 'aprende.php?pagina=0';
        }, 5000);
    } else {
        mensajeDiv.innerHTML = `
            <div style="background: linear-gradient(135deg, #e74c3c, #c0392b); color: white; padding: 2rem; border-radius: 15px;">
                <i class="fas fa-times-circle fa-3x mb-3"></i>
                <h3 class="mb-3"><b>Quiz No Aprobado</b></h3>
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
                <p>Necesitas al menos <b>${minimoAprobacion}/${total}</b> para aprobar</p>
                <p class="mb-3">Revisa las explicaciones arriba y vuelve a intentarlo</p>
                <button class="btn btn-light btn-lg mt-2" onclick="location.reload()">
                    <i class="fas fa-redo me-2"></i>Intentar de Nuevo
                </button>
            </div>
        `;
    }
    
    mensajeDiv.style.display = 'block';
    mensajeDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
}
    </script>
    
</body>
</html>