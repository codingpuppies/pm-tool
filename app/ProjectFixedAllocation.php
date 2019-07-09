<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectFixedAllocation extends Model
{
    use SoftDeletes;

    protected $table = 'project_fixed_allocation';
    protected $fillable = [
        'project_id', 'developer_id', 'percentage','month','year',
    ];
}
