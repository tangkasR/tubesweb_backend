<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\KontakKami;

class KontakKamiController extends Controller
{
    //
    public function index(){

        $kontakkami = KontakKami::all();

        if(count($kontakkami) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $kontakkami
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
            'keluhan' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $config = [
            'table' => 'kontakkami',
            'length' => 10,
        ];
    
        $kontakkami = KontakKami::create($storeData);
        $kontakkami->save();

        
            
        return response([
            'message' => 'Add Kontak Kami Success',
            'data' => $kontakkami
        ],200);
    }

    public function show($id)
    {

        $kontakkami = KontakKami::find($id);
        if(!is_null($kontakkami)){
            return response([
                'message' => 'Retrieve Kontak Kami Success',
                'data' => $kontakkami
            ], 200);
        }

        return response([
            'message' => 'Kontak Kami Not Found',
            'data' => null
        ],404);

    }

    public function update(Request $request, $id)
    {

        $kontakkami = KontakKami::find($id);

        if(is_null($kontakkami)){
            return response([
                'message' => 'Kontak Kami Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();

        $validate = Validator::make($updateData, [
            'kodePengiriman' => 'required',
            'keluhan' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $kontakkami->kodePengiriman = $updateData['kodePengiriman'];
        $kontakkami->keluhan = $updateData['keluhan'];

        if($kontakkami->save()){
             return response([
                'message'=> 'Update Kontak Kami Success',
                'data' => $kontakkami
             ], 200);
        }

        return response([
            'message'=> 'Update Kontak Kami Failed',
            'data' => null
        ], 400);

    }

    public function destroy($id)
    {

        $kontakkami = KontakKami::find($id);

        if(is_null($kontakkami)){
            return response([
                'message' => 'Kontak Kami Not Found',
                'data' => null
            ], 404);
        }

        if($kontakkami->delete()){
            return response([
                'message' => 'Delete Kontak Kami Success',
                'data' => $kontakkami
            ], 200);
        }

        return response([
            'message' => 'Delete Kontak Kami Failed',
            'data' => null
        ], 400);
        
    }
}
