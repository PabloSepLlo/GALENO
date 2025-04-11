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
    <title>Gestión usuarios</title>

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

    <!-- Navbar -->
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
                            <i class="bi bi-person-circle fs-5 ms-5"></i>
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
    <div class="table-responsive-md m-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>User name</th>
                    <th>Administrador</th>
                    <th></th>
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
                                            <form method='POST' class='d-flex gap-2'>
                                                <button type='submit' class='btn btn-danger btn-sm' formaction='../controlador/eliminar_usuario.php' title='Eliminar'>
                                                    <i class='bi bi-trash'></i>
                                                </button>
                                                <button type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditar{$usuario["id_usuario"]}' title='Editar'>
                                                    <i class='bi bi-pencil'></i>
                                                </button>
                                                <input type='hidden' name='id_usuario' value='{$usuario['id_usuario']}'>
                                            </form>
                                        </td>
                                    </tr>";
                                    // Modal para editar usuario
                                    echo "
                                    <div class='modal fade' id='modalEditar{$usuario["id_usuario"]}' tabindex='-1' aria-labelledby='modalLabel{$usuario["id_usuario"]}' aria-hidden='true'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h5 class='modal-title' id='modalLabel{$usuario["id_usuario"]}'>Editar Usuario</h5>
                                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
                                                </div>
                                                <div class='modal-body'>
                                                    <form method='POST' action='../controlador/actualizar_usuario.php'>
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

                                                        <button type='submit' class='btn btn-success'>Guardar Cambios</button>
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
