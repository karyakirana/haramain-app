<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\Akuntansi\KategoriAkun;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KategoriAkunController extends Controller
{
    /**
     * interface kategori akun
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('components.pages.kategoriAkun');
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function kategoriAkunList()
    {
        $data = KategoriAkun::all();
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
        if ($request->id == null){
            // if create data
            $request->validate([
                'kode'=>'required|unique:kategori_akuntansi',
                'namaAkun'=>'required|unique:kategori_akuntansi',
                'deskripsi' => 'required'
            ]);

        } else {
            // if update data
            $request->validate([
                'kode'=>'required',
                'namaAkun'=>'required'
            ]);
        }

        $data = [
            'kode'=>$request->kode,
            'namaAkun'=>$request->namaAkun,
            'deskripsi'=>$request->deskripsi,
        ];
        $store = KategoriAkun::updateOrCreate($data, ['id', $request->id]);
        return response()->json(['status'=>true, 'keterangan'=>$store]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $data = KategoriAkun::find($id);
        return response()->json($data);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $destroy = KategoriAkun::destroy($id);
        return response()->json(['status'=>true, 'keterangan'=>$destroy]);
    }
}
