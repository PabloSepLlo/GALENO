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

        .offcanvas {
            background-color: #f4f6f9; 
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

        .tooltip-personalizado .tooltip-inner {
            --bs-tooltip-bg: var(--bs-warning);
            font-size: 0.9rem;
            color: black;
            padding: 0.5rem;
            border-radius: 0.5rem;
        }

    </style>
</head>
<body>
    <?php 
        include("../include/navbar.php");
        include("../include/aviso.php");
    echo "
        <div class='container-fluid mt-4'>
            <div class='card shadow-lg border-primary' style='max-width: 700px; margin: 0 auto; border-width: 2px;'>
                <div class='card-header bg-primary text-white d-flex align-items-center'>
                    <i class='bi bi-person-badge fs-3 me-2'></i>
                    <h5 class='card-title mb-0 flex-grow-1'>Mis Datos Personales</h5>
                </div>
                <div class='card-body p-4'>
                    <div class='text-center mb-4'>
                        <div class='position-relative d-inline-block'>
                            <img src='../images/9ded914031de73173d19cf30839fef76-hospital-surgery-logo.webp' class='rounded-circle border border-3 border-primary' width='100' alt='Logo'>
                        </div>
                        <h4 class='mt-3 mb-0'>{$datos["nombre"]} {$datos["ape1"]}</h4>
                        <h5 class='text-muted'>@{$datos["user_name"]}</h5>
                    </div>
                    <div class='list-group list-group-flush mb-4'><!--Borra las lineas de alrededor-->
                        <div class='list-group-item d-flex align-items-center'>
                            <i class='bi bi-person-vcard text-primary fs-4 me-3'></i>
                            <div>
                                <h6 class='mb-0'>Nombre completo</h6>
                                <p class='mb-0 text-muted'>{$datos["nombre"]} {$datos["ape1"]} {$datos["ape2"]}</p>
                            </div>
                        </div>
                        <div class='list-group-item d-flex align-items-center'>
                            <i class='bi bi-person-circle text-primary fs-4 me-3'></i>
                            <div>
                                <h6 class='mb-0'>Nombre de usuario</h6>
                                <p class='mb-0 text-muted'>{$datos["user_name"]}</p>
                            </div>
                        </div>
                    </div>
                    <div class='d-flex justify-content-center gap-3 mt-4'>
                        <button class='btn btn-primary px-4 py-2 rounded-pill' data-bs-toggle='modal' data-bs-target='#modalEditarDatos'>
                            <i class='bi bi-pencil-fill me-2'></i>Editar Perfil
                        </button>
                        <button class='btn btn-outline-warning px-4 py-2 rounded-pill' data-bs-toggle='modal' data-bs-target='#cambiarPasswordModal'>
                            <i class='bi bi-key-fill me-2'></i>Cambiar Clave
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class='modal fade' id='modalEditarDatos' tabindex='-1' aria-labelledby='modalLabelDatos' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered'>
                <div class='modal-content'>
                    <div class='modal-header bg-primary text-white'>
                        <h5 class='modal-title' id='modalLabelDatos'>Editar Usuario</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                    </div>
                    <div class='modal-body'>
                        <form method='POST' action='../controlador/actualizar_usuario.php'>
                            <div class='mb-3'>
                                <label class='form-label'>Nombre de Usuario</label>
                                <div class='input-group'>
                                    <span class='input-group-text'><i class='bi bi-person-fill'></i></span>
                                    <input type='text' name='nombre_usuario' value='{$datos["user_name"]}' class='form-control' placeholder='Ingresa tu usuario'>
                                </div>
                            </div>
                            <input type='hidden' name='id_usuario' value='{$datos["id_usuario"]}'>
                            <input type='hidden' name='administrador' value='{$datos["administrador"]}'>
                            <div class='mb-3'>
                                <label class='form-label'>Nombre</label>
                                <input type='text' name='nombre' value='{$datos["nombre"]}' class='form-control'>
                            </div>
                            
                            <div class='mb-3'>
                                <label class='form-label'>Apellidos</label>
                                <input type='text' name='ape1' value='{$datos["ape1"]}' class='form-control'>
                                <input type='text' name='ape2' value='{$datos["ape2"]}' class='form-control'>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                <button type='submit' class='btn btn-primary'>Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class='modal fade' id='cambiarPasswordModal' tabindex='-1'>
            <div class='modal-dialog modal-dialog-centered'>
                <div class='modal-content'>
                    <div class='modal-header bg-warning'>
                        <h5 class='modal-title'>Cambiar Contraseña</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                    </div>
                    <div class='modal-body'>
                        <form method='POST' action='../controlador/cambiar_pass.php'>
                            <input type='hidden' name='id_usuario' value='{$datos["id_usuario"]}'>
                            
                            <div class='mb-3'>
                                <label class='form-label'>Contraseña Actual</label>
                                <div class='input-group'>
                                    <span class='input-group-text'><i class='bi bi-lock'></i></span>
                                    <input type='password' name='pass_actual' class='form-control' required>
                                </div>
                            </div>
                            <div class='mb-2'>
                                <label for='pass1' class='form-label'>Nueva contraseña</label>
                                <div class='input-group'>
                                    <span class='input-group-text'><i class='bi bi-lock-fill'></i></span>
                                    <input type='password' name='pass1' class='form-control' id='new_pass' required>
                                </div>
                                <small class='text-muted'>
                                    <i class='bi bi-info-circle me-1'></i>Debe contener 8+ caracteres, mayúsculas, minúsculas, números y símbolos
                                </small>
                            </div>
                            <div class='mb-2'>
                                <label for='pass2' class='form-label'>Confirmar nueva contraseña</label>
                                <div class='input-group'>
                                    <span class='input-group-text'><i class='bi bi-lock-fill'></i></span>
                                    <input type='password' id='confirm_pass' name='pass2' class='form-control' required>
                                </div>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                <button type='submit' class='btn btn-warning'>Actualizar Contraseña</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>";
    ?>
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
