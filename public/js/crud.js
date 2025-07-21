// Global variables
let isEditMode = false;
let currentEditId = null;

// Base URL sesuai dengan route structure - PERBAIKAN
//Kerusakan pada delete, salah URL "Mole"
const BASE_URL = '/mole/seller/product';

// Helper function untuk handle response
function handleResponse(response) {
  // Jika response tidak ok, throw error dengan status
  if (!response.ok) {
    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
  }

  // Cek content type
  const contentType = response.headers.get('content-type');
  if (!contentType || !contentType.includes('application/json')) {
    throw new Error('Server tidak mengembalikan JSON response');
  }

  return response.json();
}

// Function untuk handle fetch errors
function handleFetchError(error) {
  console.error('Fetch error:', error);

  if (error.message.includes('HTTP 405')) {
    return 'Method tidak diizinkan. Periksa konfigurasi server.';
  } else if (error.message.includes('HTTP 404')) {
    return 'Endpoint tidak ditemukan. Periksa URL.';
  } else if (error.message.includes('HTTP 419')) {
    return 'CSRF token expired. Refresh halaman.';
  } else if (error.message.includes('tidak mengembalikan JSON')) {
    return 'Server error. Periksa log server.';
  } else {
    return 'Terjadi kesalahan koneksi!';
  }
}

function openAddModal() {
  resetModalState();
  document.getElementById('modalTitle').textContent = 'Tambah Produk Baru';
  document.getElementById('saveButtonText').textContent = 'Simpan';

  // Gunakan base URL yang konsisten untuk add
  document.getElementById('productForm').action = BASE_URL;
  document.getElementById('formMethod').value = 'POST';

  console.log('Add modal opened, form action:', document.getElementById('productForm').action);

  showModal('productModal');
}

function openEditModal(product) {
  resetModalState();
  isEditMode = true;
  currentEditId = product.product_id;

  document.getElementById('modalTitle').textContent = 'Tambah Produk Baru';
  document.getElementById('saveButtonText').textContent = 'Update';
  document.getElementById('productId').value = product.product_id;
  document.getElementById('productName').value = product.product_name;
  document.getElementById('productDescription').value = product.description;
  document.getElementById('productType').value = product.type;
  document.getElementById('productPrice').value = product.price;
  document.getElementById('productStock').value = product.stock;

  // Set form action dan method dengan benar
  document.getElementById('productForm').action = `${BASE_URL}/${product.product_id}`;
  document.getElementById('formMethod').value = 'PUT';

  console.log('Edit modal opened, form action:', document.getElementById('productForm').action);

  // Reset semua field spesifikasi terlebih dahulu
  document.getElementById('scale').value = '';
  document.getElementById('material').value = '';
  document.getElementById('manufacture').value = '';
  document.getElementById('release_date').value = '';
  document.getElementById('series').value = '';

  // Isi field spesifikasi jika ada
  if (product.specification) {
    const spec = product.specification;
    if (spec.scale) document.getElementById('scale').value = spec.scale;
    if (spec.material) document.getElementById('material').value = spec.material;
    if (spec.manufacture) document.getElementById('manufacture').value = spec.manufacture;
    if (spec.release_date) document.getElementById('release_date').value = spec.release_date;
    if (spec.series) document.getElementById('series').value = spec.series;
  }

  showModal('productModal');
}

function previewImage(src) {
  const modal = document.getElementById('imagePreviewModal');
  const image = document.getElementById('imagePreviewSrc');
  image.src = src;
  modal.classList.remove('hidden');
  modal.classList.add('flex');
  document.body.style.overflow = 'hidden';
}

function closeImagePreview() {
  const modal = document.getElementById('imagePreviewModal');
  modal.classList.add('hidden');
  modal.classList.remove('flex');
  document.body.style.overflow = 'auto';
}

