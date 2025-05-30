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
    if (isset($_SESSION["nhc"])) {
        header("Location: ../controlador/borrar_datos_formulario.php");
        exit();
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
            html, body {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                overflow: hidden; 
                font-family: 'Roboto', sans-serif;
                background-color: #f4f6f9;
            }
            

            .main-container { /*ajusta al ancho del navegador*/
                display: flex;
                flex-direction: column;
                height: 100vh;
            }
            

            .carousel-container {
                flex-grow: 1; /* Ocupa todo el espacio disponible (afecta al responsive) */
                min-height: 0; 
            }
            
            /* Carrusel */
            #carouselExampleAutoplaying {
                height: 100%;
            }
            
            .carousel-inner, .carousel-item {
                height: 100%;
            }
            
            .carousel-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            
            /* Ajustes visuales */
            .carousel-caption {
                background-color: rgba(0, 123, 255, 0.7);
                border-radius: 10px;
                padding: 10px;
            }
            
            .nav-link {
                color: white;
                font-weight: 500;
            }
            
            .navbar-toggler {
                border-color: white;
            }

        </style>
    </head>
    <body>
        <div class="main-container">
            <?php 
                include("../include/navbar.php");
                include("../include/aviso.php");
            ?>
            
            <div class="carousel-container">
                <div id="carouselExampleAutoplaying" class="carousel slide h-100" data-bs-ride="carousel">
                    <div class="carousel-inner h-100">
                        <div class="carousel-item active h-100" data-bs-interval="7000">
                            <img src="../images/GettyImages-1208116440.jpg" class="d-block w-100 h-100 carousel-image" alt="Hospital">
                            <div class="carousel-caption d-none d-md-block">
                                <h5 class="text-white">Atención de Calidad</h5>
                                <p>Brindamos el mejor cuidado a nuestros pacientes.</p>
                            </div>
                        </div>
                        <div class="carousel-item h-100" data-bs-interval="5000">
                            <img src="../images/caEUBouW-gallery-21-min-jpg.webp" class="d-block w-100 h-100 carousel-image" alt="Consultorio">
                            <div class="carousel-caption d-none d-md-block">
                                <h5 class="text-white">Instalaciones Modernas</h5>
                                <p>Equipos de última tecnología para tu bienestar.</p>
                            </div>
                        </div>
                        <div class="carousel-item h-100" data-bs-interval="5000">
                            <img src="../images/datos9-scaled.jpg" class="d-block w-100 h-100 carousel-image" alt="Médicos">
                            <div class="carousel-caption d-none d-md-block">
                                <h5 class="text-white">Equipo Médico Profesional</h5>
                                <p>Especialistas comprometidos con tu salud.</p>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Muestra un modal automáticamente cuando la página termina de cargarse
            document.addEventListener('DOMContentLoaded', function() {
            const modalElement = document.getElementById('sessionModal');
            if (modalElement) {
                const sessionModal = new bootstrap.Modal(modalElement);
                sessionModal.show();
            }
        });
        </script>
    </body>
</html>