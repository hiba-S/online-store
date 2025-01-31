<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableToImagesInTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('image')->nullable()->default(null)->change();
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->string('image')->nullable()->default(null)->change();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->string('image')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('image')->nullable(false)->default('images/avatars/default-avatar.png');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->string('image')->nullable(false)->default('images/categories/default-category.svg');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->string('image')->nullable(false);
        });
    }
}
