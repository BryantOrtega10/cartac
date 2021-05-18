jQuery(function() {
    $("body").on("change", "#foto", function(e) {
        e.preventDefault();
        var file = $(this)[0].files[0];
        console.log(mostrarImgNew(file, "preview"));
    });
});