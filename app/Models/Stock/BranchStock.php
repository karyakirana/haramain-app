<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchStock extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'branch_stock';
    protected $fillable = [
        'branchName', 'alamat', 'kota', 'keterangan',
    ];
}
