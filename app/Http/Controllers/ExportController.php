<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Exports\SummaryExport;
use Excel;

class ExportController extends Controller 
{
    public function index(){
        return view('index');
     }


     /* public function exportCSV(Request $request){
        $file_name = 'store_'.date('Y_m_d_H_i_s').'.csv';
        return Excel::download(new SummaryExport, $file_name);
     } */
     public function exportCSV(Request $request)
     {
         $type = $request->input('type');
     
         // Fetch your store data here based on the filter options
         $store_list = Store::select('id','code','name','area')->get();
     
         $csvData = [];
         $csvData[] = ['Code', 'Name', 'Type', 'Area']; // Add the CSV header row
     
         foreach ($store_list as $store) {
             $csvData[] = [
                 $store['code'],
                 $store['name'],
                 $store['type'] == 1 ? 'Cafe' : 'Kiosk',
                 $store['area'],
             ];
         }
     
         $fileName = 'store_data_' . date('Y-m-d') . '.csv';
         $headers = [
             'Content-Type' => 'text/csv',
             'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
         ];
     
         return Response::stream(function () use ($csvData) {
             $file = fopen('php://output', 'w');
             foreach ($csvData as $row) {
                 fputcsv($file, $row);
             }
             fclose($file);
         }, 200, $headers);
     }
     



}
