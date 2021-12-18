<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Minuman;

class MinumanController extends Controller
{
    public function index()
    {
        $minumen = Minuman::all();

        if(count($minumen)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $minumen
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }

    public function show($id)
    {
        $minumen = Minuman::find($id);

        if(!is_null($minumen)){
            return response([
                'message' => 'Retrieve Minuman Success',
                'data' => $minumen
            ], 200);
        }

        return response([
            'message' => 'Minuman Not Found',
            'data' => null
        ],404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,[
            'nama_minuman' => 'required|max:60|unique:minumen',
            'harga_minuman' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $minumen = Minuman::create($storeData);
        return response([
            'message' => 'Add Minuman Success',
            'data' => $minumen
        ],200);
    }

    public function destroy($id)
    {
        $minumen = Minuman::find($id);

        if(is_null($minumen)){
            return response([
                'message' => 'Minuman Not Found',
                'data'=> null
            ], 404);
        }
        if($minumen->delete()){
            return response([
                'message' => 'Delete Minuman Success',
                'data'=> $minumen
            ], 200);
        }
        return response([
            'message' => 'Delete Minuman Failed',
            'data'=> null,
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $minumen = Minuman::find($id);
        if(is_null($minumen)){
            return response([
            'message' => 'Minuman Not Found',
            'data'=> null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[
            'nama_minuman' => ['max:60', 'required', Rule::unique('minumen')->ignore($minumen)],
            'harga_minuman' => 'required|numeric',
        ]);

        if($validate->fails())
            return response(['message'=> $validate-> errors()],400);

        $minumen->nama_minuman = $updateData['nama_minuman'];
        $minumen->harga_minuman = $updateData['harga_minuman'];

        if($minumen->save()){
            return response([
                'message' => 'Update Minuman Success',
                'data' => $minumen
            ],200);
        }
        return response([
            'message' => 'Update Minuman Failed',
            'data' => null,
        ],400);
    }
}
