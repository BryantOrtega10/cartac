jQuery(function() {
    $('#tabla-bonos').DataTable(optionsTable);
    $("body").on("click", ".eliminar", function(e) {
        e.preventDefault();
        $("#form-eliminar").prop("action", $(this).prop("href"));
        $(".modal-eliminar").modal("show");
    });
});