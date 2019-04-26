<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lang;

/**
 * Class Warehouse.
 */
class Warehouse extends Model
{

    use SoftDeletes;

    protected $table = 'warehouses';

    protected $fillable = [
        'name',
				
        'created_by',
        ];

    public $formelements = [
        "name" => "",
		

         // [ModelArray]
    ];

    public $searchelements = [
        'name',
				
        ];

    public function list_data() {
        return  [
            Lang::get('warehouses.name') => 'name',
			
        ];
    }


     // [Relation]
}
