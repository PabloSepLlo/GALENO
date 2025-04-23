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