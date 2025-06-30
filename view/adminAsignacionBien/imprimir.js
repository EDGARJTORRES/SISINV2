function imprimir(bien_codbarras) {
  console.log(bien_codbarras);
  redirect_by_post(
    "../../controller/stick.php?op=imprimir_barras",
    { bien_codbarras, bien_codbarras },
    true
  );
}
function imprimirGrupo(depe_id) {
  redirect_by_post(
    "../../controller/stick.php?op=imprimirDependencia",
    { depe_id, depe_id },
    true
  );
}