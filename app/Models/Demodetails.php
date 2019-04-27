<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;

/**
 * Class Demodetails.
 */
class Demodetails extends Model
{
    protected $table = 'demo_details';

    protected $fillable = [
        'demo_id',
				'full_name',
				'start_date',
				'location_id',
				'is_active',
				
        ];
}
