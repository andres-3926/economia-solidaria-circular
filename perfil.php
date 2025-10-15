<?php
$pagina_activa = 'perfil';
session_start();
include("conexion.php");

if (!isset($_SESSION['numero_documento'])) {
    header("Location: login.php");
    exit;
}

$numero_documento = $_SESSION['numero_documento'];
$sql = "SELECT nombre_completo, celular, barrio, emprendimiento, direccion,foto, rol, resena, id FROM usuarios WHERE numero_documento = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $numero_documento);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$stmt->close();

$foto = !empty($usuario['foto']) ? 'uploads/' . $usuario['foto'] : 'img/avatardefault.png';

// Consulta los trueques del usuario
if ($usuario['rol'] === 'administrador') {
    $sql_trueques = "SELECT * FROM trueques ORDER BY fecha_publicacion DESC";
    $result_trueques = $conn->query($sql_trueques);
    $lista_trueques = $result_trueques->fetch_all(MYSQLI_ASSOC);
} else {
    $sql_trueques = "SELECT * FROM trueques WHERE numero_documento = ? ORDER BY fecha_publicacion DESC";
    $stmt_trueques = $conn->prepare($sql_trueques);
    $stmt_trueques->bind_param("s", $numero_documento);
    $stmt_trueques->execute();
    $result_trueques = $stmt_trueques->get_result();
    $lista_trueques = $result_trueques->fetch_all(MYSQLI_ASSOC);
    $stmt_trueques->close();
}

