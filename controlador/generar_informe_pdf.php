<?php
    // Incluir autoload de Composer
    require __DIR__ . '/../vendor/autoload.php';

    use Dompdf\Dompdf;
    use Dompdf\Options;

    // Configurar DOMPDF
    $options = new Options();
    $options->set('defaultFont', 'DejaVu Sans');
    $options->set('isHtml5ParserEnabled', true);

    $dompdf = new Dompdf($options);

    ob_start();

    include '../include/informe_pdf.php';

    $html = ob_get_clean();

    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    $filename = "informe_" . $_SESSION['fecha_inicio'] . "_" . $_SESSION['fecha_fin'] . ".pdf";
    
    $dompdf->stream($filename, ["Attachment" => true]);

?>
