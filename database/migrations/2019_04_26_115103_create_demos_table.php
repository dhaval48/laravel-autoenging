
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Permission;
use App\Models\Role;

class CreateDemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('demos', function (Blueprint $table) {
            $table->increments("id");
			$table->string("name")->nullable();
			$table->date("date")->nullable();
			$table->integer("warehouse_id")->nullable();
			$table->string("gender")->nullable();
			$table->string("description")->nullable();
			$table->tinyinteger("status")->default("1");
			$table->timestamps();
			$table->softDeletes();
			
			
            $table->integer("created_by")->nullable();
        });


        $check_exist = DB::table('modules')->where('name','General')->first();
        $exist_group = DB::table('module_groups')->where('name','demo')->first();
        if(empty($exist_group)) {
            if(!empty($check_exist)) {
                $id = $check_exist->id;
            } else {
                $module = \DB::table('modules')->orderBy('id', 'DESC')->first();

                $id = DB::table('modules')->insertGetId([
                    'name' => 'General',
                    'description' => 'Manage General',
                    'url' => 'general',
                    'icon' => 'fa-database',
                    'order' => $module->order+1,
                ]);
            }   
            
            $module_groups=[
                    'name'=>'demo',
                    'display_name' => 'Demo',
                    'description'=>'Manage the Demo',
                    'module_id'=> $id,
                    'status' => 1,
                    'icon' => 'fa-500px',
                    'permission' => 'list_demo',
                    'url' => 'demo',
                    'route' => 'demo.index'
                ];    
            $group_id = DB::table('module_groups')->insertGetId($module_groups);

            $permission = [
                [
                    'name'=>'store_demo',
                    'display_name'=>'Store Demo',
                    'description'=>'Permission to store demo',
                    'module_group_id' => $group_id
                ],
                [
                    'name'=>'update_demo',
                    'display_name'=>'Update Demo',
                    'description'=>'Permission to update demo',
                    'module_group_id' => $group_id
                ],
                [
                    'name'=>'list_demo',
                    'display_name'=>'List Demo',
                    'description'=>'Permission to list demo',
                    'module_group_id' => $group_id
                ],
                [
                    'name'=>'delete_demo',
                    'display_name'=>'Delete Demo',
                    'description'=>'Permission to delete demo',
                    'module_group_id' => $group_id
                ],
                [
                    'name'=>'only_demo',
                    'display_name'=>'Only If Creator',
                    'description'=>'Permission to only creator demo',
                    'module_group_id' => $group_id
                ],
                [
                    'name'=>'activity_demo',
                    'display_name'=>'Activity of Demo',
                    'description'=>'Permission to activity demo',
                    'module_group_id' => $group_id
                ]
            ];
            DB::table('permissions')->insert($permission);

            $permission = Permission::where('module_group_id',$group_id)->get();
            $role = Role::find(1);       
            foreach($permission as $permission) {
                if($permission->name != "only_demo") {            
                    $role->permissions()->attach($role->id, ['permission_id' => $permission->id]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
