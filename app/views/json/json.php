<?php
header('Content-Type: application/json;charset=utf-8');
$options = PROD_ENV ? 0 : JSON_PRETTY_PRINT;
echo json_encode($dataToExtract, $options);