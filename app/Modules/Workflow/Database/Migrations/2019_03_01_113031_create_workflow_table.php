<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

class CreateWorkflowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('visible')->default(true);
            NestedSet::columns($table);
            $table->timestamps();
        });
        Schema::create('workflow_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('work_id')->unsigned();
            $table->longText('description')->nullable()->default(null);
            $table->string('locale')->index();
            $table->unique([
                'work_id',
                'locale',
            ]);

            $table->foreign('work_id')->references('id')->on('workflow')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('workflow');
        Schema::drop('workflow_translations');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
