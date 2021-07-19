jQuery(function() {
    $(".separadorMiles").inputmask({ alias: "currency", removeMaskOnSubmit: true });
    $("body").on("change", "#imagen", function(e) {
        e.preventDefault();
        var file = $(this)[0].files[0];
        console.log(mostrarImgNew(file, "preview"));
    });
});