<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FixedCost extends Model
{
    use SoftDeletes;

    protected $table = 'fixed_costs';
    protected $fillable = [
        'particular', 'amount', 'month','year','is_regular'
        ];

}
