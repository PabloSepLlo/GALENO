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

        .tooltip-personalizado {
            --bs-tooltip-bg: var(--bs-primary);
            font-size: 0.9rem;
            padding: 0.5rem;
            border-radius: 0.5rem;
        }

        .animacion_form {
        animation: animacion_form 0.8s ease-out forwards;
        }

        @keyframes animacion_form {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
    </style>
</head>
<body>
    <?php include('../include/navbar.php'); ?>
    <?php
        if (isset($_SESSION["datos_cs"], $_SESSION["datos_as"], $_SESSION["datos_c"], $_SESSION["datos_mi"], $_SESSION["datos_pc"])) {
            echo "
                <div class='container-fluid d-flex justify-content-center align-items-center my-4 row'>
                    <div class='card p-4 shadow-lg col-10 col-md-6 animacion_form'>
                        <h2 class='mb-4 text-center  text-primary fw-bold'>DIAGNÓSTICOS</h2>
                        <div class='d-flex justify-content-end mb-2'>
                            <a href='../controlador/borrar_datos_formulario.php' 
                            class='btn btn-outline-danger d-flex align-items-center rounded-pill shadow-sm px-4'>
                                    <span class='d-none d-md-inline me-2'>Borrar datos y salir</span><i class='bi bi-trash'></i>
                            </a>
                        </div>";
                        include('../include/aviso.php'); 
                        echo "<form method='POST'>
                            <div class='row'>
                                <div class='col-md-12 mb-3'>
                                    <label for='motivo_inc' class='form-label fw-bold'>Motivo principal de incapacidad</label>
                                    <select class='form-select' id='motivo_inc' name='motivo_inc'>
                                        <option value=''>-</option>";
                                        foreach ($_SESSION["datos_mi"] as $mi) {
                                            echo "<option value='{$mi["id_motivo_inc"]}'" . (isset($_SESSION["motivo_inc"]) && $_SESSION["motivo_inc"] == $mi["id_motivo_inc"] ? " selected" : "") . ">{$mi["descripcion"]}</option>";
                                        }

                                        echo "</select>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='co_morb' class='form-label fw-bold'>Comorbilidad</label><i class='bi bi-info-circle text-primary ms-3' 
                                                                                data-bs-toggle='tooltip' 
                                                                                data-bs-placement='top' 
                                                                                data-bs-custom-class='tooltip-personalizado'
                                                                                data-bs-title='This top tooltip is themed via CSS variables'></i>
                                    <input type='number' class='form-control' id='co_morb' name='co_morb' value='" . (isset($_SESSION["co_morb"]) ? $_SESSION["co_morb"] : "") . "'>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='num_farm' class='form-label fw-bold'>Número de fármacos</label>
                                    <input type='number' class='form-control' id='num_farm' name='num_farm' value='" . (isset($_SESSION["num_farm"]) ? $_SESSION["num_farm"] : "") . "'>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='grado_ulcera' class='form-label fw-bold'>Grado de úlcera</label>
                                    <select class='form-select' id='grado_ulcera' name='grado_ulcera'>
                                        <option value=''>-</option>
                                        <option value='0'" . (isset($_SESSION["grado_ulcera"]) && $_SESSION["grado_ulcera"] == '0' ? " selected" : "") . ">0</option>
                                        <option value='1'" . (isset($_SESSION["grado_ulcera"]) && $_SESSION["grado_ulcera"] == '1' ? " selected" : "") . ">1</option>
                                        <option value='2'" . (isset($_SESSION["grado_ulcera"]) && $_SESSION["grado_ulcera"] == '2' ? " selected" : "") . ">2</option>
                                        <option value='3'" . (isset($_SESSION["grado_ulcera"]) && $_SESSION["grado_ulcera"] == '3' ? " selected" : "") . ">3</option>
                                        <option value='4'" . (isset($_SESSION["grado_ulcera"]) && $_SESSION["grado_ulcera"] == '4' ? " selected" : "") . ">4</option>
                                    </select>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='dolor' class='form-label fw-bold'>Dolor</label>
                                    <select class='form-select' id='dolor' name='dolor'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["dolor"]) && $_SESSION["dolor"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["dolor"]) && $_SESSION["dolor"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='rip_domi' class='form-label fw-bold'>Fallecimiento en domicilio</label>
                                    <select class='form-select' id='rip_domi' name='rip_domi'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["rip_domi"]) && $_SESSION["rip_domi"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["rip_domi"]) && $_SESSION["rip_domi"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='upp' class='form-label fw-bold'>UPP</label>
                                    <select class='form-select' id='upp' name='upp'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["upp"]) && $_SESSION["upp"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["upp"]) && $_SESSION["upp"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div> 
                            </div>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='in_ur' class='form-label fw-bold'>Incontinencia urinaria</label>
                                    <select class='form-select' id='in_ur' name='in_ur'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["in_ur"]) && $_SESSION["in_ur"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["in_ur"]) && $_SESSION["in_ur"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='disf' class='form-label fw-bold'>Disfagia</label>
                                    <select class='form-select' id='disf' name='disf'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["disf"]) && $_SESSION["disf"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["disf"]) && $_SESSION["disf"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div> 
                            </div>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='in_fec' class='form-label fw-bold'>Incontinencia fecal</label>
                                    <select class='form-select' id='in_fec' name='in_fec'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["in_fec"]) && $_SESSION["in_fec"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["in_fec"]) && $_SESSION["in_fec"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='sv' class='form-label fw-bold'>Sonda vesical</label>
                                    <select class='form-select' id='sv' name='sv'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["sv"]) && $_SESSION["sv"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["sv"]) && $_SESSION["sv"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div> 
                            </div>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='insom' class='form-label fw-bold'>Insomnio</label>
                                    <select class='form-select' id='insom' name='insom'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["insom"]) && $_SESSION["insom"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["insom"]) && $_SESSION["insom"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='sng' class='form-label fw-bold'>SNG-Gastrostomía</label>
                                    <select class='form-select' id='sng' name='sng'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["sng"]) && $_SESSION["sng"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["sng"]) && $_SESSION["sng"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div> 
                            </div>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='sob_cui' class='form-label fw-bold'>Sobrecarga cuidador</label>
                                    <select class='form-select' id='sob_cui' name='sob_cui'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["sob_cui"]) && $_SESSION["sob_cui"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["sob_cui"]) && $_SESSION["sob_cui"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='ocd' class='form-label fw-bold'>Oxigenoterapia</label><i class='bi bi-info-circle text-primary ms-3' 
                                                                                data-bs-toggle='tooltip' 
                                                                                data-bs-placement='top' 
                                                                                data-bs-custom-class='tooltip-personalizado'
                                                                                data-bs-title='This top tooltip is themed via CSS variables'></i>
                                    <select class='form-select' id='ocd' name='ocd'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["ocd"]) && $_SESSION["ocd"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["ocd"]) && $_SESSION["ocd"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div> 
                            </div>

                            <div class='d-flex justify-content-between'>
                                <a href='./aniadir_paciente_demograficos.php' class='btn btn-outline-primary d-flex align-items-center rounded-pill shadow-sm px-4'>
                                    <i class='bi bi-arrow-left me-2'></i><span class='d-none d-md-inline'>Atrás</span>
                                </a>
                                <button type='submit' formaction='../controlador/guardar_diagnosticos.php' class='btn btn-outline-primary d-flex align-items-center rounded-pill shadow-sm px-4'>
                                    <span class='d-none d-md-inline'>Siguiente</span> <i class='bi bi-arrow-right ms-2'></i>
                                </button>
                            </div>
                        </form>
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
