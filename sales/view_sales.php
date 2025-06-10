<?php
require '../config.php';

$stmt = $pdo->query('SELECT s.*, j.jewel_name FROM sales s JOIN jewels j ON s.jewel_id = j.id ORDER BY s.sale_date DESC');
$sales = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Sales Records</title>
</head>
<body class="container py-4">
    <h1>Sales Records</h1>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Jewel</th>
                <th>Customer</th>
                <th>Price</th>
                <th>Payment Method</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sales as $s): ?>
            <tr>
                <td><?php echo htmlspecialchars($s['sale_date']); ?></td>
                <td><?php echo htmlspecialchars($s['jewel_name']); ?></td>
                <td><?php echo htmlspecialchars($s['customer_name']); ?></td>
                <td><?php echo htmlspecialchars($s['price']); ?></td>
                <td><?php echo htmlspecialchars($s['payment_method']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
