<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VariableCost extends Model
{
    use SoftDeletes;

    protected $table = 'variable_cost';
    protected $fillable = [
        'project_id', 'developer_id', 'estimate_effort','actual_effort','date','mode',
    ];
}
