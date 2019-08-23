<?php
// include_once 'config/db.php';
// include_once 'ceklogin.php';
// require_once 'config/dbmanager.php';

// if (!empty($_POST)) {
//     $request = (object) $_POST;
//     echo json_encode($request);
// }
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('bukti_pengeluaran.xlsx');

$worksheet = $spreadsheet->getActiveSheet();

$worksheet->getCell('nama_kepalasekolah')->setValue('John');
// $worksheet->getCell('A2')->setValue('Smith');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('output.xlsx');