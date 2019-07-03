<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OtherCost extends Model
{
    use SoftDeletes;

    protected $table = 'other_costs';
    protected $fillable = [
        'particular', 'amount', 'month','year',
    ];
}
