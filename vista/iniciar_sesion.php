<?php
    session_start();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .img-fluid {
            object-fit: cover;
            height: 100%;
        }
    </style>
    <body>
        <?php 
            include("../include/aviso.php");
        ?> 
        <div class="container-fluid">
            <div class="row d-flex justify-content-center align-items-center min-vh-100">
                <div class="card border-primary-subtle mb-3 w-100 p-0 m-0 shadow-lg" style="max-width: 70vw;"> 
                    <div class="row g-0">
                        <div class="col-lg-7 d-none d-lg-block">
                            <img src="../images/datos9-scaled.jpg" class="img-fluid rounded-start" alt="Imagen de fondo">
                        </div>
                        <div class="col-12 col-lg-5">
                            <div class="card-body h-100">
                                <form class="d-flex flex-column justify-content-center h-100" method="POST" action="../controlador/autenticar.php">
                                    <h3 class="text-center mb-4 text-primary fw-light">LOGIN</h3>
                                    <div class="m-3 ">
                                        <label for="nombreUsu" class="form-label">Nombre de usuario</label>
                                        <input type="text" name="user_name" class="form-control" id="nombreUsu">
                                    </div>
                                    <div class="m-3">
                                        <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                                        <input type="password" name="pass" class="form-control" id="exampleInputPassword1">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-25 mx-auto btn-sm mt-4">Inicio</button>
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
        window.addEventListener('DOMContentLoaded', () => {
            const modalElement = document.getElementById('sessionModal');
            if (modalElement) {
                const sessionModal = new bootstrap.Modal(modalElement);
                sessionModal.show();
            }
        });
    </script>
</html>

