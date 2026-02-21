function carregarPagina(pagina) {
  const url = `http://${window.location.hostname}:8080/pages${pagina}`;
  const iframe = document.getElementById("myIframe");
  iframe.src = url;
}
