<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\KonfirmasiPengiriman;

class KonfirmasiPengirimanController extends Controller
{
    //
    public function index(){

        $konfirmasiPengiriman = KonfirmasiPengiriman::all();

        if(count($konfirmasiPengiriman) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $konfirmasiPengiriman
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function store(Request $request)
    {

        $storeData = $request->all();

        $validate = Validator::make($storeData, [
            'kodePengiriman' => 'required',
            'status' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $config = [
            'table' => 'konfirmasiPengiriman',
            'length' => 10,
        ];
    
        $konfirmasiPengiriman = KonfirmasiPengiriman::create($storeData);
        $konfirmasiPengiriman->save();

        
            
        return response([
            'message' => 'Add Konfirmasi Success',
            'data' => $konfirmasiPengiriman
        ],200);
    }

    public function show($id)
    {

        $konfirmasiPengiriman = KonfirmasiPengiriman::find($id);
        if(!is_null($konfirmasiPengiriman)){
            return response([
                'message' => 'Retrieve Konfirmasi Success',
                'data' => $konfirmasiPengiriman
            ], 200);
        }

        return response([
            'message' => 'Kontak Konfirmasi Found',
            'data' => null
        ],404);

    }

    public function update(Request $request, $id)
    {

        $konfirmasiPengiriman = KonfirmasiPengiriman::find($id);

        if(is_null($konfirmasiPengiriman)){
            return response([
                'message' => 'Konfirmasi Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();

        $validate = Validator::make($updateData, [
            'kodePengiriman' => 'required',
            'status' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $konfirmasiPengiriman->kodePengiriman = $updateData['kodePengiriman'];
        $konfirmasiPengiriman->status = $updateData['status'];

        if($konfirmasiPengiriman->save()){
             return response([
                'message'=> 'Update Konfirmasi Success',
                'data' => $konfirmasiPengiriman
             ], 200);
        }

        return response([
            'message'=> 'Update Konfirmasi Failed',
            'data' => null
        ], 400);

    }

    public function destroy($id)
    {

        $konfirmasiPengiriman = KonfirmasiPengiriman::find($id);

        if(is_null($konfirmasiPengiriman)){
            return response([
                'message' => 'Konfirmasi Not Found',
                'data' => null
            ], 404);
        }

        if($konfirmasiPengiriman->delete()){
            return response([
                'message' => 'Delete Konfirmasi Success',
                'data' => $konfirmasiPengiriman
            ], 200);
        }

        return response([
            'message' => 'Delete Konfirmasi Failed',
            'data' => null
        ], 400);
        
    }
}
