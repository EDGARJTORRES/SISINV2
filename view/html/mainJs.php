<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<script src="../../public/libs/select2/js/select2.min.js"></script>
<script src="../../public/js/tabler.min.js?1692870487" defer></script>
<script src="../../public/js/demo.min.js?1692870487" defer></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  const currentPath = window.location.pathname;
  document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
    const tempLink = document.createElement("a");
    tempLink.href = link.href;
    const linkPath = tempLink.pathname;
    if (currentPath.endsWith(linkPath)) {
      document.querySelectorAll('.navbar-nav .nav-item').forEach(item =>
        item.classList.remove('active')
      );
      link.closest('.nav-item').classList.add('active');
    }
  });
});
</script>