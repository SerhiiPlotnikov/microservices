<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    public function up()
    {
        Schema::create(
            'books',
            function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('description');
                $table->unsignedBigInteger('price');
                $table->unsignedBigInteger('author_id');
                $table->timestamps();
            }
        );
    }

    public function down()
    {
        Schema::dropIfExists('books');
    }
}
