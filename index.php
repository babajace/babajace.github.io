<?php
require 'config.php';

$stmt = $pdo->query('SELECT * FROM jewels ORDER BY id DESC');
$jewels = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Jewel Inventory</title>
</head>
<body class="container py-4">
    <h1>Jewel Inventory</h1>
    <a href="add_jewel.php" class="btn btn-primary mb-3">Add Jewel</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Type</th>
                <th>Material</th>
                <th>Purity</th>
                <th>Weight (g)</th>
                <th>Price (MYR)</th>
                <th>Supplier</th>
                <th>Date Acquired</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jewels as $jewel): ?>
            <tr>
                <td>
                    <?php if ($jewel['image_path']): ?>
                        <img src="uploads/<?php echo htmlspecialchars($jewel['image_path']); ?>" width="80" alt="">
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($jewel['jewel_name']); ?></td>
                <td><?php echo htmlspecialchars($jewel['type']); ?></td>
                <td><?php echo htmlspecialchars($jewel['material']); ?></td>
                <td><?php echo htmlspecialchars($jewel['purity']); ?></td>
                <td><?php echo htmlspecialchars($jewel['weight']); ?></td>
                <td><?php echo htmlspecialchars($jewel['price']); ?></td>
                <td><?php echo htmlspecialchars($jewel['supplier']); ?></td>
                <td><?php echo htmlspecialchars($jewel['date_acquired']); ?></td>
                <td><?php echo htmlspecialchars($jewel['status']); ?></td>
                <td>
                    <a href="edit_jewel.php?id=<?php echo $jewel['id']; ?>" class="btn btn-sm btn-secondary">Edit</a>
                    <a href="delete_jewel.php?id=<?php echo $jewel['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="export_excel.php" class="btn btn-success">Export to Excel</a>
</body>
</html>
