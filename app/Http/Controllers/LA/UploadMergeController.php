<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\UploadMerge;
use DB;
use Excel;


class UploadMergeController extends Controller
{
    public function importExport()
    {
        return view('la/uploadmerge/upload');
    }

    public function downloadExcel($type)
    {
        $data = Item::get()->toArray();
        return Excel::create('final_csv', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }


    public function importExcel(Request $request)
    {
        $files = $request->file('import_file');

        if(!empty($files)) {
            $file_names = [];
            foreach ($files as $key => $file)
            {
                $file_names[$key] = $file->getClientOriginalName();
            }

            //this is where you need to run R script
            //exec("Rscript test.R $file_names", $results);
            //Basically $result needs to return final_data.csv. So I can run that tables into template.

            exec("cat $file_names[0] > final_data.csv && cat file_names[1] >> final_data.csv");

            $row = 1;
            if (($handle = fopen('../final_data.csv', "r")) !== FALSE)
            {
                echo '<table border="1">';

                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
                {
                    $num = count($data);
                    if ($row == 1) {
                        echo '<thead><tr>';
                    }else{
                        echo '<tr>';
                    }

                    for ($c=0; $c < $num; $c++) {
                        //echo $data[$c] . "<br />\n";
                        if(empty($data[$c])) {
                            $value = "&nbsp;";
                        }else{
                            $value = $data[$c];
                        }
                        if ($row == 1) {
                            echo '<th>'.$value.'</th>';
                        }else{
                            echo '<td>'.$value.'</td>';
                        }
                    }
                    if ($row == 1) {
                        echo '</tr></thead><tbody>';
                    }else{
                        echo '</tr>';
                    }
                    $row++;
                }

                echo '</tbody></table>';
                fclose($handle);
            }
            return view('la/uploadmerge/upload');
        }
    }
}
