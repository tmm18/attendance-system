<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('attendances')) { /*attendancesが存在しませんか？*/
            Schema::create('attendances', function (Belueprint $table) {

                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->date('date');
                $table->time('clock_in')->nullable(); /*空でもok*/
                $table->time('clock_out')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
