<?php

namespace App\Models\Stock;

use App\Models\Master\Produk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAkhir extends Model
{
    use HasFactory;

    protected $table = 'stockakhir';
    protected $fillable =[
        'activeCash', 'branchId','id_produk', 'jumlah_stock'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class,'id_produk', 'id_produk');
    }

    public function branch()
    {
        return $this->belongsTo(BranchStock::class, 'branchId');
    }
}
