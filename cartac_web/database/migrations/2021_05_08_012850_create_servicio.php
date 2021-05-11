<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('peaje', function (Blueprint $table) {
            $table->id("pea_id");
            $table->string("pea_nombre",100);
            $table->point("pea_ubic");
            $table->point("pea_ini")->nullable();
            $table->point("pea_fin")->nullable();
            $table->float("pea_radio");

        });

        Schema::create('peaje_tipo_veh', function (Blueprint $table) {
            $table->id("ptv_id");
            $table->integer("ptv_valor");
            $table->bigInteger('ptv_fk_tip')->unsigned()->nullable();
            $table->foreign('ptv_fk_tip')->references('tip_id')->on('tipo_veh')->onDelete('cascade');
            $table->index('ptv_fk_tip');

            $table->bigInteger('ptv_fk_pea')->unsigned()->nullable();
            $table->foreign('ptv_fk_pea')->references('pea_id')->on('peaje')->onDelete('cascade');
            $table->index('ptv_fk_pea');
        });

        Schema::create('configuracion', function (Blueprint $table) {
            $table->id("cfg_id");
            $table->float("cfg_distancia");
            $table->float("cfg_tiempo");
            $table->float("cfg_peso");
            $table->float("cfg_porcentaje_seguro");        
        });

        Schema::create('config_multiplicador', function (Blueprint $table) {
            $table->id("cfm_id");
            $table->time("cfm_hora_inicio");
            $table->time("cfm_hora_fin");
            $table->time("cfm_multiplicador");

            $table->bigInteger('cfm_fk_cfg')->unsigned()->nullable();
            $table->foreign('cfm_fk_cfg')->references('cfg_id')->on('configuracion')->onDelete('cascade');
            $table->index('cfm_fk_cfg');
            
        });

        Schema::create('servicio', function (Blueprint $table) {
            $table->id("ser_id");

            $table->bigInteger('ser_fk_cli')->unsigned()->nullable();
            $table->foreign('ser_fk_cli')->references('cli_id')->on('cliente')->onDelete('cascade');
            $table->index('ser_fk_cli');

            $table->point("ser_ubicacion_ini");
            $table->point("ser_ubicacion_fin");

            $table->string("ser_direccion_ini");
            $table->string("ser_direccion_fin");

            $table->decimal("ser_valor_final");

            $table->float("ser_calificacion");

            $table->bigInteger('ser_fk_cat')->unsigned()->nullable();
            $table->foreign('ser_fk_cat')->references('cat_id')->on('categoria')->onDelete('cascade');
            $table->index('ser_fk_cat');

            $table->bigInteger('ser_fk_dim_tip')->unsigned();
            $table->foreign('ser_fk_dim_tip')->references('id')->on('dimension_tipo_veh')->onDelete('cascade');
            $table->index('ser_fk_dim_tip');

            $table->bigInteger('ser_fk_cfm')->unsigned()->nullable();
            $table->foreign('ser_fk_cfm')->references('cfm_id')->on('config_multiplicador')->onDelete('cascade');
            $table->index('ser_fk_cfm');
            
            $table->bigInteger('ser_fk_tpg')->unsigned()->nullable();
            $table->foreign('ser_fk_tpg')->references('tpg_id')->on('tipo_pago')->onDelete('cascade');
            $table->index('ser_fk_tpg');

            $table->bigInteger('ser_fk_clb')->unsigned()->nullable();
            $table->foreign('ser_fk_clb')->references('clb_id')->on('cliente_bono')->onDelete('cascade');
            $table->index('ser_fk_clb');

            $table->timestamp('ser_created_at')->nullable()->useCurrent();
            $table->timestamp('ser_aceptado_at')->nullable();

            $table->bigInteger('ser_fk_est')->unsigned();
            $table->foreign('ser_fk_est')->references('est_id')->on('estado')->onDelete('cascade');
            $table->index('ser_fk_est');
        });

        Schema::create('ruta', function (Blueprint $table) {
            $table->id("rut_id");
            $table->point("rut_punto");

            $table->bigInteger('rut_fk_ser')->unsigned()->nullable();
            $table->foreign('rut_fk_ser')->references('ser_id')->on('servicio')->onDelete('cascade');
            $table->index('rut_fk_ser');
        });


        Schema::create('peaje_servicio', function (Blueprint $table) {
            $table->id("pjs_id");
            $table->integer("pjs_valor_cobrado");

            $table->bigInteger('pjs_fk_pea_id')->unsigned()->nullable();
            $table->foreign('pjs_fk_pea_id')->references('pea_id')->on('peaje')->onDelete('cascade');
            $table->index('pjs_fk_pea_id');

            $table->bigInteger('pjs_fk_ser_id')->unsigned()->nullable();
            $table->foreign('pjs_fk_ser_id')->references('ser_id')->on('servicio')->onDelete('cascade');
            $table->index('pjs_fk_ser_id');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peaje_servicio', function(Blueprint $table)
        {
            $table->dropForeign('peaje_servicio_pjs_fk_pea_id_foreign');
            $table->dropIndex('peaje_servicio_pjs_fk_pea_id_index');     

            $table->dropForeign('peaje_servicio_pjs_fk_ser_id_foreign');
            $table->dropIndex('peaje_servicio_pjs_fk_ser_id_index');            
        });

        Schema::table('ruta', function(Blueprint $table)
        {
            $table->dropForeign('ruta_rut_fk_ser_foreign');
            $table->dropIndex('ruta_rut_fk_ser_index');     
        });

        Schema::table('servicio', function(Blueprint $table)
        {
            $table->dropForeign('servicio_ser_fk_clb_foreign');
            $table->dropIndex('servicio_ser_fk_clb_index');

            $table->dropForeign('servicio_ser_fk_tpg_foreign');
            $table->dropIndex('servicio_ser_fk_tpg_index');

            $table->dropForeign('servicio_ser_fk_cfm_foreign');
            $table->dropIndex('servicio_ser_fk_cfm_index');

            $table->dropForeign('servicio_ser_fk_dim_tip_foreign');
            $table->dropIndex('servicio_ser_fk_dim_tip_index');

            $table->dropForeign('servicio_ser_fk_cat_foreign');
            $table->dropIndex('servicio_ser_fk_cat_index');

            $table->dropForeign('servicio_ser_fk_cli_foreign');
            $table->dropIndex('servicio_ser_fk_cli_index');
            
            
            
        });

        Schema::table('config_multiplicador', function(Blueprint $table)
        {
            $table->dropForeign('config_multiplicador_cfm_fk_cfg_foreign');
            $table->dropIndex('config_multiplicador_cfm_fk_cfg_index');     
        });

        Schema::table('peaje_tipo_veh', function(Blueprint $table)
        {
            $table->dropForeign('peaje_tipo_veh_ptv_fk_tip_foreign');
            $table->dropIndex('peaje_tipo_veh_ptv_fk_tip_index');     

            $table->dropForeign('peaje_tipo_veh_ptv_fk_pea_foreign');
            $table->dropIndex('peaje_tipo_veh_ptv_fk_pea_index');     
        });

        


        Schema::dropIfExists('peaje_servicio');
        Schema::dropIfExists('ruta');
        Schema::dropIfExists('servicio');
        Schema::dropIfExists('config_multiplicador');
        Schema::dropIfExists('configuracion');
        Schema::dropIfExists('peaje_tipo_veh');
        Schema::dropIfExists('peaje');
        
    }
}
