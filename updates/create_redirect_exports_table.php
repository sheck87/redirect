<?php

namespace Adrenth\Redirect\Updates;

use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

/**
 * Class CreateRedirectExportsTable
 *
 * @package Adrenth\Redirect\Updates
 */
class CreateRedirectExportsTable extends Migration
{
    public function up()
    {
        Schema::create('adrenth_redirect_redirect_exports', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('adrenth_redirect_redirect_exports');
    }
}
