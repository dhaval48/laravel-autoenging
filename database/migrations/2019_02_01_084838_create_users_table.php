
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Permission;
use App\Models\Role;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('users', function (Blueprint $table) {
            $table->increments("id");
            $table->string("name");
            $table->integer("created_by")->nullable();
			$table->string("locale")->default('en');
			$table->string("email");
			$table->string("password");
            $table->string('remember_token', 100)->nullable()->default(null);
			$table->timestamps();
            $table->softDeletes();
        });

        DB::table('users')->insert([
            'name' => 'Admin',
            'created_by' => 1,
            'email' => 'admin@admin.com',
            'password' => bcrypt('1234'),
        ]);
        

        $i = 1;
        $permission = [
        // Use Module Permission = 1
            [
                'name'=>'store_user',
                'display_name'=>'Store User',
                'description'=>'Permission to store user',
                'module_group_id' => $i
            ],
            [
                'name'=>'update_user',
                'display_name'=>'Update User',
                'description'=>'Permission to update user',
                'module_group_id' => $i
            ],
            [
                'name'=>'list_user',
                'display_name'=>'List User',
                'description'=>'Permission to list user',
                'module_group_id' => $i
            ],
            [
                'name'=>'delete_user',
                'display_name'=>'Delete User',
                'description'=>'Permission to delete user',
                'module_group_id' => $i
            ],
            [
                'name'=>'only_user',
                'display_name'=>'Only If Creator',
                'description'=>'Permission to only creator user',
                'module_group_id' => $i
            ],
            [
                'name'=>'activity_user',
                'display_name'=>'Activity of User',
                'description'=>'Permission to activity user',
                'module_group_id' => $i
            ]
        ];

        DB::table('permissions')->insert($permission);

        $permission = Permission::where('module_group_id',$i)->get();
        $role= Role::find(1); 
        foreach($permission as $permission) { 
            if($permission->name != "only_user") {
                $role->permissions()->attach($role->id, ['permission_id' => $permission->id]);
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
        //
    }
}
