<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Stock\BranchStock;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BranchStockController extends Controller
{
    public function index()
    {
        return view('components.pages.branchStock');
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function branchStockList()
    {
        $data = BranchStock::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('Actions', function($row){
                $edit = "<button class='btn btn-sm w-30' id='buttonEdit' data-id='".$row->id."'>
                            <i class='la la-edit text-info fs-2'></i>
                         </button>";
                $delete = "<button class='btn btn-sm' id='buttonDelete' data-id='".$row->id."'>
                            <i class='la la-trash text-danger fs-2'></i>
                         </button>";
                return $edit.$delete;
            })
            ->rawColumns(['Actions'])
            ->make(true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'namaGudang'=>'required',
            'alamat'=>'required',
        ]);

        $data = [
            'branchName'=>$request->namaGudang,
            'alamat'=>$request->alamat,
            'kota'=>$request->kota,
            'keterangan'=>$request->keterangan
        ];
        $store = BranchStock::updateOrCreate(['id'=> $request->id], $data);
        return response()->json(['status'=>true, 'keterangan'=>$store]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $data = BranchStock::find($id);
        return response()->json($data);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $destroy = BranchStock::destroy($id);
        return response()->json(['status'=>true, 'keterangan'=>$destroy]);
    }
}
