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
            background-color: #f4f6f9;
        }

        /* Navbar */
        .navbar {
            background-color: #007bff; 
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
            background-color: #28a745; 
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
        /*Select*/
        .dropdown-multi {
            position: relative;
        }
        .dropdown-button {
            cursor: pointer;
        }
        .dropdown-list {
            position: absolute;
            bottom: 100%;
            left: 0;
            right: 0;
            background-color: white;
            display: none;
            max-height: 200px;
            overflow-y: auto;
            z-index: 100;
        }
        .dropdown-list label {
            display: block;
            padding: 8px;
            cursor: pointer;
        }
        .dropdown-list label:hover {
            background-color: #f1f1f1;
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
        if (!isset($_GET["ingresando"]) && isset($_SESSION["datos_migr"], $_SESSION["datos_pr"], $_SESSION["datos_de"], $_SESSION["datos_tr"])){
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
                                <button type='submit' class='btn btn-danger col-sm-2 col-md-1 d-flex justify-content-center align-items-center' formaction='../controlador/borrar_datos_formulario_ingreso.php' title='Borrar datos y salir'>
                                    <i class='bi bi-x-lg'></i>
                                </button>
                            </div>
                            <h4>Paciente: " . (isset($_SESSION["nombre"]) ? $_SESSION["nombre"] : "") . " " . (isset($_SESSION["ape1"]) ? $_SESSION["ape1"] : "") . " " . (isset($_SESSION["ape2"]) ? $_SESSION["ape2"] : "") . "</h4>
                            <h4>N. H. C.: " . (isset($_SESSION["nhc"]) ? $_SESSION["nhc"] : "") . "</h4>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='crf' class='form-label'>CRF</label>
                                    <select class='form-select' id='crf' name='crf'>
                                        <option value=''>-</option>
                                        <option value='0'" . (isset($_SESSION["crf"]) && $_SESSION["crf"] == '0' ? " selected" : "") . ">0</option>
                                        <option value='1'" . (isset($_SESSION["crf"]) && $_SESSION["crf"] == '1' ? " selected" : "") . ">1</option>
                                        <option value='2'" . (isset($_SESSION["crf"]) && $_SESSION["crf"] == '2' ? " selected" : "") . ">2</option>
                                        <option value='3'" . (isset($_SESSION["crf"]) && $_SESSION["crf"] == '3' ? " selected" : "") . ">3</option>
                                        <option value='4'" . (isset($_SESSION["crf"]) && $_SESSION["crf"] == '4' ? " selected" : "") . ">4</option>
                                        <option value='5'" . (isset($_SESSION["crf"]) && $_SESSION["crf"] == '5' ? " selected" : "") . ">5</option>
                                    </select>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='crm' class='form-label'>CRM</label>
                                    <select class='form-select' id='crm' name='crm'>
                                        <option value=''>-</option>
                                        <option value='0'" . (isset($_SESSION["crm"]) && $_SESSION["crm"] == '0' ? " selected" : "") . ">0</option>
                                        <option value='1'" . (isset($_SESSION["crm"]) && $_SESSION["crm"] == '1' ? " selected" : "") . ">1</option>
                                        <option value='2'" . (isset($_SESSION["crm"]) && $_SESSION["crm"] == '2' ? " selected" : "") . ">2</option>
                                        <option value='3'" . (isset($_SESSION["crm"]) && $_SESSION["crm"] == '3' ? " selected" : "") . ">3</option>
                                        <option value='4'" . (isset($_SESSION["crm"]) && $_SESSION["crm"] == '4' ? " selected" : "") . ">4</option>
                                        <option value='5'" . (isset($_SESSION["crm"]) && $_SESSION["crm"] == '5' ? " selected" : "") . ">5</option>
                                    </select>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='eco' class='form-label'>ECO</label>
                                    <select class='form-select' id='eco' name='eco'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["eco"]) && $_SESSION["eco"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["eco"]) && $_SESSION["eco"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='cultivo' class='form-label'>Cultivo</label>
                                    <input type='number' class='form-control' id='cultivo' name='cultivo' value='" . (isset($_SESSION["cultivo"]) ? $_SESSION["cultivo"] : "") . "'>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='barthel' class='form-label'>Barthel</label>
                                    <input type='number' class='form-control' id='barthel' name='barthel' value='" . (isset($_SESSION["barthel"]) ? $_SESSION["barthel"] : "") . "'>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='pfeiffer' class='form-label'>Pfeiffer</label>
                                    <input type='number' class='form-control' id='pfeiffer' name='pfeiffer' value='" . (isset($_SESSION["pfeiffer"]) ? $_SESSION["pfeiffer"] : "") . "'>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='analitica' class='form-label'>Analítica</label>
                                    <input type='number' class='form-control' id='analitica' name='analitica' value='" . (isset($_SESSION["analitica"]) ? $_SESSION["analitica"] : "") . "'>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='minimental' class='form-label'>Minimental</label>
                                    <input type='number' class='form-control' id='minimental' name='minimental' value='" . (isset($_SESSION["minimental"]) ? $_SESSION["minimental"] : "") . "'>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12 mb-3'>
                                    <label for='motivo_ingreso' class='form-label'>Motivo de ingreso</label>
                                    <select class='form-select' id='motivo_ingreso' name='motivo_ingreso'>
                                        <option value=''>-</option>";
                                        foreach ($_SESSION["datos_migr"] as $migr) {
                                            echo "<option value='{$migr["id_motivo_ingreso"]}'" . (isset($_SESSION["motivo_ingreso"]) && $_SESSION["motivo_ingreso"] == $migr["id_motivo_ingreso"] ? " selected" : "") . ">{$migr["descripcion"]}</option>";
                                        }

                                        echo "</select>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12 mb-3'>
                                    <label for='tratamiento' class='form-label'>Tratamiento</label>
                                    <div class='dropdown-multi'>
                                        <div class='dropdown-button form-control' onclick='toggleDropdown()' id='dropdownText'>Añada el(los) tratamiento(s)</div>
                                        <div class='dropdown-list border rounded mt-1 p-2' id='dropdownList' style='display:none;'>";

                                        foreach ($_SESSION['datos_tr'] as $tr) {
                                            echo "<label class='d-block'><input type='checkbox' name='tratamientos[]' value='" . $tr['id_tratamiento'] . "' onchange='updateDropdownText()'" . 
                                            (isset($_SESSION['tratamientos']) && in_array($tr['id_tratamiento'], $_SESSION['tratamientos']) ? " checked" : "") . "> " . $tr['descripcion'] . "</label>";
                                        }

                            echo "
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='row d-flex justify-content-between'>
                                <a href='./aniadir_ingreso_generales.php' class='btn btn-primary col-sm-2 col-md-1 d-flex justify-content-center align-items-center mx-2' title='Regresar'>
                                    <i class='bi bi-arrow-left'></i>
                                </a>
                                <button type='submit' formaction='../controlador/guardar_diagnosticos_ingreso.php' class='btn btn-primary col-sm-2 col-md-1 d-flex justify-content-center align-items-center mx-2' title='Guardar y continuar'>
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
        function toggleDropdown() {
            const list = document.getElementById('dropdownList');
            list.style.display = list.style.display === 'block' ? 'none' : 'block';
        }

        function updateDropdownText() {
            const selected = Array.from(document.querySelectorAll('#dropdownList input:checked')).map(cb => cb.parentElement.textContent.trim());
            const button = document.getElementById('dropdownText');
            button.textContent = selected.length ? selected.join(', ') : 'Añada el(los) tratamiento(s)';
        }

        window.addEventListener('click', function(e) {
            const box = document.querySelector('.dropdown-multi');
            if (!box.contains(e.target)) {
                document.getElementById('dropdownList').style.display = 'none';
            }
        });

        document.addEventListener('DOMContentLoaded', updateDropdownText);
        
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
