<?php

namespace App\Models\Stock;

use App\Models\Master\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTemp extends Model
{
    use HasFactory;

    protected $table= 'stock_temp';
    protected $fillable = [
        'jenisTemp', 'stockMasuk', 'idSupplier', 'idUser',
        'tglMasuk', 'nomorPO', 'keterangan'
    ];

    protected $casts =[
        'tglMasuk'=>'date'
    ];

    public function stockDetilTemp()
    {
        return $this->hasMany(StockDetilTemp::class, 'stockTemp');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'idSupplier');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function getTglMasukIDAttributes()
    {
        return $this->tglMasuk->format('d-m-Y');
    }
}
