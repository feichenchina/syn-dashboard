<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Auth
{
    use SoftDeletes;

    protected $table = 'teacher';

    public function visible($item)
    {
        return false;
    }

}
