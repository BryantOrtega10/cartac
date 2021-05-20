<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConductor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('conductor', function (Blueprint $table) {
            $table->id("con_id");
            $table->string("con_documento",45);
            $table->string("con_nombres",50);
            $table->string("con_apellidos",50);
            $table->string("con_email",50);
            $table->string("con_celular",50)->nullable();
            $table->string("con_direccion",50);
            $table->string("con_foto",255);
            $table->string("con_hora_trabajo",255)->nullable();

            

            $table->bigInteger('con_fk_tpd')->unsigned();
            $table->foreign('con_fk_tpd')->references('tpd_id')->on('tipo_documento')->onDelete('cascade');
            $table->index('con_fk_tpd');

            $table->bigInteger('con_fk_usr')->unsigned();
            $table->foreign('con_fk_usr')->references('id')->on('users')->onDelete('cascade');
            $table->index('con_fk_usr');

            $table->bigInteger('con_fk_est')->unsigned();
            $table->foreign('con_fk_est')->references('est_id')->on('estado')->onDelete('cascade');
            $table->index('con_fk_est');

            $table->integer("con_billetera")->nullable();
            $table->string("con_numero_billetera",10)->nullable();
            $table->engine = "InnoDB";
        });

        Schema::create('conductor_respuesta', function (Blueprint $table) {
            $table->id("cnr_id");
            $table->text("cnr_campos")->nullable();   
            $table->text("cnr_mensaje")->nullable();   

            $table->bigInteger('cnr_fk_est')->unsigned();
            $table->foreign('cnr_fk_est')->references('est_id')->on('estado')->onDelete('cascade');
            $table->index('cnr_fk_est');

            $table->engine = "InnoDB";
        });

        Schema::create('vehiculo_conductor', function (Blueprint $table) {
            
            $table->id("veh_con_id");
            
            $table->bigInteger('fk_veh_id')->unsigned()->nullable();
            $table->foreign('fk_veh_id')->references('veh_id')->on('vehiculo')->onDelete('cascade');
            $table->index('fk_veh_id');
            
            $table->bigInteger('fk_con_id')->unsigned()->nullable();
            $table->foreign('fk_con_id')->references('con_id')->on('conductor')->onDelete('cascade');
            $table->index('fk_con_id');

            $table->bigInteger('fk_est_id')->unsigned();
            $table->foreign('fk_est_id')->references('est_id')->on('estado')->onDelete('cascade');
            $table->index('fk_est_id');
            $table->engine = "InnoDB";
        });

        Schema::create('tipo_documentacion', function (Blueprint $table) {
            $table->id("tdo_id");
            $table->string('tdo_name',100);      
            $table->engine = "InnoDB";      
        });
        
        Schema::create('documentacion', function (Blueprint $table) {
            $table->id("doc_id");
            $table->string('doc_ruta'); 

            $table->bigInteger('doc_fk_tdo')->unsigned();
            $table->foreign('doc_fk_tdo')->references('tdo_id')->on('tipo_documentacion')->onDelete('cascade');
            $table->index('doc_fk_tdo');

            $table->bigInteger('doc_fk_veh')->unsigned()->nullable();
            $table->foreign('doc_fk_veh')->references('veh_id')->on('vehiculo')->onDelete('cascade');
            $table->index('doc_fk_veh');

            $table->bigInteger('doc_fk_con')->unsigned()->nullable();
            $table->foreign('doc_fk_con')->references('con_id')->on('conductor')->onDelete('cascade');
            $table->index('doc_fk_con');

            $table->bigInteger('doc_fk_veh_con')->unsigned()->nullable();
            $table->foreign('doc_fk_veh_con')->references('veh_con_id')->on('vehiculo_conductor')->onDelete('cascade');
            $table->index('doc_fk_veh_con');
            
            $table->bigInteger('doc_fk_est')->unsigned();
            $table->foreign('doc_fk_est')->references('est_id')->on('estado')->onDelete('cascade');
            $table->index('doc_fk_est');

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
        Schema::table('documentacion', function(Blueprint $table)
        {
            $table->dropForeign('documentacion_doc_fk_veh_con_foreign');
            $table->dropIndex('documentacion_doc_fk_veh_con_index');

            $table->dropForeign('documentacion_doc_fk_con_foreign');
            $table->dropIndex('documentacion_doc_fk_con_index');

            $table->dropForeign('documentacion_doc_fk_veh_foreign');
            $table->dropIndex('documentacion_doc_fk_veh_index');

            $table->dropForeign('documentacion_doc_fk_tdo_foreign');
            $table->dropIndex('documentacion_doc_fk_tdo_index');
        });

        Schema::table('vehiculo_conductor', function(Blueprint $table)
        {
            $table->dropForeign('vehiculo_conductor_fk_veh_id_foreign');
            $table->dropIndex('vehiculo_conductor_fk_veh_id_index');

            $table->dropForeign('vehiculo_conductor_fk_con_id_foreign');
            $table->dropIndex('vehiculo_conductor_fk_con_id_index');
        });

        Schema::table('conductor', function(Blueprint $table)
        {
            $table->dropForeign('conductor_con_fk_usr_foreign');
            $table->dropIndex('conductor_con_fk_usr_index');

            $table->dropForeign('conductor_con_fk_tpd_foreign');
            $table->dropIndex('conductor_con_fk_tpd_index');
        });

  

        Schema::dropIfExists('tipo_documentacion');
        Schema::dropIfExists('documentacion');
        Schema::dropIfExists('conductor');
        Schema::dropIfExists('vehiculo_conductor');

    }
}
