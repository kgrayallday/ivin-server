<?php
    require "vendor/autoload.php";
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\IOFactory;
class tablizer{
    // use PhpOffice\PhpSpreadsheet\Spreadsheet;

    //turn array into html web table 
    function webTable($array){
        // start table
        $html = '<table>';
        // header row
        $html .= '<tr>';
        foreach($array[0] as $key=>$value){
            $html .= '<th>' . htmlspecialchars($key) . '</th>';
        }

        $html .= '</tr>';

        // data rows
        foreach($array as $key=>$value){
            $html .= '<tr>';
            foreach($value as $key2=>$value2){
                $html .= '<td>' . htmlspecialchars($value2) . '<td>';
            }

            $html .= '</tr>';
        }

        //finish tabel and return

        $html .= '</table>';
        return $html;
    }


    // turn html into spreadsheet
    function spreadsheet($html){

        $reader = IOFactory::createReader('Html'); //create reader to read html
        $tmp_file = fopen('/var/www/ivin.app/public_html/tmp_file_cron.html','w+');
        file_put_contents('/var/www/ivin.app/public_html/tmp_file_cron.html',$html);
        $spreadsheet = $reader->load('/var/www/ivin.app/public_html/tmp_file_cron.html');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $file = fopen('/var/www/ivin.app/public_html/'.'scan'.'EOM'.'.xlsx','w+');
        $writer->save($file);
        //chmod('/var/www/ivin.app/public_html/scanEOM.xlsx', 0777);
        fclose($file);
        return '/var/www/ivin.app/public_html/scanEOM.xlsx';


    }
}


?>
