<?php

namespace App\Http\Controllers;

use App\Models\Kontrakan;
use Illuminate\Http\Request;
use App\Models\transaksi;
use App\Models\User;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function lessorPending(Request $request){
        $lessorID = $request->lessorID;
        $transaksi = transaksi::join('users', 'users.id', '=', 'transaksis.lesseeID')
            ->join('kontrakans', 'kontrakans.id', '=', 'transaksis.kontrakanID')
            ->where('lessorID', $lessorID)->where('approved', 0)
            ->select("transaksis.id",
            "lesseeID",
            "lessorID",
            "startDate",
            "endDate",
            "rentDuration",
            "approved",
            "name",
            "phone",
            "Address",
            "Image")
            ->get();        
        
        return response()->json([
            'success' => true,
            'message' => 'Valid Transaksi',
            'data' => $transaksi,
        ]);
    }
    public function lessorOngoing(Request $request){
        $lessorID = $request->lessorID;
        $transaksi = transaksi::join('users', 'users.id', '=', 'transaksis.lesseeID')
            ->join('kontrakans', 'kontrakans.id', '=', 'transaksis.kontrakanID')
            ->where('lessorID', $lessorID)->where('approved', 1)
            ->where('endDate', '>', Carbon::now())
            ->select("transaksis.id",
            "lesseeID",
            "lessorID",
            "startDate",
            "endDate",
            "rentDuration",
            "approved",
            "name",
            "phone",
            "Address",
            "Image",)
            ->get();        
        
        return response()->json([
            'success' => true,
            'message' => 'Valid Transaksi',
            'data' => $transaksi,
        ]);
    }
    public function lessorFinished(Request $request){
        $lessorID = $request->lessorID;
        $transaksi = transaksi::where('lessorID', $lessorID)->where('endDate', '<', Carbon::now())
            ->join('users', 'users.id', '=', 'transaksis.lesseeID')
            ->join('kontrakans', 'kontrakans.id', '=', 'transaksis.kontrakanID')
            ->select("transaksis.id",
            "lesseeID",
            "lessorID",
            "startDate",
            "endDate",
            "rentDuration",
            "approved",
            "name",
            "phone",
            "Address",
            "Image",)
            ->get();   
        
        return response()->json([
            'success' => true,
            'message' => 'Valid Transaksi',
            'data' => $transaksi,
        ]);
    }

    public function lesseeOngoing(Request $request){
        $lesseeID = $request->lesseeID;
        $transaksi = transaksi::join('users', 'users.id', '=', 'transaksis.lessorID')
            ->join('kontrakans', 'kontrakans.id', '=', 'transaksis.kontrakanID')
            ->where('transaksis.lesseeID', $lesseeID)->where('approved', 1)
            ->where('endDate', '>', Carbon::now())
            ->select("transaksis.id",
            "lesseeID",
            "lessorID",
            "startDate",
            "endDate",
            "rentDuration",
            "approved",
            "name",
            "phone",
            "Address",
            "Image",)
            ->get();        
        
        return response()->json([
            'success' => true,
            'message' => 'Valid Transaksi',
            'data' => $transaksi,
        ]);
    }
    public function lesseeFinished(Request $request){
        $lessorID = $request->lesseeID;
        $transaksi = transaksi::where('lesseeID', $lessorID)->where('endDate', '<', Carbon::now())
            ->join('users', 'users.id', '=', 'transaksis.lessorID')
            ->join('kontrakans', 'kontrakans.id', '=', 'transaksis.kontrakanID')
            ->select("transaksis.id",
            "lesseeID",
            "lessorID",
            "startDate",
            "endDate",
            "rentDuration",
            "approved",
            "name",
            "phone",
            "Address",
            "Image",)
            ->get();   
        
        return response()->json([
            'success' => true,
            'message' => 'Valid Transaksi',
            'data' => $transaksi,
        ]);
    }

    public function setApprove(Request $request){
        $id = $request->id;

        $kontrakan = transaksi::findOrFail($id);
        $kontrakan->update([
            'approved' => 1,
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
        $transaksi = Transaksi::find($id);
        $kontrakan = Kontrakan::where('id', $transaksi->kontrakanID)->get()->first();
        $lessee = User::where('id', $transaksi->lesseeID)->get()->first();
        $lessor = User::where('id', $transaksi->lessorID)->get()->first();
        $remainingDate = Carbon::now()->diff(Carbon::parse($transaksi->endDate), false);
        $remainingDateString = $remainingDate->y.' Tahun '.$remainingDate->m.' Bulan '.$remainingDate->d.' Hari';
        if(Transaksi::find($id) != null){
            return response()->json([
            'success' => true,
            'message' => 'Valid Transaksi',
            'data' => ['remainingDate'=>$remainingDateString, 'rentDuration'=>$transaksi->rentDuration, 'startDate'=>$transaksi->startDate, 'lesseeName'=>$lessee->name, 'id'=>$transaksi->id, 'lesseePhone'=>$lessee->phone, 'image'=>$kontrakan->Image, 'lessorName'=>$lessor->name],
           ]);
        } else{
           return response()->json([
            'success' => false,
            'message' => 'Invalid Transaksi',
           ], 401);
        }
    }

    public function store(Request $request){

        $data = Transaksi::create([
            'lesseeID' => $request->lesseeID,
            'lessorID' => $request->lessorID,
            'startDate' => $request->startDate,
            'endDate' => Carbon::parse($request['startDate'])->addYear($request->rentDuration)->toDateString(),
            'rentDuration' => $request->rentDuration,
            'kontrakanID' => $request->kontrakanID,
            'approved' => 0,
        ]);
        
            return response()->json([
            'success' => true,
            'message' => 'Valid Kontrakan',
            'data' => $data,
           ]);
        

    }
}
