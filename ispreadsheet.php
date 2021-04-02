<?php
class ispreadsheet {

    function createSheet($array){ 
        require 'vendor/autoload.php';
        use PhpOffice\PhpSpreadsheet\Spreadsheet;
        use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
        require 'irandom.php';

        $newRandom = new irandom();
        $rand = $newRandom->rand_string(6);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->fromArray($array,NULL,'A1');

        $writer = new Xlsx($spreadsheet);
        $writer->save('temporaryfile-'. $rand . 'xlsx');


    }
    
