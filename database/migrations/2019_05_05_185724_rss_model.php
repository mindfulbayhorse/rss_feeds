<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RssModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('rss_feeds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('url');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->default(date('Y-m-d H-m-s'));
            
            $table->foreignId('category_id')->nullable();
            
            $table->foreignId('user_id')
            	->constrained()
            	->onDelete('cascade');
            
            $table->index(['user_id','url']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('rss_feeds');
    }
}
