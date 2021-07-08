<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCliente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->id("cli_id");
            $table->string("cli_nombres",50);
            $table->string("cli_apellidos",50);
            $table->string("cli_email",50);
            $table->string("cli_foto",255)->nullable();
            $table->string("cli_red",50)->nullable();
            $table->string("cli_id_red",255)->nullable();

            $table->bigInteger('cli_fk_usr')->unsigned()->nullable();
            $table->foreign('cli_fk_usr')->references('id')->on('users')->onDelete('cascade');
            $table->index('cli_fk_usr');
            $table->engine = "InnoDB";
        });

        Schema::create('bono', function (Blueprint $table) {
            $table->id("bon_id");
            $table->string("bon_codigo",50);
            $table->timestamp('bon_fecha_ini')->nullable();
            $table->timestamp('bon_fecha_fin')->nullable();
            $table->integer("bon_valor")->nullable();
            $table->float("bon_porcentaje")->nullable();
            $table->integer("bon_disponibles")->nullable();

            
            $table->engine = "InnoDB";


        });

        Schema::create('cliente_bono', function (Blueprint $table) {
            $table->id("clb_id");

            $table->bigInteger('clb_fk_cli_id')->unsigned()->nullable();
            $table->foreign('clb_fk_cli_id')->references('cli_id')->on('cliente')->onDelete('cascade');
            $table->index('clb_fk_cli_id');

            $table->bigInteger('clb_fk_bon_id')->unsigned()->nullable();
            $table->foreign('clb_fk_bon_id')->references('bon_id')->on('bono')->onDelete('cascade');
            $table->index('clb_fk_bon_id');

            $table->timestamp("clb_usado")->nullable();
            
            $table->bigInteger('clb_fk_est')->unsigned();
            $table->foreign('clb_fk_est')->references('est_id')->on('estado')->onDelete('cascade');
            $table->index('clb_fk_est');
            $table->engine = "InnoDB";

        });

        Schema::create('tipo_pago', function (Blueprint $table) {
            $table->id("tpg_id");
            $table->string("tpg_tipo",50);
            $table->string("tpg_token",255);
            
            $table->bigInteger('tpg_fk_cli')->unsigned()->nullable();
            $table->foreign('tpg_fk_cli')->references('cli_id')->on('cliente')->onDelete('cascade');
            $table->index('tpg_fk_cli');
            $table->engine = "InnoDB";
        });

        Schema::create('direccion', function (Blueprint $table) {
            $table->id("dir_id");
            $table->string("dir_direccion",255);
            $table->point("dir_ubicacion")->nullable();

            
            $table->bigInteger('dir_fk_cli')->unsigned()->nullable();
            $table->foreign('dir_fk_cli')->references('cli_id')->on('cliente')->onDelete('cascade');
            $table->index('dir_fk_cli');
            $table->engine = "InnoDB";
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('direccion', function(Blueprint $table)
        {
            $table->dropForeign('direccion_dir_fk_cli_foreign');
            $table->dropIndex('direccion_dir_fk_cli_index');

        });

        Schema::table('tipo_pago', function(Blueprint $table)
        {
            $table->dropForeign('tipo_pago_tpg_fk_cli_foreign');
            $table->dropIndex('tipo_pago_tpg_fk_cli_index');

        });
        Schema::table('cliente_bono', function(Blueprint $table)
        {
            $table->dropForeign('cliente_bono_clb_fk_bon_id_foreign');
            $table->dropIndex('cliente_bono_clb_fk_bon_id_index');

            $table->dropForeign('cliente_bono_clb_fk_cli_id_foreign');
            $table->dropIndex('cliente_bono_clb_fk_cli_id_index');
            
        });

        Schema::table('cliente', function(Blueprint $table)
        {
            $table->dropForeign('cliente_cli_fk_usr_foreign');
            $table->dropIndex('cliente_cli_fk_usr_index');            
        });

        Schema::dropIfExists('direccion');
        Schema::dropIfExists('tipo_pago');
        Schema::dropIfExists('cliente_bono');
        Schema::dropIfExists('bono');
        Schema::dropIfExists('cliente');
    }
}
