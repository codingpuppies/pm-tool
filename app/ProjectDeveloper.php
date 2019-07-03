<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectDeveloper extends Model
{
    use SoftDeletes;

    protected $table = 'project_developer';

    protected $fillable = [
        'project_id', 'developer_id', 'date_start', 'date_end'
    ];

    /*
    |------------------------------------------------------------------------------------
    | Validations
    |------------------------------------------------------------------------------------
    */
    public static function rules($update = false, $id = null)
    {
        $commun = [
//            'project_name'    => "required"
        ];

        return $commun;
    }
}
