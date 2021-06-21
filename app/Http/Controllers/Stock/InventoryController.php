<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Stock\InventoryReal;
use App\Models\Stock\StockAkhir;
use App\Models\Stock\StockMasukDetil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class InventoryController extends Controller
{
    public function index()
    {
        return view('components.pages.inventory');
    }

    public function inventoyList()
    {
        $data = InventoryReal::orderBy('idProduk', 'asc')->get();
        return DataTables::of($data)
            ->addColumn('foreign', function ($row){
                return [
                    'namaProduk'=>$row->produk->nama_produk ?? '',
                    'branch'=>$row->branch->branchName ?? ''
                ];
            })
            ->rawColumns(['foreign'])
            ->make(true);
    }

    /**
     * Refresh stock from StockAkhir
     * @return \Illuminate\Http\JsonResponse
     */
    public function addStockFromLast()
    {
        // add stock from stock opname

        // get all stock Detail
        $stockAkhir = StockAkhir::select(
                            'id_produk', 'jumlah_stock', 'branchId',
                        )
                        ->get();
        DB::beginTransaction();
        try {
            $trans = 0;
            foreach ($stockAkhir as $row)
            {
                // check
                $check = InventoryReal::where('idProduk', $row->id_produk)->where('branchId', $row->branchId)->first();
                if (!$check)
                {
                    InventoryReal::insert([
                        'idProduk'=>$row->id_produk,
                        'branchId'=>$row->branchId,
                        'stockIn'=>$row->jumlah_stock,
                    ]);
                } else {
                    InventoryReal::where('idProduk', $row->id_produk)
                        ->where('branchId', $row->branchId)
                        ->increment('stockIn', $row->jumlah_stock);
                }
                $trans ++;
            }

            DB::commit();
            $response= [
                'status'=>true,
                'messages' => $trans,
            ];
            return response()->json($response);

        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'status' => false,
                'messages' => $e,
            ];
            return response()->json($response);
        }
    }

    public function addStockFromGudang()
    {
        $stockMasukDetil = StockMasukDetil::select(
                                'sm.idBranch as branchId',
                                'stockmasukdetil.idProduk as idProduk',
                                'stockmasukdetil.jumlah as jumlah'
                            )
                        ->leftJoin('stockmasuk as sm', 'sm.id', '=', 'stockmasukdetil.idStockMasuk')
                        ->get();
        DB::beginTransaction();
        try {
            $trans = 0;
            $dataUpdate = [];
            $insert = [];
            foreach ($stockMasukDetil as $row)
            {
                // check
                $check = InventoryReal::where('idProduk', $row->idProduk)
                    ->where('branchId', $row->branchId)
                    ->first();
                if (!$check)
                {
                    // kondisi tidak nulled
                    $insert[]=InventoryReal::create([
                        'idProduk'=>$row->idProduk,
                        'branchId'=>$row->branchId,
                        'stockIn'=>$row->jumlah,
                    ]);
                } else {
                    $dataUpdate[] = InventoryReal::where('idProduk', $row->idProduk)
                        ->where('branchId', $row->branchId)
                        ->increment('stockIn', $row->jumlah);
                }
                $trans++;
            }
            DB::commit();
            return response()->json(['status'=>true, 'messages'=>$trans, 'insert'=>$insert, 'update'=>$dataUpdate]);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['status'=>false, 'messages'=>$e]);
        }
    }
}
