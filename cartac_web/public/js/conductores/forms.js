jQuery(function() {
    $("body").on("change", ".form-check-input", function() {

        if ($(this).is(":checked")) {
            $(".form-control[data-name=" + $(this).val() + "]").addClass("seleccionado");
        } else {
            $(".form-control[data-name=" + $(this).val() + "]").removeClass("seleccionado");
        }

        if ($(".form-check-input:checked").length > 0) {
            $(".mensaje-adicional").addClass("activo");
            $(".aprobar").addClass("oculto");
            $(".rechazar").removeClass("oculto");


        } else {
            $(".mensaje-adicional").removeClass("activo");
            $(".aprobar").removeClass("oculto");
            $(".rechazar").addClass("oculto");
        }

    });

    $("body").on("click", ".cont-img img", function() {
        $(".modal-image").modal("show");
        $("#modal-image").prop("src", $(this).prop("src"));
    });




});