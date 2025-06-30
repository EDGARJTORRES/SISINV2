const uploadArea = document.getElementById('upload_button');
const fileInput = document.getElementById('archivo_pdf');
if (uploadArea && fileInput) {
  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, e => e.preventDefault());
    uploadArea.addEventListener(eventName, e => e.stopPropagation());
  });
  ['dragenter', 'dragover'].forEach(eventName => {
    uploadArea.addEventListener(eventName, () => {
      uploadArea.classList.add('highlight');
    });
  });
  ['dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, () => {
      uploadArea.classList.remove('highlight');
    });
  });
  uploadArea.addEventListener('drop', (e) => {
    if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
      const file = e.dataTransfer.files[0];
      fileInput.files = e.dataTransfer.files; 
      document.getElementById('upload_content').innerHTML = `
        <span class="upload-area-title text-center w-100">
          <i class="fa-solid fa-file-pdf me-2"></i> ${file.name}
        </span>
      `;
    }
  });
}
