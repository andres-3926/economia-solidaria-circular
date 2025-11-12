<?php
session_start();
include("conexion.php");

// Verificar si hay un proceso de reset activo
if (!isset($_SESSION['reset_code']) || !isset($_SESSION['reset_user_id'])) {
    header("Location: login.php?error=" . urlencode("❌ Sesión de recuperación no válida."));
    exit;
}

// Verificar si el código no ha expirado (10 minutos)
if (isset($_SESSION['reset_timestamp']) && (time() - $_SESSION['reset_timestamp']) > 600) {
    unset($_SESSION['reset_code'], $_SESSION['reset_user_id'], $_SESSION['reset_timestamp'], $_SESSION['reset_documento']);
    header("Location: login.php?error=" . urlencode("⏰ El código temporal ha expirado. Inténtalo de nuevo."));
    exit;
}

// Obtener información del usuario para mostrar
$stmt = $conn->prepare("SELECT nombre_completo, celular, correo FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $_SESSION['reset_user_id']);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

// Ocultar información sensible
$celular_oculto = substr($usuario['celular'], 0, 3) . "****" . substr($usuario['celular'], -3);
$correo_oculto = "";
if (!empty($usuario['correo'])) {
    $partes_correo = explode('@', $usuario['correo']);
    $correo_oculto = substr($partes_correo[0], 0, 3) . "****@" . $partes_correo[1];
}

// Procesar formulario de nueva contraseña
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nueva_contrasena'])) {
    
    $codigo_ingresado = $_POST['codigo_temporal'] ?? '';
    $nueva_contrasena = $_POST['nueva_contrasena'] ?? '';
    $confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';
    
    // Validaciones
    if (empty($codigo_ingresado) || empty($nueva_contrasena) || empty($confirmar_contrasena)) {
        $error = "⚠️ Todos los campos son obligatorios.";
    } elseif ($codigo_ingresado !== $_SESSION['reset_code']) {
        $error = "❌ Código temporal incorrecto.";
    } elseif ($nueva_contrasena !== $confirmar_contrasena) {
        $error = "❌ Las contraseñas no coinciden.";
    } elseif (strlen($nueva_contrasena) < 6) {
        $error = "⚠️ La contraseña debe tener al menos 6 caracteres.";
    } else {
        // Todo válido, actualizar contraseña
        $contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("UPDATE usuarios SET contrasena = ? WHERE id = ?");
        $stmt->bind_param("si", $contrasena_hash, $_SESSION['reset_user_id']);
        
        if ($stmt->execute()) {
            // Limpiar sesión de reset
            unset($_SESSION['reset_code'], $_SESSION['reset_user_id'], $_SESSION['reset_timestamp'], $_SESSION['reset_documento']);
            
            $mensaje = "✅ Contraseña actualizada exitosamente. Ya puedes iniciar sesión.";
            header("Location: login.php?mensaje=" . urlencode($mensaje));
            exit;
        } else {
            $error = "❌ Error al actualizar la contraseña. Inténtalo de nuevo.";
        }
        
        $stmt->close();
    }
}

