<?php
$pagina_activa = 'inicio';
include("conexion.php");

if (session_status() === PHP_SESSION_NONE ) {
    session_start();
}

// Consulta trueques activos y datos del usuario que publicó
$sql = "SELECT t.*, u.emprendimiento AS nombre_empresa, u.celular AS numero_contacto
        FROM trueques t
        JOIN usuarios u ON t.numero_documento = u.numero_documento
        WHERE t.estado = 'activo'
        AND (t.fecha_expiracion IS NULL OR t.fecha_expiracion >= CURDATE())
        ORDER BY t.fecha_publicacion DESC";
$result = $conn->query($sql);
$trueques_publicados = $result->fetch_all(MYSQLI_ASSOC);

// --- Consulta de notificaciones pendientes para el admin ---
$noti_pendientes = 0;
if (isset($_SESSION['numero_documento'])) {
    $sql_admin = "SELECT rol FROM usuarios WHERE numero_documento = ?";
    $stmt_admin = $conn->prepare($sql_admin);
    $stmt_admin->bind_param("s", $_SESSION['numero_documento']);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();
    $admin = $result_admin->fetch_assoc();
    $stmt_admin->close();

    if ($admin && strtolower(trim($admin['rol'])) === 'administrador') {
        $sql_noti = "SELECT COUNT(*) AS total FROM notificaciones n JOIN usuarios u ON n.usuario_id = u.id WHERE n.leida=0 AND u.rol != 'administrador'";
        $result_noti = $conn->query($sql_noti);
        if ($row_noti = $result_noti->fetch_assoc()) {
            $noti_pendientes = $row_noti['total'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Reciclando Juntas, Produciendo Futuro</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Economía Solidaria, Economía Circular, Reciclaje, Compostaje, SENA Valle" name="keywords">
    <meta content="Plataforma educativa sobre economía solidaria y circular del SENA Regional Valle" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
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
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="javascript:location.reload();" class="nav-item nav-link fw-bold<?php echo $pagina_activa === 'inicio' ? ' active text-primary' : ' text-dark'; ?>">Inicio</a>
                <a href="trueques.php" class="nav-item nav-link fw-bold<?php echo $pagina_activa === 'trueque-comunitario' ? ' active text-primary' : ' text-dark'; ?>">Trueques</a>
                <a href="<?php echo isset($_SESSION['numero_documento']) ? 'aprende.php' : '#seccion-aprende'; ?>" class="nav-item nav-link fw-bold<?php echo $pagina_activa === 'aprende' ? ' active text-primary' : ' text-dark'; ?>">Aprende</a>
                <?php
                if(isset($_SESSION['numero_documento'])) {                   
                    if (isset($admin) && strtolower(trim($admin['rol'])) === 'administrador' && $noti_pendientes > 0) {
                        echo '<a href="perfil.php" class="nav-item nav-link animate__animated animate__flash animate__infinite">Perfil</a>';
                    } else {
                        $clave_perfil = ($pagina_activa === 'perfil') ? 'nav-item nav-link active text-primary' : 'nav-item nav-link text-dark';
                        echo '<a href="perfil.php" class="' . $clave_perfil . '">Perfil</a>';
                    }
                }
                ?>
                <?php
                if (isset($_SESSION['numero_documento'])) {
                    echo '<a href="logout.php" class="btn py-4 px-lg-5 d-none d-lg-block text-white" style="background-color: #43be16;">Cerrar sesión<i class="fa fa-arrow-right ms-3"></i></a>';
                    echo '<a href="logout.php" class="btn btn-success d-block d-lg-none my-3 w-100 text-white text-center justify-content-center align-items-center d-flex" style="background-color: #43be16;">'
                        .'<span class="mx-auto">Cerrar sesión</span>'
                        .'<i class="fa fa-arrow-right ms-2"></i>'
                    .'</a>';
                } else {
                    echo '<a href="registro.php" class="btn py-4 px-lg-5 d-none d-lg-block text-white" style="background-color: #43be16;">Registrate Ahora<i class="fa fa-arrow-right ms-3"></i></a>';
                }
                ?>    
            </div>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            <!-- SLIDE 1 -->
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="img/gastronomia.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .5);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-uppercase mb-3 animated slideInDown" style="color: #FFD700; font-weight: 700; letter-spacing: 2px;">
                                    <i class="fas fa-recycle me-2"></i>Reciclando Juntas, Produciendo Futuro
                                </h5>
                                <h1 class="display-3 text-white animated slideInDown mb-3" style="font-weight: 900; text-shadow: 3px 3px 6px rgba(0,0,0,0.5);">
                                    Economía Solidaria y Circular para Unidades Productivas de Cali
                                </h1>
                                <p class="fs-5 text-white mb-4 pb-2" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5); line-height: 1.7;">
                                    El SENA te acompaña en la construcción de un futuro más próspero y sostenible.
                                </p>
                                
                                <!-- ✅ BOTONES CON NUEVO ESTILO -->
                                <div class="d-flex flex-column flex-sm-row gap-3">
                                    <a href="login.php" class="btn btn-lg px-5 py-3 animate__animated animate__pulse animate__infinite" style="background-color: #43be16; border-color: #43be16; color: white; font-weight: 700; font-size: 1.2rem; border-radius: 50px; box-shadow: 0 8px 20px rgba(0,0,0,0.3); transition: all 0.3s ease;">
                                        <i class="fas fa-sign-in-alt me-2"></i>Inicio de Sesión
                                    </a>
                                    <a href="registro.php" class="btn btn-light btn-lg px-5 py-3 animate__animated animate__fadeIn" style="font-weight: 700; font-size: 1.2rem; border-radius: 50px; box-shadow: 0 8px 20px rgba(0,0,0,0.3); transition: all 0.3s ease;">
                                        <i class="fas fa-user-plus me-2"></i>Regístrate Ahora
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- SLIDE 2 -->
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="img/portada.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .5);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-sm-10 col-lg-8">
                                <h5 class="text-uppercase mb-3 animated slideInDown" style="color: #FFD700; font-weight: 700; letter-spacing: 2px;">
                                    <i class="fas fa-recycle me-2"></i>Reciclando Juntas, Produciendo Futuro
                                </h5>
                                <h1 class="display-3 text-white animated slideInDown mb-3" style="font-weight: 900; text-shadow: 3px 3px 6px rgba(0,0,0,0.5);">
                                    Economía Solidaria y Circular para Unidades Productivas de Cali
                                </h1>
                                <p class="fs-5 text-white mb-4 pb-2" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5); line-height: 1.7;">
                                    El SENA te acompaña en la construcción de un futuro más próspero y sostenible.
                                </p>
                                
                                <!-- ✅ BOTONES CON NUEVO ESTILO -->
                                <div class="d-flex flex-column flex-sm-row gap-3">
                                    <a href="login.php" class="btn btn-lg px-5 py-3 animate__animated animate__pulse animate__infinite" style="background-color: #43be16; border-color: #43be16; color: white; font-weight: 700; font-size: 1.2rem; border-radius: 50px; box-shadow: 0 8px 20px rgba(0,0,0,0.3); transition: all 0.3s ease;">
                                        <i class="fas fa-sign-in-alt me-2"></i>Inicio de Sesión
                                    </a>
                                    <a href="registro.php" class="btn btn-light btn-lg px-5 py-3 animate__animated animate__fadeIn" style="font-weight: 700; font-size: 1.2rem; border-radius: 50px; box-shadow: 0 8px 20px rgba(0,0,0,0.3); transition: all 0.3s ease;">
                                        <i class="fas fa-user-plus me-2"></i>Regístrate Ahora
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <a href="#about" style="text-decoration:none">
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
                    <a href="#about" style="text-decoration:none">
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
                    <a href="#about" style="text-decoration:none">
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
                    <a href="#about" style="text-decoration:none">
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
    <div id="about" class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="img-fluid position-absolute w-100 h-100" src="img/trueque.png" alt="" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 id="trueque-comunitario" class="section-title bg-white text-start text-primary pe-3">Trueque Comunitario</h6>
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
                        <div class="card h-100 shadow-sm">
                            <?php
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
                                            <button type="button" data-bs-target="#carouselTrueque<?php echo $t['id']; ?>" data-bs-slide-to="<?php echo $idx; ?>" class="<?php echo $idx === 0 ? 'active' : ''; ?>"></button>
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
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Trueques Publicados End --> 


    <!-- ✅ NUEVA SECCIÓN: PORTADA DE APRENDE -->
    <div id="seccion-aprende" class="container-fluid p-0 mb-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 80px 0 !important;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="text-center text-white wow fadeInUp" data-wow-delay="0.1s">
                        <div class="mb-4">
                            <img src="img/pagina-4.jpg" alt="Economía Circular" class="img-fluid rounded shadow-lg" style="max-height: 400px; object-fit: cover; border: 5px solid white;">
                        </div>
                        
                        <h6 class="text-uppercase mb-3 animate__animated animate__fadeInDown" style="color: #FFD700; font-weight: 700; letter-spacing: 2px;">
                            <i class="fas fa-graduation-cap me-2"></i>SENA - Regional Valle del Cauca
                        </h6>
                        
                        <h1 class="display-3 mb-4 animate__animated animate__fadeInUp" style="font-weight: 900; text-shadow: 3px 3px 6px rgba(0,0,0,0.3);">
                            <i class="fas fa-recycle me-3" style="color: #43be16;"></i>
                            Economía Solidaria y Circular
                        </h1>
                        
                        <p class="fs-4 mb-4 pb-2 animate__animated animate__fadeIn" style="line-height: 1.8; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                            Aprende sobre <strong>prácticas sostenibles</strong>, <strong>compostaje</strong>, <strong>reciclaje</strong> y <strong>economía circular</strong>. 
                            Transforma tu emprendimiento en Cali con herramientas educativas prácticas diseñadas por el SENA.
                        </p>

                        <!-- ✅ CONTENIDO DIFERENTE SEGÚN ESTÉ LOGUEADO O NO -->
                        <?php if (isset($_SESSION['numero_documento'])): ?>
                            <!-- 🟢 USUARIO AUTENTICADO: Puede acceder directamente -->
                            <div class="alert alert-success d-inline-block mb-4 animate__animated animate__bounceIn" style="max-width: 700px; background: rgba(67, 190, 22, 0.9); border: 3px solid white; color: white; font-weight: 700;">
                                <i class="fas fa-check-circle fa-2x me-3"></i>
                                <strong>¡Bienvenido de vuelta!</strong> Continúa tu aprendizaje en la cartilla educativa.
                            </div>
                            <div class="mt-4">
                                <a href="aprende.php" class="btn btn-lg px-5 py-3 me-3 animate__animated animate__pulse animate__infinite" style="background-color: #43be16; border-color: #43be16; color: white; font-weight: 700; font-size: 1.2rem; border-radius: 50px; box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                                    <i class="fas fa-book-open me-2"></i>Acceder a la Cartilla
                                </a>
                                <a href="perfil.php" class="btn btn-light btn-lg px-5 py-3 animate__animated animate__fadeIn" style="font-weight: 700; font-size: 1.2rem; border-radius: 50px; box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                                    <i class="fas fa-user me-2"></i>Mi Perfil
                                </a>
                            </div>
                        <?php else: ?>
                            <!-- 🔴 USUARIO NO AUTENTICADO: Debe registrarse -->
                            <div class="alert alert-warning d-inline-block mb-4 animate__animated animate__bounceIn" style="max-width: 700px; background: rgba(255, 193, 7, 0.95); border: 3px solid white; color: #001122; font-weight: 700;">
                                <i class="fas fa-info-circle fa-2x me-3"></i>
                                <strong>¡Regístrate gratis</strong> para acceder a todo el contenido educativo de la cartilla
                            </div>
                            <div class="mt-4">
                                <a href="registro.php?from=aprende" class="btn btn-lg px-5 py-3 me-3 animate__animated animate__pulse animate__infinite" style="background-color: #43be16; border-color: #43be16; color: white; font-weight: 700; font-size: 1.2rem; border-radius: 50px; box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                                    <i class="fas fa-user-plus me-2"></i>Registrarse Ahora
                                </a>
                                <a href="login.php?from=aprende" class="btn btn-light btn-lg px-5 py-3 animate__animated animate__fadeIn" style="font-weight: 700; font-size: 1.2rem; border-radius: 50px; box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                                    <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- ✅ INFORMACIÓN ADICIONAL -->
                        <div class="row mt-5 g-4">
                            <div class="col-md-4 animate__animated animate__fadeInLeft">
                                <div class="p-4 rounded" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 2px solid rgba(255,255,255,0.3);">
                                    <i class="fas fa-book fa-3x mb-3" style="color: #FFD700;"></i>
                                    <h5 class="mb-2">17 Páginas Interactivas</h5>
                                    <p class="mb-0">Contenido educativo completo y práctico</p>
                                </div>
                            </div>
                            <div class="col-md-4 animate__animated animate__fadeInUp">
                                <div class="p-4 rounded" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 2px solid rgba(255,255,255,0.3);">
                                    <i class="fas fa-certificate fa-3x mb-3" style="color: #FFD700;"></i>
                                    <h5 class="mb-2">Certificación SENA</h5>
                                    <p class="mb-0">Al completar todas las actividades</p>
                                </div>
                            </div>
                            <div class="col-md-4 animate__animated animate__fadeInRight">
                                <div class="p-4 rounded" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 2px solid rgba(255,255,255,0.3);">
                                    <i class="fas fa-seedling fa-3x mb-3" style="color: #FFD700;"></i>
                                    <h5 class="mb-2">100% Práctico</h5>
                                    <p class="mb-0">Aplica lo aprendido en tu emprendimiento</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Portada de Aprende End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-4">
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
            
            <hr style="border-color: rgba(255,255,255,0.2);">
            
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

    <!-- ✅ LIMPIAR FLECHAS DUPLICADAS DEL CARRUSEL -->
    <script>
    $(document).ready(function() {
        // Esperar a que Owl Carousel se inicialice completamente
        setTimeout(function() {
            // Seleccionar los botones de navegación
            var $prevBtn = $('.header-carousel .owl-prev');
            var $nextBtn = $('.header-carousel .owl-next');
            
            // Limpiar todo el contenido interno (HTML, texto, íconos)
            $prevBtn.html('');
            $nextBtn.html('');
            
            // Verificar en consola
            console.log('✅ Flechas del carrusel limpiadas');
            console.log('Contenido botón anterior:', $prevBtn.html());
            console.log('Contenido botón siguiente:', $nextBtn.html());
        }, 1000); // Esperar 1 segundo a que todo cargue
    });
    </script>

    <!-- ✅ SCROLL SUAVE A LA SECCIÓN APRENDE -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Verificar si viene desde el navbar "Aprende"
        if (window.location.hash === '#seccion-aprende') {
            setTimeout(function() {
                document.getElementById('seccion-aprende').scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 500);
        }
    });
    </script>
</body>
</html>