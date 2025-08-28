<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>New Tenant Registration Alert</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
      color: #333;
    }
    .container {
      max-width: 600px;
      margin: 40px auto;
      background-color: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }
    .header {
      background-color: #333;
      color: white;
      padding: 20px;
      text-align: center;
    }
    .header h2 {
      margin: 0;
      font-size: 20px;
    }
    .content {
      padding: 30px 20px;
    }
    .content h3 {
      margin-top: 0;
      color: #4CAF50;
    }
    .details-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    .details-table td {
      padding: 8px 5px;
      border-bottom: 1px solid #eee;
    }
    .footer {
      text-align: center;
      font-size: 13px;
      color: #999;
      padding: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h2>🆕 New Tenant Registered</h2>
    </div>
    <div class="content">
      <p>Hello Admin,</p>
      <p>A new tenant has just signed up on <strong>{{ config('app.name') }}</strong>. Here are the details:</p>

      <table class="details-table">
        <tr>
          <td><strong>Store Name:</strong></td>
          <td>{{ $tenant->name }}</td>
        </tr>
        <tr>
          <td><strong>Domain:</strong></td>
          <td>{{ $tenant->domain }}</td>
        </tr>
        <tr>
          <td><strong>Email:</strong></td>
          <td>{{ $tenant->email }}</td>
        </tr>
        <tr>
          <td><strong>Phone:</strong></td>
          <td>{{ $tenant->phone ?? 'N/A' }}</td>
        </tr>
        <tr>
          <td><strong>Owner Name:</strong></td>
          <td>{{ $tenant->owner_name ?? 'N/A' }}</td>
        </tr>
        <tr>
          <td><strong>Registered At:</strong></td>
          <td>{{ $tenant->created_at->format('F d, Y H:i A') }}</td>
        </tr>
      </table>

      <p>Please review the new tenant's profile and verify if necessary.</p>

      <p>Regards,<br>{{ config('app.name') }} System</p>
    </div>
    <div class="footer">
      &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
  </div>
</body>
</html>
