<?php
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO custom_orders (customer_name, size, material, design_notes, quote, progress, payment_status, delivery_status) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->execute([
        $_POST['customer_name'],
        $_POST['size'],
        $_POST['material'],
        $_POST['design_notes'],
        $_POST['quote'],
        'received',
        'pending',
        'not_delivered'
    ]);
    header('Location: add_order.php?success=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Add Custom Order</title>
</head>
<body class="container py-4">
    <h1>Add Custom Order</h1>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Order saved!</div>
    <?php endif; ?>
    <form method="post" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Customer Name</label>
            <input type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Size</label>
            <input type="text" name="size" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Material Requirement</label>
            <input type="text" name="material" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Quote (MYR)</label>
            <input type="number" step="0.01" name="quote" class="form-control">
        </div>
        <div class="col-12">
            <label class="form-label">Design Notes</label>
            <textarea name="design_notes" class="form-control" rows="3"></textarea>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Add Order</button>
        </div>
    </form>
</body>
</html>
