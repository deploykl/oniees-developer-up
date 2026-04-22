<?php

namespace App\Http\Controllers\Registro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Webpage;

class WebPageController extends Controller
{
    public function __construct(){
        $this->middleware(['can:Web Page - Inicio'])->only('index');
    }

    public function index()
    {
        $webpage = Webpage::first(); 
        return view('registro.webpage.index', compact('webpage'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2024',
        ]);

        try {
            $destinationPath = public_path('img/webpage');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $file = $request->file('image');
            $filename = 'icono_' . time() . '.' . $file->getClientOriginalExtension();

            $file->move($destinationPath, $filename);

            $url = asset("img/webpage/$filename");

            $webpage = Webpage::first();
            if (!$webpage) {
                $webpage = new Webpage();
            }
            $webpage->imagen = "img/webpage/$filename";
            $webpage->save();

            return response()->json([
                'success' => true,
                'message' => 'Imagen subida correctamente.',
                'image_url' => $url
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Hubo un problema al subir la imagen.'
            ]);
        }
    }
}