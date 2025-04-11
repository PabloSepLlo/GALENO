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
        if (isset($_SESSION["datos_cs"], $_SESSION["datos_as"], $_SESSION["datos_c"], $_SESSION["datos_mi"], $_SESSION["datos_pc"])) {
            echo "
                <div class='container d-flex justify-content-center align-items-center my-4'>
                    <div class='card p-4 shadow-lg w-50'>
                        <h2 class='mb-4 text-center'>DIAGNÓSTICOS</h2>";
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
                        echo "<form method='POST'>
                            <div class='row d-flex justify-content-end'>
                                <button type='submit' class='btn btn-danger col-sm-2 col-md-1 d-flex justify-content-center align-items-center' formaction='../controlador/borrar_datos_formulario_paciente.php' title='Borrar datos de paciente y salir'>
                                    <i class='bi bi-x-lg'></i>
                                </button>
                            </div>
                            <div class='row'>
                                <div class='col-md-12 mb-3'>
                                    <label for='motivo_inc' class='form-label'>Motivo principal de incapacidad</label>
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
                                    <label for='co_morb' class='form-label'>Comorbilidad</label>
                                    <input type='number' class='form-control' id='co_morb' name='co_morb' value='" . (isset($_SESSION["co_morb"]) ? $_SESSION["co_morb"] : "") . "'>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='num_farm' class='form-label'>Número de fármacos</label>
                                    <input type='number' class='form-control' id='num_farm' name='num_farm' value='" . (isset($_SESSION["num_farm"]) ? $_SESSION["num_farm"] : "") . "'>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='grado_ulcera' class='form-label'>Grado de úlcera</label>
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
                                    <label for='dolor' class='form-label'>Dolor</label>
                                    <select class='form-select' id='dolor' name='dolor'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["dolor"]) && $_SESSION["dolor"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["dolor"]) && $_SESSION["dolor"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='rip_domi' class='form-label'>Rip_domi</label>
                                    <select class='form-select' id='rip_domi' name='rip_domi'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["rip_domi"]) && $_SESSION["rip_domi"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["rip_domi"]) && $_SESSION["rip_domi"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='upp' class='form-label'>UPP</label>
                                    <select class='form-select' id='upp' name='upp'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["upp"]) && $_SESSION["upp"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["upp"]) && $_SESSION["upp"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div> 
                            </div>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='in_ur' class='form-label'>Incontinencia urinaria</label>
                                    <select class='form-select' id='in_ur' name='in_ur'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["in_ur"]) && $_SESSION["in_ur"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["in_ur"]) && $_SESSION["in_ur"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='disf' class='form-label'>Disfagia</label>
                                    <select class='form-select' id='disf' name='disf'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["disf"]) && $_SESSION["disf"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["disf"]) && $_SESSION["disf"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div> 
                            </div>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='in_fec' class='form-label'>Incontinencia fecal</label>
                                    <select class='form-select' id='in_fec' name='in_fec'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["in_fec"]) && $_SESSION["in_fec"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["in_fec"]) && $_SESSION["in_fec"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='sv' class='form-label'>SV</label>
                                    <select class='form-select' id='sv' name='sv'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["sv"]) && $_SESSION["sv"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["sv"]) && $_SESSION["sv"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div> 
                            </div>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='insom' class='form-label'>Insomnio</label>
                                    <select class='form-select' id='insom' name='insom'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["insom"]) && $_SESSION["insom"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["insom"]) && $_SESSION["insom"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='sng' class='form-label'>SNG</label>
                                    <select class='form-select' id='sng' name='sng'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["sng"]) && $_SESSION["sng"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["sng"]) && $_SESSION["sng"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div> 
                            </div>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='sob_cui' class='form-label'>Sob_cui</label>
                                    <select class='form-select' id='sob_cui' name='sob_cui'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["sob_cui"]) && $_SESSION["sob_cui"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["sob_cui"]) && $_SESSION["sob_cui"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='ocd' class='form-label'>OCD</label>
                                    <select class='form-select' id='ocd' name='ocd'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["ocd"]) && $_SESSION["ocd"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["ocd"]) && $_SESSION["ocd"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div> 
                            </div>
                            <div class='row d-flex justify-content-between'>
                                <a href='./aniadir_paciente_demograficos.php' class='btn btn-primary col-sm-2 col-md-1 d-flex justify-content-center align-items-center mx-2' title='Regresar'>
                                    <i class='bi bi-arrow-left'></i>
                                </a>
                                <button type='submit' formaction='../controlador/guardar_diagnosticos.php' class='btn btn-primary col-sm-2 col-md-1 d-flex justify-content-center align-items-center mx-2' title='Guardar y continuar'>
                                    <i class='bi bi-arrow-right'></i>
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
