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
    <title>Vista resumen ingreso</title>

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
        .titulo-azul-oscuro {
            color: #052c65 !important;
        }

    </style>
</head>
<body>
    <?php 
        include("../include/navbar.php");
        include("../include/aviso.php");
    ?> 
    <div class="container-fluid my-4">
    <?php
        echo "
        <div class='row mb-4'>
            <div class='col-md-12'>
                <div class='card shadow-sm bg-primary-subtle'>
                    <div class='card-body py-3'>
                        <div class='d-flex flex-column flex-md-row justify-content-between align-items-center'>
                            <h3 class='card-title mb-2 fw-bold titulo-azul-oscuro'>
                                DATOS INGRESO 
                            </h3>
                            <div class='text-center text-md-end'>
                                <h4 class='mb-1'>
                                    <span class='titulo-azul-oscuro fw-bold'>Paciente: </span> 
                                    {$_SESSION["nombre"]} {$_SESSION["ape1"]} {$_SESSION["ape2"]}</span>
                                </h4>
                                <h5 class='mb-0 text-secondary'>
                                    <span class='badge bg-white border border-primary titulo-azul-oscuro px-3 py-2'>
                                        N.H.C: {$_SESSION["nhc"]}
                                    </span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ";
    ?>
        <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button fs-4 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                    GENERALES
                </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <table class="table table-primary table-striped-columns table-bordered table-hover">
                            <?php
                                $procedencia = null;
                                foreach ($_SESSION["datos_pr"] as $pr) {
                                    if ($pr["id_procedencia"] == $_SESSION["procedencia"]){
                                        $procedencia = $pr["descripcion"];
                                    }
                                } 
                                $destino = null;
                                foreach ($_SESSION["datos_de"] as $de) {
                                    if ($de["id_destino"] == $_SESSION["destino"]){
                                        $destino = $de["descripcion"];
                                    }
                                } 
                                echo "
                                <tr>
                                    <td>Fecha de ingreso</td>
                                    <td>". ($_SESSION["fecha_ingreso"] ?? '-') ."</td>
                                </tr>
                                <tr>
                                    <td>Fecha de alta</td>
                                    <td>". ($_SESSION["fecha_alta"] ?? '-') ."</td>
                                </tr>
                                <tr>
                                    <td>Reingreso</td>
                                    <td>". ($_SESSION["reingreso"] ?? '-') ."</td>
                                </tr>
                                <tr>
                                    <td>Número de visitas</td>
                                    <td>". ($_SESSION["NUM_VISIT"] ?? '-') ."</td>
                                </tr>
                                <tr>
                                    <td>Procedencia</td>
                                    <td>". ($procedencia ?? '-') ."</td>
                                </tr>
                                <tr>
                                    <td>Destino</td>
                                    <td>". ($destino ?? '-') ."</td>
                                </tr>
                                ";
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button collapsed fs-4 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                    DIAGNÓSTICOS
                </button>
                </h2>
                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <table class="table table-primary table-striped-columns table-bordered table-hover">
                            <?php
                                $motivo_ingreso = null;
                                foreach ($_SESSION["datos_migr"] as $migr) {
                                    if ($migr["id_motivo_ingreso"] == $_SESSION["motivo_ingreso"]){
                                        $motivo_ingreso = $migr["descripcion"];
                                    }
                                } 
                                $tratamientos = [];
                                if ($_SESSION["lista_tratamientos"] != null) {
                                    foreach ($_SESSION["datos_tr"] as $tr) {
                                        if (in_array($tr["id_tratamiento"], $_SESSION["lista_tratamientos"])) {
                                            $tratamientos[] = $tr["descripcion"];
                                        }
                                    } 
                                }
                                echo "
                                <tr>
                                    <td>CRF</td>
                                    <td>". ($_SESSION["crf"] ?? '-') ."</td>
                                </tr>
                                <tr>
                                    <td>CRM</td>
                                    <td>". ($_SESSION["crm"] ?? '-') ."</td>
                                </tr>
                                <tr>
                                    <td>ECO</td>
                                    <td>". ($_SESSION["eco"] ?? '-') ."</td>
                                </tr>
                                <tr>
                                    <td>Cultivo</td>
                                    <td>". ($_SESSION["cultivo"] ?? '-') ."</td>
                                </tr>
                                <tr>
                                    <td>Barthel</td>
                                    <td>". ($_SESSION["barthel"] ?? '-') ."</td>
                                </tr>
                                <tr>
                                    <td>Pfeiffer</td>
                                    <td>". ($_SESSION["pfeiffer"] ?? '-') ."</td>
                                </tr>
                                <tr>
                                    <td>Analítica</td>
                                    <td>". ($_SESSION["analitica"] ?? '-') ."</td>
                                </tr>
                                <tr>
                                    <td>Minimental</td>
                                    <td>". ($_SESSION["minimental"] ?? '-') ."</td>
                                </tr>
                                <tr>
                                    <td>Motivo de ingreso</td>
                                    <td>". ($motivo_ingreso ?? '-') ."</td>
                                </tr>
                                <tr>
                                    <td>Tratamiento(s)</td>
                                    <td>"; 
                                        if (!empty($tratamientos)) {
                                            echo "<ul>";
                                            foreach($tratamientos as $tratamiento){
                                                echo "<li>". $tratamiento . "</li>";
                                            }
                                            echo "</ul>";
                                        }
                                        else {
                                            echo "-";
                                        }
                                    echo "</td>
                                </tr>
                                ";
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container text-center my-4">
        <?php
            if (isset($_SESSION["editando"])) {
                echo "
                    <a href='./aniadir_ingreso_diagnosticos.php' class='btn btn-primary me-2'>Volver a editar</a>
                    <a href='../controlador/actualizar_ingreso.php' class='btn btn-success me-2'>Guardar los cambios</a>
                    <a href='../controlador/borrar_datos_formulario.php' class='btn btn-danger'>Cancelar</a> 
                ";
            }
            else {
                echo "
                    <a href='./aniadir_ingreso_diagnosticos.php' class='btn btn-primary me-2'>Volver a editar</a>
                    <a href='../controlador/aniadir_ingreso.php' class='btn btn-success me-2'>Guardar ingreso</a>
                    <a href='../controlador/borrar_datos_formulario.php' class='btn btn-danger'>Cancelar</a>
                ";
            }

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
