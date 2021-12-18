<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Makanan;

class MakananController extends Controller
{
    public function index()
    {
        $makanans = Makanan::all();

        if(count($makanans)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $makanans
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }

    public function show($id)
    {
        $makanans = Makanan::find($id);

        if(!is_null($makanans)){
            return response([
                'message' => 'Retrieve Makanan Success',
                'data' => $makanans
            ], 200);
        }

        return response([
            'message' => 'Makanan Not Found',
            'data' => null
        ],404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,[
            'nama_makanan' => 'required|max:60|unique:makanans',
            'harga_makanan' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $makanans = Makanan::create($storeData);
        return response([
            'message' => 'Add Makanan Success',
            'data' => $makanans
        ],200);
    }

    public function destroy($id)
    {
        $makanans = Makanan::find($id);

        if(is_null($makanans)){
            return response([
                'message' => 'Makanan Not Found',
                'data'=> null
            ], 404);
        }
        if($makanans->delete()){
            return response([
                'message' => 'Delete Makanan Success',
                'data'=> $makanans
            ], 200);
        }
        return response([
            'message' => 'Delete Makanan Failed',
            'data'=> null,
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $makanans = Makanan::find($id);
        if(is_null($makanans)){
            return response([
            'message' => 'Makanan Not Found',
            'data'=> null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[
            'nama_makanan' => ['max:60', 'required', Rule::unique('makanans')->ignore($makanans)],
            'harga_makanan' => 'required|numeric',
        ]);

        if($validate->fails())
            return response(['message'=> $validate-> errors()],400);

        $makanans->nama_makanan = $updateData['nama_makanan'];
        $makanans->harga_makanan = $updateData['harga_makanan'];

        if($makanans->save()){
            return response([
                'message' => 'Update Makanan Success',
                'data' => $makanans
            ],200);
        }
        return response([
            'message' => 'Update Makanan Failed',
            'data' => null,
        ],400);
    }
}
