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
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->date('due_date'); // تاريخ الاستحقاق
            $table->string('product');   
            $table->decimal('Amount_Collection',8,2)->nullable();;
            $table->decimal('Amount_Commission',8,2);
            $table->decimal('discount',8,2)->default(0);
            $table->decimal('Value_VAT',8,2); // الفيمة المضافة
            $table->string('Rate_VAT',999); // الفيمة المضافة
            $table->decimal('total',8,2);
            $table->string('status',50);
            $table->integer('value_status');
            $table->text('note')->nullable();
            $table->date('Payment_Date')->nullable();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->bigInteger( 'section_id' )->unsigned();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');    
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
        Schema::dropIfExists('invoices');
    }
};
