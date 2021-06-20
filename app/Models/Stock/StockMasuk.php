<?php

namespace App\Models\Stock;

use App\Models\Master\Supplier;
use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockMasuk extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'stockmasuk';
    protected $fillable = [
        'kode', 'idSupplier', 'idUser', 'idBranch',
        'tglMasuk', 'nomorPo', 'keterangan'
    ];

    protected $casts =[
        'tglMasuk'=>'date'
    ];

    public function stockMasukDetil()
    {
        return $this->hasMany(StockMasukDetil::class, 'idStockMasuk');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'idSupplier' );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function branch()
    {
        return $this->belongsTo(BranchStock::class, 'idBranch');
    }

    // atributes aha
    public function getTanggalMasukIDAttribute()
    {
        return $this->tglMasuk->format('d-m-Y');
    }

    // attribute Mysql
    public function getTanggalMasukMysqlAttribute()
    {
        return $this->tglMasuk->format('Y-m-d');
    }
}
