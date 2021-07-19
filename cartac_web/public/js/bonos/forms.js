jQuery(function() {
    $(".separadorMiles").inputmask({ alias: "currency", removeMaskOnSubmit: true });
    $("#tipo").change(function()  {
        $(".opcion_valor").removeClass("activo");
        $(".opcion_porcentaje").removeClass("activo");
        console.log($(this).val());
        if($(this).val()=="1"){
            $(".opcion_valor").addClass("activo");
        }
        else if($(this).val()=="2"){
            $(".opcion_porcentaje").addClass("activo");
        }
    });
});