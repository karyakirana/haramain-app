<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KategoriAkunController extends Controller
{
    public function index()
    {
        return view('components.pages.kategoriAkun');
    }
}
