<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('first_name');
            $table->string('last_name');
            $table->string('student_id')->unique();
            $table->date('birth_date');
            $table->enum('sex', ['Male', 'Female', 'Other']);
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
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'student_id', 'birth_date', 'sex', 'image_path']);
        });
    }
}
