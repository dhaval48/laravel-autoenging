
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoDemoDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $exist_module = DB::table('form_modules')->where('main_module','demo details')->first();
        if(empty($exist_module)) {

            $module_id = DB::table('form_modules')->insertGetId([
                            
                 'parent_module' => 'General',
                 'main_module' => 'demo details',
                 'table_name' => 'demo_details',
                 'parent_form' => 'demo',
                
                        ]);
            $data = [
                    
                    [
                        'formmodule_id' => $module_id,
                        'name' => 'demo_id',
                        'type' => 'integer',
                        'validation' => null,
                        'default' => null,
                    ],
                    
                    [
                        'formmodule_id' => $module_id,
                        'name' => 'full_name',
                        'type' => 'varchar',
                        'validation' => null,
                        'default' => null,
                    ],
                    
                    [
                        'formmodule_id' => $module_id,
                        'name' => 'start_date',
                        'type' => 'date',
                        'validation' => null,
                        'default' => null,
                    ],
                    
                    [
                        'formmodule_id' => $module_id,
                        'name' => 'location_id',
                        'type' => 'integer',
                        'validation' => null,
                        'default' => null,
                    ],
                    
                    [
                        'formmodule_id' => $module_id,
                        'name' => 'is_active',
                        'type' => 'varchar',
                        'validation' => null,
                        'default' => null,
                    ],
                    
                ];

            DB::table('module_tables')->insert($data);

            $values = [
                    
                    [
                        'formmodule_id' => $module_id,
                        'visible' => 0,
                        'db_name' => 'demo_id',
                        'input_name' => 'demo_id',
                        'input_type' => '',
                        'key' => null,
                        'value' => null,
                        'table' => null,
                    ],
                    
                    [
                        'formmodule_id' => $module_id,
                        'visible' => 1,
                        'db_name' => 'full_name',
                        'input_name' => 'full name',
                        'input_type' => 'input',
                        'key' => null,
                        'value' => null,
                        'table' => null,
                    ],
                    
                    [
                        'formmodule_id' => $module_id,
                        'visible' => 1,
                        'db_name' => 'start_date',
                        'input_name' => 'start date',
                        'input_type' => 'date',
                        'key' => null,
                        'value' => null,
                        'table' => null,
                    ],
                    
                    [
                        'formmodule_id' => $module_id,
                        'visible' => 1,
                        'db_name' => 'location_id',
                        'input_name' => 'location',
                        'input_type' => 'dropdown',
                        'key' => 'name',
                        'value' => 'id',
                        'table' => 'warehouses',
                    ],
                    
                    [
                        'formmodule_id' => $module_id,
                        'visible' => 1,
                        'db_name' => 'is_active',
                        'input_name' => 'is active',
                        'input_type' => 'dropdown',
                        'key' => null,
                        'value' => null,
                        'table' => null,
                    ],
                    
                ];
            DB::table('module_inputs')->insert($values);
        }       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
