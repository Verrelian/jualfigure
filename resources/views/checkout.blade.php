<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Menambahkan scrollbar hanya untuk bagian form */
        /*.scrollable {
            max-height: 80vh;
            overflow-y: auto;
        }

        /* Tidak bisa discroll pada bagian kanan */
        /*.no-scroll {
            overflow: hidden;
        }*/
    </style>
</head>

<body class="flex flex-col overflow-y-auto">

    <!-- Header -->
    <header class="flex items-center justify-between px-5 py-4 bg-white text-gray-800 border-b">
        <img src="{{ asset('images/mole.png') }}" alt="Logo" class="h-20 ml-16">
    </header>

    <!-- Container Utama -->
    <div class="flex flex-grow">
        <!-- Kiri: Form Input -->
        <div class="w-3/5 px-16 py-10 bg-white border-r">
            <h2 class="text-5xl font-bold mb-10">Contact</h2>
            <form id="checkoutForm" method="POST" action="{{ route('checkout.process') }}" autocomplete="off">
                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                @csrf
                <label class="block mb-5">
                    <h1 class="mb-3 text-2xl">Phone Number</h1>
                    <input type="text" name="phone_number" required class="block w-full h-16 text-xl px-2 border border-black rounded" placeholder="Ex : 08123456789">
                </label>
                <label class="block mb-5">
                    <h1 class="mb-3 text-2xl">Name</h1>
                    <input type="text" name="name" required class="block w-full h-16 text-xl px-2 border border-black rounded" placeholder="Ex : John">
                </label>
                <label class="block mb-5">
                    <h1 class="mb-3 text-2xl">Address</h1>
                    <input type="text" name="address" required class="block w-full h-16 text-xl px-2 border border-black rounded" placeholder="Ex : Dusseldorf, German">
                </label>
                <label class="block mb-10">
                    <h1 class="mb-3 text-2xl ml-16">Quantity</h1>
                    <input id="quantity" type="number" name="quantity" value="1" min="1" class="block w-30 h-16 text-xl p-2 border border-black rounded text-center" onchange="updateSubtotalOnly()">
                </label>
                <label class="block mb-10">
                    <h2 class="text-5xl font-bold mb-5 py-5">Payment Method </h2>
                    <select name="payment_method" id="paymentMethod" class="block w-full h-16 text-xl px-2 pr-64 border border-black rounded" onchange="updateTotal()">
                        <option value="" disabled selected>Select Payment Method</option>
                        <option value="BANK BCA">BANK BCA</option>
                        <option value="BANK MANDIRI">BANK Mandiri</option>
                        <option value="BANK BNI">BANK BNI</option>
                        <option value="BANK BRI">BANK BRI</option>
                    </select>
                </label>
                <button type="submit" id="checkoutBtn" class="w-full h-16 font-bold bg-blue-500 text-2xl text-white p-2 rounded disabled:opacity-50" disabled>Checkout</button>
            </form>
        </div>

        <!-- Kanan: Container Produk -->
        <div class="w-2/5 p-4 bg-gray-200 border-l sticky top-0 flex flex-col h-screen">
            <div id="productInfo" class="flex flex-col top-0 gap-6 flex-grow">
                <!-- Bagian gambar + nama + tipe -->
                <div class="ml-10 mt-10 flex text-center items-start gap-4">
                    <div class="w-48 h-48 overflow-hidden">
                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->product_name }}" class="h-40 rounded-lg object-contain">
                        <a href="{{ route('product.detail', $product->product_id) }}" class="text-blue-500 mt-2 mr-8 hover:underline inline-block">Product Detail</a>
                    </div>
                    <div class="justify-center font-bold text-left mt-6">
                        <h2 class="text-lg font-semibold">{{ $product->product_name }}</h2>
                        <p class="text-sm text-gray-500">{{ $product->type }}</p>
                    </div>
                </div>

                <!-- Harga subtotal, pajak, ongkir, total -->
                <div class="ml-10 space-y-6">
                    <p>Subtotal: <span id="subtotal" class="font-semibold">IDR {{ number_format($product->price) }}</span></p>
                    <p>Tax: <span id="tax" class="font-semibold">-</span></p>
                    <p>Shipping: <span id="shipping" class="font-semibold">-</span></p>
                    <span id="bankCharge"></span>
                    <p class="text-lg mt-2">Total: <span id="total" class="font-bold text-green-600">-</span></p>
                </div>
            </div>

            <!-- Reminder footer, selalu di bawah -->
            <div class="mt-6 pt-3 pb-3 border-t border-gray-400 text-base text-red-600 text-center">
                <div class="flex items-center justify-center gap-2">
                    <span class="text-2xl mb-3">⚠️</span>
                </div>
                <div>
                    <span>Reminder! Don't make the wrong purchase.</span>
                </div>
                <div>
                    <span>When you checkout, your item will be on order.</span>
                </div>
            </div>
        </div>

        <script>
            function updateSubtotalOnly() {
                const productPrice = @json($product->price);
                const quantity = parseInt(document.getElementById('quantity').value) || 1;
                const subtotal = productPrice * quantity;
                document.getElementById('subtotal').textContent = `IDR ${subtotal.toLocaleString()}`;
            }

            function updateTotal() {
                const quantity = parseInt(document.getElementById('quantity').value) || 1;
                const paymentMethod = document.getElementById('paymentMethod').value;
                const checkoutBtn = document.getElementById('checkoutBtn');

                // Ambil harga produk dari Blade ke JS
                const productPrice = @json($product->price);
                const tax = 50000;
                const shipping = 100000;
                let bankCharge = 0;

                // Bank Charge berdasarkan pilihan
                switch (paymentMethod) {
                    case 'BANK BCA':
                        bankCharge = 350000;
                        break;
                    case 'BANK MANDIRI':
                        bankCharge = 300000;
                        break;
                    case 'BANK BNI':
                        bankCharge = 260000;
                        break;
                    case 'BANK BRI':
                        bankCharge = 250000;
                        break;
                    default:
                        // Gak milih apa-apa → tampilkan "-"
                        document.getElementById('tax').textContent = "-";
                        document.getElementById('shipping').textContent = "-";
                        return;
                }

                const subtotal = productPrice * quantity;
                const total = subtotal + tax + shipping + bankCharge;

                document.getElementById('subtotal').innerText = `IDR ${subtotal.toLocaleString()}`;
                document.getElementById('tax').innerText = `IDR ${tax.toLocaleString()}`;
                document.getElementById('shipping').innerText = `IDR ${shipping.toLocaleString()}`;

                // Hanya tampilkan total jika paymentMethod dipilih
                if (paymentMethod) {
                    document.getElementById('total').innerText = `IDR ${total.toLocaleString()}`;
                    checkoutBtn.disabled = false;
                } else {
                    document.getElementById('total').innerText = `-`;
                    checkoutBtn.disabled = true;
                }
            }

            document.getElementById('checkoutForm').addEventListener('submit', function(event) {
                // Nonaktifkan pengiriman form bawaan saat testing
                //event.preventDefault();
                //alert('Checkout Success!');

                //console.log({
                //    phone: this.phone.value,
                //    name: this.name.value,
                //    address: this.address.value,
                //    quantity: this.quantity.value,
                //    paymentMethod: this.paymentMethod.value
                //});

                //this.reset();
                updateTotal();
            });

            // Trigger total pertama kali
            window.onload = updateTotal;
        </script>
</body>

</html>