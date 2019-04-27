
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoApiTestModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $exist_module = DB::table('api_modules')->where('main_module','test module')->first();
        
        if(empty($exist_module)) {
            $module_id = DB::table('api_modules')->insertGetId([
                            
                 'parent_module' => 'General',
                 'main_module' => 'test module',
                 'table_name' => 'test_modules',
                 'is_model' => 1,
                 'is_public' => 1,
                
                        ]);
            $data = [
                    
                    [
                        'apimodule_id' => $module_id,
                        'name' => 'name',
                        'type' => 'varchar',
                        'validation' => 'required',
                        'default' => null,
                    ],
                    
                ];

            DB::table('api_tables')->insert($data);
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
