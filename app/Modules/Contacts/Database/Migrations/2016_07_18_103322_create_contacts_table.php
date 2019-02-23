<?php
/**
 * Copyright (c) 2019. ProVision Media Group Ltd. <http://provision.bg>
 * Venelin Iliev <http://veneliniliev.com>
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('lat', 10, 8)->nullable()->default(NULL);
            $table->decimal('long', 10, 8)->nullable()->default(NULL);
            $table->boolean('visible')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('contacts_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contacts_id')->unsigned();
            $table->string('title')->nullable()->default(null);
            $table->string('description')->nullable()->default(null);
            $table->string('working_time')->nullable()->default(null);
            $table->text('address')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->string('locale')->index();
            $table->unique([
                'contacts_id',
                'locale'
            ]);
            $table->foreign('contacts_id')->references('id')->on('contacts')->onDelete('cascade');
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
        Schema::drop('contacts');
        Schema::drop('contacts_translations');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}