function showSpecModal(productId) {
  // Fetch specification data
  fetch(`${BASE_URL}/${productId}/specification`)
    .then(handleResponse)
    .then(data => {
      const specContent = document.getElementById('specContent');
      specContent.innerHTML = '';

      // Check if data is empty or has content
      if (!data || Object.keys(data).length === 0) {
        specContent.innerHTML = '<p class="text-gray-500">Tidak ada spesifikasi tersedia.</p>';
      } else {
        // Create specification list
        Object.entries(data).forEach(([key, value]) => {
          if (value) { // Only show if value exists
            const specItem = document.createElement('div');
            specItem.className = 'flex justify-between items-center p-2 border-b border-gray-100 last:border-b-0';
            specItem.innerHTML = `
              <span class="font-medium text-gray-700 capitalize">${key.replace('_', ' ')}:</span>
              <span class="text-gray-600">${value}</span>
            `;
            specContent.appendChild(specItem);
          }
        });
      }

      document.getElementById('specModal').classList.remove('hidden');
    })
    .catch(error => {
      console.error('Error:', error);
      showToast('Gagal mengambil data spesifikasi', 'error');
    });
}

function toggleDescription(el) {
  const shortText = el.querySelector('.short-text');
  const fullText = el.querySelector('.full-text');
  const toggleBtn = el.querySelector('.toggle-btn');

  if (fullText.classList.contains('hidden')) {
    // Show full
    shortText.classList.add('hidden');
    fullText.classList.remove('hidden');
    toggleBtn.textContent = ' less';
  } else {
    // Show short
    shortText.classList.remove('hidden');
    fullText.classList.add('hidden');
    toggleBtn.textContent = '...more';
  }
}

function closeSpecModal() {
  document.getElementById('specModal').classList.add('hidden');
}

function openDeleteModal(productId, productName) {
  document.getElementById('deleteProductName').textContent = productName;

  // Set delete form action dengan base URL yang konsisten
  const deleteForm = document.getElementById('deleteForm');
  deleteForm.action = `${BASE_URL}/${productId}`;

  console.log('Delete modal opened, form action:', deleteForm.action);

  showModal('deleteModal');
}

// Toggle dropdown function
function toggleDropdown(productId) {
  const dropdown = document.getElementById(`dropdown-${productId}`);
  const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');

  // Close all other dropdowns
  allDropdowns.forEach(dd => {
    if (dd.id !== `dropdown-${productId}`) {
      dd.classList.add('hidden');
    }
  });

  // Toggle current dropdown
  dropdown.classList.toggle('hidden');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(e) {
  if (!e.target.closest('.relative')) {
    const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
    allDropdowns.forEach(dd => {
      dd.classList.add('hidden');
    });
  }
});

function resetModalState() {
  isEditMode = false;
  currentEditId = null;
  document.getElementById('productForm').reset();
  document.getElementById('productId').value = '';

  // Reset spesifikasi fields
  document.getElementById('scale').value = '';
  document.getElementById('material').value = '';
  document.getElementById('manufacture').value = '';
  document.getElementById('release_date').value = '';
  document.getElementById('series').value = '';
}

function showModal(modalId) {
  const modal = document.getElementById(modalId);
  modal.classList.remove('hidden');
  modal.classList.add('flex');
  document.body.style.overflow = 'hidden';
}

function hideModal(modalId) {
  const modal = document.getElementById(modalId);
  modal.classList.remove('flex');
  modal.classList.add('hidden');
  document.body.style.overflow = 'auto';
}

function closeProductModal() {
  hideModal('productModal');
  resetModalState();
}

function closeDeleteModal() {
  hideModal('deleteModal');
}