// --- AQUI AGREGA LA CONSULTA DE NOTIFICACIONES ---
$noti_pendientes = 0;
if ($usuario['rol'] === 'administrador') {
    $sql_noti = "SELECT COUNT(*) AS total FROM notificaciones n JOIN usuarios u ON n.usuario_id = u.id WHERE n.leida=0 AND u.rol != 'administrador'";
    $result_noti = $conn->query($sql_noti);
    if ($row_noti = $result_noti->fetch_assoc()) {
        $noti_pendientes = $row_noti['total'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Perfil - Reciclando Juntas</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="img/favicon.ico" rel="icon">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body {
            background: linear-gradient(135deg, #e8f5e9 0%, #e3f2fd 100%);
        }
        .profile-card {
            background: #fff;
            border-radius: 1.2rem;
            box-shadow: 0 4px 24px rgba(67,190,22,0.10);
            padding: 2rem 1.5rem 1.5rem 1.5rem;
            margin-bottom: 2rem;
            transition: box-shadow 0.2s;
        }
        .profile-card:hover {
            box-shadow: 0 8px 32px rgba(67,190,22,0.18);
        }
        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid #43be16;
            object-fit: cover;
            margin-bottom: 1rem;
            box-shadow: 0 2px 12px rgba(67,190,22,0.12);
        }
        .badge-custom {
            background: #43be16;
            color: #fff;
            font-size: 0.9em;
        }
        .insignia-img {
            width: 48px;
            height: 48px;
            object-fit: contain;
            margin-right: 8px;
        }
        .profile-upload-form input[type="file"] {
            display: none;
        }
        .profile-upload-form label {
            cursor: pointer;
        }
        /* Tarjetas de pestañas tipo card */
        .card-tab {
            background: #f4fcf7;
            border: none;
            cursor: pointer;
            transition: background 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(67,190,22,0.05);
            min-height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .card-tab:hover, .card-tab.tab-active {
            background: #43be16;
            color: #fff;
            box-shadow: 0 4px 16px rgba(67,190,22,0.12);
        }
        .card-tab:hover i, .card-tab.tab-active i,
        .card-tab:hover .fw-bold, .card-tab.tab-active .fw-bold {
            color: #fff !important;
        }
        .card-tab .fw-bold {
            font-size: 1rem;
            color: #222;
            transition: color 0.2s;
        }
        .tab-pane {
            min-height: 120px;
        }
        @media (max-width: 767px) {
            .profile-card {
                padding: 1.2rem 0.7rem 1.2rem 0.7rem;
            }
            .profile-avatar {
                width: 100px;
                height: 100px;
            }
            .card-tab {
                min-height: 100px;
            }
        }
        #perfilTabsCards .col-6 {
            flex: 0 0 20%;
            max-width: 20%; /* Ajusta el ancho para que quepan más tarjetas en pantallas pequeñas */
        }
        #perfilTabsCards .fw-bold {
            font-size: 1rem;         /* Tamaño más pequeño */
            font-weight: 600;
            white-space: nowrap;     /* Evita salto de línea */
            line-height: 1.2;
        }
        .card-tab {
             min-height: 120px;       /* Opcional: reduce la altura de la tarjeta */
        }
        .page-header {
            background: linear-gradient(rgba(24, 29, 56, .7), rgba(24, 29, 56, .7)), url('<?php echo htmlspecialchars($foto); ?>');
            background-position: center 20%;
            background-repeat: no-repeat;
            background-size: 100% 120%;
            min-height: 420px;
            max-width: 1200px;
            margin-left: auto !important;
            margin-right: auto !important;
            margin-top: 32px !important;
            border-radius: 2.5vw;
            overflow: hidden;
        }
        .badge-activo {
            background: #43be16 !important;
            color: #fff !important;
        }
    </style>
</head>
<body>
<?php if (isset($_GET['mensaje'])): ?>
    <div id="toast-alert" style="
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: <?php echo (strpos($_GET['mensaje'], '✅') !== false) ? '#4caf50' : '#f44336'; ?>;
        color: #fff;
        padding: 0.7rem 1.2rem;
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.18);
        font-size: 1rem;
        font-weight: 500;
        z-index: 1060;
        opacity: 0;
        transform: translateX(120%);
        transition: opacity 0.5s, transform 0.5s;
    ">
        <?php echo htmlspecialchars($_GET['mensaje']); ?>
    </div>
    <script>
        window.onload = function() {
            var toast = document.getElementById('toast-alert');
            toast.style.opacity = 1;
            toast.style.transform = 'translateX(0)';
            setTimeout(function() {
                toast.style.opacity = 0;
                toast.style.transform = 'translateX(120%)';
            }, 3500);
        }
    </script>
<?php endif; ?>

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.php" class="navbar-brand d-flex align-items-center px-2 px-lg-4">
            <h2 class="m-0 text-shadow titulo-navbar text-break" style="color: #43be16;"><i class="fa-solid fa-recycle fa-beat fa-xl me-2"></i>Economía Solidaria y Circular</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link fw-bold<?php echo $pagina_activa === 'inicio' ? ' active text-primary' : ' text-dark'; ?>">Inicio</a>
                <a href="trueques.php" class="nav-item nav-link fw-bold<?php echo $pagina_activa === 'trueques' ? ' active text-primary' : ' text-dark'; ?>">Trueques</a>
                <a href="aprende.php" class="nav-item nav-link fw-bold<?php echo $pagina_activa === 'aprende' ? ' active text-primary' : ' text-dark'; ?>">Aprende</a>
                <?php
                // Panel admin solo si es admin
                if (isset($usuario['rol']) && strtolower(trim($usuario['rol'])) === 'administrador') {
                    echo '<a href="admin_panel.php" class="nav-item nav-link fw-bold admin-panel-center'.($noti_pendientes > 0 ? ' animate__animated animate__flash animate__infinite' : '').'">Panel Administrador';
                    if (!empty($noti_pendientes) && $noti_pendientes > 0) {
                        echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger animate__animated animate__flash animate__infinite" style="font-size:0.8em;">'.$noti_pendientes.'<span class="visually-hidden">usuarios esperando habilitación</span></span>';
                    }
                    echo '</a>';
                }
                // Botón perfil
                if (isset($_SESSION['numero_documento'])) {
                    $clave_perfil = ($pagina_activa === 'perfil') ? 'nav-item nav-link fw-bold active text-primary' : 'nav-item nav-link fw-bold text-dark';
                    echo '<a href="perfil.php" class="' . $clave_perfil . '">Perfil</a>';
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
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8 mx-auto ">
                    <h1 class="display-3 animated slideInDown text-center" style="color: #2196f3; line-height: 1.3;">Perfil</h1>
                </div>
            </div>
           <?php if (!empty($usuario['resena'])): ?>
                <div class="text-center" style="
                    color: #fff;
                    font-size: 1.2em;
                    font-weight: 500;
                    margin-top: -10px;
                    margin-bottom: 18px;
                    text-shadow: 1px 1px 8px #1565c0;
                ">
                    <i class="fa fa-quote-left"></i>
                    <?php echo nl2br(htmlspecialchars($usuario['resena'])); ?>
                    <i class="fa fa-quote-right"></i>
                </div>
            <?php endif; ?>
            <?php
            // Mostrar imágenes del emprendimiento
            $imagenes = [];
            if (!empty($usuario['id'])) {
                $stmt = $conn->prepare("SELECT id, ruta_imagen FROM imagenes_emprendimiento WHERE usuario_id = ?");
                $stmt->bind_param("i", $usuario['id']);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($img = $result->fetch_assoc()) {
                    $imagenes[] = $img;
                }
                $stmt->close();
            }
            if (!empty($imagenes)): ?>
                <div class="mb-3 text-center">                  
                   <?php foreach ($imagenes as $img): ?>
                        <div style="display:inline-block; position:relative; margin:12px 10px 30px 10px;">
                            <img src="<?php echo htmlspecialchars($img['ruta_imagen']); ?>" alt="Producto"
                                style="width:120px;height:120px;object-fit:cover;border-radius:10px;display:block;">
                            <!-- Botón fuera de la imagen, en la esquina inferior derecha del contenedor -->
                            <form method="POST" action="eliminar_imagen.php" 
                                style="position:absolute;left:50%;bottom:-28px;transform:translateX(40px);margin:0;padding:0;">
                                <input type="hidden" name="imagen_id" value="<?php echo $img['id']; ?>">
                                <button type="submit" 
                                        class="btn btn-sm"
                                        style="background:transparent;color:#fff;border:none;box-shadow:none;"
                                        title="Eliminar imagen"
                                        onclick="return confirm('¿Seguro que deseas eliminar esta imagen?');">
                                    <i class="fa fa-trash fa-lg" style="color:#fff;"></i>
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
    <!-- Header End -->

    <!-- Perfil Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-lg rounded-3 profile-card">
                        <div class="card-body p-4">
                            <!-- Foto y saludo -->
                            <div class="text-center mb-4">
                                <?php
                                    $borderColor = ($usuario['rol'] === 'emprendedor' || $usuario['rol'] === 'administrador') ? '#43be16' : '#f0ad4e';
                                ?>
                                <img src="<?php echo htmlspecialchars($foto); ?>" 
                                    alt="Foto de perfil" 
                                    class="profile-avatar"
                                    style="border-color: <?php echo $borderColor; ?>;">
                                <h4 class="fw-bold mt-2">Hola, <?php echo htmlspecialchars($usuario['nombre_completo'] ?? 'Usuario'); ?>!</h4>
                                <?php if ($usuario['rol'] === 'emprendedor' || $usuario['rol'] === 'administrador'): ?>
                                    <span class="badge badge-custom mb-2">
                                        <i class="fa-solid fa-thumbs-up me-2"></i> Miembro activo
                                    </span>
                                <?php else: ?>
                                    <span class="badge mb-2" style="background-color: #f0ad4e; color: white;">
                                        <i class="fa-solid fa-hand me-2"></i> Pendiente de habilitación
                                    </span>
                                <?php endif; ?>
                                <form action="subir_foto.php" method="POST" enctype="multipart/form-data" class="profile-upload-form mt-2">
                                    <input type="file" name="foto" id="fotoInput" accept="image/*" onchange="this.form.submit()">
                                    <label for="fotoInput" class="btn btn-outline-success btn-sm mb-0">
                                        <i class="fa fa-camera"></i> Cambiar foto
                                    </label>
                                </form>
                            </div>

                            <!-- Reseña e imágenes (solo para emprendedor) -->
                            <?php if ($usuario['rol'] == 'emprendedor'): ?>
                            <form action="guardar_resena_imagenes.php" method="POST" enctype="multipart/form-data" class="mb-4">
                                <div class="mb-3">
                                    <label for="resena" class="form-label">Reseña de tu emprendimiento</label>
                                    <textarea name="resena" id="resena" class="form-control" rows="3"
                                        <?php if (empty($usuario['resena'])) echo 'required'; ?>
                                        placeholder="Escribe una breve reseña de tu emprendimiento..."></textarea>
                                    <?php if (!empty($usuario['resena'])): ?>
                                        <div class="form-text text-success">
                                            Ya tienes una reseña guardada. Si escribes aquí, la reemplazarás.
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="imagenes" class="form-label">Sube imágenes de tus productos</label>
                                    <input type="file" name="imagenes[]" id="imagenes" class="form-control" multiple accept="image/*">
                                    <div id="preview-imagenes" class="d-flex flex-wrap mt-2"></div>
                                </div>
                                <button type="submit" class="btn btn-success">Guardar reseña e imágenes</button>
                            </form>
                            <?php endif; ?>

                            <!-- Pestañas tipo tarjeta -->
                            <div class="row g-3 mb-4 justify-content-center" id="perfilTabsCards">
                                <div class="col-6 col-md-2">
                                    <div class="card card-tab text-center py-3 px-2 tab-active" data-bs-target="#info">
                                        <div class="mb-2"><i class="fa fa-id-card fa-2x text-success"></i></div>
                                        <div class="fw-bold">Información</div>
                                    </div>
                                </div>                                
                                <div class="col-6 col-md-2">
                                    <div class="card card-tab text-center py-3 px-2" data-bs-target="#trueques">
                                        <div class="mb-2"><i class="fa fa-exchange-alt fa-2x text-info"></i></div>
                                        <div class="fw-bold">Trueques</div>
                                    </div>
                                </div>                               
                                <div class="col-6 col-md-2">
                                    <div class="card card-tab text-center py-3 px-2" data-bs-target="#enlaces">
                                        <div class="mb-2"><i class="fa fa-link fa-2x text-secondary"></i></div>
                                        <div class="fw-bold">Enlaces</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contenido de pestañas -->
                            <div class="tab-content" id="perfilTabsContent">
                                <!-- Info personal -->
                                <div class="tab-pane fade" id="info" role="tabpanel">
                                    <?php if (isset($usuario ['rol']) && $usuario ['rol'] === 'emprendedor' || $usuario ['rol'] === 'administrador'): ?>
                                        <form action="guardar_perfil.php" method="POST" class="mb-3">
                                            <div class="mb-2">
                                                <label class="form-label fw-bold"><i class="fa fa-user text-success"></i> Nombre:</label>
                                                <input type="text" name="nombre_completo" class="form-control" value="<?php echo htmlspecialchars($usuario['nombre_completo'] ?? ''); ?>" required>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label fw-bold"><i class="fa fa-phone text-success"></i> Celular:</label>
                                                <input type="text" name="celular" class="form-control" value="<?php echo htmlspecialchars($usuario['celular'] ?? ''); ?>" required>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label fw-bold"><i class="fa fa-home text-success"></i> Barrio:</label>
                                                <input type="text" name="barrio" class="form-control" value="<?php echo htmlspecialchars($usuario['barrio'] ?? ''); ?>" required>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label fw-bold"><i class="fa fa-briefcase text-success"></i> Emprendimiento:</label>
                                                <input type="text" name="emprendimiento" class="form-control" value="<?php echo htmlspecialchars($usuario['emprendimiento'] ?? ''); ?>" required>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label fw-bold"><i class="fa fa-map-marker-alt text-success"></i> Dirección:</label>
                                                <input type="text" name="direccion" class="form-control" value="<?php echo htmlspecialchars($usuario['direccion'] ?? ''); ?>" required>
                                            </div>
                                            <button type="submit" class="btn btn-success btn-sm mt-2"><i class="fa fa-save"></i> Guardar cambios</button>
                                        </form>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            Tu cuenta aún no ha sido habilitada como emprendedora. Espera a que el administrador te habilite para editar tu perfil.
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Trueques -->                                
                                <div class="tab-pane fade" id="trueques" role="tabpanel">
                                    <?php if ($usuario['rol'] === 'emprendedor' || $usuario['rol'] === 'administrador'): ?>
                                        <div class="alert alert-info mb-3" style="background-color: #e3f2fd; color: #1565c0; border-color: none;">
                                            <i class="fa fa-info-circle me-2"></i>
                                            Espacio para intercambiar productos, servicios, materiales```
                                        </div>
                                        <?php if ($usuario['rol'] === 'emprendedor'): ?>
                                        <div class="card mb-4">
                                            <div class="card-header bg-success text-white">Publicar un nuevo trueque</div>
                                            <div class="card-body">
                                                <form action="publicar_trueque.php" method="POST" enctype="multipart/form-data">
                                                    <div class="mb-3">
                                                        <label for="categoria" class="form-label">Categoría</label>
                                                        <select name="categoria" id="categoria" class="form-select" required onchange="actualizarSubcategorias()">
                                                            <option value="">Selecciona una categoría</option>
                                                            <option value="Mis Productos">Mis Productos</option>
                                                            <option value="Mis Residuos">Mis Residuos</option>
                                                            <option value="Varios">Varios</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="subcategoria" class="form-label">Subcategoría</label>
                                                        <select name="subcategoria" id="subcategoria" class="form-select" required>
                                                            <option value="">Selecciona una subcategoría</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="que_ofreces" class="form-label">¿Qué ofreces?</label>
                                                        <input type="text" name="que_ofreces" id="que_ofreces" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="que_necesitas" class="form-label">¿Qué necesitas?</label>
                                                        <input type="text" name="que_necesitas" id="que_necesitas" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="descripcion" class="form-label">Descripción</label>
                                                        <textarea name="descripcion" id="descripcion" class="form-control" rows="2" required></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="barrio" class="form-label">Barrio</label>
                                                        <input type="text" name="barrio" id="barrio" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="imagenes_trueque" class="form-label">Imágenes del trueque (máximo 3)</label>
                                                        <input type="file" name="imagenes[]" id="imagenes_trueque" class="form-control" multiple accept="image/*">
                                                        <div id="preview-imagenes-trueque" class="d-flex flex-wrap mt-2"></div>
                                                    </div>
                                                    <div class="d-flex gap-2">
                                                        <button type="submit" name="accion" value="publicar" class="btn btn-success">
                                                            <i class="fa fa-check"></i> Publicar Trueque
                                                        </button>
                                                        <button type="submit" name="accion" value="pendiente" class="btn btn-warning text-dark">
                                                            <i class="fa fa-clock"></i> Guardar como Pendiente
                                                        </button>
                                                        <button type="submit" name="accion" value="cancelado" class="btn btn-danger">
                                                            <i class="fa fa-times"></i> Cancelar Trueque
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <h5 class="fw-bold mb-3"><i class="fa fa-exchange-alt text-info"></i> Historial de Trueques</h5>
                                        <?php if (empty($lista_trueques)): ?>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item text-muted">No hay trueques registrados.</li>
                                            </ul>
                                        <?php else: ?>
                                            <ul class="list-group list-group-flush">
                                                <?php foreach ($lista_trueques as $trueque): ?>
                                                    <li class="list-group-item">
                                                        <?php
                                                        // Consulta las imágenes asociadas a este trueque
                                                        $stmt_imgs = $conn->prepare("SELECT ruta_imagen FROM imagenes_trueque WHERE trueque_id = ?");
                                                        $stmt_imgs->bind_param("i", $trueque['id']);
                                                        $stmt_imgs->execute();
                                                        $res_imgs = $stmt_imgs->get_result();
                                                        $imagenes_trueque = $res_imgs->fetch_all(MYSQLI_ASSOC);
                                                        $stmt_imgs->close();

                                                        if (!empty($imagenes_trueque)):
                                                        ?>
                                                            <div class="d-flex flex-wrap mb-2">
                                                                <?php foreach ($imagenes_trueque as $img): ?>
                                                                    <img src="<?php echo htmlspecialchars($img['ruta_imagen']); ?>" style="width:80px;height:60px;object-fit:cover;border-radius:6px;margin-right:5px;">
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php endif; ?>                                                
                                                        <div class="d-flex align-items-center">                                                            
                                                            <div>
                                                                <strong><?php echo htmlspecialchars($trueque['que_ofreces']); ?></strong>
                                                                <?php
                                                                $sql_vistas = "SELECT COUNT(*) AS total FROM visitas_trueques WHERE trueque_id = ?";
                                                                $stmt_vistas = $conn->prepare($sql_vistas);
                                                                $stmt_vistas->bind_param("i", $trueque['id']);
                                                                $stmt_vistas->execute();
                                                                $res_vistas = $stmt_vistas->get_result();
                                                                $vistas = $res_vistas->fetch_assoc();
                                                                $stmt_vistas->close();
                                                                ?>
                                                                <span class="badge bg-info">Visto por <?php echo $vistas['total']; ?> usuarios</span>
                                                                <?php if (!empty($trueque['categoria'])): ?>
                                                                    <span class="badge bg-primary"><?php echo htmlspecialchars($trueque['categoria']); ?></span>
                                                                <?php endif; ?>
                                                                <?php if (!empty($trueque['subcategoria'])): ?>
                                                                    <span class="badge bg-secondary"><?php echo htmlspecialchars($trueque['subcategoria']); ?></span>
                                                                <?php endif; ?>
                                                                <?php
                                                                    $badgeClass = 'bg-secondary';
                                                                    if ($trueque['estado'] === 'activo') $badgeClass = 'badge-activo';
                                                                    elseif ($trueque['estado'] === 'pendiente') $badgeClass = 'bg-warning text-dark';
                                                                    elseif ($trueque['estado'] === 'cancelado') $badgeClass = 'bg-danger';
                                                                ?>
                                                                <span class="badge <?php echo $badgeClass; ?>">
                                                                    <?php echo htmlspecialchars($trueque['estado']); ?>
                                                                </span>
                                                                <br>
                                                                <small class="text-muted">
                                                                    <?php echo htmlspecialchars($trueque['descripcion']); ?><br>
                                                                    <i class="fa fa-calendar-alt"></i>
                                                                    <?php echo date('d/m/Y', strtotime($trueque['fecha_publicacion'])); ?>
                                                                </small>
                                                                <?php if (!empty($trueque['barrio'])): ?>
                                                                    <br><small><i class="fa fa-map-marker-alt"></i> <?php echo htmlspecialchars($trueque['barrio']); ?></small>
                                                                <?php endif; ?>

                                                                <!-- Botones Editar y Eliminar -->
                                                                <div class="mt-2">
                                                                    <?php if (
                                                                        $trueque['numero_documento'] == $_SESSION['numero_documento'] ||
                                                                        (isset($_SESSION['rol']) && $_SESSION['rol'] === 'administrador')
                                                                    ): ?>
                                                                        <a href="editar_trueque.php?id=<?php echo $trueque['id']; ?>" class="btn btn-sm btn-primary">
                                                                            <i class="fa fa-edit"></i> Editar
                                                                        </a>
                                                                    <?php endif; ?>
                                                                    <?php if ($trueque['numero_documento'] == $_SESSION['numero_documento']): ?>
                                                                        <a href="eliminar_trueque.php?id=<?php echo $trueque['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este trueque?');">
                                                                            <i class="fa fa-trash"></i> Eliminar
                                                                        </a>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>              
                                                    </li>
                                                <?php endforeach; ?>                                      
                                            </ul>
                                        <?php endif; ?>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        Tu cuenta aún no ha sido habilitada como emprendedora. Espera a que el administrador te habilite para acceder a los trueques.
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Enlaces -->
                            <div class="tab-pane fade" id="enlaces" role="tabpanel">
                                <?php if ($usuario['rol'] === 'emprendedor' || $usuario['rol'] === 'administrador'): ?>
                                    <form action="guardar_enlaces.php" method="POST" class="mb-4">
                                        <div class="mb-2">
                                            <label class="form-label fw-bold"><i class="fa fa-instagram text-danger"></i> Instagram:</label>
                                            <input type="text" name="instagram" class="form-control" value="<?php echo htmlspecialchars($usuario['instagram'] ?? ''); ?>">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label fw-bold"><i class="fa fa-facebook text-primary"></i> Facebook:</label>
                                            <input type="text" name="facebook" class="form-control" value="<?php echo htmlspecialchars($usuario['facebook'] ?? ''); ?>">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label fw-bold"><i class="fa fa-map-marker-alt text-success"></i> Dirección:</label>
                                            <input type="text" name="direccion" class="form-control" value="<?php echo htmlspecialchars($usuario['direccion'] ?? ''); ?>">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label fw-bold"><i class="fa fa-envelope text-info"></i> Correo:</label>
                                            <input type="email" name="correo" class="form-control" value="<?php echo htmlspecialchars($usuario['correo'] ?? ''); ?>">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label fw-bold"><i class="fa fa-briefcase text-warning"></i> Nombre del Emprendimiento:</label>
                                            <input type="text" name="emprendimiento" class="form-control" value="<?php echo htmlspecialchars($usuario['emprendimiento'] ?? ''); ?>">
                                        </div>
                                        <button type="submit" class="btn btn-success btn-sm mt-2"><i class="fa fa-save"></i> Guardar enlaces</button>
                                    </form>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                        Tu cuenta aún no ha sido habilitada como emprendedora. Espera a que el administrador te habilite para acceder a los enlaces.
                                    </div>
                                <?php endif; ?>
                            </div><!-- Enlaces End -->
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
    <!-- Footer End -->

    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    <script>
    // Script para activar pestañas tipo tarjeta
    document.querySelectorAll('.card-tab').forEach(function(tab){
        tab.addEventListener('click', function(){
            // Quitar activo a todos
            document.querySelectorAll('.card-tab').forEach(t=>t.classList.remove('tab-active'));
            tab.classList.add('tab-active');
            // Ocultar todos los contenidos
            document.querySelectorAll('.tab-pane').forEach(p=>p.classList.remove('show','active'));
            // Mostrar el contenido correspondiente
            const target = tab.getAttribute('data-bs-target');
            document.querySelector(target).classList.add('show','active');
        });
    });
    window.onload = function() {
        var toast = document.getElementById('toast-alert');
        if (toast) {
            toast.style.opacity = 1;
            toast.style.transform = 'translateX(0)';
            setTimeout(function() {
                toast.style.opacity = 0;
                toast.style.transform = 'translateX(120%)';
            }, 3500);
        }
        // Aquí puedes agregar el nuevo código:
        const params = new URLSearchParams(window.location.search);
        if (params.get('tab') === 'trueques') {
            document.querySelectorAll('.card-tab').forEach(t=>t.classList.remove('tab-active'));
            const truequesTab = document.querySelector('.card-tab[data-bs-target="#trueques"]');
            if (truequesTab) truequesTab.classList.add('tab-active');
            document.querySelectorAll('.tab-pane').forEach(p=>p.classList.remove('show','active'));
            const truequesPane = document.querySelector('#trueques');
            if (truequesPane) truequesPane.classList.add('show','active');
        }
    };
    </script>
    <script>
    let archivosSeleccionados = [];

    document.getElementById('imagenes').addEventListener('change', function(e) {
        // Agrega los archivos seleccionados a la lista global
        for (let archivo of e.target.files) {
            archivosSeleccionados.push(archivo);
        }
        mostrarPrevisualizacion();
        // Limpia el input para permitir volver a seleccionar los mismos archivos si se desea
        e.target.value = '';
    });

    function mostrarPrevisualizacion() {
        const preview = document.getElementById('preview-imagenes');
        preview.innerHTML = '';
        archivosSeleccionados.forEach((archivo, idx) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.style.position = 'relative';
                div.style.margin = '5px';
                div.innerHTML = `
                    <img src="${e.target.result}" style="width:90px;height:90px;object-fit:cover;border-radius:8px;">
                    <button type="button" onclick="eliminarImagen(${idx})" style="position:absolute;top:0;right:0;background:rgba(0,0,0,0.5);border:none;color:#fff;border-radius:50%;width:22px;height:22px;line-height:18px;padding:0;cursor:pointer;">
                        &times;
                    </button>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(archivo);
        });
    }

    function eliminarImagen(idx) {
        archivosSeleccionados.splice(idx, 1);
        mostrarPrevisualizacion();
    }

    // Al enviar el formulario, reemplaza los archivos del input por los de la lista global
    document.querySelector('form[action="guardar_resena_imagenes.php"]').addEventListener('submit', function(e) {
        // Crea un nuevo DataTransfer para los archivos seleccionados
        const dt = new DataTransfer();
        archivosSeleccionados.forEach(archivo => dt.items.add(archivo));
        document.getElementById('imagenes').files = dt.files;
    });
    </script>
    <script>
    const subcategorias = {
        "Mis Productos": ["Gastronomia", "Artesanos"],
        "Mis Residuos": [
            "Reciclables (papel, cartón, plásticos, metales, vidrio, etc)",
            "Compostables (cáscaras, restos de comida, hojas, etc)",
            "Reutilizables (telas, madera, fibras, etc)"
        ],
        "Varios": ["Intercambio de servicios", "Donaciones", "Otros"]
    };

    function actualizarSubcategorias() {
        const cat = document.getElementById('categoria').value;
        const subcat = document.getElementById('subcategoria');
        subcat.innerHTML = '<option value="">Selecciona una subcategoría</option>';
        if (subcategorias[cat]) {
            subcategorias[cat].forEach(function(sc) {
                subcat.innerHTML += `<option value="${sc}">${sc}</option>`;
            });
        }
    }
    </script>
    <script>
    let archivosTrueque = [];

    document.getElementById('imagenes_trueque').addEventListener('change', function(e) {
        if (archivosTrueque.length + e.target.files.length > 3) {
            alert('Solo puedes seleccionar un máximo de 3 imágenes para tu trueque.');
            e.target.value = '';
            return;
        }
        for (let archivo of e.target.files) {
            archivosTrueque.push(archivo);
        }
        mostrarPreviewTrueque();
        e.target.value = '';
    });

    function mostrarPreviewTrueque() {
        const preview = document.getElementById('preview-imagenes-trueque');
        preview.innerHTML = '';
        archivosTrueque.forEach((archivo, idx) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.style.position = 'relative';
                div.style.margin = '5px';
                div.innerHTML = `
                    <img src="${e.target.result}" style="width:90px;height:90px;object-fit:cover;border-radius:8px;">
                    <button type="button" onclick="eliminarImagenTrueque(${idx})" style="position:absolute;top:0;right:0;background:rgba(0,0,0,0.5);border:none;color:#fff;border-radius:50%;width:22px;height:22px;line-height:18px;padding:0;cursor:pointer;">
                        &times;
                    </button>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(archivo);
        });
    }

    function eliminarImagenTrueque(idx) {
        archivosTrueque.splice(idx, 1);
        mostrarPreviewTrueque();
    }

    // Al enviar el formulario, reemplaza los archivos del input por los de la lista global
    document.querySelector('form[action="publicar_trueque.php"]').addEventListener('submit', function(e) {
        const dt = new DataTransfer();
        archivosTrueque.forEach(archivo => dt.items.add(archivo));
        document.getElementById('imagenes_trueque').files = dt.files;
    });
    </script>
</body>
</html>