<?php
$pagina_activa = 'trueques';
session_start();
include("conexion.php");

if (!isset($_SESSION['numero_documento'])) {
    header("Location: login.php");
    exit;
}

$usuario_actual_id = null;
$dueno_trueque_id = null;

// --- Lógica para mostrar el detalle de un trueque ---
$detalle_trueque = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT t.*, u.emprendimiento AS nombre_empresa, u.celular AS numero_contacto, u.nombre_completo
            FROM trueques t
            JOIN usuarios u ON t.numero_documento = u.numero_documento            
            WHERE t.id = ?
            AND (t.fecha_expiracion IS NULL OR t.fecha_expiracion >= CURDATE())";            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $trueque = $result->fetch_assoc();
    $stmt->close();

    if (!$trueque) {
        $detalle_trueque = "<div class='container my-5'><div class='alert alert-danger'> ❌ Trueque no encontrado.</div></div>";
    } else {  


        // Registrar visita si el usuario está logueado y no es el creador del trueque

        
        $usuario = null;
        if (isset($_SESSION['numero_documento'])) {
            $sql_usuario = "SELECT id FROM usuarios WHERE numero_documento = ?";
            $stmt_usuario = $conn->prepare($sql_usuario);
            $stmt_usuario->bind_param("s", $_SESSION['numero_documento']);
            $stmt_usuario->execute();
            $res_usuario = $stmt_usuario->get_result();
            $usuario = $res_usuario->fetch_assoc();
            $stmt_usuario->close();

            if ($usuario && $trueque['numero_documento'] != $_SESSION['numero_documento']) {
                $sql_check = "SELECT id FROM visitas_trueques WHERE trueque_id = ? AND usuario_id = ?";
                $stmt_check = $conn->prepare($sql_check);
                $stmt_check->bind_param("ii", $trueque['id'], $usuario['id']);
                $stmt_check->execute();
                $stmt_check->store_result();
                if ($stmt_check->num_rows == 0) {
                    $sql_visita = "INSERT INTO visitas_trueques (trueque_id, usuario_id) VALUES (?, ?)";
                    $stmt_visita = $conn->prepare($sql_visita);
                    $stmt_visita->bind_param("ii", $trueque['id'], $usuario['id']);
                    $stmt_visita->execute();
                    $stmt_visita->close();
                }
                $stmt_check->close();
            }
        } 
        // Mostrar imágenes del trueque (máximo 3)
        $stmt_imgs = $conn->prepare("SELECT ruta_imagen FROM imagenes_trueque WHERE trueque_id = ?");
        $stmt_imgs->bind_param("i", $trueque['id']);
        $stmt_imgs->execute();
        $res_imgs = $stmt_imgs->get_result();
        $imagenes_trueque = $res_imgs->fetch_all(MYSQLI_ASSOC);
        $stmt_imgs->close();

        ob_start();
        ?>
        <div class="container my-5">
            <h2 class="mb-4 text-success"><i class="fa fa-exchange-alt"></i> Detalle del Trueque</h2>
            <div class="card shadow">
                <?php if (!empty($imagenes_trueque)): ?>
                    <div id="carouselDetalleTrueque<?php echo $trueque['id']; ?>" class="carousel slide mb-3" data-bs-ride="carousel" data-bs-interval="3000">
                        <div class="carousel-inner">
                            <?php foreach ($imagenes_trueque as $idx => $img): ?>
                                <div class="carousel-item <?php echo $idx === 0 ? 'active' : ''; ?>">
                                    <img src="<?php echo htmlspecialchars($img['ruta_imagen']); ?>" class="d-block w-100" style="height:250px;object-fit:cover;border-radius:8px;">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count($imagenes_trueque) > 1): ?>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselDetalleTrueque<?php echo $trueque['id']; ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>                                            
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselDetalleTrueque<?php echo $trueque['id']; ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                        <?php endif; ?>
                        <div class="carousel-indicators">
                            <?php foreach ($imagenes_trueque as $idx => $img): ?>
                                <button type="button" data-bs-target="#carouselDetalleTrueque<?php echo $trueque['id']; ?>" data-bs-slide-to="<?php echo $idx; ?>" class="<?php echo $idx === 0 ? 'active' : ''; ?>" aria-current="<?php echo $idx === 0 ? 'true' : 'false'; ?>" aria-label="Slide <?php echo $idx + 1; ?>"></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php elseif (!empty($trueque['foto'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($trueque['foto']); ?>" class="card-img-top" style="height:250px;object-fit:cover;">
                <?php endif; ?>
                <div class="card-body">
                    <span class="badge" style="background:#43be16;color:#fff;"><?php echo htmlspecialchars($trueque['estado']); ?></span>
                    <h4 class="card-title mt-2"><strong>Ofrece:</strong> <?php echo htmlspecialchars($trueque['que_ofreces']); ?></h4>
                    <p><strong>Necesita:</strong> <?php echo htmlspecialchars($trueque['que_necesitas']); ?></p>
                    <p><strong>Descripción:</strong> <?php echo htmlspecialchars($trueque['descripcion']); ?></p>
                    <p><strong>Publicado por:</strong> <?php echo htmlspecialchars($trueque['nombre_completo']); ?></p>
                    <p><strong>Empresa:</strong> <?php echo htmlspecialchars($trueque['nombre_empresa']); ?></p>
                    <p><strong>Contacto:</strong> <?php echo htmlspecialchars($trueque['numero_contacto']); ?></p>
                    <?php if (!empty($trueque['instagram'])): ?>
                        <p><strong>Instagram:</strong> <a href="<?php echo htmlspecialchars($trueque['instagram']); ?>" target="_blank"><?php echo htmlspecialchars($trueque['instagram']); ?></a></p>
                    <?php endif; ?>
                    <?php if (!empty($trueque['facebook'])): ?>
                        <p><strong>Facebook:</strong> <a href="<?php echo htmlspecialchars($trueque['facebook']); ?>" target="_blank"><?php echo htmlspecialchars($trueque['facebook']); ?></a></p>
                    <?php endif; ?>
                    <?php if (!empty($trueque['direccion'])): ?>
                        <p><strong>Dirección:</strong> <?php echo htmlspecialchars($trueque['direccion']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($trueque['correo'])): ?>
                        <p><strong>Correo:</strong> <a href="mailto:<?php echo htmlspecialchars($trueque['correo']); ?>"><?php echo htmlspecialchars($trueque['correo']); ?></a></p>
                    <?php endif; ?>
                    <?php if (!empty($trueque['barrio'])): ?>
                        <p><strong>Barrio:</strong> <?php echo htmlspecialchars($trueque['barrio']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($trueque['etiquetas'])): ?>
                        <p>
                        <?php foreach (explode(',', $trueque['etiquetas']) as $tag): ?>
                            <span class="badge bg-info text-dark">#<?php echo trim(htmlspecialchars($tag)); ?></span>
                        <?php endforeach; ?>
                        </p>
                    <?php endif; ?>
                    <p class="text-muted"><i class="fa fa-calendar"></i> <?php echo date('d/m/Y', strtotime($trueque['fecha_publicacion'])); ?></p>
                    <a href="trueques.php#trueques" class="btn btn-success mt-2">Volver a Trueques</a>
                    
                    <!-- Mostrar usuarios que han visto el trueque -->
                    <?php
                    $sql_vistos = "SELECT u.nombre_completo FROM visitas_trueques v JOIN usuarios u ON v.usuario_id = u.id WHERE v.trueque_id = ?";
                    $stmt_vistos = $conn->prepare($sql_vistos);
                    $stmt_vistos->bind_param("i", $trueque['id']);
                    $stmt_vistos->execute();
                    $res_vistos = $stmt_vistos->get_result();
                    ?>
                    <div class="mb-3 mt-4">
                        <strong>Usuarios que han visto este trueque:</strong>
                        <?php if ($res_vistos->num_rows == 0): ?>
                            <span class="text-muted">Nadie ha visto este trueque aún.</span>
                        <?php else: ?>
                            <ul>
                                <?php while ($visto = $res_vistos->fetch_assoc()): ?>
                                    <li><?php echo htmlspecialchars($visto['nombre_completo']); ?></li>
                                <?php endwhile; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <?php $stmt_vistos->close(); ?>                 

                    <!-- CHAT/HILO ENTRE DUEÑO Y USUARIO SELECCIONADO -->
                    <?php
                    // Obtener IDs de usuario actual y dueño del trueque
                    $usuario_actual_id = null;
                    $dueno_trueque_id = null;
                    if(isset($_SESSION['numero_documento'])) {
                        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE numero_documento = ?");
                        $stmt->bind_param("s", $_SESSION['numero_documento']);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        if($row = $res->fetch_assoc()) {
                            $usuario_actual_id = $row['id'];
                        }
                        $stmt->close();
                    }
                    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE numero_documento = ?");
                    $stmt->bind_param("s", $trueque['numero_documento']);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    if($row = $res->fetch_assoc()) {
                        $dueno_trueque_id = $row['id'];
                    }
                    $stmt->close();

                    // Si el usuario actual es el dueño, mostrar lista de usuarios con los que ha conversado
                    if ($usuario_actual_id == $dueno_trueque_id) {
                        $stmt_usuarios = $conn->prepare(
                            "SELECT DISTINCT u.id, u.nombre_completo
                            FROM mensajes_trueque m
                            JOIN usuarios u ON m.de_usuario_id = u.id
                            WHERE m.trueque_id = ? AND m.de_usuario_id != ?");
                        $stmt_usuarios->bind_param("ii", $trueque['id'], $dueno_trueque_id);
                        $stmt_usuarios->execute();
                        $res_usuarios = $stmt_usuarios->get_result();
                        $usuarios_interesados = [];
                        while ($row = $res_usuarios->fetch_assoc()) {
                            $usuarios_interesados[] = $row;
                        }
                        $stmt_usuarios->close();

                        // Selección de usuario (por GET)
                        $usuario_seleccionado_id = isset($_GET['usuario']) ? intval($_GET['usuario']) : ($usuarios_interesados[0]['id'] ?? null);
                    }
                    ?>

                    <?php
                    // Mostrar mensajes del hilo entre el usuario actual y el usuario seleccionado
                    $stmt_mensajes = $conn->prepare(
                        "SELECT m.*, 
                                u1.nombre_completo AS nombre_remitente, 
                                u2.nombre_completo AS nombre_destinatario
                        FROM mensajes_trueque m
                        JOIN usuarios u1 ON m.de_usuario_id = u1.id
                        JOIN usuarios u2 ON m.para_usuario_id = u2.id
                        WHERE m.trueque_id = ?
                        ORDER BY m.fecha_envio ASC"
                    );
                    $stmt_mensajes->bind_param("i", $trueque['id']);
                    $stmt_mensajes->execute();
                    $res_mensajes = $stmt_mensajes->get_result();
                    $mensajes = [];
                    while($msg = $res_mensajes->fetch_assoc()) {
                        $mensajes[$msg['respuesta_a_id']][] = $msg;
                    }
                    $stmt_mensajes->close();

                    // Función recursiva para mostrar mensajes y respuestas
                    function mostrar_mensajes($mensajes, $padre_id = null, $dueno_trueque_id, $usuario_actual_id, $nivel = 0) {
                        if(empty($mensajes[$padre_id])) return;
                        foreach($mensajes[$padre_id] as $msg) {
                            $es_dueno = $msg['de_usuario_id'] == $dueno_trueque_id;
                            $bg = $es_dueno ? 'background:#e6ffe6;' : 'background:#f0f0f0;';
                            $margin_left = $nivel * 40;
                            $align = $es_dueno ? 'text-align:right;' : '';
                            $form_id = 'form-responder-'.$msg['id'];
                            echo '<div class="mb-2" style="margin-left:'.$margin_left.'px;'.$align.'">';
                            // INICIO BURBUJA
                            echo '<div class="list-group-item" style="'.$bg.';border-radius:18px;box-shadow:0 1px 4px #0001;display:inline-block;max-width:90%;">';
                            echo '<strong>'.htmlspecialchars($msg['nombre_remitente']).':</strong> ';
                            echo nl2br(htmlspecialchars($msg['mensaje']));
                            echo '<br><small class="text-muted">'.date('d/m/Y H:i', strtotime($msg['fecha_envio'])).'</small>';
                            // SOLO mostrar "Responder" en mensajes raíz (nivel 0)
                            if($nivel == 0 && isset($_SESSION['numero_documento']) && $usuario_actual_id) {
                                echo '<div style="margin-top:6px;">';
                                echo '<a href="javascript:void(0);" class="btn btn-outline-primary btn-sm" style="border-radius:12px;padding:2px 12px;font-size:0.95em;" onclick="mostrarFormulario(\''.$form_id.'\')">Responder</a>';
                                // Formulario oculto por defecto
                                echo '<div id="'.$form_id.'" style="display:none;margin-top:8px;">';
                                echo '<form method="POST" action="enviar_mensaje_trueque.php">';
                                echo '<input type="hidden" name="trueque_id" value="'.intval($msg['trueque_id']).'">';
                                echo '<input type="hidden" name="de_usuario_id" value="'.$usuario_actual_id.'">';
                                echo '<input type="hidden" name="para_usuario_id" value="'.$msg['de_usuario_id'].'">';
                                echo '<input type="hidden" name="respuesta_a_id" value="'.$msg['id'].'">';
                                echo '<textarea name="mensaje" class="form-control mb-2" rows="1" placeholder="Responder a '.htmlspecialchars($msg['nombre_remitente']).'" required></textarea>';
                                echo '<button type="submit" class="btn btn-primary btn-sm">Enviar respuesta</button>';
                                echo '</form>';
                                echo '</div>';
                                echo '</div>';
                            }
                            echo '</div>'; // FIN BURBUJA
                            // Mostrar respuestas anidadas (nivel + 1)
                            mostrar_mensajes($mensajes, $msg['id'], $dueno_trueque_id, $usuario_actual_id, $nivel + 1);
                            echo '</div>';
                        }
                    }
                    ?>

                    <div id="mensajes" class="mb-3 mt-4">
                        <h6><i class="fa fa-comments text-success"></i> Conversación</h6>
                        <?php
                        if(empty($mensajes[null])) {
                            echo '<div class="text-muted">No hay mensajes aún.</div>';
                        } else {
                            mostrar_mensajes($mensajes, null, $dueno_trueque_id, $usuario_actual_id);
                        }
                        ?>
                    </div>

                    <!-- Formulario para que cualquier usuario escriba al dueño (mensaje raíz) -->
                    <?php if(isset($_SESSION['numero_documento']) && $usuario_actual_id != $dueno_trueque_id): ?>
                    <form method="POST" action="enviar_mensaje_trueque.php" class="mt-3">
                        <input type="hidden" name="trueque_id" value="<?php echo $trueque['id']; ?>">
                        <input type="hidden" name="de_usuario_id" value="<?php echo $usuario_actual_id; ?>">
                        <input type="hidden" name="para_usuario_id" value="<?php echo $dueno_trueque_id; ?>">
                        <textarea name="mensaje" class="form-control mb-2" rows="2" placeholder="Escribe tu mensaje..." required></textarea>
                        <button type="submit" class="btn btn-success btn-sm">Enviar mensaje</button>
                        <input type="hidden" name="respuesta_a_id" value="">
                    </form>
                    <?php endif; ?>
                    <!-- FIN BLOQUE DE CHAT/HILO -->                  
                </div>
            </div>
        </div>
        <?php
        $detalle_trueque = ob_get_clean();
    }
}

// --- Mostrar la lista de trueques ---

$sql = "SELECT t.*, 
                u.emprendimiento AS nombre_empresa, 
                u.celular AS numero_contacto,
                u.nombre_completo, 
                u.instagram, u.facebook, u.direccion, u.correo, u.barrio
        FROM trueques t
        JOIN usuarios u ON t.numero_documento = u.numero_documento
        WHERE t.estado = 'activo'
        AND (t.fecha_expiracion IS NULL OR t.fecha_expiracion >= CURDATE())
        ORDER BY t.fecha_publicacion DESC";
$result = $conn->query($sql);
$trueques_publicados = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Trueques Comunitarios</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

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

<body style="padding-top:75px;">

    <?php
    if ($detalle_trueque) {
        echo $detalle_trueque;
    } else {
        ?>
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
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="index.php" class="nav-item nav-link fw-bold<?php echo $pagina_activa === 'inicio' ? ' active text-primary' : ' text-dark'; ?>">Inicio</a>
                    <a href="trueques.php#trueques" class="nav-item nav-link fw-bold<?php echo $pagina_activa === 'trueques' ? ' active text-primary' : ' text-dark'; ?>">Trueques</a>
                    <a href="aprende.php" class="nav-item nav-link fw-bold<?php echo $pagina_activa === 'aprende' ? ' active text-primary' : ' text-dark'; ?>">Aprende</a>
                    <?php
                    if(isset($_SESSION['numero_documento'])) {
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
                        $clase_perfil = $pagina_activa === 'perfil' ? ' active text-primary' : ' text-dark';
                        echo '<a href="perfil.php" class="nav-item nav-link' . $clase_perfil . '" style="color:#43be16 !important;font-weight:bold !important;">'.($nombre_usuario ? htmlspecialchars($nombre_usuario) : 'Perfil').'</a>';
                    }
                    ?>
                    <?php
                    if (isset($_SESSION['numero_documento'])) {
                        // Botón de cerrar sesión escritorio
                        echo '<a href="logout.php" class="btn py-4 px-lg-5 d-none d-lg-block text-white" style="background-color: #43be16;">Cerrar sesión<i class="fa fa-arrow-right ms-3"></i></a>';
                        // Botón de cerrar sesión móvil (hamburguesa)
                        echo '<a href="logout.php" class="btn btn-success d-block d-lg-none my-3 w-100 text-white text-center justify-content-center align-items-center d-flex" style="background-color: #43be16;">'
                            .'<span class="mx-auto">Cerrar sesión</span>'
                            .'<i class="fa fa-arrow-right ms-2"></i>'
                        .'</a>';
                    } else {
                        // Botón registrate ahora solo si NO está logueado
                        echo '<a href="registro.php" class="btn py-4 px-lg-5 d-none d-lg-block text-white" style="background-color: #43be16;">Registrate Ahora<i class="fa fa-arrow-right ms-3"></i></a>';
                    }
                    ?>    
                </div>
            </div>
        </nav>
        <!-- Navbar End -->



        <!-- Header Start -->
        <style>
        .header-trueques {
            background: url('img/portada.jpg') center center/cover no-repeat;
        }
        @media (max-width: 991.98px) {
            .header-trueques {
                min-height: 60vh !important;
                padding-top: 2rem !important;
                padding-bottom: 2rem !important;
                display: flex;
                align-items: center;
                justify-content: center;
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            .header-trueques .container {
                padding: 0 !important;
            }
            .header-trueques-inner {
                background: rgba(60,60,60,0.18); /* gris aún más oscuro translúcido */
                border-radius: 20px;
                box-shadow: 0 4px 24px rgba(0,0,0,0.12);
                padding: 2rem 1rem;
                width: 100%;
                max-width: 100%;
            }
            .header-trueques h1 {
                font-size: 2rem !important;
            }
            .header-trueques p.lead {
                font-size: 1rem !important;
                margin-left: 0.5rem;
                margin-right: 0.5rem;
            }
        }
        </style>
        <div class="container-fluid bg-primary py-5 mb-5 page-header header-trueques">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-10 text-center header-trueques-inner">
                        <h1 class="display-3 text-white animated slideInDown">Trueques Comunitarios</h1>
                        <p class="lead text-white mt-3 mb-4">
                            Bienvenido a la red de intercambio solidario donde puedes ofrecer y recibir productos, servicios o saberes sin necesidad de dinero.<br>
                            ¡Participa, fortalece tu comunidad y promueve la economía circular!
                        </p>
                        <a class="btn btn-success py-2 px-5 mt-5" href="#trueques-publicados" style="background-color: #43be16; margin-top: 5rem;">Ver Trueques Publicados</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->


        <!-- Service Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                        <a href="javascript:void(0)" style="text-decoration:none" 
                            onclick="showserviceMenssage(
                                'Intercambiar Productos', 
                                'Participa en el trueque comunitario y fortalece la economia solidaria.',
                                'img/intercambio.webp'
                            )">
                            <div class="service-item text-center pt-3">
                                <div class="p-4">
                                    <i class="fa fa-3x fa-exchange-alt text-primary mb-4"></i>
                                    <h5 class="mb-3">Intercambiar Productos</h5>
                                    <p>Participa en el trueque comunitario y fortalece la economia solidaria.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                        <a href="javascript:void(0)" style="text-decoration:none" 
                            onclick="showserviceMenssage(
                                'Colaborar sin Dinero', 
                                'Ofrece y recibe servicios o productos sin necesidad de efectivo.',
                                'img/colaborar.webp'
                            )">
                            <div class="service-item text-center pt-3">
                                <div class="p-4">
                                    <i class="fa fa-3x fa-hands-helping text-primary mb-4"></i>
                                    <h5 class="mb-3">Colaborar sin Dinero</h5>
                                    <p>Ofrece y recibe servicios o productos sin necesidad de efectivo.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                        <a href="javascript:void(0)" style="text-decoration:none" 
                            onclick="showserviceMenssage(
                                'Economía Circular', 
                                'Promueve el consumo responsable y la reutilización de recursos.',
                                'img/economia_circular.jpg'
                            )">
                            <div class="service-item text-center pt-3">
                                <div class="p-4">
                                    <i class="fa fa-3x fa-recycle text-primary mb-4"></i>
                                    <h5 class="mb-3">Economía circular</h5>
                                    <p>Promueve el consumo responsable y la reutilización de recursos.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                        <a href="javascript:void(0)" style="text-decoration:none"   
                            onclick="showserviceMenssage(
                                'Comunidad Unida', 
                                'Fortalece lazos y apoya a otros miembros de tu entorno.',
                                'img/comunidad_unida.webp'
                            )">
                            <div class="service-item text-center pt-3">
                                <div class="p-4">
                                    <i class="fa fa-3x fa-users text-primary mb-4"></i>
                                    <h5 class="mb-3">Comunidad Unida</h5>
                                    <p>Fortalece lazos y apoya a otros miembros de tu entorno.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Service End -->

        
        <!-- Trueques Start -->
        <div id="trueques" class="container-xxl py-5">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                        <div class="position-relative h-100">
                            <img class="img-fluid position-absolute w-100 h-100" src="img/trueque.png" alt="" style="object-fit: cover;">
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                        <h6 class="section-title bg-white text-start text-primary pe-3">Trueque Comunitario</h6>
                        <h1 class="mb-4">Bienvenido a tu espacio de intercambio solidario</h1>
                        <p class="mb-4">
                            El <strong>trueque</strong> es una forma ancestral de intercambio que nos permite compartir lo que tenemos y recibir lo que necesitamos, sin necesidad de dinero. Aquí podrás ofrecer objetos, conocimientos o servicios, y a su vez encontrar productos que aporten valor a tu vida. Nuestro objetivo es fortalecer la economía solidaria y promover el consumo responsable.
                        </p>
                        <div class="row gy-2 gx-4 mb-4">
                            <div class="col-sm-6">
                                <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Intercambia productos, servicios o saberes</p>
                            </div>
                            <div class="col-sm-6">
                                <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Sin dinero, solo solidaridad y colaboración</p>
                            </div>
                            <div class="col-sm-6">
                                <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Fortalece tu comunidad y apoya la economía circular</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Trueques End -->
        
        <!-- Trueques Publicados Start -->
        <div id="trueques-publicados" class="container-xxl py-5">
            <div class="container">
                <h2 class="mb-4 text-success"><i class="fa fa-exchange-alt"></i> Trueques publicados</h2>
                <?php if (empty($trueques_publicados)): ?>
                    <div class="alert alert-info">No hay trueques publicados aún.</div>
                <?php else: ?>
                    <div class="row">
                    <?php foreach ($trueques_publicados as $t): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm trueque-card" style="cursor:pointer;" onclick="window.location.href='trueques.php?id=<?php echo $t['id']; ?>'">
                                
                                <?php
                                // Mostrar imágenes del trueque (máximo 3)
                                $stmt_imgs = $conn->prepare("SELECT ruta_imagen FROM imagenes_trueque WHERE trueque_id = ?");
                                $stmt_imgs->bind_param("i", $t['id']);
                                $stmt_imgs->execute();
                                $res_imgs = $stmt_imgs->get_result();
                                $imagenes_trueque = $res_imgs->fetch_all(MYSQLI_ASSOC);
                                $stmt_imgs->close();

                                if (!empty($imagenes_trueque)): ?>  
                                    <div id="carouselTrueque<?php echo $t['id']; ?>" class="carousel slide mb-3" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php foreach ($imagenes_trueque as $idx => $img): ?>
                                                <div class="carousel-item <?php echo $idx === 0 ? 'active' : ''; ?>">
                                                    <img src="<?php echo htmlspecialchars($img['ruta_imagen']); ?>" class="d-block w-100" style="height:250px;object-fit:cover;border-radius:8px;">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php if (count($imagenes_trueque) > 1): ?>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselTrueque<?php echo $t['id']; ?>" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon"></span>                                            
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselTrueque<?php echo $t['id']; ?>" data-bs-slide="next">
                                            <span class="carousel-control-next-icon"></span>
                                        </button>
                                        <?php endif; ?>
                                        <div class="carousel-indicators">
                                            <?php foreach ($imagenes_trueque as $idx => $img): ?>
                                                <button type="button" data-bs-target="#carouselTrueque<?php echo $t['id']; ?>" data-bs-slide-to="<?php echo $idx; ?>" class="<?php echo $idx === 0 ? 'active' : ''; ?>" aria-current="<?php echo $idx === 0 ? 'true' : 'false'; ?>" aria-label="Slide <?php echo $idx + 1; ?>"></button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>                            
                                <div class="card-body">
                                    <span class="badge" style="background:#43be16;color:#fff;"><?php echo htmlspecialchars($t['estado']); ?></span>
                                    <h5 class="card-title mb-1">
                                        <a href="trueques.php?id=<?php echo $t['id']; ?>" Style="color:#43be16;text-decoration:none;">
                                            <strong>Ofrece:</strong> <?php echo htmlspecialchars($t['que_ofreces']); ?>
                                        </a>
                                    </h5>
                                    <?php if (!empty($t['categoria'])): ?>
                                        <span class="badge bg-primary"><?php echo htmlspecialchars($t['categoria']); ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($t['subcategoria'])): ?>
                                        <span class="badge bg-secondary"><?php echo htmlspecialchars($t['subcategoria']); ?></span>
                                    <?php endif; ?>
                                    <?php
                                        $badgeClass = 'bg-secondary';
                                        if ($t['estado'] === 'activo') $badgeClass = 'badge-activo';
                                        elseif ($t['estado'] === 'borrador') $badgeClass = 'bg-warning text-dark';
                                        elseif ($t['estado'] === 'cancelado') $badgeClass = 'bg-danger';
                                    ?>
                                    <span class="badge <?php echo $badgeClass; ?>">
                                        <?php echo htmlspecialchars($t['estado']); ?>
                                    </span>
                                    <p class="mb-1"><strong>Necesita:</strong> <?php echo htmlspecialchars($t['que_necesitas']); ?></p>
                                    <p class="card-text"><?php echo htmlspecialchars($t['descripcion']); ?></p>
                                    <small class="text-muted"><i class="fa fa-calendar"></i> <?php echo date('d/m/Y', strtotime($t['fecha_publicacion'])); ?></small>
                                    <br>
                                    <small><i class="fa fa-building"></i> <strong>Empresa:</strong> <?php echo htmlspecialchars($t['nombre_empresa']); ?></small><br>
                                    <small><i class="fa fa-phone"></i> <strong>Contacto:</strong> <?php echo htmlspecialchars($t['numero_contacto']); ?></small>
                                    <?php if (!empty($t['barrio'])): ?>
                                        <br><small><i class="fa fa-map-marker-alt"></i> <?php echo htmlspecialchars($t['barrio']); ?></small>
                                    <?php endif; ?>
                                    <?php if (!empty($t['etiquetas'])): ?>
                                        <div class="mt-2">
                                            <?php foreach (explode(',', $t['etiquetas']) as $tag): ?>
                                                <span class="badge bg-info text-dark">#<?php echo trim(htmlspecialchars($tag)); ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($t['instagram'])): ?>
                                        <small><i class="fab fa-instagram"></i> <?php echo htmlspecialchars($t['instagram']); ?></small><br>
                                    <?php endif; ?>
                                    <?php if (!empty($t['facebook'])): ?>
                                        <small><i class="fab fa-facebook"></i> <?php echo htmlspecialchars($t['facebook']); ?></small><br>
                                    <?php endif; ?>
                                    <?php if (!empty($t['direccion'])): ?>
                                        <small><i class="fa fa-map-marker-alt"></i> <?php echo htmlspecialchars($t['direccion']); ?></small><br>
                                    <?php endif; ?>
                                    <?php if (!empty($t['correo'])): ?>
                                        <small><i class="fa fa-envelope"></i> <?php echo htmlspecialchars($t['correo']); ?></small><br>
                                    <?php endif; ?>
                                </div>                                
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Trueques Publicados End -->  
        <?php 
    }
    ?>

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
    document.addEventListener("DOMContentLoaded", function() {
        if(window.location.hash === "#trueques") {
            setTimeout(function() {
                var target = document.getElementById("trueques");
                if(target){
                    var navbarHeight = document.querySelector('.navbar').offsetHeight || 0;
                    var y = target.getBoundingClientRect().top + window.pageYOffset - navbarHeight;
                    window.scrollTo({top: y, behavior: "smooth"});
                }
            }, 300);
        }
    });
    </script>

    <!-- Modal para mensajes de Service Start -->
    <div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceModalLabel">Mensaje</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" id="serviceModalBody">
                <!-- Aquí va el mensaje dinámico -->
                </div>
            </div>
        </div>
    </div>
    <script>
        function showserviceMenssage(title, message, imgUrl = null) {
            document.getElementById('serviceModalLabel').textContent = title;
            let html = '';
            if(imgUrl){
                html += `<img src="${imgUrl}" alt="" class="img-fluid mb-3" style="max-height:150px;display:block;margin:auto;">`;
            }
            html += `<p>${message}</p>`;
            document.getElementById('serviceModalBody').innerHTML = html;
            var serviceModal = new bootstrap.Modal(document.getElementById('serviceModal'));
            serviceModal.show();
    }
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var carousels = document.querySelectorAll('.carousel');
        carousels.forEach(function(carousel) {
            var bsCarousel = new bootstrap.Carousel(carousel, {
                interval: 3000,
                ride: 'carousel'
            });
        });
    });
    </script>

    <script>
    function mostrarFormulario(id) {
        // Oculta todos los formularios primero
        document.querySelectorAll('[id^="form-responder-"]').forEach(function(div) {
            div.style.display = 'none';
        });
        // Muestra solo el formulario seleccionado
        var form = document.getElementById(id);
        if(form) form.style.display = 'block';
    }
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    </script>
</body>
</html>