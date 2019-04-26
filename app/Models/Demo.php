<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Lang;

/**
 * Class Demo.
 */
class Demo extends Model
{

    use SoftDeletes;

    protected $table = 'demos';

    protected $fillable = [
        'name',
				'date',
				'warehouse_id',
				'gender',
				'description',
				
        'created_by',
        ];

    public $formelements = [
        "name" => "",
		"date" => "",
		"warehouse_id" => "",
		"gender" => "",
		"description" => "",
		

         // [ModelArray]
    ];

    public $searchelements = [
        'name',
				'date',
				'warehouse_id',
				'gender',
				'description',
				
        ];

    public function list_data() {
        return  [
            Lang::get('demos.name') => 'name',
			Lang::get('demos.date') => 'date',
			Lang::get('demos.warehouse_id') => 'warehouses.name',
			Lang::get('demos.gender') => 'gender',
			Lang::get('demos.description') => 'description',
			
        ];
    }


     	
	public function warehouses() {
	    return $this->belongsTo('App\Models\Warehouse','warehouse_id','id');
	}
// [Relation]
}
