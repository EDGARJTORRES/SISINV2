const estadosBien = {
  'N': 'Nuevo',
  'B': 'Bueno',
  'R': 'Regular',
  'M': 'Malo'
};

const estadoBienLegible = estadosBien[data.bien_est] || 'Desconocido';
function get_color_string(color_id, callback) {
  $.post(
    "../../controller/objeto.php?op=get_color",
    { color_id: color_id },
    function (data) {
      var jsonData = JSON.parse(data);
      callback(jsonData.color_nom);
    }
  );
}
