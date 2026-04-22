<?php

namespace App\Http\Controllers\Admin;

use Http;
use App\Models\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ReniecController extends Controller
{
    public function searchRUC($nroDocumento) {    
        try {
            $url = "";
            $response = null;
            $data = null;
            $readonly = false;
            $apis = Api::where('ruc', '=', '1')->take(1)->get();
            $api = $apis->count() > 0 ? $apis->first() : null;
            
            //TIPO GET
            if ($api != null && $api->tipo == 1) {
                $url = $api->url."ruc/".$nroDocumento;
                
                $requestSearch = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$api->token
                ])->get($url);
                
                
                $response = $requestSearch->json();
                $data = $response;
                    
                if ($response != null && $response["data"] != null) {
                    $datos = $response["data"];
                    $data = [  
                        "razonSocial" => $datos["nombre_o_razon_social"] != null ? $datos["nombre_o_razon_social"] : "",
                    ];
                    $readonly = true;
                }
            } else if ($api != null && $api->tipo == 3) {
                $url = $api->url."ruc/".$nroDocumento."?token=".$api->token;
                
                $requestSearch = Http::get($url);
                
                $response = $requestSearch->json();
                $data = $response;
                    
                if ($response != null) {
                    $data = [  
                        "razonSocial" => $response["razonSocial"] != null ? $response["razonSocial"] : "",
                    ];
                    $readonly = true;
                }
            }
            
            return [
                'status' => 'OK',
                'url' => $url,
                'api' => $api,
                'data' => $data,
                'response' => $response,
                'readonly' => $readonly
            ];   
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ];   
        }
    }
    
    public function search_dni($nroDocumento) {    
        try {
            $response = null;
            $data = null;
            $readonly = false;
            $apis = Api::where('dni', '=', '1')->take(1)->get();
            $api = $apis->count() > 0 ? $apis->first() : null;
            
            //TIPO GET
            if ($api != null && $api->tipo == 1) {
                $url = $api->url."dni/".$nroDocumento;
                
                $requestSearch = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.$api->token
                ])->get($url);
                
                $response = $requestSearch->json();
                $data = $response;
                    
                if ($response != null && $response["data"] != null) {
                    $datos = $response["data"];
                    $data = [  
                        "nombres" => $datos["nombres"] != null ? $datos["nombres"] : "",
                        "apellidoPaterno" => $datos["apellido_paterno"] != null ? $datos["apellido_paterno"] : "",
                        "apellidoMaterno" => $datos["apellido_materno"] != null ? $datos["apellido_materno"] : ""
                    ];
                    $readonly = true;
                }  
            } else if ($api != null && $api->tipo == 2) {
                $url = $api->url;
                
                $requestSearch = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->post($url, [
                    'idApp' => "ONIEES",
                    'nroDocumento' => $nroDocumento,
                    'oficina' => "DGIESP",
                    'renipress' => "",
                    'tipDocumento' => "1",
                    'usuarioConsulta' => Auth::user()->email,
                ]);
                $response = $requestSearch->json();
                $data = $response;
                    
                if ($response != null && $response["datos"] != null) {
                    $datos = $response["datos"];
                    $data = [  
                        "nombres" => $datos["nombres"] != null ? $datos["nombres"] : "",
                        "apellidoPaterno" => $datos["apellidoPaterno"] != null ? $datos["apellidoPaterno"] : "",
                        "apellidoMaterno" => $datos["apellidoMaterno"] != null ? $datos["apellidoMaterno"] : ""
                    ];
                    $readonly = true;
                }  
            } else if ($api != null && $api->tipo == 3) {
                $url = $api->url."dni/".$nroDocumento."?token=".$api->token;
                
                $requestSearch = Http::get($url);
                
                $response = $requestSearch->json();
                $data = $response;
                    
                if ($response != null) {
                    $data = [  
                        "nombres" => $response["nombres"] != null ? $response["nombres"] : "",
                        "apellidoPaterno" => $response["apellidoPaterno"] != null ? $response["apellidoPaterno"] : "",
                        "apellidoMaterno" => $response["apellidoMaterno"] != null ? $response["apellidoMaterno"] : ""
                    ];
                    $readonly = true;
                }
            }
            
            return [
                'status' => 'OK',
                'data' => $data,
                'response' => $response,
                'readonly' => $readonly
            ]; 
        } catch (\Exception $e) {
            return [
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ];   
        }
    }
    
    public function searchDni($fechaEmision = null, $nroDocumento = null) {    
        try {
            if ($fechaEmision == null || $nroDocumento == null) {
                throw new \Exception("FECHA EMISION Y NRO DOCUMENTO OBLIGATORIOS");
            }

            $TYPE = "DESA";
            if (env('APP_EETT_Q')) $TYPE = "CALI";
            if (env('APP_EETT_P')) $TYPE = "PROD";
            $URL_TOKEN = ""; $EETT_AUTORIZATION = ""; $EETT_USERNAME = ""; 
            $EETT_PASSWORD = ""; $EETT_GRAND_TYPE = ""; $URL_FECHAEMISION = "";
            switch($TYPE) {
                case "DESA":
                    $URL_TOKEN = env("APP_URL_D_TOKEN");
                    $EETT_AUTORIZATION = env("APP_EETT_D_AUTORIZATION");
                    $EETT_USERNAME = env("APP_EETT_D_USERNAME");
                    $EETT_PASSWORD = env("APP_EETT_D_PASSWORD");
                    $EETT_GRAND_TYPE = env("APP_EETT_D_GRAND_TYPE");
                    $URL_FECHAEMISION = env("APP_URL_D_FECHAEMISION");
                    break;
                case "CALI":
                    $URL_TOKEN = env("APP_URL_Q_TOKEN");
                    $EETT_AUTORIZATION = env("APP_EETT_Q_AUTORIZATION");
                    $EETT_USERNAME = env("APP_EETT_Q_USERNAME");
                    $EETT_PASSWORD = env("APP_EETT_Q_PASSWORD");
                    $EETT_GRAND_TYPE = env("APP_EETT_Q_GRAND_TYPE");
                    $URL_FECHAEMISION = env("APP_URL_Q_FECHAEMISION");
                    break;
                case "PROD":
                    $URL_TOKEN = env("APP_URL_P_TOKEN");
                    $EETT_AUTORIZATION = env("APP_EETT_P_AUTORIZATION");
                    $EETT_USERNAME = env("APP_EETT_P_USERNAME");
                    $EETT_PASSWORD = env("APP_EETT_P_PASSWORD");
                    $EETT_GRAND_TYPE = env("APP_EETT_P_GRAND_TYPE");
                    $URL_FECHAEMISION = env("APP_URL_P_FECHAEMISION");
                    break;
            }

            //TOKEN
            $requestToken = Http::asForm()->withHeaders([
                'Authorization' => 'Basic '.$EETT_AUTORIZATION
            ])->post($URL_TOKEN, [
                'username' => $EETT_USERNAME,
                'password' => $EETT_PASSWORD,
                'grant_type' => $EETT_GRAND_TYPE,
            ]);
            $responseToken = $requestToken->json();
            $access_token = $responseToken["access_token"];
            if ($access_token != null && strlen($access_token) == 0)
                throw new \Exception("TOKEN INVALIDO");

            // BUSQUEDA DE DOCUMENTO DE IDENTIDAD
            $fechaEmision = str_replace("-", "", $fechaEmision);

            $requestSearch = Http::withHeaders([
                'Authorization' => 'Bearer '.$access_token
            ])->get($URL_FECHAEMISION, [
                'fechaEmision' => $fechaEmision, //'20180328',
                'nroDocumento' => $nroDocumento, //'46696801',
                'tipoDocumento' => '01',
            ]);
            $responseSearch = $requestSearch->json();
            if ($responseSearch["codigo"] != "0000")
                throw new \Exception("ERROR VALIDAR DATOS PERSONALES FECHA EMISION");

            return [
                'status' => 'OK',
                'data' => [
                    'nombres' => $responseSearch["dato"]["nombres"],
                    'apellidoPaterno' => $responseSearch["dato"]["apePaterno"],
                    'apellidoMaterno' => $responseSearch["dato"]["apeMaterno"],
                ]
            ];
        } catch (\Exception $ex) {
            try {
                $response = Http::get('https://dniruc.apisperu.com/api/v1/dni/'.$nroDocumento."?token=".env('TOKEN'));
                $data = $response->json();
                
                return [
                    'status' => 'OK',
                    'data' => $data
                ];   
            } catch (\Exception $e) {
                return [
                    'status' => 'ERROR',
                    'message' => $e->getMessage()
                ];   
            }
        }
    }
    
    public function token() {   
        try {
            $TYPE = "DESA";
            if (env('APP_EETT_Q')) $TYPE = "CALI";
            if (env('APP_EETT_P')) $TYPE = "PROD";
            $URL_TOKEN = ""; $EETT_AUTORIZATION = ""; $EETT_USERNAME = ""; 
            $EETT_PASSWORD = ""; $EETT_GRAND_TYPE = ""; $URL_FECHAEMISION = "";
            switch($TYPE) {
                case "DESA":
                    $URL_TOKEN = env("APP_URL_D_TOKEN");
                    $EETT_AUTORIZATION = env("APP_EETT_D_AUTORIZATION");
                    $EETT_USERNAME = env("APP_EETT_D_USERNAME");
                    $EETT_PASSWORD = env("APP_EETT_D_PASSWORD");
                    $EETT_GRAND_TYPE = env("APP_EETT_D_GRAND_TYPE");
                    break;
                case "CALI":
                    $URL_TOKEN = env("APP_URL_Q_TOKEN");
                    $EETT_AUTORIZATION = env("APP_EETT_Q_AUTORIZATION");
                    $EETT_USERNAME = env("APP_EETT_Q_USERNAME");
                    $EETT_PASSWORD = env("APP_EETT_Q_PASSWORD");
                    $EETT_GRAND_TYPE = env("APP_EETT_Q_GRAND_TYPE");
                    break;
                case "PROD":
                    $URL_TOKEN = env("APP_URL_P_TOKEN");
                    $EETT_AUTORIZATION = env("APP_EETT_P_AUTORIZATION");
                    $EETT_USERNAME = env("APP_EETT_P_USERNAME");
                    $EETT_PASSWORD = env("APP_EETT_P_PASSWORD");
                    $EETT_GRAND_TYPE = env("APP_EETT_P_GRAND_TYPE");
                    break;
            }
            
            //TOKEN
            $requestToken = Http::withoutVerifying()
            ->withHeaders([
                'Authorization' => 'Basic '.$EETT_AUTORIZATION, 
                //'Cache-Control' => 'no-cache',
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->withOptions(["verify"=>false])
            ->post($URL_TOKEN, [
                'username' => $EETT_USERNAME,
                'password' => $EETT_PASSWORD,
                'grant_type' => $EETT_GRAND_TYPE,
            ]);

            $responseToken = $requestToken->json();
            $access_token = $responseToken["access_token"];
            if ($access_token != null && strlen($access_token) == 0)
                throw new \Exception("TOKEN INVALIDO");
                
            return $access_token;
        } catch (\Exception $ex) {
            return [
                'status' => 'ERROR',
                'message' => $ex->getMessage()
            ];   
        }
    }
}
