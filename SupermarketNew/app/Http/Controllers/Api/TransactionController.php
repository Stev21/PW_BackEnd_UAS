<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();

        if(count($transactions)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $transactions
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }

    public function show($id)
    {
        $transactions = Transaction::find($id);

        if(!is_null($transactions)){
            return response([
                'message' => 'Retrieve Transaction Success',
                'data' => $transactions
            ], 200);
        }

        return response([
            'message' => 'Transaction Not Found',
            'data' => null
        ],404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,[
            'nama_barang' => 'required|max:60|unique:transactions',
            'harga_barang' => 'required|numeric',
            'jumlah_barang' => 'required|numeric',
            'subtotal' => 'required|numeric'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $transactions = Transaction::create($storeData);
        return response([
            'message' => 'Add Transaction Success',
            'data' => $transactions
        ],200);
    }

    public function destroy($id)
    {
        $transactions = Transaction::find($id);

        if(is_null($transactions)){
            return response([
                'message' => 'Transaction Not Found',
                'data'=> null
            ], 404);
        }
        if($transactions->delete()){
            return response([
                'message' => 'Delete Transaction Success',
                'data'=> $transactions
            ], 200);
        }
        return response([
            'message' => 'Delete Transaction Failed',
            'data'=> null,
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $transactions = Transaction::find($id);
        if(is_null($transactions)){
            return response([
            'message' => 'Transaction Not Found',
            'data'=> null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[
            'nama_barang' => ['max:60', 'required', Rule::unique('transactions')->ignore($transactions)],
            'harga_barang' => 'required|numeric',
            'jumlah_barang' => 'required|numeric',
            'subtotal' => 'required|numeric'
        ]);

        if($validate->fails())
            return response(['message'=> $validate-> errors()],400);

        $transactions->nama_barang = $updateData['nama_barang'];
        $transactions->harga_barang = $updateData['harga_barang'];
        $transactions->jumlah_barang = $updateData['harga_barang'];
        $transactions->subtotal = $updateData['subtotal'];

        if($transactions->save()){
            return response([
                'message' => 'Update Transaction Success',
                'data' => $transactions
            ],200);
        }
        return response([
            'message' => 'Update Transaction Failed',
            'data' => null,
        ],400);
    }
}
