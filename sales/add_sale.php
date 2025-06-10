<?php
require '../config.php';

// Get jewels for selection
$jewels = $pdo->query("SELECT id, jewel_name FROM jewels WHERE status='in_stock'")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO sales (jewel_id, customer_name, sale_date, price, payment_method) VALUES (?,?,?,?,?)");
    $stmt->execute([
        $_POST['jewel_id'],
        $_POST['customer_name'],
        $_POST['sale_date'],
        $_POST['price'],
        $_POST['payment_method']
    ]);
    // Mark jewel as sold
    $up = $pdo->prepare("UPDATE jewels SET status='sold' WHERE id=?");
    $up->execute([$_POST['jewel_id']]);
    header('Location: add_sale.php?success=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Add Sale</title>
</head>
<body class="container py-4">
    <h1>Add Sale</h1>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Sale recorded!</div>
    <?php endif; ?>
    <form method="post" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Jewel</label>
            <select name="jewel_id" class="form-select" required>
                <?php foreach ($jewels as $j): ?>
                    <option value="<?php echo $j['id']; ?>"><?php echo htmlspecialchars($j['jewel_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Customer Name</label>
            <input type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Sale Date</label>
            <input type="date" name="sale_date" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Price (MYR)</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Payment Method</label>
            <select name="payment_method" class="form-select">
                <option value="cash">Cash</option>
                <option value="credit_card">Credit Card</option>
                <option value="online">Online</option>
            </select>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Add Sale</button>
        </div>
    </form>
</body>
</html>
