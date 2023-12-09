<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pagte_id');
            $table->bigInteger('section_id');
            $table->bigInteger('item_id');
            $table->bigInteger('attribute_id');
            $table->text('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_attribute_values');
    }
}