function showToast(message, type = 'success') {
  const toast = document.getElementById('toast');
  const toastMessage = document.getElementById('toastMessage');

  toastMessage.textContent = message;

  // Determine color and duration based on type
  let bgColor = 'bg-green-500';
  let duration = 3000;

  switch(type) {
    case 'error':
      bgColor = 'bg-red-500';
      duration = 5000;
      break;
    case 'warning':
      bgColor = 'bg-yellow-500';
      duration = 4000;
      break;
    case 'info':
      bgColor = 'bg-blue-500';
      duration = 3000;
      break;
    default:
      bgColor = 'bg-green-500';
      duration = 3000;
  }

  toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg transform transition-transform duration-300 z-50 ${bgColor} text-white`;

  // Show toast
  toast.classList.remove('translate-x-full');

  // Hide toast after specified duration
  setTimeout(() => {
    toast.classList.add('translate-x-full');
  }, duration);
}

// Event listeners
document.addEventListener('DOMContentLoaded', function () {
  // Add product button
  const btn = document.getElementById('btnAddProduct');

  btn.addEventListener('click', function () {
    console.log("Status profil lengkap:", window.isProfileComplete);

if (!window.isProfileComplete) {
  Swal.fire({
    icon: 'warning',
    title: 'Profil Belum Lengkap',
    text: 'Silakan lengkapi profil anda terlebih dahulu(Nama, Alamat dan No Handphone) sebelum menambahkan produk.',
    confirmButtonText: 'Oke',
    customClass: {
      confirmButton: 'bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded'
    }
  });
  return;
    }
    openAddModal();
  });

  // Modal cancel buttons
  document.getElementById('btnCancelModal').addEventListener('click', closeProductModal);
  document.getElementById('btnCancelDelete').addEventListener('click', closeDeleteModal);

  // Close modal when clicking outside
  document.getElementById('productModal').addEventListener('click', function(e) {
    if (e.target === this) {
      closeProductModal();
    }
  });

  document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
      closeDeleteModal();
    }
  });

  // Handle image upload preview
  document.getElementById('productImage').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        // You can add image preview logic here if needed
        console.log('Image selected:', file.name);
      };
      reader.readAsDataURL(file);
    }
  });

  // Product form submission
  document.getElementById('productForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitButton = document.getElementById('btnSaveProduct');
    const originalText = document.getElementById('saveButtonText').textContent;

    // Disable button and show loading
    submitButton.disabled = true;
    document.getElementById('saveButtonText').textContent = 'Menyimpan...';

    // Debug: Log form action dan method
    console.log('Form action:', this.action);
    console.log('Is edit mode:', isEditMode);
    console.log('Current edit ID:', currentEditId);

    // Untuk PUT request, tambahkan _method field
    if (isEditMode) {
      formData.append('_method', 'PUT');
    }

    fetch(this.action, {
      method: 'POST', // Selalu gunakan POST, Laravel akan handle _method
      body: formData,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json'
      }
    })
    .then(handleResponse)
    .then(data => {
      if (data.success) {
        showToast(data.message || (isEditMode ? 'Produk berhasil diupdate!' : 'Produk berhasil ditambahkan!'));
        closeProductModal();
        // Reload page to show updated data
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      } else {
        // Show specific error message
        showToast(data.message || 'Terjadi kesalahan!', 'error');

        // If there are validation errors, show them
        if (data.errors) {
          console.error('Validation errors:', data.errors);
          // You can display validation errors in the form if needed
        }
      }
    })
    .catch(error => {
      const errorMessage = handleFetchError(error);
      showToast(errorMessage, 'error');
    })
    .finally(() => {
      // Re-enable button
      submitButton.disabled = false;
      document.getElementById('saveButtonText').textContent = originalText;
    });
  });

  // Delete form submission
  document.getElementById('deleteForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const submitButton = document.getElementById('btnConfirmDelete');
    const originalText = submitButton.textContent;

    submitButton.disabled = true;
    submitButton.textContent = 'Menghapus...';

    // Debug: Log delete action
    console.log('Delete action:', this.action);

    // Gunakan FormData untuk mengirim _method
    const formData = new FormData();
    formData.append('_method', 'DELETE');

    fetch(this.action, {
      method: 'POST', // Gunakan POST dengan _method DELETE
      body: formData,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json'
      }
    })
    .then(handleResponse)
    .then(data => {
      if (data.success) {
        showToast(data.message || 'Produk berhasil dihapus!');
        closeDeleteModal();
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      } else {
        showToast(data.message || 'Terjadi kesalahan!', 'error');
      }
    })
    .catch(error => {
      const errorMessage = handleFetchError(error);
      showToast(errorMessage, 'error');
    })
    .finally(() => {
      submitButton.disabled = false;
      submitButton.textContent = originalText;
    });
  });
});

// Handle escape key to close modals
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    if (!document.getElementById('productModal').classList.contains('hidden')) {
      closeProductModal();
    }
    if (!document.getElementById('deleteModal').classList.contains('hidden')) {
      closeDeleteModal();
    }
    if (!document.getElementById('specModal').classList.contains('hidden')) {
      closeSpecModal();
    }
  }
  // Tambahkan ini di dalam document.addEventListener('DOMContentLoaded', function () { ... });

  // Aktifkan event klik untuk toggle deskripsi
  document.querySelectorAll('.truncate-description').forEach(el => {
    el.addEventListener('click', function () {
      toggleDescription(this);
    });
  });
});