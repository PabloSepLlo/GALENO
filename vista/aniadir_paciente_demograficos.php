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
    <title>Añadir paciente</title>

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
                            <i class="bi bi-person-circle ms-5 fs-5"></i>
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
    <?php
        if (!isset($_GET["editando"]) && isset($_SESSION["datos_cs"], $_SESSION["datos_as"], $_SESSION["datos_c"], $_SESSION["datos_mi"], $_SESSION["datos_pc"])){
            echo "
                <div class='container d-flex justify-content-center align-items-center my-4'>
                    <div class='card p-4 shadow-lg w-50'>
                        <h2 class='mb-4 text-center'>DEMOGRÁFICOS</h2>";
                            if (isset($_SESSION["err"])) {
                                echo "
                                    <div class='alert alert-danger text-center' role='alert'>
                                        {$_SESSION["err"]}
                                    </div>
                                ";
                                unset($_SESSION["err"]);
                            }
                            if (isset($_SESSION["msg"])) {
                                echo "
                                    <div class='alert alert-success text-center' role='alert'>
                                        {$_SESSION["msg"]}
                                    </div>
                                ";
                                unset($_SESSION["msg"]);
                            }
                        echo "<form method='POST'>
                            <div class='row d-flex justify-content-end'>
                                <button type='submit' class='btn btn-danger col-sm-2 col-md-1 d-flex justify-content-center align-items-center' formaction='../controlador/borrar_datos_formulario_paciente.php' title='Borrar datos de paciente y salir'>
                                    <i class='bi bi-x-lg'></i>
                                </button>
                            </div>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='nhc' class='form-label'>N. H. C.</label>
                                    <input type='text' class='form-control' id='nhc' name='nhc' value='" . (isset($_SESSION["nhc"]) ? $_SESSION["nhc"] : "") . "' required>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='nombre' class='form-label'>Nombre</label>
                                    <input type='text' class='form-control' id='nombre' name='nombre' value='" . (isset($_SESSION["nombre"]) ? $_SESSION["nombre"] : "") . "' required>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='ape1' class='form-label'>Primer Apellido</label>
                                    <input type='text' class='form-control' id='ape1' name='ape1' value='" . (isset($_SESSION["ape1"]) ? $_SESSION["ape1"] : "") . "' required>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='ape2' class='form-label'>Segundo Apellido</label>
                                    <input type='text' class='form-control' id='ape2' name='ape2' value='" . (isset($_SESSION["ape2"]) ? $_SESSION["ape2"] : "") . "'>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='sexo' class='form-label'>Sexo</label>
                                    <select class='form-select' id='sexo' name='sexo' required>
                                        <option value='F'" . (isset($_SESSION["sexo"]) && $_SESSION["sexo"] == "F" ? " selected" : "") . ">Femenino</option>
                                        <option value='M'" . (isset($_SESSION["sexo"]) && $_SESSION["sexo"] == "M" ? " selected" : "") . ">Masculino</option>
                                    </select>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='edad' class='form-label'>Edad</label>
                                    <input type='number' class='form-control' id='edad' name='edad' value='" . (isset($_SESSION["edad"]) ? $_SESSION["edad"] : "") . "' required>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col-md-12 mb-3'>
                                    <label for='centro_salud' class='form-label'>Centro de Salud</label>
                                    <select class='form-select' id='centro_salud' name='centro_salud'>
                                        <option value=''>-</option>";
                                        foreach ($_SESSION["datos_cs"] as $cs) {
                                            echo "<option value='{$cs["id_centro_salud"]}'" . (isset($_SESSION["centro_salud"]) && $_SESSION["centro_salud"] == $cs["id_centro_salud"] ? " selected" : "") . ">{$cs["codigo_centro"]}</option>";
                                        }

                                        echo "</select>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='med' class='form-label'>Médico/a</label>
                                    <input type='text' class='form-control' id='med' name='med' value='" . (isset($_SESSION["med"]) ? $_SESSION["med"] : "") . "'>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='enf' class='form-label'>Enfermero/a</label>
                                    <input type='text' class='form-control' id='enf' name='enf' value='" . (isset($_SESSION["enf"]) ? $_SESSION["enf"] : "") . "'>
                                </div>
                            </div>

                            <div class='row d-flex justify-content-end'>
                                    <button type='submit' formaction='../controlador/guardar_demograficos.php' class='btn btn-primary col-sm-2 col-md-1 d-flex justify-content-center align-items-center' title='Guardar y continuar'>
                                        <i class='bi bi-arrow-right'></i>
                                    </button>
                            </div>
                        </form>
                    </div>
                </div>
            ";
        }
        else {
            unset($_SESSION["datos_cs"], $_SESSION["datos_as"], $_SESSION["datos_c"], $_SESSION["datos_mi"], $_SESSION["datos_pc"]);
            echo "
                <div class='modal fade show' id='modalNHC' tabindex='-1' style='display: block; background: rgba(0,0,0,0.5);' aria-labelledby='modalNHCLabel'>
                <div class='modal-dialog modal-dialog-centered'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title'>Introducir NHC</h5>
                            <a href='./menu.php' class='btn-close'></a>
                        </div>
                        <div class='modal-body'>
                        ";
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
                        echo "
                            <form method='POST' action='../controlador/cargar_datos_paciente.php?editando'>
                            <label for='nhc' class='form-label'>Número de Historia Clínica (NHC):</label>
                            <input type='text' name='nhc' id='nhc' class='form-control' required>
                            <div class='modal-footer'>
                                <button type='submit' class='btn btn-primary'>Editar Paciente</button>
                                <a href='./menu.php' class='btn btn-secondary'>Cancelar</a>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            ";
        }
    ?>
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
