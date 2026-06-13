 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Cart with Sidebar</title>
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Rubik', sans-serif;
      background: linear-gradient(to right, #e3f2fd, #fce4ec);
      margin: 0;
      padding: 40px;
      color: #333;
    }

    .main-container {
      display: flex;
      max-width: 1200px;
      margin: auto;
      gap: 30px;
    }

    .cart-section, .sidebar {
      background: #fff;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .cart-section {
      flex: 2;
    }

    .sidebar {
      flex: 1;
      background: #f9fbe7;
    }

    h1 {
      font-size: 2rem;
      margin-bottom: 20px;
      color: #3f51b5;
    }

    .cart {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .card {
      width: 220px;
      background: #fafafa;
      border-radius: 10px;
      padding: 16px;
      box-shadow: 0 4px 12px rgba(63, 81, 181, 0.15);
      text-align: center;
    }

    .card img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 8px;
    }

    .card h3 {
      font-size: 1.1rem;
      margin: 10px 0;
      color: #303f9f;
    }

    .remove-btn {
      background: #d32f2f;
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 10px;
    }

    .billing-box {
      margin-top: 30px;
      font-size: 1rem;
    }

    .billing-box p {
      margin: 10px 0;
    }

    .billing-box input {
      padding: 8px;
      width: 180px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .billing-box button {
      margin-left: 8px;
      padding: 8px 16px;
      background: #388e3c;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
    }

    .checkout-btn {
      margin-top: 20px;
      background: #ff5722;
      color: white;
      padding: 12px 18px;
      border: none;
      width: 100%;
      font-size: 1rem;
      border-radius: 8px;
      cursor: pointer;
    }

    .sidebar h2 {
      font-size: 1.4rem;
      margin-bottom: 20px;
      color: #33691e;
    }

    .sidebar input, .sidebar textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 1rem;
    }

    .sidebar textarea {
      resize: vertical;
    }

    @media (max-width: 768px) {
      .main-container {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>

<div class="main-container">
  <!-- Cart Section -->
  <div class="cart-section">
    <h1>🛒 Your Cart</h1>
    <div class="cart" id="cart"></div>

    <div class="billing-box">
      <p>Subtotal: ₹<span id="subtotal">0</span></p>
      <p>Tax (18%): ₹<span id="tax">0</span></p>
      <p>Discount: ₹<span id="discount">0</span></p>
      <p>Shipping: ₹<span id="shipping">0</span></p>
      <p><strong>Grand Total: ₹<span id="grand-total">0</span></strong></p>
      <input type="text" id="promo-input" placeholder="Promo Code" />
      <button onclick="applyPromo()">Apply</button>
    </div>
  </div>

  <!-- Sidebar for Customer Info -->
  <div class="sidebar">
    <h2>Customer Details</h2>
    <input type="text" id="customer-name" placeholder="Full Name" />
    <input type="tel" id="customer-mobile" placeholder="Mobile Number" />
    <textarea id="customer-address" rows="4" placeholder="Address"></textarea>
    <button class="checkout-btn" onclick="proceedToCheckout()">Checkout & Download PDF</button>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  let discountApplied = false;

  function updateCart() {
    const cartContainer = document.getElementById("cart");
    cartContainer.innerHTML = "";
    let subtotal = 0;

    cart.forEach(item => {
      subtotal += item.price * item.quantity;
      const div = document.createElement("div");
      div.className = "card";
      div.innerHTML = `
        <img src="${item.image}" alt="${item.name}" />
        <h3>${item.name}</h3>
        <p>₹${item.price} × ${item.quantity}</p>
        <button class="remove-btn" onclick="removeFromCart(${item.id})">Remove</button>
      `;
      cartContainer.appendChild(div);
    });

    const tax = Math.round(subtotal * 0.18);
    const discount = discountApplied ? Math.round(subtotal * 0.1) : 0;
    const shipping = subtotal > 0 && subtotal < 5000 ? 150 : 0;
    const grandTotal = subtotal + tax + shipping - discount;

    document.getElementById("subtotal").textContent = subtotal;
    document.getElementById("tax").textContent = tax;
    document.getElementById("discount").textContent = discount;
    document.getElementById("shipping").textContent = shipping;
    document.getElementById("grand-total").textContent = grandTotal;
  }

  function removeFromCart(id) {
    cart = cart.filter(item => item.id !== id);
    localStorage.setItem("cart", JSON.stringify(cart));
    updateCart();
  }

  function applyPromo() {
    const code = document.getElementById("promo-input").value.trim().toUpperCase();
    if (code === "WEL10" && !discountApplied) {
      discountApplied = true;
      updateCart();
      alert("Promo applied!");
    } else {
      alert("Invalid or already used promo code.");
    }
  }

  async function proceedToCheckout() {
    if (cart.length === 0) return alert("Cart is empty!");

    const name = document.getElementById("customer-name").value.trim();
    const mobile = document.getElementById("customer-mobile").value.trim();
    const address = document.getElementById("customer-address").value.trim();

    if (!name || !mobile || !address) {
      return alert("Please fill all customer details.");
    }

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    let y = 20;
    doc.setFontSize(18);
    doc.text("Digital Store - Invoice", 70, y);
    y += 10;
    doc.setFontSize(12);
    doc.text(`Date: ${new Date().toLocaleString()}`, 14, y);
    y += 10;
    doc.text("Items:", 14, y);
    y += 10;

    cart.forEach(item => {
      doc.text(`${item.name} × ${item.quantity} = ₹${item.price * item.quantity}`, 20, y);
      y += 8;
    });

    y += 10;
    doc.text(`Customer Name: ${name}`, 20, y); y += 8;
    doc.text(`Mobile: ${mobile}`, 20, y); y += 8;
    doc.text(`Address: ${address}`, 20, y); y += 10;

    doc.text(`Subtotal: ₹${document.getElementById("subtotal").textContent}`, 20, y); y += 8;
    doc.text(`Tax: ₹${document.getElementById("tax").textContent}`, 20, y); y += 8;
    doc.text(`Discount: ₹${document.getElementById("discount").textContent}`, 20, y); y += 8;
    doc.text(`Shipping: ₹${document.getElementById("shipping").textContent}`, 20, y); y += 10;
    doc.setFont("helvetica", "bold");
    doc.text(`Grand Total: ₹${document.getElementById("grand-total").textContent}`, 20, y);

    doc.save("Invoice.pdf");
    alert("Thank you! Invoice downloaded.");
    localStorage.removeItem("cart");
    cart = [];
    updateCart();
    document.querySelector('.sidebar').reset;
  }

  updateCart();
</script>

</body>
</html>
