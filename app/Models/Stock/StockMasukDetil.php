<?php

namespace App\Models\Stock;

use App\Models\Master\Produk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMasukDetil extends Model
{
    use HasFactory;
    use HasFactory;

    protected $table='stockmasukdetil';
    protected $fillable = [
        'idStockMasuk', 'idProduk', 'jumlah'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'idProduk', 'id_produk');
    }
}
