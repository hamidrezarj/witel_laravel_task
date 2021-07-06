<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::table('students', function (Blueprint $table){
            $table->string('first_name');
            $table->string('last_name');
            $table->string('student_id')->unique();
            $table->date('birth_date');
            $table->enum('sex', ['Male', 'Female', 'Other']);
        });

        Schema::table('students', function (Blueprint $table){
            $table->string('image_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
