<!-- Payment Receipt Modal -->
<div id="receiptModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg w-full max-w-3xl shadow-xl max-h-[80vh] overflow-y-auto">
        <div class="flex">
            <!-- Left Side - Success Icon and Basic Info -->
            <div class="w-1/3 p-4 bg-gray-50 rounded-l-lg flex flex-col items-center justify-center">
                <img src="{{ asset('images/success-icon.png') }}" alt="Success" class="w-20 h-20 mb-4" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjMGY5ZDU4IiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgY2xhc3M9ImZlYXRoZXIgZmVhdGhlci1jaGVjay1jaXJjbGUiPjxwYXRoIGQ9Ik0yMiAxMS4wOFYxMmExMCAxMCAwIDEgMS01LjkzLTkuMTQiPjwvcGF0aD48cG9seWxpbmUgcG9pbnRzPSIyMiA0IDEyIDE0LjAxIDkgMTEuMDEiPjwvcG9seWxpbmU+PC9zdmc+'; this.classList.add('p-2')">
                <h4 class="text-center text-lg font-bold text-green-600 mb-2">Payment info!</h4>
                <p class="text-center text-sm text-gray-600 mb-6">Your order has been processed..</p>

                <div class="flex flex-col w-full space-y-1 text-sm mb-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order ID:</span>
                        <span class="font-semibold" id="receiptOrderNumber"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Date:</span>
                        <span id="receiptDate"></span>
                    </div>
                </div>

                <div class="mt-auto w-full">
                    <button id="downloadReceipt" class="w-full bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded font-medium">
                        Download Receipt
                    </button>
                </div>
            </div>

            <!-- Right Side - Order Details -->
            <div class="w-2/3 p-4 overflow-y-auto">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Payment Receipt</h3>
                    <button id="closeReceiptModal" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Receipt Content -->
                <div class="border-t border-b border-gray-200 py-6 mb-6">
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('images/success-icon.png') }}" alt="Success" class="w-16 h-16" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjMGY5ZDU4IiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgY2xhc3M9ImZlYXRoZXIgZmVhdGhlci1jaGVjay1jaXJjbGUiPjxwYXRoIGQ9Ik0yMiAxMS4wOFYxMmExMCAxMCAwIDEgMS01LjkzLTkuMTQiPjwvcGF0aD48cG9seWxpbmUgcG9pbnRzPSIyMiA0IDEyIDE0LjAxIDkgMTEuMDEiPjwvcG9seWxpbmU+PC9zdmc+'; this.classList.add('p-2')">
                    </div>
                    <h4 class="text-center text-xl font-bold text-green-600 mb-2">Payment!</h4>
                    <p class="text-center text-gray-600 mb-4">Your order has been Add to order status please check.</p>

                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Info:If you done for payment please check your order list</span>
                            <span class="font-semibold" id="receiptOrderNumber2"></span>
                        </div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Name Store:Market Place of Legends</span>
                            <span id="receiptDate2"></span>
                        </div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Payment Method:</span>
                            <span id="receiptPaymentMethod"></span>
                        </div>
                        <div class="flex justify-between text-sm font-semibold">
                            <span class="text-gray-600">Virtual Account Number:</span>
                            <span id="virtualAccountNumber"></span>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <h5 class="font-semibold mb-3 text-gray-800">Order Details</h5>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Product:</span>
                            <span class="text-right">{{ $product['title'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Quantity:</span>
                            <span id="receiptQuantity">1</span>
                        </div>
                        <div class="flex justify-between text-sm mb-2 pt-2 border-t border-gray-200">
                            <span class="text-gray-600">Subtotal:</span>
                            <span id="receiptSubtotal"></span>
                        </div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Shipping:</span>
                            <span id="receiptShipping"></span>
                        </div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Tax:</span>
                            <span id="receiptTax"></span>
                        </div>
                        <div class="flex justify-between font-bold pt-2 border-t border-gray-200">
                            <span>Total:</span>
                            <span id="receiptTotal"></span>
                        </div>
                    </div>
                </div>

                <div class="text-sm text-gray-600 mb-6">
                    <p class="mb-2">Please complete your payment by transferring to the virtual account number shown above. Your order will be processed once payment is verified.</p>
                    <p>Estimated delivery: <span class="font-semibold">3-5 business days</span> after payment verification.</p>
                </div>

                <div class="text-right">
                    <a href="{{ url('/order-status') }}">
                    <button id="closeReceiptBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-medium">
                        Done
                    </button></a>
                </div>
            </div>
        </div>
    </div>
</div>