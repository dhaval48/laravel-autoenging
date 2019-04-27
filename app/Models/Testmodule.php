<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Testmodule.
 */

class Testmodule extends Model
{

    use SoftDeletes;

    protected $table = 'test_modules';

    protected $fillable = [
        'name',
				
        ];


    public $searchelements = [
        'name',
				
        ];

     // [Relation]
}
