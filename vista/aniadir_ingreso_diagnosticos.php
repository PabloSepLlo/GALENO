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
    <title>Añadir ingreso</title>

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

        .nav-link {
            color: white;
            font-weight: 500;
        }

        .navbar-toggler {
            border-color: white;
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
        if (!isset($_GET["ingresando"]) && isset($_SESSION["datos_migr"], $_SESSION["datos_pr"], $_SESSION["datos_de"], $_SESSION["datos_tr"])){
            echo "
                <div class='container-fluid d-flex justify-content-center align-items-center my-4 row'>
                    <div class='card p-4 shadow-lg col-10 col-md-6 animacion_form'>
                        <h2 class='mb-4 text-center fw-bold  text-primary'>DIAGNÓSTICOS</h2>
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
                            <div class='col-auto'>
                                <a href='../controlador/borrar_datos_formulario.php' 
                                class='btn btn-outline-danger d-flex align-items-center rounded-pill shadow-sm px-4'>
                                        <span class='d-none d-md-inline me-2'>Cancelar y salir</span><i class='bi bi-x-lg'></i>
                                </a>
                            </div>
                        </div>
                        <div class='progress my-2'>
                            <div class='progress-bar progress-bar-striped progress-bar-animated' role='progressbar' aria-valuenow='75' aria-valuemin='0' aria-valuemax='100' style='width: 66%'></div>
                        </div>";
                        include('../include/aviso.php'); 
                        echo "<form method='POST'>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='crf' class='form-label fw-bold'>CRF</label>
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
                                    <label for='crm' class='form-label fw-bold'>CRM</label>
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
                                    <label for='eco' class='form-label fw-bold'>ECO</label>
                                    <select class='form-select' id='eco' name='eco'>
                                        <option value=''>-</option>
                                        <option value='SÍ'" . (isset($_SESSION["eco"]) && $_SESSION["eco"] == "SÍ" ? " selected" : "") . ">SÍ</option>
                                        <option value='NO'" . (isset($_SESSION["eco"]) && $_SESSION["eco"] == "NO" ? " selected" : "") . ">NO</option>
                                    </select>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='cultivo' class='form-label fw-bold'>Cultivo</label>
                                    <input type='number' class='form-control' id='cultivo' name='cultivo' value='" . (isset($_SESSION["cultivo"]) ? $_SESSION["cultivo"] : "") . "'>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='barthel' class='form-label fw-bold'>Barthel</label>
                                    <input type='number' class='form-control' id='barthel' name='barthel' value='" . (isset($_SESSION["barthel"]) ? $_SESSION["barthel"] : "") . "'>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='pfeiffer' class='form-label fw-bold'>Pfeiffer</label>
                                    <input type='number' class='form-control' id='pfeiffer' name='pfeiffer' value='" . (isset($_SESSION["pfeiffer"]) ? $_SESSION["pfeiffer"] : "") . "'>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-6 mb-3'>
                                    <label for='analitica' class='form-label fw-bold'>Analítica</label>
                                    <input type='number' class='form-control' id='analitica' name='analitica' value='" . (isset($_SESSION["analitica"]) ? $_SESSION["analitica"] : "") . "'>
                                </div>
                                <div class='col-md-6 mb-3'>
                                    <label for='minimental' class='form-label fw-bold'>Minimental</label>
                                    <input type='number' class='form-control' id='minimental' name='minimental' value='" . (isset($_SESSION["minimental"]) ? $_SESSION["minimental"] : "") . "'>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12 mb-3'>
                                    <label for='motivo_ingreso' class='form-label fw-bold'>Motivo de ingreso</label>
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
                                    <label for='tratamiento' class='form-label fw-bold'>Tratamiento</label>
                                    <div class='dropdown-multi'>
                                        <div class='dropdown-button form-control' onclick='toggleDropdown()' id='dropdownText'>Añada el(los) tratamiento(s)</div>
                                        <div class='dropdown-list border rounded mt-1 p-2' id='dropdownList' style='display:none;'>";

                                        foreach ($_SESSION['datos_tr'] as $tr) {
                                            echo "<label class='d-block'><input type='checkbox' name='tratamientos[]' value='" . $tr['id_tratamiento'] . "' onchange='updateDropdownText()'" . 
                                            (isset($_SESSION['lista_tratamientos']) && in_array($tr['id_tratamiento'], $_SESSION['lista_tratamientos']) ? " checked" : "") . "> " . $tr['descripcion'] . "</label>";
                                        }

                            echo "
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='d-flex justify-content-between'>
                                <a href='./aniadir_ingreso_generales.php' class='btn btn-outline-primary d-flex align-items-center rounded-pill shadow-sm px-4'>
                                    <i class='bi bi-arrow-left me-2'></i><span class='d-none d-md-inline'>Atrás</span>
                                </a>
                                <button type='submit' formaction='../controlador/guardar_diagnosticos_ingreso.php' class='btn btn-primary d-flex align-items-center rounded-pill shadow-sm px-4'>
                                    <span class='d-none d-md-inline'>Guardar</span> <i class='bi bi-arrow-right ms-2'></i>
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
        // Inicializa todos los tooltips de Bootstrap en los elementos que tengan el atributo data-bs-toggle="tooltip"
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

        // Función para mostrar u ocultar el menú desplegable de los tratamientos
        function toggleDropdown() {
            const list = document.getElementById('dropdownList');
            list.style.display = list.style.display === 'block' ? 'none' : 'block';
        }

        // Función para actualizar el texto del botón con los elementos seleccionados del dropdown
        function updateDropdownText() {
            // Obtiene los checkboxes marcados dentro del dropdown
            const selected = Array.from(document.querySelectorAll('#dropdownList input:checked')).map(cb => cb.parentElement.textContent.trim());
            const button = document.getElementById('dropdownText');
            // Si hay seleccionados, los muestra en el botón; si no, muestra el texto por defecto
            button.textContent = selected.length ? selected.join(', ') : 'Añada el(los) tratamiento(s)';
        }

        // Cierra el dropdown si se hace clic fuera de él
        document.addEventListener('click', function(e) {
            const box = document.querySelector('.dropdown-multi');
            if (!box.contains(e.target)) {
                document.getElementById('dropdownList').style.display = 'none';
            }
        });

        // Actualiza el texto del dropdown cuando el contenido del DOM se haya cargado
        document.addEventListener('DOMContentLoaded', updateDropdownText);
        
        // Muestra un modal de aviso automáticamente cuando la página termina de cargarse
        document.addEventListener('DOMContentLoaded', () => {
            const modalElement = document.getElementById('sessionModal');
            if (modalElement) {
                const sessionModal = new bootstrap.Modal(modalElement);
                sessionModal.show();
            }
        });
    </script>
</body>
</html>
