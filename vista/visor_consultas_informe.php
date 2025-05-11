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
        /* Informe */
        /* Estilos específicos para el informe */
        .informe-geriatrico {
            font-size: 0.85rem;
            overflow-x: auto;
        }

        .informe-geriatrico h1, 
        .informe-geriatrico h4, 
        .informe-geriatrico h2 {
            color: #003366;
            text-align: center;
            margin-bottom: 1rem;
        }

        .informe-geriatrico h1 {
            font-size: 1.5rem;
            margin-top: 0.5rem;
        }

        .informe-geriatrico h2 {
            font-size: 1.2rem;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 0.5rem;
        }

        .informe-geriatrico table {
            width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
        }

        .informe-geriatrico table th,
        .informe-geriatrico table td {
            padding: 0.5rem;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }

        .informe-geriatrico table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .informe-geriatrico .dato-label {
            font-weight: 600;
            color: #495057;
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
            echo "<div class='container mt-4 mb-5'>
                    <div class='card shadow-sm'>
                        <div class='card-body p-3 informe-geriatrico'>";
                            include("../include/informe.php");
            echo "      </div>
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
