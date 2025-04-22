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
       
    <div class="container-fluid my-4">
        <?php
            echo "
            <h4 class='text-center'>Paciente: " . (isset($_SESSION["nombre"]) ? $_SESSION["nombre"] : "") . " " . (isset($_SESSION["ape1"]) ? $_SESSION["ape1"] : "") . " " . (isset($_SESSION["ape2"]) ? $_SESSION["ape2"] : "") . "</h4>
            <h4 class='text-center'>N. H. C.: " . (isset($_SESSION["nhc"]) ? $_SESSION["nhc"] : "") . "</h4>";
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
                                if ($_SESSION["tratamientos"] != null) {
                                    foreach ($_SESSION["datos_tr"] as $tr) {
                                        if (in_array($tr["id_tratamiento"], $_SESSION["tratamientos"])) {
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
                                    <td>Tratamaiento(s)</td>
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
                    <a href='../controlador/actualizar_ingreso.php' class='btn btn-success'>Guardar los cambios</a>
                ";
            }
            else {
                echo "
                    <a href='./aniadir_ingreso_diagnosticos.php' class='btn btn-primary me-2'>Volver a editar</a>
                    <a href='../controlador/aniadir_ingreso.php' class='btn btn-success'>Guardar ingreso</a>
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
