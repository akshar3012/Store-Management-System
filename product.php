<?php
session_start();
include('db_connect.php');

// Verify user authentication and authorization
if (!isset($_SESSION['user_id'])) {
    header('Location: Index.php');
    exit();
}

// Initialize variables
$message = '';
$view_mode = isset($_GET['view']) ? $_GET['view'] : 'grid'; // Changed default to grid
$products = array(); // Initialize products array

// Fetch products from database
try {
    $stmt = $pdo->query("SELECT * FROM products");
    $products = $stmt->fetchAll();
} catch(PDOException $e) {
    $message = "Error fetching products: " . $e->getMessage();
}

// Handle Add to Cart with AJAX
if(isset($_POST['add_to_cart'])) {
    $product_id = filter_var($_POST['product_id'], FILTER_VALIDATE_INT);
    $quantity = filter_var($_POST['quantity'], FILTER_VALIDATE_INT);
    
    if($product_id && $quantity > 0) {
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
        
        // Get product details from database
        $stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();
        
        if($product) {
            if(isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] += $quantity;
            } else {
                $_SESSION['cart'][$product_id] = array(
                    'name' => $product['product_name'],
                    'price' => $product['price'],
                    'image' => $product['image_path'],
                    'quantity' => $quantity,
                    'stock' => $product['stock_quantity'],
                    'description' => $product['description'] ?? '',
                    'product_id' => $product['product_id'],
                    'subtotal' => $product['price'] * $quantity
                );
            }
            $_SESSION['last_added_product'] = $_SESSION['cart'][$product_id];
            header('Location: cart.php');
            exit();
        }
    }
}

// Handle Add Product
if (isset($_POST['add_product'])) {
    $product_name = filter_var($_POST['product_name'], FILTER_SANITIZE_STRING);
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
    $stock_quantity = filter_var($_POST['stock_quantity'], FILTER_VALIDATE_INT);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    
    // Handle file upload
    $image_path = '';
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['image']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if(in_array($ext, $allowed)) {
            $upload_path = 'uploads/';
            $image_path = $upload_path . uniqid() . '.' . $ext;
            
            if(!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                $message = "Error uploading file.";
                $image_path = '';
            }
        }
    }
    
    try {
        $stmt = $pdo->prepare("INSERT INTO products (product_name, price, stock_quantity, description, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$product_name, $price, $stock_quantity, $description, $image_path]);
        $message = "Product added successfully!";
        header('Location: products.php');
        exit();
    } catch(PDOException $e) {
        $message = "Error adding product: " . $e->getMessage();
    }
}

// Handle Delete Product 
if (isset($_GET['delete_product'])) {
    $product_id = filter_var($_GET['delete_product'], FILTER_VALIDATE_INT);
    
    if($product_id) {
        try {
            $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = ?");
            $stmt->execute([$product_id]);
            $message = "Product deleted successfully!";
            header('Location: products.php');
            exit();
        } catch(PDOException $e) {
            $message = "Error deleting product: " . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .modal-content {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 15px;
        }
        .modal-header {
            background: #4e73df;
            color: white;
            border-radius: 15px 15px 0 0;
        }
        .modal-footer {
            background: rgba(78, 115, 223, 0.1);
            border-radius: 0 0 15px 15px;
        }
        .form-label {
            color: #4e73df;
            font-weight: 600;
        }
        .form-control {
            border-radius: 10px;
            border: 1px solid #4e73df;
        }
        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .btn-secondary {
            background-color: #858796;
            border-color: #858796;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <?php if($message): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Products</h5>
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="fas fa-plus"></i> Add Product
                    </button>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-3 g-4 grid-view">
                    <?php foreach ($products as $product): ?>
                    <div class="col">
                        <div class="card h-100">
                            <img src="<?php echo $product['image_path']; ?>" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                                <p class="card-text">Price: $<?php echo htmlspecialchars($product['price']); ?></p>
                                <p class="card-text">Stock: <?php echo htmlspecialchars($product['stock_quantity']); ?></p>
                                <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                                <div class="d-flex gap-2">
                                    <form method="POST" action="products.php" class="add-to-cart-form">
                                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                        <div class="input-group mb-3">
                                            <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock_quantity']; ?>" class="form-control" style="width: 70px;">
                                            <button type="submit" 
                                                    name="add_to_cart"
                                                    class="btn btn-success"
                                                    <?php echo $product['stock_quantity'] <= 0 ? 'disabled' : ''; ?>>
                                                <i class="fas fa-cart-plus"></i> Add to Cart
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel"><i class="fas fa-box-open me-2"></i>Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action=products.php" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="product_name" class="form-label"><i class="fas fa-tag me-2"></i>Product Name</label>
                                <input type="text" class="form-control shadow-sm" id="product_name" name="product_name" required>
                            </div>"
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label"><i class="fas fa-dollar-sign me-2"></i>Price</label>
                                <input type="number" step="0.01" class="form-control shadow-sm" id="price" name="price" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="stock_quantity" class="form-label"><i class="fas fa-boxes me-2"></i>Stock Quantity</label>
                                <input type="number" class="form-control shadow-sm" id="stock_quantity" name="stock_quantity" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label"><i class="fas fa-image me-2"></i>Product Image</label>
                                <input type="file" class="form-control shadow-sm" id="image" name="image" accept="image/*">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label"><i class="fas fa-align-left me-2"></i>Description</label>
                            <textarea class="form-control shadow-sm" id="description" name="description" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" name="add_product" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>