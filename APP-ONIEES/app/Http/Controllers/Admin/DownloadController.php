<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DownloadController extends Controller
{
    public function encodeFile(Request $request) {
        try {
            $file = base64_encode($request->input('file'));
            $name = base64_encode($request->input('name'));
            
            return [
                'status' => 'OK',
                'file' => $file,
                'name' => $name
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'mensaje' => $e->getMessage()
            ];
        }
    }
    
    public function downloadFile($file, $name){
        $file = base64_decode($file);
        $name = base64_decode($name);
        $src = public_path("storage/".$file);
        if (file_exists($src)) {
            return response()->download($src, $name);
        } else {
            return "ERROR";
        }
    }
}