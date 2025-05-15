<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
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
            background: #003366; 
            margin: 2.5rem 0;
            opacity: 0.2; 
        }
        .informe-geriatrico .dato-label {
            font-weight: 600;
            color: #003366; 
        }
    </style>
</head>
<body>
    <div class="informe-geriatrico">
        <?php include("../include/visor_informe.php"); ?>
    </div>                   
</body>
</html>