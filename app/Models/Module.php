<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';

    protected $fillable = [
        'name',
    ];

    public function module_groups() {
    	return $this->hasMany('App\Models\ModuleGroup');
    }
}
