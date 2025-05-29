<?php
    require_once("../modelo/usuario.php");
    session_start();
    if (!isset($_SESSION["id_usuario"]) ) {
        $_SESSION["msg"] = "Necesitas estar autenticado";
        header("Location: ./iniciar_sesion.php");
        exit();
    }
    else {
        $usuario = new Usuario();
        $usuario->cargar_datos_desde_BBDD($_SESSION["id_usuario"]);
        $datos = $usuario->get_datos();
        if ($datos["administrador"] != "SÍ") {
            $_SESSION["msg"] = "No eres administrador, no puedes acceder a esta vista";
            header("Location: ./menu.php");
            exit();
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de usuarios</title>

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
        include("../include/navbar.php");
        include("../include/aviso.php");
    ?>
    <div class="table-responsive-md m-5">
        <table class="table table-primary table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>User name</th>
                    <th>Administrador</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="table-light">
                <?php
                    if (isset($_SESSION["lista_usuarios"])){
                        foreach ($_SESSION["lista_usuarios"] as $usuario) { 
                            if ($usuario["id_usuario"] != $_SESSION["id_usuario"]) {
                                echo "<tr>
                                        <td>{$usuario["nombre"]}</td>
                                        <td>{$usuario["ape1"]} {$usuario["ape2"]}</td>
                                        <td>{$usuario["nombre_usuario"]}</td>
                                        <td>{$usuario["administrador"]}</td>
                                        <td>
                                            <form method='POST' class='d-flex justify-content-around'>
                                                <button type='button' class='btn btn-link p-0 text-primary' data-bs-toggle='modal' data-bs-target='#modalEditar{$usuario["id_usuario"]}' title='Editar'>
                                                    <i class='bi bi-pencil'></i>
                                                </button>
                                                <button type='submit' class='btn btn-link p-0 text-danger' formaction='../controlador/eliminar_usuario.php' title='Eliminar'>
                                                    <i class='bi bi-trash'></i>
                                                </button>
                                                <input type='hidden' name='id_usuario' value='{$usuario['id_usuario']}'>
                                            </form>
                                        </td>
                                    </tr>
                                    <div class='modal fade' id='modalEditar{$usuario["id_usuario"]}' tabindex='-1' aria-labelledby='modalLabel{$usuario["id_usuario"]}' aria-hidden='true'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>
                                                <div class='modal-header bg-primary text-white'>
                                                    <h5 class='modal-title' id='modalLabel{$usuario["id_usuario"]}'>Editar Usuario</h5>
                                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                                </div>
                                                <div class='modal-body'>
                                                    <form method='POST' action='../controlador/gestionar_usuarios.php'>
                                                        <input type='hidden' name='id_usuario' value='{$usuario["id_usuario"]}'>
                                                        
                                                        <div class='mb-3'>
                                                            <label class='form-label'>Nombre</label>
                                                            <input type='text' name='nombre' value='{$usuario["nombre"]}' class='form-control'>
                                                        </div>
                                                        
                                                        <div class='mb-3'>
                                                            <label class='form-label'>Apellidos</label>
                                                            <input type='text' name='ape1' value='{$usuario["ape1"]}' class='form-control'>
                                                            <input type='text' name='ape2' value='{$usuario["ape2"]}' class='form-control'>
                                                        </div>

                                                        <div class='mb-3'>
                                                            <label class='form-label'>Nombre de Usuario</label>
                                                            <input type='text' name='nombre_usuario' value='{$usuario["nombre_usuario"]}' class='form-control'>
                                                        </div>

                                                        <div class='mb-3'>
                                                            <label class='form-label'>Administrador</label>
                                                            <select name='administrador' class='form-select'>
                                                                <option value='SÍ' " . ($usuario["administrador"] == 'SÍ' ? 'selected' : '') . ">Sí</option>
                                                                <option value='NO' " . ($usuario["administrador"] == 'NO' ? 'selected' : '') . ">No</option>
                                                            </select>
                                                        </div>

                                                        <div class='modal-footer'>
                                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                                            <button type='submit' class='btn btn-primary'>Guardar cambios</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                            }
                        }
                        unset($_SESSION["lista_usuarios"]);
                    }
                ?>
            </tbody>
        </table>
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
