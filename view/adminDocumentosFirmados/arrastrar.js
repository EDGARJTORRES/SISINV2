// Referencia al área visible
const uploadArea = document.getElementById('upload_button');
const fileInput = document.getElementById('archivo_pdf');

if (uploadArea && fileInput) {
  // Previene comportamiento por defecto del navegador
  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, e => e.preventDefault());
    uploadArea.addEventListener(eventName, e => e.stopPropagation());
  });

  // Resaltar al arrastrar
  ['dragenter', 'dragover'].forEach(eventName => {
    uploadArea.addEventListener(eventName, () => {
      uploadArea.classList.add('highlight');
    });
  });

  // Quitar resaltado al salir o soltar
  ['dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, () => {
      uploadArea.classList.remove('highlight');
    });
  });

  // Manejar el drop
  uploadArea.addEventListener('drop', (e) => {
    if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
      const file = e.dataTransfer.files[0];
      fileInput.files = e.dataTransfer.files; // asignar archivo al input oculto

      // Mostrar nombre en la interfaz
      document.getElementById('upload_content').innerHTML = `
        <span class="upload-area-title text-center w-100">
          <i class="fa-solid fa-file-pdf me-2"></i> ${file.name}
        </span>
      `;
    }
  });
}
