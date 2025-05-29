<?php
    session_start();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .img-fluid {
            object-fit: cover;
            height: 100%;
            width: 100%;
        }
        .animacion_form {
            opacity: 0;
            transform: translateY(20px);
            animation: animacion_form 0.8s ease-out forwards;
        }
        @keyframes animacion_form {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-light">
    <?php 
        include("../include/aviso.php");
    ?>      
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8 animacion_form">
                <div class="card border-primary-subtle shadow">
                    <div class="row">
                        <div class="col-md-5 d-none d-md-block">
                            <img src="../images/registro.jpeg" class="img-fluid rounded-start h-100" alt="Imagen de registro">
                        </div>
                        <div class="col-md-7">
                            <div class="card-body">
                                <h3 class="text-center text-primary mb-4">Regístrate</h3>
                                <form method="POST" action="../controlador/registrar.php">
                                    
                                    <div class="mb-3">
                                        <label for="nombreUsu" class="form-label">Nombre de usuario</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                            <input type="text" name="user_name" class="form-control" id="nombreUsu" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input type="text" name="nombre" class="form-control" id="nombre" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="ape1Usu" class="form-label">Primer apellido</label>
                                            <input type="text" name="ape1" class="form-control" id="ape1Usu" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="ape2Usu" class="form-label">Segundo apellido</label>
                                            <input type="text" name="ape2" class="form-control" id="ape2Usu">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="pass1" class="form-label">Contraseña</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                            <input type="password" name="pass1" class="form-control" id="new_pass" required>
                                        </div>
                                        <small class="text-muted">
                                            <i class="bi bi-info-circle me-1"></i>Debe contener 8+ caracteres, mayúsculas, minúsculas, números y símbolos
                                        </small>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="pass2" class="form-label">Repita la contraseña</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                            <input type="password" id="confirm_pass" name="pass2" class="form-control" required>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button type="submit" class="btn btn-primary">
                                            Registrar
                                        </button>
                                    </div>
                                    
                                    <div class="text-center mt-3">
                                        ¿Ya tienes cuenta? <a href="./iniciar_sesion.php">Inicia sesión aquí</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Obtiene los campos de contraseña
            const newPass = document.getElementById('new_pass');         
            const confirmPass = document.getElementById('confirm_pass');  

            // Agrega un evento cuando se escribe algo en el campo de confirmación
            confirmPass.addEventListener('input', function() {
                // Compara si ambas contraseñas coinciden
                if(newPass.value !== confirmPass.value) {
                    // Si no coinciden, se agrega la clase 'is-invalid' de Bootstrap a ambos campos
                    newPass.classList.add('is-invalid');
                    confirmPass.classList.add('is-invalid');
                } else {
                    // Si coinciden, se eliminan las clases de error
                    newPass.classList.remove('is-invalid');
                    confirmPass.classList.remove('is-invalid');
                }
            });
        });
    </script>
</body>
</html>