<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->integer('seller_id')->nullable();
            $table->string('offer_title')->nullable();
            $table->timestamp('offer_expiry_date')->nullable();
            $table->string('image')->nullable();

            $table->integer('minimum_order_quantity')->nullable();
            $table->double('minimum_order_amount')->nullable();

            // $table->double('total_price')->nullable()->comment('The total price of the items');
            // $table->double('total_amount')->nullable()->comment('The total amount of items');
            // $table->integer('number_of_items')->nullable()->comment('The total number of items');
            $table->unsignedBigInteger('offer_type_id')->nullable();
            $table->foreign('offer_type_id')->references('id')->on('offer_types');
            $table->boolean('is_active')->default(0);
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
        Schema::dropIfExists('offers');
    }
};
