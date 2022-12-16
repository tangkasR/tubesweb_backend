<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Pengiriman;

class PengirimanController extends Controller
{
    public function index(){

        $pengiriman = Pengiriman::all();

        if(count($pengiriman) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $pengiriman
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
            'namaPenerima' => 'required',
            'alamat' => 'required',
            'jenisBarang' => 'required',
            'jenisPengiriman' => 'required',
            'berat' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $config = [
            'table' => 'pengiriman',
            'length' => 10,
        ];
    
        $product = Pengiriman::create($storeData);
        $product->save();

        
            
        return response([
            'message' => 'Add Pengiriman Success',
            'data' => $product
        ],200);
    }

    public function show($id)
    {

        $product = Pengiriman::find($id);
        if(!is_null($product)){
            return response([
                'message' => 'Retrieve Pengiriman Success',
                'data' => $product
            ], 200);
        }

        return response([
            'message' => 'Pengiriman Not Found',
            'data' => null
        ],404);

    }

    public function update(Request $request, $id)
    {

        $product = Pengiriman::find($id);

        if(is_null($product)){
            return response([
                'message' => 'Pengiriman Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();

        $validate = Validator::make($updateData, [
            'kodePengiriman' => 'required',
            'namaPenerima' => 'required',
            'alamat' => 'required',
            'jenisBarang' => 'required',
            'jenisPengiriman' => 'required',
            'berat' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $product->kodePengiriman = $updateData['kodePengiriman'];
        $product->namaPenerima = $updateData['namaPenerima'];
        $product->alamat = $updateData['alamat'];
        $product->jenisBarang = $updateData['jenisBarang'];
        $product->jenisPengiriman = $updateData['jenisPengiriman'];
        $product->berat = $updateData['berat'];

        if($product->save()){
             return response([
                'message'=> 'Update Pengiriman Success',
                'data' => $product
             ], 200);
        }

        return response([
            'message'=> 'Update Pengiriman Failed',
            'data' => null
        ], 400);

    }

    public function destroy($id)
    {

        $product = Pengiriman::find($id);

        if(is_null($product)){
            return response([
                'message' => 'Pengiriman Not Found',
                'data' => null
            ], 404);
        }

        if($product->delete()){
            return response([
                'message' => 'Delete Pengiriman Success',
                'data' => $product
            ], 200);
        }

        return response([
            'message' => 'Delete Pengiriman Failed',
            'data' => null
        ], 400);
        
    }
}
