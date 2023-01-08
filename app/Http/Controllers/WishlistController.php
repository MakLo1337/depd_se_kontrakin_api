<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index(Request $request){
        return response()->json([
            'success' => true,
            'message' => 'Valid Wishlist',
            'data' => Wishlist::where('userID', $request->userID)->get(),
        ]);
    }
    public function store(Request $request){
        $data = Wishlist::create([
            'kontrakanID' => $request->kontrakanID,
            'userID' => $request->userID,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Valid Wishlist',
            'data' => $data,
        ]);
    }

    public function delete(Request $request)
    {
        $kontrakan = Kontrakan::findOrFail($request->kontrakanID);
        $kontrakan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Valid Kontrakan',
            'data' => $kontrakan,
           ]);
    }
}
