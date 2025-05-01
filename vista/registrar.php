<?php
    session_start();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .img-fluid {
            object-fit: cover;
            height: 100%;
        }
    </style>
</head>
<body>
    <?php 
        include("../include/aviso.php");
    ?>      
    <div class="container-fluid my-2">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="card border-primary-subtle mb-3 w-100 p-0 m-0 shadow-lg" style="max-width: 50vw;"> 
                <div class="row g-0">
                    <div class="col-lg-7 d-none d-lg-block">
                        <img src="../images/registro.jpeg" class="img-fluid rounded-start" alt="Imagen de fondo">
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="card-body h-100 f-size">
                            <form class="d-flex flex-column justify-content-center h-100" method="POST" action="../controlador/registrar.php">
                                <h3 class="text-center text-primary fw-light mb-4">Regístrate</h3>
                                <div class="mb-2">
                                    <label for="nombreUsu" class="form-label">Nombre de usuario</label>
                                    <input type="text" name="user_name" class="form-control" id="nombreUsu" required>
                                </div> 
                                <div class="mb-2">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" id="nombre" required>
                                </div> 
                                <div class="mb-2">
                                    <label for="ape1Usu" class="form-label">Primer apellido</label>
                                    <input type="text" name="ape1" class="form-control" id="ape1Usu" required>
                                </div> 
                                <div class="mb-2">
                                    <label for="ape2Usu" class="form-label">Segundo apellido</label>
                                    <input type="text" name="ape2" class="form-control" id="ape2Usu">
                                </div> 
                                <div class="mb-2">
                                    <label for="pass1" class="form-label">Contraseña</label>
                                    <input type="password" name="pass1" class="form-control" id="pass1" required>
                                </div>
                                <div class="mb-2">
                                    <label for="pass2" class="form-label">Repita la contraseña</label>
                                    <input type="password" name="pass2" class="form-control" id="pass2" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-50 mx-auto btn-sm mt-4 mb-1">Registrar</button>
                                <div class="text-center mt-2">
                                    ¿Ya tienes cuenta? <a href="./iniciar_sesion.php">Inicia sesión aquí</a>
                                </div>
                            </form>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
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