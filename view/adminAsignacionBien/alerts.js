function mostrarLoader() {
  const loader = document.getElementById('page');
  loader.style.visibility = 'visible';
  loader.style.opacity = '1';
  loader.style.pointerEvents = 'auto';
}
function ocultarLoader() {
  const loader = document.getElementById('page');
  loader.style.visibility = 'hidden';
  loader.style.opacity = '0';
  loader.style.pointerEvents = 'none';
}