
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoDemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $exist_module = DB::table('form_modules')->where('main_module','demo')->first();
        if(empty($exist_module)) {

            $module_id = DB::table('form_modules')->insertGetId([
                            
                 'parent_module' => 'General',
                 'main_module' => 'demo',
                 'table_name' => 'demos',
                
                        ]);
            $data = [
                    
                    [
                        'formmodule_id' => $module_id,
                        'name' => 'name',
                        'type' => 'varchar',
                        'validation' => 'required',
                        'default' => null,
                    ],
                    
                    [
                        'formmodule_id' => $module_id,
                        'name' => 'date',
                        'type' => 'date',
                        'validation' => null,
                        'default' => null,
                    ],
                    
                    [
                        'formmodule_id' => $module_id,
                        'name' => 'warehouse_id',
                        'type' => 'integer',
                        'validation' => null,
                        'default' => null,
                    ],
                    
                    [
                        'formmodule_id' => $module_id,
                        'name' => 'gender',
                        'type' => 'varchar',
                        'validation' => null,
                        'default' => null,
                    ],
                    
                    [
                        'formmodule_id' => $module_id,
                        'name' => 'description',
                        'type' => 'varchar',
                        'validation' => null,
                        'default' => null,
                    ],
                    
                ];

            DB::table('module_tables')->insert($data);

            $values = [
                    
                    [
                        'formmodule_id' => $module_id,
                        'visible' => 1,
                        'db_name' => 'name',
                        'input_name' => 'name',
                        'input_type' => 'input',
                        'key' => null,
                        'value' => null,
                        'table' => null,
                    ],
                    
                    [
                        'formmodule_id' => $module_id,
                        'visible' => 1,
                        'db_name' => 'date',
                        'input_name' => 'date',
                        'input_type' => 'date',
                        'key' => null,
                        'value' => null,
                        'table' => null,
                    ],
                    
                    [
                        'formmodule_id' => $module_id,
                        'visible' => 1,
                        'db_name' => 'warehouse_id',
                        'input_name' => 'warehouse_id',
                        'input_type' => 'dropdown',
                        'key' => 'name',
                        'value' => 'id',
                        'table' => 'warehouses',
                    ],
                    
                    [
                        'formmodule_id' => $module_id,
                        'visible' => 1,
                        'db_name' => 'gender',
                        'input_name' => 'gender',
                        'input_type' => 'dropdown',
                        'key' => null,
                        'value' => null,
                        'table' => null,
                    ],
                    
                    [
                        'formmodule_id' => $module_id,
                        'visible' => 1,
                        'db_name' => 'description',
                        'input_name' => 'description',
                        'input_type' => 'textarea',
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
