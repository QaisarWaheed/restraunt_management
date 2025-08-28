
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Order Confirmation - {{ config('app.name') }}</title>
  <style>
    body {
      font-family: 'Segoe UI', Roboto, sans-serif;
      background-color: #f2f4f8;
      margin: 0;
      padding: 0;
      color: #2c3e50;
    }
    .container {
      max-width: 640px;
      margin: 40px auto;
      background-color: #ffffff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }
    .header {
      background-color: #1e3a8a;
      color: #ffffff;
      padding: 30px 25px;
      text-align: center;
    }
    .header h1 {
      margin: 0;
      font-size: 24px;
      font-weight: 600;
    }
    .content {
      padding: 30px 25px;
      font-size: 16px;
      line-height: 1.7;
    }
    .content p {
      margin-bottom: 16px;
    }
    .details {
      background-color: #f9fafb;
      padding: 15px;
      border-radius: 6px;
      margin: 20px 0;
      font-size: 15px;
    }
    .button {
      display: inline-block;
      background-color: #2563eb;
      color: #ffffff;
      padding: 12px 20px;
      border-radius: 6px;
      font-weight: 600;
      text-decoration: none;
      margin-top: 20px;
    }
    .footer {
      text-align: center;
      font-size: 13px;
      color: #7b8794;
      padding: 20px;
      background-color: #f1f5f9;
      border-top: 1px solid #e5e7eb;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Thank You for Your Order!</h1>
    </div>

    <div class="content">
      <p>Hello {{ $customer->name }},</p>

      <p>We're happy to confirm your order <strong>#{{ $order->order_number }}</strong> placed on <strong>{{ $order->created_at->format('F j, Y') }}</strong>.</p>

      <div class="details">
        <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
        <p><strong>Total Amount:</strong> {{ number_format($order->total, 2) }} {{ $order->currency }}</p>
        <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
        <p><strong>Estimated Delivery:</strong> {{ $order->estimated_delivery ?? 'Will be updated soon' }}</p>
      </div>

      <p>We'll notify you once your order has been shipped.</p>

      <a href="{{ $orderUrl }}" class="button" target="_blank">View My Order</a>

      <p>If you have any questions, feel free to reach out to our support team.</p>

      <p>Thank you for shopping with <strong>{{ $tenant->name }}</strong>!</p>
    </div>

    <div class="footer">
      &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
  </div>
</body>
</html>
