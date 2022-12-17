<?php

namespace App\Http\Controllers;

use App\Models\Kontrakan;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KontrakanController extends Controller
{
    public function index(){
        return Kontrakan::all();
    }

    public function show($id)
    {
        return Kontrakan::find($id);
    }

    public function store(Request $request){
        $this->validate($request, [
            'Image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $image_path = $request->file('Image')->store('Image', 'public');

        $data = Kontrakan::create([
            'UserID' => $request->UserID,
            'City' => $request->City,
            'Province' => $request->Province,
            'Price_per_year' => $request->Price_per_year,
            'Image' => $image_path,
            'Description' => $request->Description,
        ]);

        return response($data, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $kontrakan = Kontrakan::findOrFail($id);
        $kontrakan->update($request->all());

        return $kontrakan;
    }

    public function delete(Request $request, $id)
    {
        $kontrakan = Kontrakan::findOrFail($id);
        $kontrakan->delete();

        return 204;
    }
}
