const optionsTable = {
    pageLength: 50,
    language: {
        processing: "Procesando...",
        search: "Buscar en la consulta:",
        lengthMenu: "Mostrar _MENU_ Registros",
        info: "Mostrando del _START_ hasta el _END_ de _TOTAL_ registros",
        infoEmpty: "No hay registros para mostrar",
        infoFiltered: "_MAX_ Registros en total",
        infoPostFix: "",
        loadingRecords: "Cargando...",
        zeroRecords: "No hay registros para mostrar",
        emptyTable: "No hay registros para mostrar",
        paginate: {
            first: "Primero",
            previous: "Anterior",
            next: "Siguiente",
            last: "último"
        },
        aria: {
            sortAscending: ": Activar para ordenar la columna en orden ascendente",
            sortDescending: ": Activar para ordenar la columna en orden descendente"
        }
    },
    buttons: ['print', { extend: 'excelHtml5', title: 'Excel' }, 'pdf', 'colvis']
        // dom: 'lBf',
}

const mostrarImgNew = function(file, idImage) {
    var preview = document.getElementById(idImage);
    var reader = new FileReader();

    reader.onloadend = function() {
        preview.src = reader.result;
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "";
    }
}