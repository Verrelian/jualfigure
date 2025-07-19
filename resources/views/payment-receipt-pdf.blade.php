<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Payment Receipt</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter&display=swap');

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #fff;
            color: #1a1a1a;
            font-size: 14px;
            line-height: 1.4;
        }

        strong {
            font-weight: 700;
        }

        /* Container */
        .container {
            max-width: 1100px;
            margin: 0 auto;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            display: table;
            width: 100%;
            min-height: 600px;
            table-layout: fixed;
        }

        /* Left panel */
        .left-panel {
            display: table-cell;
            width: 33.3333%;
            border-right: 1px solid #e5e7eb;
            padding: 32px 32px 32px 32px;
            vertical-align: top;
        }

        .check-image-wrapper {
            text-align: center;
        }

        .check-image {
            width: 130px;
            height: 100px;
            margin-bottom: 12px;
            display: inline-block;
        }

        .order-processed-text {
            color: #166534;
            font-weight: 600;
            font-size: 14px;
            text-align: center;
            line-height: 1.3;
            margin: 0 0 32px 0;
        }

        .status-text {
            font-weight: 600;
            font-size: 14px;
            text-align: center;
            line-height: 1.3;
            margin: 0 0 32px 0;
        }

        .status-blue {
            color: #1e40af;
        }

        .status-red {
            color: #dc2626;
        }

        .status-green {
            color: #15803d;
        }

        .order-info {
            width: 100%;
            padding: 0 12px;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .info-label,
        .info-value {
            display: table-cell;
            white-space: nowrap;
            vertical-align: middle;
            font-size: 12px;
        }

        .info-label {
            text-align: left;
            padding-right: 10px;
        }

        .info-value {
            text-align: right;
            width: 1%;
        }

        .order-info div:last-child {
            margin-bottom: 0;
        }

        .order-info strong {
            font-weight: 700;
        }

        .btn-download {
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 12px 0;
            font-size: 14px;
            cursor: pointer;
            width: 100%;
            font-weight: 400;
        }

        .btn-download:hover {
            background-color: #1d4ed8;
        }

        /* Right panel */
        .right-panel {
            display: table-cell;
            width: 66.6667%;
            padding: 32px 32px 32px 32px;
            vertical-align: top;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
        }

        .header h2 {
            font-weight: 700;
            font-size: 16px;
            margin: 0;
            color: #111827;
        }

        .close-btn {
            font-size: 16px;
            color: #6b7280;
            border: none;
            background: none;
            cursor: pointer;
            line-height: 1;
            padding: 0;
        }

        .close-btn:hover {
            color: #374151;
        }

        .payment-info-box {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 16px 20px 20px 20px;
            font-size: 12px;
            color: #4b5563;
            margin-bottom: 32px;
        }

        .payment-info-box p.title {
            color: #166534;
            font-weight: 600;
            font-size: 14px;
            text-align: center;
            margin: 0 0 8px 0;
        }

        .payment-info-box p.desc {
            text-align: center;
            margin: 0 0 16px 0;
            line-height: 1.3;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .info-label,
        .info-value {
            display: table-cell;
            white-space: nowrap;
            vertical-align: middle;
            font-size: 12px;
            color: #111827;
        }

        .info-label {
            text-align: left;
            padding-right: 10px;
        }

        .info-value {
            text-align: right;
            width: 1%;
        }

        .detail-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
            border-bottom: 1px solid #d1d5db;
            padding: 4px 0;
        }

        .detail-label,
        .detail-value {
            display: table-cell;
            white-space: nowrap;
            vertical-align: middle;
            font-size: 13px;
        }

        .detail-label {
            text-align: left;
            padding-right: 10px;
        }

        .detail-value {
            text-align: right;
            width: 1%;
        }

        .detail-row.total {
            border-bottom: none;
            font-weight: bold;
        }

        /* Footer text */
        .footer-text {
            font-size: 12px;
            color: #6b7280;
            line-height: 1.3;
            max-width: 480px;
        }

        .footer-text strong {
            font-weight: 700;
        }

        /* Done button */
        .btn-done {
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 12px 0;
            font-size: 14px;
            cursor: pointer;
            width: 100%;
            font-weight: 600;
        }

        .btn-done:hover {
            background-color: #1d4ed8;
        }
    </style>
</head>

<body>
    <div class="container" role="main" aria-label="Payment Receipt">
        <section class="left-panel" aria-label="Order summary and status">
            <div>
                @php
                $now = now();
                $isExpired = $payment->payment_status === 'UNPAID' && $payment->expired_at <= $now;
                    $isCanceled=$payment->payment_status === 'PAID' && $payment->transaction_status === 'CANCELED';
                    $isCompleted = $payment->transaction_status === 'COMPLETED';
                    @endphp

                    <div class="check-image-wrapper" aria-hidden="true">
                        @if ($isCompleted)
                        <img src="{{ public_path('images/completed.png') }}" alt="Completed Icon" class="check-image" />
                        @elseif ($isExpired)
                        <img src="{{ public_path('images/canceled-expired.png') }}" alt="Expired Icon" class="check-image" />
                        @elseif ($isCanceled)
                        <img src="{{ public_path('images/canceled-expired.png') }}" alt="Canceled Icon" class="check-image" />
                        @elseif ($payment->payment_status === 'PAID')
                        <img src="{{ public_path('images/checklist.png') }}" alt="Checklist Icon" class="check-image" />
                        @endif
                    </div>
                    <p class="status-text
@if ($isCompleted)
    status-blue
@elseif ($isExpired || $isCanceled)
    status-red
@elseif ($payment->payment_status === 'PAID')
    status-green
@endif
">
                        @if ($isCompleted)
                        Order completed successfully!
                        @elseif ($isExpired)
                        This payment has expired!
                        @elseif ($isCanceled)
                        Your order has been canceled!
                        @elseif ($payment->payment_status === 'PAID')
                        Your order has been processed!
                        @endif
                    </p>
            </div>
            <div class="order-info">
                <div class="info-row">
                    <div class="info-label">Order ID:</div>
                    <div class="info-value"><strong>{{ $payment->order_id }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Date:</div>
                    <div class="info-value">{{ $payment->payment_date }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Name:</div>
                    <div class="info-value">{{ $payment->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Phone:</div>
                    <div class="info-value">{{ $payment->phone_number }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Address:</div>
                    <div class="info-value">{{ $payment->address }}</div>
                </div>
            </div>
        </section>
        <section class="right-panel" aria-label="Payment details and order details">
            <header class="header">
                <h2>Payment Receipt</h2>
            </header>
            <div class="payment-info-box" aria-label="Payment information">
                <p class="title">Payment Info!</p>
                <p class="desc">Your order has been Add to order status, please check !<br />Info : If you done for payment please check your order list</p>
                <div class="payment-info-details">
                    <div class="info-row">
                        <div class="info-label">Name Store:</div>
                        <div class="info-value">Market Place of Legends</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Payment Method:</div>
                        <div class="info-value">{{ $payment->payment_method }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Payment Status:</div>
                        <div class="info-value">{{ $payment->payment_status }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Transaction Status:</div>
                        <div class="info-value">{{ $payment->transaction_status }}</div>
                    </div>
                </div>
            </div>
            <div class="order-details" aria-label="Order details">
                <p class="title">Order Details</p>
                @if ($isCart)
                <div class="detail-row">
                    <div class="detail-label">Products:</div>
                    <div class="detail-value">
                        @foreach ($payments as $p)
                        {{ $p->product_name }} x{{ $p->quantity }}<br>
                        @endforeach
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Subtotal:</div>
                    <div class="detail-value">IDR {{ number_format($subtotal) }}</div>
                </div>
                <div class="detail-row total">
                    <div class="detail-label"><strong>Total (Tax + Shipping):</strong></div>
                    <div class="detail-value"><strong>IDR {{ number_format($cartTotal, 2, ',', '.') }}</strong></div>
                </div>
                @else
                <div class="detail-row">
                    <div class="detail-label">Product:</div>
                    <div class="detail-value">{{ $payment->product_name }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Quantity:</div>
                    <div class="detail-value">{{ $payment->quantity }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Subtotal:</div>
                    <div class="detail-value">IDR {{ number_format($payment->price) }}</div>
                </div>
                <div class="detail-row total">
                    <div class="detail-label"><strong>Total (Tax + Shipping):</strong></div>
                    <div class="detail-value"><strong>IDR {{ number_format($payment->price_total, 2, ',', '.') }}</strong></div>
                </div>
                @endif
            </div>

            <p class="footer-text" aria-label="Payment instructions and delivery estimate">
                Please complete your payment by transferring to the virtual account number shown above. Your order will be processed once payment is verified.<br />
                Estimated delivery: <strong>3-5 business days</strong> after payment verification.
            </p>
        </section>
    </div>
</body>

</html>