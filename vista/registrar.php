<?php
    session_start();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            width: 400px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center min-vh-100">
            <div class="card shadow p-4 form-container">
                <form method="POST" action="../controlador/registrar.php">
                    <h3 class="text-center mb-3">Registrate</h3>
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
                    <div class="mb-3">
                        <label for="nombreUsu" class="form-label">Nombre de usuario</label>
                        <input type="text" name="user_name" class="form-control" id="nombreUsu" required>
                    </div> 
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" id="nombre" required>
                    </div> 
                    <div class="mb-3">
                        <label for="ape1Usu" class="form-label">Primer apellido</label>
                        <input type="text" name="ape1" class="form-control" id="ape1Usu" required>
                    </div> 
                    <div class="mb-3">
                        <label for="ape2Usu" class="form-label">Segundo apellido</label>
                        <input type="text" name="ape2" class="form-control" id="ape2Usu">
                    </div> 
                    <div class="mb-3">
                        <label for="pass1" class="form-label">Contraseña</label>
                        <input type="password" name="pass1" class="form-control" id="pass1" required>
                    </div>
                    <div class="mb-3">
                        <label for="pass2" class="form-label">Repita la contraseña</label>
                        <input type="password" name="pass2" class="form-control" id="pass2" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registrar</button>
                    <div class="text-center mt-3">
                        ¿Ya tienes cuenta? <a href="./iniciar_sesion.php">Inicia sesión aquí</a>
                    </div>
                </form>
            </div>
        </div>
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