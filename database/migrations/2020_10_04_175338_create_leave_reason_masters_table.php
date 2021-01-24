<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveReasonMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_reason_masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reason_name');
            
        });
        
        DB::table('leave_reason_masters')->insert([
            ['id' => '1'],
            ['reason_name' => '有給'],
        ]);
        
        DB::table('leave_reason_masters')->insert([
            ['id' => '2'],
            ['reason_name' => 'その他'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_reason_masters');
    }
}
