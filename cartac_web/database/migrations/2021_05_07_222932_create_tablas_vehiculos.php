<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablasVehiculos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado', function (Blueprint $table) {
            $table->id("est_id");
            $table->string("est_name",100);
            $table->string("est_clase",100);
        });

        Schema::create('color_veh', function (Blueprint $table) {
            $table->id("col_id");
            $table->string("col_name",100);
        });

        Schema::create('marca_veh', function (Blueprint $table) {
            $table->id("mar_id");
            $table->string("mar_name",100);
        });

        Schema::create('tipo_documento', function (Blueprint $table) {
            $table->id("tpd_id");
            $table->string("tpd_nombre",100);
        });

        Schema::create('dimension_veh', function (Blueprint $table) {
            $table->id("dim_id");
            $table->string("dim_name",45);
        });

        Schema::create('tipo_veh', function (Blueprint $table) {
            $table->id("tip_id");
            $table->string("tip_name",45);
            $table->string("tip_alias",100);
        });

        Schema::create('dimension_tipo_veh', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fk_dim')->unsigned();
            $table->foreign('fk_dim')->references('dim_id')->on('dimension_veh')->onDelete('cascade');
            $table->index('fk_dim');
            $table->bigInteger('fk_tip')->unsigned();
            $table->foreign('fk_tip')->references('tip_id')->on('tipo_veh')->onDelete('cascade');
            $table->index('fk_tip');
        });

        Schema::create('propietario', function (Blueprint $table) {
            $table->id("pro_id");
            $table->string("pro_documento",45);
            $table->string("pro_nombres",45);
            $table->string("pro_apellidos",45);
            $table->string("pro_email",45);
            $table->bigInteger('pro_fk_tpd')->unsigned();
            $table->foreign('pro_fk_tpd')->references('tpd_id')->on('tipo_documento')->onDelete('cascade');
            $table->index('pro_fk_tpd');
        });

        

        Schema::create('vehiculo', function (Blueprint $table) {
            $table->id("veh_id");
            $table->string("veh_placa",6);
            $table->string("veh_foto",255);
            $table->bigInteger('veh_fk_col')->unsigned();
            $table->foreign('veh_fk_col')->references('col_id')->on('color_veh')->onDelete('cascade');
            $table->index('veh_fk_col');

            $table->bigInteger('veh_fk_mar')->unsigned();
            $table->foreign('veh_fk_mar')->references('mar_id')->on('marca_veh')->onDelete('cascade');
            $table->index('veh_fk_mar');

            $table->bigInteger('veh_fk_dim_tip')->unsigned();
            $table->foreign('veh_fk_dim_tip')->references('id')->on('dimension_tipo_veh')->onDelete('cascade');
            $table->index('veh_fk_dim_tip');
            
            $table->bigInteger('veh_fk_pro')->unsigned()->nullable();
            $table->foreign('veh_fk_pro')->references('pro_id')->on('propietario')->onDelete('cascade');
            $table->index('veh_fk_pro');

            $table->timestamp('veh_created_at')->nullable()->useCurrent();
            $table->timestamp('veh_updated_at')->nullable()->useCurrent();
            
            $table->bigInteger('veh_fk_est')->unsigned();
            $table->foreign('veh_fk_est')->references('est_id')->on('estado')->onDelete('cascade');
            $table->index('veh_fk_est');
        });


        Schema::create('categoria', function (Blueprint $table) {
            $table->id("cat_id");
            $table->string("cat_name",45);
            $table->string("cat_icono",255)->nullable();


            $table->bigInteger('cat_fk_cat')->unsigned()->nullable();
            $table->foreign('cat_fk_cat')->references('cat_id')->on('categoria')->onDelete('cascade');
            $table->index('cat_fk_cat');
        });

        Schema::create('vehiculo_categoria', function (Blueprint $table) {
            
            $table->bigInteger('fk_veh_id')->unsigned();
            $table->foreign('fk_veh_id')->references('veh_id')->on('vehiculo')->onDelete('cascade');
            $table->index('fk_veh_id');

            $table->bigInteger('fk_cat_id')->unsigned();
            $table->foreign('fk_cat_id')->references('cat_id')->on('categoria')->onDelete('cascade');
            $table->index('fk_cat_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehiculo', function(Blueprint $table)
        {
            $table->dropForeign('vehiculo_veh_fk_col_foreign');
            $table->dropIndex('vehiculo_veh_fk_col_index');
            
            
            $table->dropForeign('vehiculo_veh_fk_mar_foreign');
            $table->dropIndex('vehiculo_veh_fk_mar_index');
            

            $table->dropForeign('vehiculo_veh_fk_dim_tip_foreign');
            $table->dropIndex('vehiculo_veh_fk_dim_tip_index');
            

            $table->dropForeign('vehiculo_veh_fk_pro_foreign');
            $table->dropIndex('vehiculo_veh_fk_pro_index');
            
        });

        Schema::table('propietario', function(Blueprint $table)
        {
            $table->dropForeign('propietario_pro_fk_tpd_foreign');
            $table->dropIndex('propietario_pro_fk_tpd_index');
            
            
        });

        Schema::table('dimension_tipo_veh', function(Blueprint $table)
        {
            $table->dropForeign('dimension_tipo_veh_fk_dim_foreign');
            $table->dropIndex('dimension_tipo_veh_fk_dim_index');
            
            
            $table->dropForeign('dimension_tipo_veh_fk_tip_foreign');
            $table->dropIndex('dimension_tipo_veh_fk_tip_index');
            

            
        });
        


        Schema::dropIfExists('vehiculo');
        Schema::dropIfExists('propietario');
        Schema::dropIfExists('dimension_tipo_veh');

        Schema::dropIfExists('tipo_veh');
        Schema::dropIfExists('dimension_veh');
        Schema::dropIfExists('tipo_documento');
        Schema::dropIfExists('marca_veh');
        Schema::dropIfExists('color_veh');
    }
}
