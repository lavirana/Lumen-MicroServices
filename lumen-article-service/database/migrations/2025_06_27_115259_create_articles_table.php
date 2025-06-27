<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');                // Title of the article
            $table->text('content');                // Body/content
            $table->string('author')->nullable();   // Optional author name
            $table->timestamps();                   // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
