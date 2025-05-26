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
        .tooltip-personalizado .tooltip-inner {
            --bs-tooltip-bg: var(--bs-warning);
            font-size: 0.9rem;
            color: black;
            padding: 0.5rem;
            border-radius: 0.5rem;
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
<body>
    <?php 
        include("../include/aviso.php");
    ?>      
    <div class="container-fluid my-2">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="card border-primary-subtle mb-3 w-100 p-0 m-0 shadow-lg animacion_form" style="max-width: 50vw;"> 
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
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                        <input type="text" name="user_name" class="form-control" id="nombreUsu" placeholder="Ingresa tu usuario">
                                    </div>
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
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                        <input type="password" name="pass1" class="form-control" id="new_pass" required>
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i>Debe contener 8+ caracteres, mayúsculas, minúsculas, números y símbolos
                                    </small>
                                </div>
                                
                                <div class="mb-2">
                                    <label for="pass2" class="form-label">Repita la contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                        <input type="password" id="confirm_pass" name="pass2" class="form-control" required>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-50 mx-auto btn-sm mt-4 mb-1">
                                    Registrar
                                </button>
                                
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
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

        window.addEventListener('DOMContentLoaded', () => {
            const modalElement = document.getElementById('sessionModal');
            if (modalElement) {
                const sessionModal = new bootstrap.Modal(modalElement);
                sessionModal.show();
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const newPass = document.getElementById('new_pass');
            const confirmPass = document.getElementById('confirm_pass');
            
            confirmPass.addEventListener('input', function() {
                if(newPass.value !== confirmPass.value) {
                    newPass.classList.add('is-invalid');
                    confirmPass.classList.add('is-invalid');
                } else {
                    newPass.classList.remove('is-invalid');
                    confirmPass.classList.remove('is-invalid');
                }
            });
        });
    </script>
</body>
</html>