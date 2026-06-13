<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoice Report</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      padding: 20px;
    }

    .invoice-box {
      max-width: 800px;
      margin: auto;
      background: white;
      padding: 30px;
      border: 1px solid #eee;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
      line-height: 24px;
      font-size: 16px;
      color: #333;
    }

    .invoice-box h2 {
      text-align: center;
      color: #333;
    }

    .info, .customer {
      margin: 20px 0;
    }

    .info span, .customer span {
      display: block;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table, th, td {
      border: 1px solid #ddd;
    }

    th, td {
      padding: 10px;
      text-align: left;
    }

    th {
      background: #eee;
    }

    .total {
      text-align: right;
      font-weight: bold;
      padding-top: 10px;
    }

    .download-btn {
      margin-top: 20px;
      text-align: center;
    }

    .download-btn button {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 10px 20px;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
    }

    .download-btn button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>

<div class="invoice-box" id="invoice">
  <h2>Invoice Report</h2>

  <div class="info">
    <span><strong>Company:</strong> My Store Pvt. Ltd.</span>
    <span><strong>Address:</strong> 123 Business St, City</span>
    <span><strong>Date:</strong> <span id="invoice-date"></span></span>
  </div>

  <div class="customer">
    <span><strong>Customer Name:</strong> John Doe</span>
    <span><strong>Email:</strong> john@example.com</span>
  </div>

  <table>
    <thead>
      <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody id="invoice-items">
      <tr>
        <td>Product A</td>
        <td>2</td>
        <td>₹500</td>
        <td>₹1000</td>
      </tr>
      <tr>
        <td>Product B</td>
        <td>1</td>
        <td>₹1200</td>
        <td>₹1200</td>
      </tr>
    </tbody>
  </table>

  <div class="total">
    Total: ₹2200
  </div>

  <div class="download-btn">
    <button onclick="downloadPDF()">Download PDF</button>
  </div>
</div>

<script>
  // Set current date
  document.getElementById("invoice-date").innerText = new Date().toLocaleDateString();

  // Download invoice as PDF
  function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.html(document.querySelector("#invoice"), {
      callback: function (pdf) {
        pdf.save("Invoice_Report.pdf");
      },
      margin: [10, 10, 10, 10],
      autoPaging: 'text',
      html2canvas: { scale: 0.5 }
    });
  }
</script>

</body>
</html>
