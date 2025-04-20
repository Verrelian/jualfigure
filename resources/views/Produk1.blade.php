<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="image/logo.jpeg" type="image/x-icon">
  <title>Detail Produk Figure - MOLE</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: #000;
      color: #fff;
    }
    
    .product-thumbnail {
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .product-thumbnail:hover {
      opacity: 0.8;
    }
  </style>
</head>

<body class="bg-black text-white min-h-screen">
  <!-- Back button -->
  <div class="fixed top-4 left-4 z-50">
    <a href="javascript:history.back()" class="text-white hover:text-gray-300">
      <i class="fas fa-arrow-left text-2xl"></i>
    </a>
  </div>

  <!-- Main Content -->
  <div class="container mx-auto pt-16 px-4 max-w-4xl">
    <div class="bg-gray-800 rounded-lg overflow-hidden">
      <div class="flex flex-col md:flex-row p-4 gap-6">
        <!-- Product Images -->
        <div class="md:w-1/2">
          <div class="flex flex-col gap-4">
            <!-- Main Image -->
            <div class="mb-2">
              <img id="mainImage" src="image/p5.jpg" alt="Himura Kenshin Figure" class="w-full rounded-lg">
            </div>
            
            <!-- Price for mobile only -->
            <div class="text-2xl font-bold text-red-500 md:hidden mb-4">
              IDR 699,000
            </div>
            
            <!-- Thumbnails -->
            <div class="flex gap-2 overflow-x-auto pb-2">
              <img src="image/p5o1.jpg" alt="Kenshin View 1" class="product-thumbnail w-20 h-20 object-cover rounded-lg" onclick="changeImage('image/p5o1.jpg')">
              <img src="image/p5o2.jpg" alt="Kenshin View 2" class="product-thumbnail w-20 h-20 object-cover rounded-lg" onclick="changeImage('image/p5o2.jpg')">
              <img src="image/p5o3.jpg" alt="Kenshin View 3" class="product-thumbnail w-20 h-20 object-cover rounded-lg" onclick="changeImage('image/p5o3.jpg')">
            </div>
          </div>
          
          <!-- Price for desktop, visible only on md and up -->
          <div class="text-3xl font-bold text-red-500 hidden md:block mt-4">
            IDR 699,000
          </div>
        </div>
        
        <!-- Product Details -->
        <div class="md:w-1/2">
          <h1 class="text-2xl font-bold mb-2">[Hanami SALE] PVC Non Scale Figure Himura Kenshin - Rurouni Kenshin</h1>
          
          <!-- Quantity Selector -->
          <div class="mb-6">
            <p class="mb-2">Quantity</p>
            <div class="flex items-center">
              <button class="bg-gray-700 px-4 py-2 rounded-l" onclick="decrementQuantity()">−</button>
              <input type="text" id="quantity" value="1" class="bg-gray-600 text-center w-16 py-2 border-0 focus:outline-none">
              <button class="bg-gray-700 px-4 py-2 rounded-r" onclick="incrementQuantity()">+</button>
              
              <!-- Bookmark Button -->
              <button class="ml-4 bg-transparent border border-gray-500 p-2 rounded">
                <i class="far fa-bookmark text-xl"></i>
              </button>
            </div>
          </div>
          
          <!-- Product Description -->
          <div class="space-y-4 text-gray-300">
            <p>From "Rurouni Kenshin," the main character Kenshin Himura has been sculpted as a non-scale figure!</p>
            
            <p>Kenshin is posed sitting on a chair with a gentle yet strong expression on his face.</p>
            
            <p>Costumes are created by modeling the thickness and flexure of his clothing with a focus on texture.</p>
            
            <p>Under special supervision, every detail has been carefully considered.</p>
            
            <p>Bring Kenshin Himura home at an affordable price and with a lot of attention to detail!</p>
            
            <p>Painted plastic non-scale complete product. Approximately 155mm in height.</p>
          </div>
          
          <!-- Buy Button -->
          <button class="w-full bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-4 rounded-lg mt-6">
            Buy It Now
          </button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Related Products Section (Optional) -->
  <div class="container mx-auto py-10 px-4 max-w-4xl">
    <h2 class="text-xl font-bold mb-4">Related Products</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div class="bg-gray-800 rounded-lg p-2">
        <img src="image/p4.jpg" alt="Related Figure" class="w-full h-40 object-cover rounded-lg">
        <p class="text-sm mt-2 text-gray-300">[REVIVE] S.H.MonsterArts Red Eyes Black Dragon - Yu-Gi-Oh! Duel Monsters</p>
        <p class="text-sm font-bold text-red-500">IDR 2.750,000</p>
      </div>
      <div class="bg-gray-800 rounded-lg p-2">
        <img src="/api/placeholder/150/150" alt="Related Figure" class="w-full h-40 object-cover rounded-lg">
        <p class="text-sm mt-2 text-gray-300">PVC Figure Aoshi Shinomori - Rurouni Kenshin</p>
        <p class="text-sm font-bold text-red-500">IDR 649,000</p>
      </div>
      <div class="bg-gray-800 rounded-lg p-2">
        <img src="/api/placeholder/150/150" alt="Related Figure" class="w-full h-40 object-cover rounded-lg">
        <p class="text-sm mt-2 text-gray-300">PVC Figure Kaoru Kamiya - Rurouni Kenshin</p>
        <p class="text-sm font-bold text-red-500">IDR 579,000</p>
      </div>
      <div class="bg-gray-800 rounded-lg p-2">
        <img src="/api/placeholder/150/150" alt="Related Figure" class="w-full h-40 object-cover rounded-lg">
        <p class="text-sm mt-2 text-gray-300">PVC Figure Yahiko Myojin - Rurouni Kenshin</p>
        <p class="text-sm font-bold text-red-500">IDR 499,000</p>
      </div>
    </div>
  </div>
  
  <!-- Footer -->
  <footer class="bg-gray-900 text-center text-white py-6 mt-10">
    <div class="flex flex-col items-center gap-2">
      <img src="image/logo.jpeg" alt="MOLE Logo" class="w-12 h-12 rounded-full">
      <p class="max-w-xl px-4">Discover premium anime figures and collectibles at MOLE - your trusted source for authentic merchandise.</p>
      <p class="text-sm">&copy; 2025 MOLE Figure Collection</p>
    </div>
  </footer>

  <!-- JavaScript for functionality -->
  <script>
    // Image changer function
    function changeImage(src) {
      document.getElementById('mainImage').src = src;
    }
    
    // Quantity incrementer/decrementer
    function incrementQuantity() {
      const quantityInput = document.getElementById('quantity');
      quantityInput.value = parseInt(quantityInput.value) + 1;
    }
    
    function decrementQuantity() {
      const quantityInput = document.getElementById('quantity');
      const currentValue = parseInt(quantityInput.value);
      if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
      }
    }
  </script>
</body>
</html>