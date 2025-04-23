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
    <?php include('../include/navbar.php'); ?>
    <?php
        if (isset($_SESSION["datos_cs"], $_SESSION["datos_as"], $_SESSION["datos_c"], $_SESSION["datos_mi"], $_SESSION["datos_pc"])) {
            echo "
                <div class='container d-flex justify-content-center align-items-center my-4'>
                    <div class='card p-4 shadow-lg w-50'>
                        <h2 class='mb-4 text-center'>DATOS GENERALES</h2>
                            <div class='row d-flex justify-content-end'>
                                <a href='../controlador/borrar_datos_formulario.php' 
                                class='btn btn-danger col-sm-2 col-md-1 d-flex justify-content-center align-items-center' 
                                title='Borrar datos de paciente y salir'>
                                    <i class='bi bi-x-lg'></i>
                                </a>
                            </div>";
                        include('../include/aviso.php'); 
                        echo "<form method='POST'>
                            <div class='row'>
                                <div class='col-md-12 mb-3'>
                                    <label for='ayuda_social' class='form-label'>Ayuda social</label>
                                    <select class='form-select' id='ayuda_social' name='ayuda_social'>
                                        <option value=''>-</option>";
                                        foreach ($_SESSION["datos_as"] as $as) {
                                            echo "<option value='{$as["id_ayuda_social"]}'" . (isset($_SESSION["ayuda_social"]) && $_SESSION["ayuda_social"] == $as["id_ayuda_social"] ? " selected" : "") . ">{$as["descripcion"]}</option>";
                                        }

                                        echo "</select>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12 mb-3'>
                                    <label for='convivencia' class='form-label'>Convivencia</label>
                                    <select class='form-select' id='convivencia' name='convivencia'>
                                        <option value=''>-</option>";
                                        foreach ($_SESSION["datos_c"] as $c) {
                                            echo "<option value='{$c["id_convivencia"]}'" . (isset($_SESSION["convivencia"]) && $_SESSION["convivencia"] == $c["id_convivencia"] ? " selected" : "") . ">{$c["descripcion"]}</option>";
                                        }

                                        echo "</select>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12 mb-3'>
                                    <label for='ppal_cuidador' class='form-label'>Principal cuidador</label>
                                    <select class='form-select' id='ppal_cuidador' name='ppal_cuidador'>
                                        <option value=''>-</option>";
                                        foreach ($_SESSION["datos_pc"] as $pc) {
                                            echo "<option value='{$pc["id_ppal_cuidador"]}'" . (isset($_SESSION["ppal_cuidador"]) && $_SESSION["ppal_cuidador"] == $pc["id_ppal_cuidador"] ? " selected" : "") . ">{$pc["descripcion"]}</option>";
                                        }

                                        echo "</select>
                                </div>
                            </div>
                            <div class='row d-flex justify-content-between'>
                                <a href='./aniadir_paciente_diagnosticos.php' class='btn btn-primary col-sm-2 col-md-1 d-flex justify-content-center align-items-center mx-2' title='Regresar'>
                                    <i class='bi bi-arrow-left'></i>
                                </a>
                                <button type='submit' formaction='../controlador/guardar_datos_generales.php' class='btn btn-primary col-sm-2 col-md-1 d-flex justify-content-center align-items-center mx-2' title='Guardar y continuar'>
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
