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
        .form-container {
            width: 400px;
        }
    </style>
</head>
<body>
    <?php 
        include("../include/aviso.php");
    ?> 
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center min-vh-100">
            <div class="card shadow p-4 form-container">
                <form method="POST" action="../controlador/autenticar.php">
                    <h3 class="text-center mb-3">Iniciar sesión</h3>
                    <div class="mb-3">
                        <label for="nombreUsu" class="form-label">Nombre de usuario</label>
                        <input type="text" name="user_name" class="form-control" id="nombreUsu">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                        <input type="password" name="pass" class="form-control" id="exampleInputPassword1">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Inicio</button>
                    <div class="text-center mt-3">
                        ¿No tienes una cuenta? <a href="./registrar.php">Regístrate aquí</a>
                    </div>
                </form>
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

