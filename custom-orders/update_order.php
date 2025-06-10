<?php
require '../config.php';

if (!isset($_GET['id'])) {
    die('No ID specified');
}
$id = (int)$_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM custom_orders WHERE id=?');
$stmt->execute([$id]);
$order = $stmt->fetch();
if (!$order) {
    die('Order not found');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('UPDATE custom_orders SET progress=?, payment_status=?, delivery_status=? WHERE id=?');
    $stmt->execute([
        $_POST['progress'],
        $_POST['payment_status'],
        $_POST['delivery_status'],
        $id
    ]);
    header('Location: update_order.php?id=' . $id . '&success=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Update Order</title>
</head>
<body class="container py-4">
    <h1>Update Order</h1>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Order updated!</div>
    <?php endif; ?>
    <form method="post" class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Progress</label>
            <select name="progress" class="form-select">
                <?php $progressOptions = ['received','in_production','completed','delivered']; ?>
                <?php foreach ($progressOptions as $p): ?>
                    <option value="<?php echo $p; ?>" <?php if ($order['progress']==$p) echo 'selected'; ?>><?php echo ucfirst(str_replace('_',' ',$p)); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Payment Status</label>
            <select name="payment_status" class="form-select">
                <?php $paymentOptions = ['pending','paid','refunded']; ?>
                <?php foreach ($paymentOptions as $p): ?>
                    <option value="<?php echo $p; ?>" <?php if ($order['payment_status']==$p) echo 'selected'; ?>><?php echo ucfirst($p); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Delivery Status</label>
            <select name="delivery_status" class="form-select">
                <?php $deliveryOptions = ['not_delivered','delivered']; ?>
                <?php foreach ($deliveryOptions as $p): ?>
                    <option value="<?php echo $p; ?>" <?php if ($order['delivery_status']==$p) echo 'selected'; ?>><?php echo ucfirst(str_replace('_',' ',$p)); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</body>
</html>
