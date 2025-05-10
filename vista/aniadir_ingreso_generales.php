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

        .tooltip-personalizado {
            --bs-tooltip-bg: var(--bs-primary);
            font-size: 0.9rem;
            padding: 0.5rem;
            border-radius: 0.5rem;
        }

    </style>
</head>
<body>
    <?php include('../include/navbar.php'); ?> 
    <?php
        if (!isset($_GET["ingresando"]) && isset($_SESSION["datos_migr"], $_SESSION["datos_pr"], $_SESSION["datos_de"], $_SESSION["datos_tr"])){
            echo "
                <div class='container d-flex justify-content-center align-items-center my-4'>
                    <div class='card p-4 shadow-lg w-50'>
                        <h2 class='mb-4 text-center text-primary fw-bold'>GENERALES</h2>
                        <div class='row align-items-center justify-content-between mb-3'>
                            <div class='col-auto'>
                                <i class='bi bi-person text-primary fs-2'
                                    data-bs-toggle='tooltip' 
                                    data-bs-placement='right' 
                                    data-bs-custom-class='tooltip-personalizado'
                                    data-bs-html='true'
                                    data-bs-title='
                                        <strong>Paciente:</strong> {$_SESSION['nombre']} {$_SESSION['ape1']} {$_SESSION['ape2']}<br>
                                        <strong>N.H.C:</strong> {$_SESSION['nhc']}
                                '></i>
                            </div>
                            <div class='col-auto text-end'>
                                <a href='../controlador/borrar_datos_formulario.php' 
                                    class='btn btn-link p-0 text-danger d-flex align-items-center' 
                                    title='Borrar datos de paciente y salir'>
                                    <i class='bi bi-x-lg fs-3'></i>
                                </a>
                            </div>
                        </div>";
                        include('../include/aviso.php'); 
                        echo "<form method='POST'>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='fecha_ingreso' class='form-label fw-bold'>Fecha de Ingreso</label>
                                    <input type='date' class='form-control' id='fecha_ingreso' name='fecha_ingreso' value='" . (isset($_SESSION["fecha_ingreso"]) ? $_SESSION["fecha_ingreso"] : "") . "' required>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='fecha_alta' class='form-label fw-bold'>Fecha de Alta</label>
                                    <input type='date' class='form-control' id='fecha_alta' name='fecha_alta' value='" . (isset($_SESSION["fecha_alta"]) ? $_SESSION["fecha_alta"] : "") . "'>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='reingreso' class='form-label fw-bold'>Reingreso</label>
                                    <select class='form-select' id='reingreso' name='reingreso'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["reingreso"]) && $_SESSION["reingreso"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["reingreso"]) && $_SESSION["reingreso"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='NUM_VISIT' class='form-label fw-bold'>Número de visitas</label>
                                    <input type='number' class='form-control' id='NUM_VISIT' name='NUM_VISIT' value='" . (isset($_SESSION["NUM_VISIT"]) ? $_SESSION["NUM_VISIT"] : "") . "'>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col-md-12 mb-3'>
                                    <label for='procedencia' class='form-label fw-bold'>Procedencia</label>
                                    <select class='form-select' id='procedencia' name='procedencia'>
                                        <option value=''>-</option>";
                                        foreach ($_SESSION["datos_pr"] as $pr) {
                                            echo "<option value='{$pr["id_procedencia"]}'" . (isset($_SESSION["procedencia"]) && $_SESSION["procedencia"] == $pr["id_procedencia"] ? " selected" : "") . ">{$pr["descripcion"]}</option>";
                                        }

                                        echo "</select>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12 mb-3'>
                                    <label for='destino' class='form-label fw-bold'>Destino</label>
                                    <select class='form-select' id='destino' name='destino'>
                                        <option value=''>-</option>";
                                        foreach ($_SESSION["datos_de"] as $de) {
                                            echo "<option value='{$de["id_destino"]}'" . (isset($_SESSION["destino"]) && $_SESSION["destino"] == $de["id_destino"] ? " selected" : "") . ">{$de["descripcion"]}</option>";
                                        }

                                        echo "</select>
                                </div>
                            </div>

                            <div class='d-flex justify-content-end'>
                                    <button type='submit' formaction='../controlador/guardar_generales_ingreso.php' class='btn btn-outline-primary d-flex align-items-center rounded-pill shadow-sm px-4'>
                                    Siguiente <i class='bi bi-arrow-right ms-2'></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            ";
        }
        else {
            unset($_SESSION["datos_migr"], $_SESSION["datos_pr"], $_SESSION["datos_de"], $_SESSION["datos_tr"]);
            echo "
                <div class='modal fade show' id='modalNHC' tabindex='-1' style='display: block; background: rgba(0,0,0,0.5);' aria-labelledby='modalNHCLabel'>
                <div class='modal-dialog modal-dialog-centered'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title'>Introducir NHC</h5>
                            <a href='./menu.php' class='btn-close'></a>
                        </div>
                        <div class='modal-body'>
                            <form method='POST' action='../controlador/cargar_datos_paciente.php?ingresando'>
                            <label for='nhc' class='form-label'>Número de Historia Clínica (NHC):</label>
                            <input type='text' name='nhc' id='nhc' class='form-control' required>
                            <div class='modal-footer'>
                                <button type='submit' class='btn btn-primary'>Registrar Ingreso</button>
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
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
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
