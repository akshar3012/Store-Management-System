<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Format</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
        }
        .header img {
            max-width: 100px;
            margin-bottom: 10px;
        }
        .details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .details div {
            width: 48%;
        }
        .details div p {
            margin: 4px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #f8f8f8;
        }
        .footer {
            text-align: center;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <img src="Images/AKSHAR.jpg" alt="Company Logo">
            <h1>Invoice</h1>
            <p>AKSHAR MART</p>
            <p>BHAVNAGAR , GUJRATA </p>
        </div>

        <div class="details">
            <div>
                <p><strong>Invoice To:</strong></p>
                <p>Customer Name</p>
                <p>Address</p>
                <p>City, State, Zip</p>
            </div>
            <div>
                <p><strong>Invoice Details:</strong></p>
                <p>Invoice #: 12345</p>
                <p>Date: 23 June 2025</p>
                <p>Due Date: 30 June 2025</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Product/Service 1</td>
                    <td>2</td>
                    <td>$50</td>
                    <td>$100</td>
                </tr>
                <tr>
                    <td>Product/Service 2</td>
                    <td>1</td>
                    <td>$75</td>
                    <td>$75</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align:right;"><strong>Subtotal</strong></td>
                    <td>$175</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right;"><strong>Tax (10%)</strong></td>
                    <td>$17.50</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right;"><strong>Total</strong></td>
                    <td>$192.50</td>
                </tr>
            </tfoot>
        </table>

        <div class="footer">
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>
</html>
