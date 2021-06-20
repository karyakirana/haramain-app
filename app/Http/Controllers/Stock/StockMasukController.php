<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Master\Produk;
use App\Models\Master\Supplier;
use App\Models\Stock\BranchStock;
use App\Models\Stock\StockDetilTemp;
use App\Models\Stock\StockMasuk;
use App\Models\Stock\StockMasukDetil;
use App\Models\Stock\StockTemp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;
use Yajra\DataTables\DataTables;

class StockMasukController extends Controller
{
    public function index()
    {
        return view('components.pages.daftarStockMasuk');
    }

    public function stockMasukList()
    {
        $data = StockMasuk::latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tanggal_masuk_id', function ($row){
                return $row->tanggal_masuk_id;
            })
            ->addColumn('relation', function ($row){
                return ['supplierNama'=>$row->supplier->namaSupplier, 'userNama'=>$row->user->name, 'branchNama'=>$row->branch->branchName ?? ''];
            })
            ->addColumn('Actions', function($row){
                $edit = "<button class='btn btn-sm w-30' id='buttonEdit' data-id='".$row->id."'>
                            <i class='la la-edit text-info fs-2'></i>
                         </button>";
                $delete = "<button class='btn btn-sm' id='buttonDelete' data-id='".$row->id."'>
                            <i class='la la-trash text-danger fs-2'></i>
                         </button>";
                return $edit.$delete;
            })
            ->rawColumns(['Actions', 'relation'])
            ->make(true);
    }

    protected function idStockMasuk()
    {
//        $closedCash = session('ClosedCash');
        $data = StockMasuk::latest()->first();
        $num = null;
        if(!$data){
            $num = 1;
        } else {
            $urutan = (int) substr($data->kode, 0, 4);
            $num = $urutan + 1;
        }
        $id = sprintf("%04s", $num)."/SM/".date('Y');
        return $id;
    }

    /**
     * @return mixed
     */
    protected function createTemp()
    {
        $create = StockTemp::create([
            'jenisTemp' => 'stockMasuk',
            'idUser' => Auth::user()->id,
        ]);
        session(['stockMasuk'=>$create->id]);
        return $create;
    }

    /**
     * @return array
     */
    protected function checkTemp()
    {
        // check session
        $sessionTemp = session('stockMasuk');
        $data = [];
        if ($sessionTemp) { // jika session ada
            $stockTemp = StockTemp::find($sessionTemp);
            $user = User::find($stockTemp)->first();
            $data = [
                'idTemp' => $sessionTemp,
                'idUser' => $stockTemp->idUser,
                'namaUser' => $user->name,
                'kode' => $this->idStockMasuk(),
            ];
        } else { // jika session tidak ada
            $temporary = $this->createTemp(); // buat session baru
            $user = User::find($temporary->idUser);
            $data = [
                'idTemp' => $temporary->id,
                'idUser' => $temporary->idUser,
                'namaUser' => $user->name,
                'kode' => $this->idStockMasuk(),
            ];
        }
        return $data;
    }

    public function create()
    {
        $data = $this->checkTemp();
        $gudang = BranchStock::all();
        $masuk = [
            'data' => $data,
            'gudang'=> $gudang
        ];
//        dd($masuk);
        return view('components.pages.transStockMasuk')->with($data)->with(['data'=>$gudang]);
    }

    public function produkList()
    {
        $data = Produk::latest()->get();
        return DataTables::of($data)
            ->addColumn('foreign', function ($row){
                return ['kategori'=>$row->kategori->nama, 'kategoriHarga'=>$row->kategoriHarga->nama_kat];
            })
            ->addColumn('Actions', function($row){
                $tombol = "<button class='btn btn-sm w-30' id='buttonEdit' data-id='".$row->id_produk."'>
                            <i class='la la-edit text-info fs-2'></i>
                         </button>";
                return $tombol;
            })
            ->rawColumns(['foreign', 'Actions'])
            ->make(true);
    }

    public function supplierList()
    {
        $data = Supplier::latest()->get();
        return DataTables::of($data)
            ->addColumn('foreign', function($row){
                return ['jenisSupplier'=>$row->jenisSupplierTable->jenis];
            })
            ->addColumn('Actions', function($row){
                $tombol = "<button class='btn btn-sm w-30' id='buttonEditSupplier' data-id='".$row->id."'>
                            <i class='la la-edit text-info fs-2'></i>
                         </button>";
                return $tombol;
            })
            ->rawColumns(['foreign', 'Actions'])
            ->make(true);
    }

    public function setProduk($id_produk)
    {
        $data = Produk::where('id_produk', $id_produk)->first();
        $produk = [
            'id_produk' => $data->id_produk,
            'id_kategori' => $data->kategori->nama,
            'kode_lokal' => $data->kode_lokal,
            'penerbit' => $data->penerbit,
            'nama_produk' => $data->nama_produk,
            'stock' => $data->stock,
            'hal' => $data->hal,
            'cover' => $data->cover,
            'id_kat_harga' => $data->kategoriHarga->nama_kat,
            'harga' => $data->harga,
            'size' => $data->size,
            'deskripsi' => $data->deskripsi,
        ];
        return response()->json($produk);
    }

    public function setSupplier($id_supplier)
    {
        $data = Supplier::find($id_supplier);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggalMasuk'=>'required'
        ]);
        $tanggal = strtotime($request->tanggalMasuk);
        $dataMaster = [
            'kode'=>$this->idStockMasuk(),
            'idSupplier'=>$request->idSupplier,
            'idUser'=>Auth::user()->id,
            'idBranch'=>$request->gudang,
            'tglMasuk'=>date('Y-m-d', $tanggal),
            'nomorPo'=>$request->nomorPo,
            'keterangan'=>$request->keterangan,
        ];
