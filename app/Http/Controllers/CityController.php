<?php
namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;

class CityController extends Controller{

    public function getProvince(){

        return response()->json([
            'success' => true,
            'message' => 'Valid Kontrakan',
            'data' => Province::all(),
        ]);
    }

    public function getCity(Request $request){
        $provinceID = $request->provinceID;

        return response()->json([
            'success' => true,
            'message' => 'Valid Kontrakan',
            'data' => City::where('provinceID', $provinceID)->get(),
        ]);
    }

}