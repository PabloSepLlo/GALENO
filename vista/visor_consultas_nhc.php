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

    </style>
</head>
<body>
    <?php 
        include("../include/navbar.php");
        include("../include/aviso.php");
        if (isset($_GET["filtroNHC"])) {
            echo "
                <div class='modal fade show' id='modalNHC' tabindex='-1' style='display: block; background: rgba(0,0,0,0.5);' aria-labelledby='modalNHCLabel'>
                    <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title'>Introducir NHC</h5>
                                <a href='./menu.php' class='btn-close'></a>
                            </div>
                            <div class='modal-body'>
                                <form method='POST' action='../controlador/cargar_datos_paciente.php?consultando'>
                                <label for='nhc' class='form-label'>Número de Historia Clínica (NHC):</label>
                                <input type='text' name='nhc' id='nhc' class='form-control' required>
                                <div class='modal-footer'>
                                    <button type='submit' class='btn btn-primary'>Ver datos del paciente</button>
                                    <a href='./menu.php' class='btn btn-secondary'>Cancelar</a>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>";
        }
        if (isset($_GET["consultando"])) {
            echo "
                <div class='container-fluid my-4'>
                    <div class='row d-flex justify-content-end'>
                        <a href='../controlador/borrar_datos_formulario.php' 
                        class='btn btn-link p-0 text-danger col-sm-2 col-md-1 d-flex justify-content-center align-items-center' 
                        title='Salir del visor de consultas'>
                            <i class='bi bi-x-lg fs-3'></i>
                        </a>
                    </div>
                    <div class='accordion' id='accordionPanelsStayOpenExample'>
                        <div class='accordion-item'>
                            <h2 class='accordion-header'>
                            <button class='accordion-button fs-4 fw-bold' type='button' data-bs-toggle='collapse' data-bs-target='#panelsStayOpen-collapseOne' aria-expanded='true' aria-controls='panelsStayOpen-collapseOne'>
                                DEMOGRÁFICOS
                            </button>
                            </h2>
                            <div id='panelsStayOpen-collapseOne' class='accordion-collapse collapse show'>
                                <div class='accordion-body'>
                                    <table class='table table-primary table-striped-columns table-bordered table-hover'>";
                                    $centro_salud = null;
                                    foreach ($_SESSION["datos_cs"] as $cs) {
                                        if ($cs["id_centro_salud"] == $_SESSION["centro_salud"]){
                                            $centro_salud = $cs["codigo_centro"];
                                        }
                                    } 
                                    echo "
                                        <tr>
                                            <td>NHC</td>
                                            <td>". ($_SESSION["nhc"] ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>NOMBRE</td>
                                            <td>". ($_SESSION["nombre"] ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>PRIMER APELLIDO</td>
                                            <td>". ($_SESSION["ape1"] ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>SEGUNDO APELLIDO</td>
                                            <td>". ($_SESSION["ape2"] ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>SEXO</td>
                                            <td>". ($_SESSION["sexo"] ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>EDAD</td>
                                            <td>". ($_SESSION["edad"] ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>CENTRO DE SALUD</td>
                                            <td>". ($centro_salud ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>MÉDICO/A</td>
                                            <td>". ($_SESSION["med"] ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>ENFERMERO/A</td>
                                            <td>". ($_SESSION["enf"] ?? '-') ."</td>
                                        </tr>
                                    
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class='accordion-item'>
                            <h2 class='accordion-header'>
                                <button class='accordion-button collapsed fs-4 fw-bold' type='button' data-bs-toggle='collapse' data-bs-target='#panelsStayOpen-collapseTwo' aria-expanded='false' aria-controls='panelsStayOpen-collapseTwo'>
                                    DIAGNÓSTICOS
                                </button>
                            </h2>
                            <div id='panelsStayOpen-collapseTwo' class='accordion-collapse collapse'>
                                <div class='accordion-body'>
                                    <table class='table table-primary table-striped-columns table-bordered table-hover'>";
                                        $motivo_inc = null;
                                        foreach ($_SESSION["datos_mi"] as $mi) {
                                            if ($mi["id_motivo_inc"] == $_SESSION["motivo_inc"]){
                                                $motivo_inc = $mi["descripcion"];
                                            }
                                        } 
                                        echo "
                                        <tr>
                                            <td>MOTIVO PRINCIPAL DE INCAPACIDAD</td>
                                            <td>". ($motivo_inc ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>COMORBILIDAD</td>
                                            <td>". ($_SESSION["co_morb"] ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>NÚMERO DE FÁRMACOS</td>
                                            <td>". ($_SESSION["num_farm"] ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>GRADO DE ÚLCERA</td>
                                            <td>". ($_SESSION["grado_ulcera"] ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>RIP_DOMI</td>
                                            <td>". ($_SESSION["rip_domi"] ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>UPP</td>
                                            <td>". ($_SESSION["upp"] ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>INCONTINENCIA URINARIA</td>
                                            <td>". ($_SESSION["in_ur"] ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>DISFAGIA</td>
                                            <td>". ($_SESSION["disf"] ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>INCONTINENCIA FECAL</td>
                                            <td>". ($_SESSION["in_fec"] ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>SV</td>
                                            <td>". ($_SESSION["sv"] ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>INSOMNIO</td>
                                            <td>". ($_SESSION["insom"] ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>SNG</td>
                                            <td>". ($_SESSION["sng"] ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>SOB_CUI</td>
                                            <td>". ($_SESSION["sob_cui"] ?? '-') ."</td>
                                        </tr>
                                        <tr>
                                            <td>OCD</td>
                                            <td>". ($_SESSION["ocd"] ?? '-') ."</td>
                                        </tr>
                                        
                                </table>
                                </div>
                            </div>
                        </div>
                        <div class='accordion-item'>
                            <h2 class='accordion-header'>
                                <button class='accordion-button collapsed fs-4 fw-bold' type='button' data-bs-toggle='collapse' data-bs-target='#panelsStayOpen-collapseThree' aria-expanded='false' aria-controls='panelsStayOpen-collapseThree'>
                                    GENERALES
                                </button>
                            </h2>
                            <div id='panelsStayOpen-collapseThree' class='accordion-collapse collapse'>
                                <div class='accordion-body'>
                                    <table class='table table-primary table-striped-columns table-bordered table-hover'>";
                                            $ayuda_social = $convivencia = $ppal_cuidador = null;
                                            foreach ($_SESSION["datos_as"] as $as) {
                                                if ($as["id_ayuda_social"] == $_SESSION["ayuda_social"]){
                                                    $ayuda_social = $as["descripcion"];
                                                }
                                            } 
                                            foreach ($_SESSION["datos_c"] as $c) {
                                                if ($c["id_convivencia"] == $_SESSION["convivencia"]){
                                                    $convivencia = $c["descripcion"];
                                                }
                                            } 
                                            foreach ($_SESSION["datos_pc"] as $pc) {
                                                if ($pc["id_ppal_cuidador"] == $_SESSION["ppal_cuidador"]){
                                                    $ppal_cuidador = $pc["descripcion"];
                                                }
                                            } 
                                            echo "
                                            <tr>
                                                <td>AYUDA SOCIAL</td>
                                                <td>". ($ayuda_social ?? '-') ."</td>
                                            </tr>
                                            <tr>
                                                <td>CONVIVENCIA</td>
                                                <td>". ($convivencia ?? '-') ."</td>
                                            </tr>
                                            <tr>
                                                <td>PRINCIPAL CUIDADOR</td>
                                                <td>". ($ppal_cuidador ?? '-') ."</td>
                                            </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class='accordion-item'>
                            <h2 class='accordion-header'>
                                <button class='accordion-button collapsed fs-4 fw-bold' type='button' data-bs-toggle='collapse' data-bs-target='#panelsStayOpen-collapseFour' aria-expanded='false' aria-controls='panelsStayOpen-collapseFour'>
                                    INGRESOS
                                </button>
                            </h2>
                            <div id='panelsStayOpen-collapseFour' class='accordion-collapse collapse'>
                                <div class='accordion-body'>";
                                    if (!empty($_SESSION["lista_ingresos"])) {
                                        echo "<table class='table table-primary table-striped-columns table-bordered table-hover'>
                                            <tr><th>FECHA DE INGRESO</th><th>PROCEDENCIA</th><th>ACCIONES</th></tr>
                                        ";
                                        foreach ($_SESSION["lista_ingresos"] as $ingreso) {
                                            echo "<tr>
                                                    <td>{$ingreso["fecha_ingreso"]}</td>
                                                    <td> ".($ingreso["procedencia"] ?? "-") ."</td>
                                                    <td class='text-center align-middle'>
                                                        <form method='POST' class='text-center' action='../controlador/cargar_ingreso.php?consultando'>
                                                            <button type='submit' name='action' value='ver' class='btn btn-link p-0 text-primary' title='Visualizar'>
                                                                <i class='bi bi-eye'></i>
                                                            </button>
                                                            <input type='hidden' name='id_ingreso' value='{$ingreso["id"]}'>
                                                        </form>
                                                    </td>
                                                </tr>
                                                ";
                                        }
                                        echo "</table></form>";
                                    }  
                                    else {
                                        echo "Este paciente aún no tiene ingresos.";
                                    }          
                                    echo "            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
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
