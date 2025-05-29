<?php
    session_start();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión</title>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9; 
        }
        .img-fluid {
            object-fit: cover;
            height: 100%;
        }
        .animacion_form {
        animation: animacion_form 0.8s ease-out forwards;
        }

        @keyframes animacion_form {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <body>
        <?php 
            include("../include/aviso.php");
        ?> 
        <div class="container-fluid">
            <div class="row d-flex justify-content-center align-items-center min-vh-100">
                <div class="card border-primary-subtle mb-3 w-100 p-0 m-0 shadow-lg animacion_form" style="max-width: 70vw;"> 
                    <div class="row g-0">
                        <div class="col-md-7 d-none d-lg-block">
                            <img src="../images/datos9-scaled.jpg" class="img-fluid rounded-start" alt="Imagen de fondo">
                        </div>
                        <div class="col-12 col-lg-5">
                            <div class="card-body h-100">
                                <form class="d-flex flex-column justify-content-center h-100" method="POST" action="../controlador/autenticar.php">
                                    <h3 class="text-center mb-4 text-primary">LOGIN</h3>
                                    <div class="mb-3">
                                        <label for="nombreUsu" class="form-label">Nombre de usuario</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                            <input type="text" name="user_name" class="form-control" id="nombreUsu" placeholder="Ingresa tu usuario">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Contraseña</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                            <input type="password" name="pass" class="form-control" id="password" placeholder="Ingresa tu contraseña">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button type="submit" class="btn btn-primary">
                                            Iniciar sesión
                                        </button>
                                    </div>
                                    <div class="text-center mt-3">
                                        ¿No tienes una cuenta? <a href="./registrar.php">Regístrate aquí</a>
                                    </div>
                                </form>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
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
</html>

