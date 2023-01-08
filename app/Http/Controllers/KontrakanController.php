<?php

namespace App\Http\Controllers;

use App\Models\Kontrakan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class KontrakanController extends Controller
{
    public function indexLessor(Request $request){
        $UserID = $request->UserID;
        
        return response()->json([
            'success' => true,
            'message' => 'Valid Kontrakan',
            'data' => Kontrakan::where(['userID' => $UserID])->get(),
           ]);
    }
    public function indexLessee(Request $request){
        $UserID = $request->UserID;
        
            return response()->json([
            'success' => true,
            'message' => 'Valid Kontrakan',
            'data' => User::join('kontrakans', 'kontrakans.UserID', '=', 'users.id')->select('name', 'phone', 'kontrakans.id', 'UserID',
            'Address',
            'City',
            'Province',
            'Price_per_year',
            'Image',
            'Description',
            'Active',
            'MinimumRent', 'kontrakans.created_at', 'kontrakans.updated_at')->get(),
           ]);
    }

    public function showActive(Request $request){
        $UserID = $request->UserID;
        return response()->json([
            'success' => true,
            'message' => 'Valid Kontrakan',
            'data' => Kontrakan::where(['userID' => $UserID, 'Active' => 1])->get(),
           ]);
    }

    public function showNotActive(Request $request){
        $UserID = $request->UserID;
        return response()->json([
            'success' => true,
            'message' => 'Valid Kontrakan',
            'data' => Kontrakan::where(['userID' => $UserID, 'Active' => 0])->get(),
           ]);
    }

    public function setActive(Request $request){
        $id = $request->id;

        $kontrakan = Kontrakan::findOrFail($id);
        $kontrakan->update([
            'Active' => 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Valid Kontrakan',
            'data' => $kontrakan,
        ]);
    }
    public function setNotActive(Request $request){
        $id = $request->id;

        $kontrakan = Kontrakan::findOrFail($id);
        $kontrakan->update([
            'Active' => 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Valid Kontrakan',
            'data' => $kontrakan,
        ]);
    }

    public function show(Request $request)
    {
        $id = $request->id;
        if(Kontrakan::find($id) != null){
            return response()->json([
            'success' => true,
            'message' => 'Valid Kontrakan',
            'data' => Kontrakan::find($id),
           ]);
        } else{
           return response()->json([
            'success' => false,
            'message' => 'Invalid Kontrakan',
           ], 401);
        }
    }

    public function store(Request $request){
        $this->validate($request, [
            'Image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $image_path = $request->file('Image')->store('Image', 'public');

        $data = Kontrakan::create([
            'UserID' => $request->UserID,
            'Address' => $request->Address,
            'City' => $request->City,
            'Province' => $request->Province,
            'Price_per_year' => $request->Price_per_year,
            'Image' => $image_path,
            'Description' => $request->Description,
            'Active' => 0,
            'MinimumRent' => $request->MinimumRent,
        ]);
        
            return response()->json([
            'success' => true,
            'message' => 'Valid Kontrakan',
            'data' => $data,
           ]);
        

    }

    public function update(Request $request)
    {
        $id = $request->id;
        $this->validate($request, [
            'Image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        $image_path = $request->file('Image')->store('Image', 'public');
        $kontrakan = Kontrakan::findOrFail($id);
        $kontrakan->update([
            'Address' => $request->Address,
            'City' => $request->City,
            'Province' => $request->Province,
            'Price_per_year' => $request->Price_per_year,
            'Image' => $image_path,
            'Description' => $request->Description,
            'MinimumRent' => $request->MinimumRent,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Valid Kontrakan',
            'data' => $kontrakan,
           ]);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $kontrakan = Kontrakan::findOrFail($id);
        $kontrakan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Valid Kontrakan',
            'data' => $kontrakan,
           ]);
    }
}
