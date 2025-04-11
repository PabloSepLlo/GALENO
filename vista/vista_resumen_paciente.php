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
        <div class="row d-flex justify-content-evenly">
            <div class="col-12 col-md-3 mb-4">
                <div class="card shadow">
                    <div class="card-header table-responsive bg-primary text-white text-center">
                        <h5>DEMOGRÁFICOS</h5>
                    </div>
                    <div class="card-body m-0">
                        <table class="table table-primary table-striped-columns table-bordered table-hover">
                            <?php
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
                            ";
                        ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 mb-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h5>DIAGNÓSTICOS</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-primary table-striped-columns table-bordered table-hover">
                            <?php
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
                            ";
                        ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h5>DATOS GENERALES</h5> 
                    </div>
                    <div class="card-body">
                    <table class="table table-primary table-striped-columns table-bordered table-hover">
                            <?php
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
                    <a href='./aniadir_paciente_datos_generales.php' class='btn btn-primary me-2'>Volver a editar</a>
                    <a href='../controlador/actualizar_paciente.php' class='btn btn-success'>Guardar los cambios</a>
                ";
            }
            else {
                echo "
                    <a href='./aniadir_paciente_datos_generales.php' class='btn btn-primary me-2'>Volver a editar</a>
                    <a href='../controlador/aniadir_paciente.php' class='btn btn-success'>Guardar paciente</a>
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
