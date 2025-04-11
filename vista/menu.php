<?php
    require_once("../modelo/usuario.php");
    session_start();
    if (!isset($_SESSION["id_usuario"])) {
        $_SESSION["msg"] = "Necesitas estar autenticado";
        header("Location: ./iniciar_sesion.php");
        exit();
    }
    else {
      $usuario = new Usuario();
      $usuario->cargar_datos_desde_BBDD($_SESSION["id_usuario"]);
      $datos = $usuario->get_datos();
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Estilos generales */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9; /* Fondo claro */
        }

        /* Navbar */
        .navbar {
            background-color: #007bff; /* Azul hospitalario */
        }

        .nav-link {
            color: white;
            font-weight: 500;
        }

        .navbar-toggler {
            border-color: white;
        }

        /* Botón de búsqueda */
        .btn-search {
            background-color: #28a745; /* Verde médico */
            border: none;
        }

        .btn-search:hover {
            background-color: #218838;
        }

        /* Carrusel */
        .carousel-image {
            height: 92vh;
            object-fit: cover;
        }

        .carousel-caption {
            background-color: rgba(0, 123, 255, 0.7); /* Azul translúcido */
            border-radius: 10px;
            padding: 10px;
        }

        /* Menú desplegable */
        .dropdown-menu {
            background-color: white;
        }

        .dropdown-item:hover {
            background-color: #e2e6ea;
        }

    </style>
</head>
<body>
    <?php
        $modalContent = '';
        if (isset($_SESSION['err'])) {
            $modalContent = "<div class='modal fade' id='sessionModal' tabindex='-1'>
                <div class='modal-dialog modal-dialog-centered modal-sm'>
                    <div class='modal-content'>
                        <div class='modal-header bg-danger text-white'>
                            <h5 class='modal-title w-100 text-center'>Error</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body text-center'>
                            <p>{$_SESSION['err']}</p>
                        </div>
                    </div>
                </div>
            </div>";
            unset($_SESSION['err']);
        } elseif (isset($_SESSION['msg'])) {
            $modalContent = "<div class='modal fade' id='sessionModal' tabindex='-1'>
                <div class='modal-dialog modal-dialog-centered modal-sm'>
                    <div class='modal-content'>
                        <div class='modal-header bg-success text-white'>
                            <h5 class='modal-title w-100 text-center'>Éxito</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body text-center'>
                            <p>{$_SESSION['msg']}</p>
                        </div>
                    </div>
                </div>
            </div>";
            unset($_SESSION['msg']);
        }

        echo $modalContent;
    ?>
       
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="./menu.php">
                <img src="../images/9ded914031de73173d19cf30839fef76-hospital-surgery-logo.webp" alt="Logo" width="50" height="50" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php
                    echo " 
                    <span class='navbar-text fs-5 fw-bold text-primary-subtle mx-5'>
                        Bienvenido, <span>{$datos["nombre"]}</span>
                    </span>";
                    if ($datos["administrador"] == "SÍ") {
                        echo " 
                        <li class='nav-item'><a class='nav-link fs-5' href='../controlador/cargar_usuarios.php'>GESTIÓN USUARIOS</a></li>
                        ";
                    }
                    
                    ?>
                    <li class="nav-item"><a class="nav-link fs-5" href="#">CONSULTAS</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fs-5" href="#" role="button" data-bs-toggle="dropdown">
                            GESTIÓN PACIENTE
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../controlador/cargar_datos_form_pacientes.php">Añadir paciente</a></li>
                            <li><a class="dropdown-item" href="./aniadir_ingreso_generales.php?ingresando">Añadir ingreso</a></li>
                            <li><a class="dropdown-item" href="./aniadir_paciente_demograficos.php?editando">Editar paciente</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fs-5 px-2" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle ms-5 fs-5"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Mis datos</a></li>
                            <li><a class="dropdown-item" href="../controlador/cerrar_sesion.php">Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Carrusel -->
    <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../images/GettyImages-1208116440.jpg" class="d-block w-100 carousel-image" alt="Hospital">
                <div class="carousel-caption d-none d-md-block">
                    <h5 class="text-white">Atención de Calidad</h5>
                    <p>Brindamos el mejor cuidado a nuestros pacientes.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../images/caEUBouW-gallery-21-min-jpg.webp" class="d-block w-100 carousel-image" alt="Consultorio">
                <div class="carousel-caption d-none d-md-block">
                    <h5 class="text-white">Instalaciones Modernas</h5>
                    <p>Equipos de última tecnología para tu bienestar.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../images/datos9-scaled.jpg" class="d-block w-100 carousel-image" alt="Médicos">
                <div class="carousel-caption d-none d-md-block">
                    <h5 class="text-white">Equipo Médico Profesional</h5>
                    <p>Especialistas comprometidos con tu salud.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const modalElement = document.getElementById('sessionModal');
            if (modalElement) {
                const sessionModal = new bootstrap.Modal(modalElement);
                sessionModal.show();
            }
        });
    </script>
</body>
</html>
