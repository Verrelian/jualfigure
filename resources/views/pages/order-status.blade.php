@extends('layout.app')

 @section('content')

     <!-- Order Detail Container -->
     <div class="container mx-auto px-4 py-6 max-w-4xl">
         <!-- Order Header -->
         <div class="bg-white rounded-t-lg shadow-sm p-4">
             <div class="flex justify-between items-center">
                 <h1 class="text-xl font-bold">Order #3321345</h1>
                 <span class="text-sm text-blue-600 cursor-pointer">View Invoice</span>
             </div>
         </div>

         <!-- Order Status Timeline -->
         <div class="bg-white shadow-sm p-4 border-t border-gray-200">
             <div class="flex justify-between mb-6">
                 <div class="text-center w-1/5">
                     <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center mx-auto mb-2">
                         <i class="fas fa-check text-sm"></i>
                     </div>
                     <p class="text-xs text-green-500 font-medium">Order Placed</p>
                 </div>
                 <div class="text-center w-1/5">
                     <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center mx-auto mb-2">
                         <i class="fas fa-check text-sm"></i>
                     </div>
                     <p class="text-xs text-green-500 font-medium">Payment Confirmed</p>
                 </div>
                 <div class="text-center w-1/5">
                     <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center mx-auto mb-2">
                         <i class="fas fa-check text-sm"></i>
                     </div>
                     <p class="text-xs text-green-500 font-medium">Processing</p>
                 </div>
                 <div class="text-center w-1/5">
                     <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center mx-auto mb-2">
                         <i class="fas fa-truck text-sm"></i>
                     </div>
                     <p class="text-xs text-blue-500 font-medium">Shipping</p>
                 </div>
                 <div class="text-center w-1/5">
                     <div class="w-8 h-8 rounded-full bg-gray-300 text-white flex items-center justify-center mx-auto mb-2">
                         <i class="fas fa-box text-sm"></i>
                     </div>
                     <p class="text-xs text-gray-500 font-medium">Delivered</p>
                 </div>
             </div>
             <div class="relative">
                 <div class="absolute top-0 left-0 w-full h-2 bg-gray-200 rounded-full"></div>
                 <div class="absolute top-0 left-0 w-3/4 h-2 bg-blue-500 rounded-full"></div>
             </div>
         </div>

         <!-- Shipping Info -->
         <div class="bg-white shadow-sm p-4 border-t border-gray-200">
             <h2 class="text-lg font-semibold mb-3">Shipping Info</h2>
             <div class="grid grid-cols-2 gap-4">
                 <div>
                     <p class="text-sm text-gray-500 mb-1">Recipient</p>
                     <p class="text-sm font-medium">Wahyudi (Verel)</p>
                 </div>
                 <div>
                     <p class="text-sm text-gray-500 mb-1">Phone</p>
                     <p class="text-sm font-medium">62+ 82119223180</p>
                 </div>
                 <div>
                     <p class="text-sm text-gray-500 mb-1">Address</p>
                     <p class="text-sm font-medium">Nagoya, Blok Timur</p>
                 </div>
                 <div>
                     <p class="text-sm text-gray-500 mb-1">Estimated</p>
                     <p class="text-sm font-medium">3-5 business days</p>
                 </div>
             </div>
         </div>

         <!-- Product Detail -->
         <div class="bg-white shadow-sm p-4 border-t border-gray-200">
             <h2 class="text-lg font-semibold mb-3">Product Detail</h2>
             <div id="productItem" class="flex border-b border-gray-200 pb-4 mb-4 cursor-pointer hover:bg-gray-50 rounded-md p-2">
                 <div class="w-20 h-20 flex-shrink-0">
                     <img src="{{ asset('/images/p1.jpg') }}" alt="Product" class="w-full h-full object-cover rounded-md">
                 </div>
                 <div class="ml-4 flex-grow">
                     <h3 class="font-medium">Pop Up Parade SP Figure Belle / Rin - Zenless Zone Zero (17,7cm)</h3>
                     <p class="text-sm text-gray-500">Scale: 1/7 | Size: 17cm</p>
                     <div class="flex justify-between mt-2">
                         <span class="text-sm">x1</span>
                         <span class="text-sm font-semibold">$79.99</span>
                     </div>
                 </div>
             </div>
             <div class="flex justify-between border-b border-gray-200 py-2 text-sm">
                 <span>Subtotal (1 item)</span>
                 <span>$79.99</span>
             </div>
             <div class="flex justify-between border-b border-gray-200 py-2 text-sm">
                 <span>Shipping</span>
                 <span>$8.00</span>
             </div>
             <div class="flex justify-between py-2 text-sm font-semibold">
                 <span>Total</span>
                 <span>$87.99</span>
             </div>
         </div>

         <!-- Order History Timeline -->
         <div class="bg-white shadow-sm p-4 border-t border-gray-200 mt-4 rounded-b-lg">
             <h2 class="text-lg font-semibold mb-4">Order History</h2>
             <div class="relative pl-6">
                 <!-- Vertical Line -->
                 <div class="absolute top-0 left-2 w-0.5 h-full bg-gray-200"></div>

                 <!-- Timeline Items -->
                 <div class="mb-6 relative">
                     <div class="absolute -left-4 w-4 h-4 rounded-full bg-blue-500 border-2 border-white"></div>
                     <div class="ml-4">
                         <h3 class="font-medium">Order Ship Out</h3>
                         <p class="text-xs text-gray-500">Last updated: 14 April 2025, 14:32</p>
                         <p class="text-xs text-gray-600 mt-1">Current Location: Shinjutsu Myer Figure</p>
                     </div>
                 </div>

                 <div class="mb-6 relative">
                     <div class="absolute -left-4 w-4 h-4 rounded-full bg-blue-500 border-2 border-white"></div>
                     <div class="ml-4">
                         <h3 class="font-medium">Order Display</h3>
                         <p class="text-xs text-gray-500">Last updated: 14 April 2025, 18:32</p>
                         <p class="text-xs text-gray-600 mt-1">Current Location: Ferry Port Station</p>
                     </div>
                 </div>

                 <div class="mb-6 relative">
                     <div class="absolute -left-4 w-4 h-4 rounded-full bg-blue-500 border-2 border-white"></div>
                     <div class="ml-4">
                         <h3 class="font-medium">Haven Staged</h3>
                         <p class="text-xs text-gray-500">Last updated: 14 April 2025, 19:32</p>
                         <p class="text-xs text-gray-600 mt-1">Current Location: Nagoya Blok Timur</p>
                     </div>
                 </div>

                 <div class="mb-6 relative">
                     <div class="absolute -left-4 w-4 h-4 rounded-full bg-blue-500 border-2 border-white"></div>
                     <div class="ml-4">
                         <h3 class="font-medium">Out for Delivery</h3>
                         <p class="text-xs text-gray-500">Last updated: 15 April 2025, 07:32</p>
                         <p class="text-xs text-gray-600 mt-1">Current Location: Nagoya Blok Barat Shipyard</p>
                     </div>
                 </div>

                 <div class="relative">
                     <div class="absolute -left-4 w-4 h-4 rounded-full bg-gray-300 border-2 border-white"></div>
                     <div class="ml-4">
                         <h3 class="font-medium text-gray-500">Mission Accomplished</h3>
                         <p class="text-xs text-gray-400">Pending delivery confirmation</p>
                     </div>
                 </div>
             </div>
         </div>

         <!-- Action Button -->
         <div class="mt-4 text-center">
             <a href="{{ url('/dashboard') }}"><button id="doneButton" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-8 rounded-md">
                 Done
             </button></a>
         </div>
     </div>

     <!-- Product Detail Modal -->
     <div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
         <div class="bg-white rounded-lg w-full max-w-4xl shadow-xl">
             <div class="flex flex-col md:flex-row">
                 <!-- Product Image -->
                 <div class="md:w-1/2 p-4">
                     <div class="bg-gray-100 rounded-lg p-4 flex items-center justify-center h-80">
                         <img src="{{ asset('/images/p1.jpg') }}" alt="Product" class="max-w-full h-auto max-h-full object-contain">
                     </div>
                 </div>

                 <!-- Product Info -->
                 <div class="md:w-1/2 p-4">
                     <div class="flex justify-between items-center mb-4">
                         <h3 class="text-xl font-bold">Pop Up Parade SP Figure Belle / Rin - Zenless Zone Zero (17,7cm)</h3>
                         <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600">
                             <i class="fas fa-times text-xl"></i>
                         </button>
                     </div>

                     <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold mb-3">Anime Figure</span>
                     <div class="text-xl font-bold text-red-600 mb-4">$79.99</div>

                     <div class="mb-6">
                         <p class="text-gray-700">A stunning figure from Zenless Zone Zero featuring Belle / Rin. This high-quality PVC figure captures the character's iconic look with amazing detail.</p>
                     </div>

                     <div class="mb-6">
                         <h3 class="font-bold text-lg mb-2">Specifications</h3>
                         <div class="bg-gray-50 rounded-lg p-4">
                             <div class="flex border-b border-gray-200 py-2">
                                 <span class="font-semibold w-1/3">Manufacturer</span>
                                 <span class="text-gray-700 w-2/3">Good Smile Company</span>
                             </div>
                             <div class="flex border-b border-gray-200 py-2">
                                 <span class="font-semibold w-1/3">Scale</span>
                                 <span class="text-gray-700 w-2/3">1/7</span>
                             </div>
                             <div class="flex border-b border-gray-200 py-2">
                                 <span class="font-semibold w-1/3">Size</span>
                                 <span class="text-gray-700 w-2/3">17 cm</span>
                             </div>
                             <div class="flex border-b border-gray-200 py-2">
                                 <span class="font-semibold w-1/3">Material</span>
                                 <span class="text-gray-700 w-2/3">PVC & ABS</span>
                             </div>
                             <div class="flex py-2">
                                 <span class="font-semibold w-1/3">Release Date</span>
                                 <span class="text-gray-700 w-2/3">March 2025</span>
                             </div>
                         </div>
                     </div>

                     <button id="viewInStoreBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-semibold flex items-center">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                             <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                         </svg>
                         View in Store
                     </button>
                 </div>
             </div>
         </div>
     </div>

     <script>
         document.addEventListener('DOMContentLoaded', function() {
             // Elements
             const productItem = document.getElementById('productItem');
             const productModal = document.getElementById('productModal');
             const closeModalBtn = document.getElementById('closeModalBtn');
             const viewInStoreBtn = document.getElementById('viewInStoreBtn');
             const doneButton = document.getElementById('doneButton');

             // Open product modal when clicking on product item
             productItem.addEventListener('click', function() {
                 productModal.classList.remove('hidden');
                 document.body.style.overflow = 'hidden'; // Prevent scrolling
             });

             // Close product modal
             closeModalBtn.addEventListener('click', function() {
                 productModal.classList.add('hidden');
                 document.body.style.overflow = 'auto'; // Enable scrolling
             });

             // Close modal when clicking outside content
             productModal.addEventListener('click', function(e) {
                 if (e.target === productModal) {
                     productModal.classList.add('hidden');
                     document.body.style.overflow = 'auto'; // Enable scrolling
                 }
             });

             // View in store button
             viewInStoreBtn.addEventListener('click', function() {
                 window.location.href = "{{ route('product.detail', ['id' => 1]) }}";
             });
         });
     </script>
 @endsection