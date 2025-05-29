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
    <title>Visor informe</title>

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

        .offcanvas {
            background-color: #f4f6f9; 
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
        /* Informe */
        /* Estilos específicos para el informe */
        .informe-geriatrico {
            font-size: 0.85rem;
            overflow-x: auto;
            padding: 2rem;
        }

        .informe-geriatrico .seccion {
            margin-top: 1.5rem; 
        }

        .informe-geriatrico h1,  
        .informe-geriatrico h2,
        .informe-geriatrico h3 {
            color: #003366;
            text-align: center;
            margin-bottom: 1rem;
            font-weight: bold;
        }

        .informe-geriatrico h1 {
            font-size: 2rem;
            margin-top: 0.5rem;
        }


        .informe-geriatrico table {
            width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .informe-geriatrico table th,
        .informe-geriatrico table td {
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }

        .informe-geriatrico table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .informe-geriatrico {
            color: black;
        }

        .informe-geriatrico ul {
            padding-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .informe-geriatrico footer {
            text-align: center;
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #dee2e6;
        }
        .informe-geriatrico hr {
            border: 0;
            height: 2px;
            background: #003366; /* Fondo sólido (más legible al imprimir) */
            margin: 2.5rem 0;
            opacity: 0.2; /* Suaviza el color */
        }
        .informe-geriatrico .dato-label {
            font-weight: 600;
            color: #003366; 
        }
    </style>
</head>
<body>
    <?php 
        include("../include/navbar.php");
        include("../include/aviso.php");
        if (isset($_GET["fechas_informe"])) {
            echo"
                <div class='modal fade show' id='modalFechaInf' tabindex='-1' style='display: block; background: rgba(0,0,0,0.5);' aria-labelledby='modalFechaInfLabel'>
                    <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title'>Seleccione las dos fechas entre las que quiere obtener los datos del informe</h5>
                                <a href='./menu.php' class='btn-close'></a>
                            </div>
                            <div class='modal-body'>
                                <form method='POST' action='../controlador/cargar_datos_informe.php'>
                                    <div class='row'>
                                        <div class='col-md-6 mb-3'>
                                            <label for='fecha_ingreso' class='form-label fw-bold'>Fecha de inicio</label>
                                            <input type='date' class='form-control' id='fecha_inicio' name='fecha_inicio'>
                                        </div>
                                        <div class='col-md-6 mb-3'>
                                            <label for='fecha_alta' class='form-label fw-bold'>Fecha final</label>
                                            <input type='date' class='form-control' id='fecha_fin' name='fecha_fin'>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='submit' class='btn btn-primary'>Generar informe</button>
                                        <a href='./menu.php' class='btn btn-secondary'>Cancelar</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            ";
            unset($_SESSION["pacientes_por_migr"], $_SESSION["pacientes_por_cs"]);
        }
        if (isset($_GET["informe_generado"])) {
            echo "
                <div class='container mt-4 mb-5'>
                    <div class='col-auto d-flex justify-content-between m-2'>
                        <a href='../controlador/generar_informe_pdf.php' 
                            class='btn btn-outline-primary d-flex justify-content-around align-items-center rounded-pill shadow-sm px-4' 
                            title='Generar PDF'>
                            <span class='d-none d-md-inline me-1'>Descargar PDF</span><i class='bi bi-file-arrow-down'></i>
                        </a>
                        <a href='../controlador/borrar_datos_formulario.php' 
                            class='btn btn-outline-danger col-auto d-flex align-items-center rounded-pill shadow-sm px-4'>
                            <span class='d-none d-md-inline me-2'>Salir</span><i class='bi bi-x'></i>
                        </a>
                    </div>
                    <div class='card shadow-sm'>
                        <div class='card-body p-3 informe-geriatrico'>";
                            include("../include/visor_informe.php");
            echo "      </div>
                    </div>
                </div>";
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Muestra un modal automáticamente cuando la página termina de cargarse
        document.addEventListener('DOMContentLoaded', function() {
            const modalElement = document.getElementById('sessionModal');
            if (modalElement) {
                const sessionModal = new bootstrap.Modal(modalElement);
                sessionModal.show();
            }
        });
    </script>
</body>
</html>
