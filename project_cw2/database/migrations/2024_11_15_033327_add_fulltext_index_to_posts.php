<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFulltextIndexToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Trong file migration
        Schema::table('products', function (Blueprint $table) {
            $table->fullText('name'); // Tạo chỉ mục fulltext trên cột 'name'
            $table->fullText('description'); // Tạo chỉ mục fulltext trên cột 'description'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
}
