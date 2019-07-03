<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Developer extends Model
{
    use SoftDeletes;

    protected $table = 'developers';
    protected $fillable = [
        'salary', 'first_name', 'middle_name','last_name', 'email', 'position', 'department','user_id','employee_number','status'
    ];

    /*
    |------------------------------------------------------------------------------------
    | Validations
    |------------------------------------------------------------------------------------
    */
    public static function rules($update = false, $id = null)
    {
        $commun = [
            'email'    => "required|email|unique:developers,email,$id"
        ];

        if ($update) {
            return $commun;
        }

        return array_merge($commun, [
            'email'    => 'required|email|max:255|unique:developers',
            'password' => 'required|confirmed|min:6',
        ]);
    }


}
