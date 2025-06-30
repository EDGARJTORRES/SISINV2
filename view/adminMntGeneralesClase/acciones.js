function mostrarUltimaAccion(texto, timestampISO) {
  document.getElementById('accion_texto').textContent = texto;
  document.getElementById('accion_tiempo').textContent = dayjs(timestampISO).fromNow();
  document.getElementById('card_ultima_accion').style.display = 'block'
  localStorage.setItem('ultima_accion_texto', texto);
  localStorage.setItem('ultima_accion_fecha', timestampISO); 
}
window.addEventListener('DOMContentLoaded', function () {
  const texto = localStorage.getItem('ultima_accion_texto');
  const fecha = localStorage.getItem('ultima_accion_fecha');
  if (texto && fecha) {
    document.getElementById('accion_texto').textContent = texto;
    document.getElementById('accion_tiempo').textContent = dayjs(fecha).fromNow();
    document.getElementById('card_ultima_accion').style.display = 'block';
  }
});
