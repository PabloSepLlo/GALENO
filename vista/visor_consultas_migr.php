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
    <title>Visor de consultas</title>

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

        .titulo-azul-oscuro {
            color: #052c65 !important;
        }
    </style>
</head>
<body>
    <?php 
        include("../include/navbar.php");
        include("../include/aviso.php");
        if (isset($_GET["filtroMIGR"])) {
            echo "
                <div class='modal fade show' id='modalFiltroMIGR' tabindex='-1' style='display: block; background: rgba(0,0,0,0.5);' aria-labelledby='modalFiltroMIGRLabel'>
                    <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title'>Seleccione el motivo de ingreso de los pacientes que quiere consultar</h5>
                                <a href='./menu.php' class='btn-close'></a>
                            </div>
                            <div class='modal-body'>
                                <form method='POST' action='../controlador/cargar_datos_paciente_por_migr.php'>
                                    <label for='motivo_ingreso' class='form-label fw-bold'>Motivo de ingreso</label>
                                        <select class='form-select' id='motivo_ingreso' name='motivo_ingreso'>
                                            <option value=''>-</option>";

                                                foreach ($_SESSION["datos_migr"] as $migr) {
                                                    echo "<option value='{$migr["id_motivo_ingreso"]}'>{$migr["descripcion"]}</option>";
                                                }
                                                unset($_SESSION["datos_migr"]);
                                        echo "</select>
                                    <div class='modal-footer'>
                                        <button type='submit' class='btn btn-primary'>Filtrar por MIGR</button>
                                        <a href='./menu.php' class='btn btn-secondary'>Cancelar</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>";
            unset($_SESSION["pacientes_por_migr"], $_SESSION["pacientes_por_cs"]);
        }
        if (isset($_SESSION["pacientes_por_migr"])) {
            echo "
            <div class='row mx-5 mt-4'>
                <div class='col-md-12'>
                    <div class='card shadow-sm bg-primary-subtle'>
                        <div class='card-body py-3'>
                            <div class='d-flex flex-column flex-md-row justify-content-center align-items-center'>
                                <h3 class='card-title mb-2 fw-bold titulo-azul-oscuro'>
                                    PACIENTES CON MOTIVO DE INGRESO: {$_SESSION["pacientes_por_migr"][0]["motivo_ingreso"]}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='row d-flex justify-content-between align-items-center mb-3 mx-5'>
                <div class='col-sm-6 col-md-3'>
                    <input type='text' class='form-control' id='buscar' placeholder='Filtrar por apellido ...'>
                </div>
                <div class='col-sm-2 col-md-1 d-flex justify-content-center'>
                    <a href='../controlador/borrar_datos_formulario.php' 
                    class='btn btn-link text-danger' 
                    title='Borrar datos y salir'>
                        <i class='bi bi-x-lg fs-3'></i>
                    </a>
                </div>
            </div>
            <div class='table-responsive-md mx-5'>
                <table class='table table-primary table-striped table-hover table-bordered'>
                    <thead>
                        <tr>
                            <th>N.H.C</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Edad</th>
                            <th>Motivo de incapacidad</th>
                            <th>Centro de salud</th>
                            <th>Médico/a</th>
                        </tr>
                    </thead>
                    <tbody class='table-light'>";
            
            foreach ($_SESSION["pacientes_por_migr"] as $paciente) { 
                echo "<tr>
                        <td>{$paciente['nhc']}</td>
                        <td>{$paciente['nombre']}</td>
                        <td class='ape'>{$paciente['ape1']} {$paciente['ape2']}</td>
                        <td>{$paciente['edad']}</td>
                        <td>{$paciente['motivo_inc']}</td>
                        <td>{$paciente['codigo_centro']}</td>
                        <td>{$paciente['medico']}</td>
                    </tr>";
            }
        
            echo "</tbody>
                </table>
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
        const buscar = document.getElementById("buscar");
        buscar.addEventListener("input", function() {
            const texto = buscar.value.toLowerCase();
            document.querySelectorAll("tr").forEach(fila => {
                const ape = fila.querySelector(".ape");
                if (ape) {
                    const apellidos = ape.textContent.toLowerCase();
                    fila.style.display = apellidos.includes(texto) ? "table-row" : "none";
                }
            });
        });
    </script>
</body>
</html>
