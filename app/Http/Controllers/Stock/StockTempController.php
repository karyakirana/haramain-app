<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Stock\StockDetilTemp;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StockTempController extends Controller
{
    public function detilTempList($temp)
    {
        $data = StockDetilTemp::where('stockTemp', $temp)->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('foreign', function($row){
                return ['produk'=>$row->produk->nama_produk];
            })
            ->addColumn('Actions', function($row){
                $edit = "<button class='btn btn-sm w-30' id='buttonEditTemp' data-id='".$row->id."'>
                            <i class='la la-edit text-info fs-2'></i>
                         </button>";
                $delete = "<button class='btn btn-sm' id='buttonDeleteTemp' data-id='".$row->id."'>
                            <i class='la la-trash text-danger fs-2'></i>
                         </button>";
                return $edit.$delete;
            })
            ->rawColumns(['Actions', 'foreign'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|integer'
        ]);

        $data = [
            'stockTemp'=>$request->idTempforDetil,
            'idProduk'=>$request->idProduk,
            'jumlah' =>$request->jumlah,
        ];
        $store = StockDetilTemp::updateOrCreate(['id'=>$request->idDetilTemp], $data);
        return response()->json(['status'=>true, 'keterangan'=>$store]);
    }

    public function edit($idTemp)
    {
        $data = StockDetilTemp::find($idTemp);
        $dataTemp = [
            'id'=>$data->id,
            'stockTemp'=>$data->stockTemp,
            'idProduk'=>$data->idProduk,
            'namaProduk'=>$data->produk->nama_produk,
            'cover'=>$data->produk->cover,
            'kategori'=>$data->produk->kategori->nama,
            'kategori_harga'=>$data->produk->kategoriHarga->nama_kat,
            'jumlah'=>$data->jumlah,
        ];
        return response()->json($dataTemp);
    }

    public function destroy($idTemp)
    {
        $data = StockDetilTemp::where('id', $idTemp)->delete();
        return response()->json(['status'=>true, 'keterangan'=>$data]);
    }
}
