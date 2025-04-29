@extends('layout.apps')

@section('content')
    <h1 class="text-2xl font-bold mb-4">CRUD Action Figure</h1>
    <button class="px-4 py-2 bg-green-600 text-white rounded-md" onclick="openModal()">Add New Figure</button>

    <table class="min-w-full mt-4 bg-white border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border-b-2 border-gray-300 px-4 py-2">Image</th>
                <th class="border-b-2 border-gray-300 px-4 py-2">Name</th>
                <th class="border-b-2 border-gray-300 px-4 py-2">Price</th>
                <th class="border-b-2 border-gray-300 px-4 py-2">Description</th>
                <th class="border-b-2 border-gray-300 px-4 py-2">Category</th>
                <th class="border-b-2 border-gray-300 px-4 py-2">Stock</th>
                <th class="border-b-2 border-gray-300 px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody id="crudTableBody">
            <!-- Data will be populated here -->
        </tbody>
    </table>

    {{-- Modal --}}
    <!-- Modal Background -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-6 z-50 hidden">

    <!-- Modal Box -->
    <div class="bg-white rounded-lg shadow-lg w-full max-w-5xl flex flex-col max-h-[90vh]">

        <!-- Modal Header -->
        <div class="p-6 border-b">
        <h2 id="modalTitle" class="text-2xl font-bold">Add New Action Figure</h2>
        </div>

        <!-- Modal Content (scrollable) -->
        <div class="overflow-y-auto p-6 flex-1">
        <form id="crudForm" class="space-y-4">

            <div>
            <label class="block text-gray-700 mb-1">Name</label>
            <input type="text" id="name" class="w-full border rounded p-2" required>
            </div>

            <div>
            <label class="block text-gray-700 mb-1">Description</label>
            <textarea id="description" class="w-full border rounded p-2" rows="3" required></textarea>
            </div>

            <div>
            <label class="block text-gray-700 mb-1">Price</label>
            <input type="number" id="price" class="w-full border rounded p-2" required>
            </div>

            <div>
            <label class="block text-gray-700 mb-1">Stock</label>
            <input type="number" id="stock" class="w-full border rounded p-2" required>
            </div>

            <div>
            <label class="block text-gray-700 mb-1">Category</label>
            <input type="text" id="category" class="w-full border rounded p-2" required>
            </div>

            <div>
            <label class="block text-gray-700 mb-1">Image</label>
            <input type="file" id="image" class="w-full border rounded p-2" accept="image/*">
            <div id="imagePreview" class="mt-3 flex flex-wrap gap-4"></div>
            </div>

        </form>
        </div>

        <!-- Modal Footer -->
        <div class="p-6 bg-gray-100 border-t flex justify-end gap-4">
        <button onclick="closeModal()" class="px-4 py-2 bg-gray-400 text-white rounded">Cancel</button>
        <button type="submit" form="crudForm" class="px-4 py-2 bg-green-600 text-white rounded">Save</button>
        </div>

    </div>
    </div>


    <script>
        let editingRow = null;

        function openModal(isEdit = false, row = null) {
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('crudForm').reset();
            document.getElementById('imagePreview').classList.add('hidden');
            editingRow = null;

            if (isEdit && row) {
                document.getElementById('modalTitle').innerText = 'Edit Figure';
                editingRow = row;

                // Pre-fill data
                document.getElementById('name').value = row.querySelector('.name').innerText;
                document.getElementById('description').value = row.querySelector('.description').innerText;
                document.getElementById('price').value = row.querySelector('.price').innerText.replace('$', '');
                document.getElementById('stock').value = row.querySelector('.stock').innerText;
                document.getElementById('category').value = row.querySelector('.category').innerText;
                document.getElementById('imagePreview').src = row.querySelector('.image img').src;
                document.getElementById('imagePreview').classList.remove('hidden');
            } else {
                document.getElementById('modalTitle').innerText = 'Add New Figure';
            }
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.classList.add('hidden');
            }
        });

        document.getElementById('crudForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const name = document.getElementById('name').value;
            const description = document.getElementById('description').value;
            const price = document.getElementById('price').value;
            const category = document.getElementById('category').value;
            const stock = document.getElementById('stock').value;
            const imageInput = document.getElementById('image');
            const preview = document.getElementById('imagePreview');

            let imageSrc = preview.src;

            if (editingRow) {
                // Update existing row
                editingRow.querySelector('.name').innerText = name;
                editingRow.querySelector('.description').innerText = description;
                editingRow.querySelector('.price').innerText = `$${price}`;
                editingRow.querySelector('.category').innerText = category;
                editingRow.querySelector('.stock').innerText = stock;
                if (imageInput.files.length > 0) {
                    editingRow.querySelector('.image img').src = imageSrc;
                }
            } else {
                // Add new row
                const tableBody = document.getElementById('crudTableBody');
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td class="border-b border-gray-300 px-4 py-2 image"><img src="${imageSrc}" class="w-16 h-16 object-cover mx-auto" alt="Image"></td>
                    <td class="border-b border-gray-300 px-4 py-2 name">${name}</td>
                    <td class="border-b border-gray-300 px-4 py-2 description">${description}</td>
                    <td class="border-b border-gray-300 px-4 py-2 price">$${price}</td>
                    <td class="border-b border-gray-300 px-4 py-2 category">${category}</td>
                    <td class="border-b border-gray-300 px-4 py-2 stock">${stock}</td>
                    <td class="border-b border-gray-300 px-4 py-2">
                        <button class="text-blue-600 mr-2" onclick="openModal(true, this.parentElement.parentElement)">Edit</button>
                        <button class="text-red-600" onclick="deleteItem(this)">Delete</button>
                    </td>
                `;
                tableBody.appendChild(newRow);
            }

            closeModal();
        });

        function deleteItem(button) {
            const row = button.closest('tr');
            row.remove();
        }
    </script>
@endsection
