<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = 'uploads/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $imageName);
        // Thumbnail generation can be added here
    }
    $stmt = $pdo->prepare("INSERT INTO jewels (jewel_name, type, material, purity, weight, price, description, supplier, date_acquired, status, image_path) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->execute([
        $_POST['jewel_name'],
        $_POST['type'],
        $_POST['material'],
        $_POST['purity'],
        $_POST['weight'],
        $_POST['price'],
        $_POST['description'],
        $_POST['supplier'],
        $_POST['date_acquired'],
        $_POST['status'],
        $imageName
    ]);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Add Jewel</title>
</head>
<body class="container py-4">
    <h1>Add Jewel</h1>
    <form method="post" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Name</label>
            <input type="text" name="jewel_name" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Type</label>
            <select name="type" class="form-select">
                <option value="ring">Ring</option>
                <option value="necklace">Necklace</option>
                <option value="earring">Earring</option>
                <option value="bracelet">Bracelet</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Material</label>
            <input type="text" name="material" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Purity/Hallmark</label>
            <input type="text" name="purity" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Weight (g)</label>
            <input type="number" step="0.01" name="weight" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Price (MYR)</label>
            <input type="number" step="0.01" name="price" class="form-control">
        </div>
        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Supplier</label>
            <input type="text" name="supplier" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Date Acquired</label>
            <input type="date" name="date_acquired" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="in_stock">In Stock</option>
                <option value="sold">Sold</option>
                <option value="display">Display</option>
                <option value="retired">Retired</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Add</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</body>
</html>
