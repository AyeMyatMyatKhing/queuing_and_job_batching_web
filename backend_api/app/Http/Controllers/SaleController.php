<?php

namespace App\Http\Controllers;

use Throwable;
use App\Jobs\UploadCsvProcess;
use Illuminate\Support\Facades\Bus;
use App\Http\Requests\UploadCSVRequest;

class SaleController extends Controller
{
    /**
     * upload csv file
     */
    public function upload(UploadCSVRequest $request)
    {
        try {
            $data = file($request->file('myfile'));
            $chunks = array_chunk($data,1000);
            $header = [];
            $batch = Bus::batch([])->dispatch();
            foreach($chunks as $key => $file) {
                $data = array_map('str_getcsv' , $file);
                if($key === 0) {
                    $header = $data[0];
                    $header = array_map(function ($item) {
                        return preg_replace('/\x{FEFF}/u', '', $item);
                    }, $header);
                    unset($data[0]);
                }
                $batch->add(new UploadCsvProcess($data , $header));
            }
            return response()->json(['batch' => $batch] , 200);
        } catch(Throwable $e) {
            return response()->json(['message' => $e->getMessage()] , 500);
        } 
    }
    
    /**
     * get batch progress detail
     */
    public function batch()
    {
        $batchId = request('id');
        $batch = Bus::findBatch($batchId);
        return response()->json($batch, 200);
    }
}
