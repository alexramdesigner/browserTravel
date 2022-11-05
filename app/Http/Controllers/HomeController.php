<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\WeatherHistory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        $cities = City::select('id','name','long','lat')->get();

        return view('app.inicio',compact('cities'));
    }
    
    //// Fetch enviados por POST
    public function guarda_historial(Request $request)
    {
        //dd($request);

        $addHistory = new WeatherHistory();
        $addHistory->icon = $request->icon;
        $addHistory->temp = $request->temp;
        $addHistory->description = $request->desc;
        $addHistory->feels_like = $request->feels_like;
        $addHistory->humidity = $request->humedad;
        $addHistory->city_id = $request->ciudad;
        $addHistory->ip = strval($this->getIp());
        $addHistory->created_at = now();

        if($addHistory->save()){
            return response()->json(['msg' => 'Registro agregado éxito','msg_type' => 'success','valid' => 1]);
        }else{
            return response()->json(['msg' => 'Imposible agregar registro' ,'msg_type' => 'error','valid' => 0]);
        }
    }

    public function carga_historial(Request $request){
        $weather = WeatherHistory::where('city_id',$request->ciudad)->get();

        $html = View::make('partials.historial',compact('weather'))->render();

        return response()->json(['msg' => 'Datos cargados con éxito','msg_type' => 'success','html'=>$html]);
    }

    public function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return server ip when no client ip found
    }

}
