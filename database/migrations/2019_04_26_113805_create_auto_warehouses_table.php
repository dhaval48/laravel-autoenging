
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $exist_module = DB::table('form_modules')->where('main_module','warehouse')->first();
        if(empty($exist_module)) {

            $module_id = DB::table('form_modules')->insertGetId([
                            
                 'parent_module' => 'General',
                 'main_module' => 'warehouse',
                 'table_name' => 'warehouses',
                
                        ]);
            $data = [
                    
                    [
                        'formmodule_id' => $module_id,
                        'name' => 'name',
                        'type' => 'varchar',
                        'validation' => 'required',
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
