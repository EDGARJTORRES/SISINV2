$(document).ready(function() {
    $('#bien_id').select2({
        placeholder: "Seleccione un bien",
        allowClear: true,
        ajax: {
            url: "../../controller/bien.php?op=get_bien_detalle",
            type: "GET",
            dataType: "json",
            delay: 250,
            processResults: function (data) {
                return {
                    results: data
                };
            }
        }
    });
});
