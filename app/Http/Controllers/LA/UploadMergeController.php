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

            //exec("cat $file_names[0] > final_data.csv && cat file_names[1] >> final_data.csv");

        $rows = array();
        if (($handle = fopen("../storage/app/public/csv2.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $rows[] = $data;
            }
            fclose($handle);
        }

        return view('la/uploadmerge/upload')->with('rows',$rows);
    }
}