//        dd($dataMaster);
        $dataDetail = StockDetilTemp::where('stockTemp', $request->temp)->get();
        DB::beginTransaction();
        try {
            // create Stock Temp Master
            $master = StockMasuk::updateOrCreate(['id'=>$request->idStockMasuk], $dataMaster);
            $deleteDetail = StockMasukDetil::where('idStockMasuk', $master->id)->delete();
            foreach ($dataDetail as $row)
            {
                StockMasukDetil::create([
                    'idStockMasuk'=>$master->id,
                    'idProduk'=>$row->idProduk,
                    'jumlah'=>$row->jumlah
                ]);
            }
            $deleteTempDetail = StockDetilTemp::where('stockTemp', $request->temp)->delete();
            $deleteTemp = StockTemp::destroy($request->temp);
            session()->forget('stockMasuk');
            DB::commit();
            return redirect()->to('/stock/daftarmasuk')->with(['messages'=>'Sukses']);
        } catch (\Exception $exception)
        {
            DB::rollBack();
            return redirect()->back();
        }
    }

    public function edit($idStockMasuk)
    {
        // check session
        if (session('stockMasuk')){
            // delete file temp first
            DB::beginTransaction();
            try {
                $deleteTempDetail = StockDetilTemp::where('stockTemp', session('stockMasuk'))->delete();
                $deleteTemp = StockTemp::destroy(session('stockMasuk'));
                session()->forget('stocMasuk');
                DB::commit();
            } catch (Exception $exception) {
                DB::rollBack();
            }
        }

        $data = null;

        // set data Stock masuk yg ada
        $dataStockMasuk = StockMasuk::find($idStockMasuk);
        $dataStockMasukDetil = $dataStockMasuk->stockMasukDetil;
        $yoman = StockMasukDetil::where('idStockMasuk', $dataStockMasuk->id)->get();
//        dd($yoman);

        // set data Temp
        DB::beginTransaction();
        try {
            $stockTemp = StockTemp::create([
                'jenisTemp'=>'stockMasuk',
                'stockMasuk'=> $dataStockMasuk->id,
                'idSupplier'=> $dataStockMasuk->idSupplier,
                'idUser'=>Auth::user()->id,
                'tglMasuk'=>$dataStockMasuk->tglMasuk,
                'nomorPO', $dataStockMasuk->nomorPO,
                'keterangan', $dataStockMasuk->keterangan,
            ]);
            foreach ($dataStockMasukDetil as $row)
            {
                StockDetilTemp::create([
                    'stockTemp'=>$stockTemp->id,
                    'idProduk'=>$row->idProduk,
                    'jumlah'=>$row->jumlah
                ]);
            }
            DB::commit();
            session(['stockMasuk'=>$stockTemp->id]);

            $data = [
                'idTemp' =>$stockTemp->id,
                'kode'=> $dataStockMasuk->kode,
                'branch' => $dataStockMasuk->idBranch,
                'tglMasuk'=>date('Y-m-d', strtotime($dataStockMasuk->tglMasuk)),
                'idSupplier' => $dataStockMasuk->idSupplier,
                'namaSupplier' =>Supplier::find($stockTemp->idSupplier)->namaSupplier,
                'idStockMasuk'=>$dataStockMasuk->id,
                'nomorPO'=> $dataStockMasuk->nomorPo,
                'keterangan'=> $dataStockMasuk->keterangan,
            ];

        } catch (\Exception $e){
            DB::rollBack();
            dd($e);
        }

        // get Gudang
        $gudang = BranchStock::all();

        return view('components.pages.transStockMasuk')->with($data)->with(['data'=>$gudang]);
    }
}
