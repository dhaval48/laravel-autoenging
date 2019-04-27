
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Permission;
use App\Models\Role;

class CreateDemoDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('demo_details', function (Blueprint $table) {
            $table->increments("id");
			$table->integer("demo_id")->unsigned();
			$table->string("full_name")->nullable();
			$table->date("start_date")->nullable();
			$table->integer("location_id")->nullable();
			$table->string("is_active")->nullable();
			$table->timestamps();
			
			$table->foreign("demo_id")->references("id")->on("demos")
                                ->onUpdate("restrict")
                                ->onDelete("cascade");
        });
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