// Calcular tiempo restante
$tiempo_restante = 600 - (time() - $_SESSION['reset_timestamp']);
$minutos_restantes = floor($tiempo_restante / 60);
$segundos_restantes = $tiempo_restante % 60;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Restablecer Contraseña - Reciclando Juntas</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    
    <!-- Bootstrap y estilos -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    
    <style>
        body { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Nunito', sans-serif;
        }
        .reset-container { 
            max-width: 500px; 
            margin: 50px auto; 
            padding: 20px;
        }
        .code-display { 
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
            border: 2px solid #43be16;
            padding: 20px;
            border-radius: 15px;
            margin: 20px 0;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .code-number {
            font-size: 32px;
            font-weight: bold;
            color: #43be16;
            letter-spacing: 5px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        .user-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid #43be16;
        }
        .timer {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            margin: 15px 0;
        }
        .form-control:focus {
            border-color: #43be16;
            box-shadow: 0 0 0 0.2rem rgba(67, 190, 22, 0.25);
        }
        
        /* Responsive para móviles */
        @media (max-width: 991.98px) {
            .owl-carousel-item.position-relative {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .container, .row.justify-content-center {
                height: 100%;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .container-fluid.mb-5 {
                margin-bottom: 0 !important;
            }
            .footer {
                padding: 0 !important;
                margin: 0 !important;
                min-height: auto !important;
                height: 35px !important;
                overflow: hidden !important;
            }
            .footer .container {
                padding: 0 !important;
                height: 100% !important;
                display: flex !important;
                align-items: center !important;
            }
            .footer .copyright {
                padding: 0 15px !important;
                margin: 0 !important;
                border: none !important;
                height: 35px !important;
                display: flex !important;
                align-items: center !important;
                width: 100% !important;
            }
            .footer .copyright .row {
                margin: 0 !important;
                width: 100% !important;
            }
            .footer .copyright .col-md-6{
                margin: 0 !important;
                padding: 0 !important;
                font-size: 11px !important;
                line-height: 1.2 !important;
                text-align: center !important;
                font-weight: 400 !important;
            }
        }
        /* Para dispositivos moviles muy pequeños */
        @media (max-width: 576px) {            
            .footer {
                height: 180px !important;
                overflow: hidden !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }
            .footer .container {
                height: 100% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 0 !important;
            }
            .footer .copyright {
                height: auto !important;
                padding: 20px 10px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 100% !important;
                margin: 0 !important;
                border: none !important;
            }
            .footer .copyright .row {
                margin: 0 !important;
                width: 100% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                height: auto !important;
            }
            .footer .copyright .col-md-6{
                font-size: 16px !important;
                font-weight: 600 !important;
                color: #ffffff !important;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.8) !important;
                text-align: center !important;
                margin: 0 !important;
                padding: 20px !important;
                line-height: 1.4 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.php" class="navbar-brand d-flex align-items-center px-2 px-lg-5">
            <h2 class="m-0 text-shadow titulo-navbar text-break" style="color: #43be16;">
                <i class="fa-solid fa-recycle fa-beat fa-xl me-2"></i>Economía Solidaria y Circular
            </h2>
        </a>
    </nav>

    <!-- Form with Same Background -->
    <div class="container-fluid p-0 mb-5">
        <div class="owl-carousel header-carousel position-relative">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="img/portada.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(24, 29, 56, .7);">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-sm-12 col-lg-6">
                                
                                <div class="card bg-light rounded-3 shadow-lg">
                                    <div class="card-header py-2 text-center" style="background-color: #43be16;">
                                        <h3 class="m-0 text-white">
                                            <i class="fa-solid fa-key me-2"></i>Restablecer Contraseña
                                        </h3>
                                    </div>
                                    
                                    <div class="card-body p-3">
                                        <!-- Información del usuario encontrado -->
                                        <div class="user-info">
                                            <h5 class="text-success">
                                                <i class="fa-solid fa-user-check me-2"></i>Usuario Encontrado
                                            </h5>
                                            <p class="mb-1"><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre_completo']) ?></p>
                                            <p class="mb-1"><strong>Celular:</strong> <?= htmlspecialchars($celular_oculto) ?></p>
                                            <?php if (!empty($correo_oculto)): ?>
                                                <p class="mb-0"><strong>Correo:</strong> <?= htmlspecialchars($correo_oculto) ?></p>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <!-- Código temporal -->
                                        <div class="code-display">
                                            <div class="mb-2">
                                                <i class="fa-solid fa-shield-halved text-success fa-2x"></i>
                                                <h5 class="mt-2 mb-3 text-success">Código de Seguridad</h5>
                                            </div>
                                            <div class="code-number"><?= $_SESSION['reset_code'] ?></div>
                                            <small class="text-muted">Use este código para restablecer su contraseña</small>
                                        </div>
                                        
                                        <!-- Timer -->
                                        <div class="timer">
                                            <i class="fa-solid fa-clock text-warning"></i>
                                            <strong>Tiempo restante: <span id="countdown"><?= sprintf('%02d:%02d', $minutos_restantes, $segundos_restantes) ?></span></strong>
                                        </div>
                                        
                                        <?php if (isset($error)): ?>
                                            <div class="alert alert-danger">
                                                <i class="fa-solid fa-exclamation-triangle me-2"></i><?= htmlspecialchars($error) ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <form method="POST" class="mt-4">
                                            <div class="mb-3">
                                                <label for="codigo_temporal" class="form-label">
                                                    <i class="fa-solid fa-shield-halved me-1 text-success"></i>Código de Seguridad
                                                </label>
                                                <input type="text" class="form-control form-control-lg text-center" id="codigo_temporal" name="codigo_temporal" 
                                                       placeholder="000000" maxlength="6" style="letter-spacing: 3px; font-size: 20px;" required>
                                                <small class="text-muted">Ingrese el código de 6 dígitos mostrado arriba</small>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="nueva_contrasena" class="form-label">
                                                    <i class="fa-solid fa-lock me-1 text-success"></i>Nueva Contraseña
                                                </label>
                                                <input type="password" class="form-control" id="nueva_contrasena" name="nueva_contrasena" 
                                                       placeholder="Mínimo 6 caracteres" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="confirmar_contrasena" class="form-label">
                                                    <i class="fa-solid fa-lock-open me-1 text-success"></i>Confirmar Contraseña
                                                </label>
                                                <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena" 
                                                       placeholder="Repita la nueva contraseña" required>
                                            </div>
                                            
                                            <button type="submit" class="btn w-100 text-white py-2 mb-3" style="background-color: #43be16;">
                                                <i class="fa-solid fa-check me-2"></i>Actualizar Contraseña
                                            </button>
                                        </form>
                                        
                                        <div class="text-center">
                                            <a href="login.php" class="text-success">
                                                <i class="fa-solid fa-arrow-left me-1"></i>Volver al inicio de sesión
                                            </a>
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

    <!-- Script para countdown -->
    <script>
        let timeLeft = <?= $tiempo_restante ?>;
        
        function updateCountdown() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            
            document.getElementById('countdown').textContent = 
                String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
            
            if (timeLeft <= 0) {
                alert('⏰ El código ha expirado. Será redirigido al inicio de sesión.');
                window.location.href = 'login.php?error=' + encodeURIComponent('⏰ El código temporal ha expirado. Inténtalo de nuevo.');
                return;
            }
            
            timeLeft--;
        }
        
        // Actualizar cada segundo
        setInterval(updateCountdown, 1000);
        
        // Auto-focus en el campo de código
        document.getElementById('codigo_temporal').focus();
        
        // Validar solo números en el código
        document.getElementById('codigo_temporal').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="/economia-solidaria-circular/js/bootstrap.bundle.min.js"></script>
</body>
</html>