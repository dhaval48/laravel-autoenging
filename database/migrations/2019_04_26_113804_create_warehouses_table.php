
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Permission;
use App\Models\Role;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('warehouses', function (Blueprint $table) {
            $table->increments("id");
			$table->string("name")->nullable();
			$table->timestamps();
			$table->softDeletes();
			
			
            $table->integer("created_by")->nullable();
        });


        $check_exist = DB::table('modules')->where('name','General')->first();
        $exist_group = DB::table('module_groups')->where('name','warehouse')->first();
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
                    'name'=>'warehouse',
                    'display_name' => 'Warehouse',
                    'description'=>'Manage the Warehouse',
                    'module_id'=> $id,
                    'status' => 1,
                    'icon' => 'fa-500px',
                    'permission' => 'list_warehouse',
                    'url' => 'warehouse',
                    'route' => 'warehouse.index'
                ];    
            $group_id = DB::table('module_groups')->insertGetId($module_groups);

            $permission = [
                [
                    'name'=>'store_warehouse',
                    'display_name'=>'Store Warehouse',
                    'description'=>'Permission to store warehouse',
                    'module_group_id' => $group_id
                ],
                [
                    'name'=>'update_warehouse',
                    'display_name'=>'Update Warehouse',
                    'description'=>'Permission to update warehouse',
                    'module_group_id' => $group_id
                ],
                [
                    'name'=>'list_warehouse',
                    'display_name'=>'List Warehouse',
                    'description'=>'Permission to list warehouse',
                    'module_group_id' => $group_id
                ],
                [
                    'name'=>'delete_warehouse',
                    'display_name'=>'Delete Warehouse',
                    'description'=>'Permission to delete warehouse',
                    'module_group_id' => $group_id
                ],
                [
                    'name'=>'only_warehouse',
                    'display_name'=>'Only If Creator',
                    'description'=>'Permission to only creator warehouse',
                    'module_group_id' => $group_id
                ],
                [
                    'name'=>'activity_warehouse',
                    'display_name'=>'Activity of Warehouse',
                    'description'=>'Permission to activity warehouse',
                    'module_group_id' => $group_id
                ]
            ];
            DB::table('permissions')->insert($permission);

            $permission = Permission::where('module_group_id',$group_id)->get();
            $role = Role::find(1);       
            foreach($permission as $permission) {
                if($permission->name != "only_warehouse") {            
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
