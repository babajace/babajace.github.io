<?php
require 'config.php';

if (!isset($_GET['id'])) {
    die('No ID specified');
}
$id = (int)$_GET['id'];

// Fetch existing data
$stmt = $pdo->prepare('SELECT * FROM jewels WHERE id = ?');
$stmt->execute([$id]);
$jewel = $stmt->fetch();
if (!$jewel) {
    die('Jewel not found');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imageName = $jewel['image_path'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = 'uploads/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        if ($imageName && file_exists($targetDir . $imageName)) {
            unlink($targetDir . $imageName);
        }
        $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $imageName);
    }
    $stmt = $pdo->prepare("UPDATE jewels SET jewel_name=?, type=?, material=?, purity=?, weight=?, price=?, description=?, supplier=?, date_acquired=?, status=?, image_path=? WHERE id=?");
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
        $imageName,
        $id
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
    <title>Edit Jewel</title>
</head>
<body class="container py-4">
    <h1>Edit Jewel</h1>
    <form method="post" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Name</label>
            <input type="text" name="jewel_name" class="form-control" value="<?php echo htmlspecialchars($jewel['jewel_name']); ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Type</label>
            <select name="type" class="form-select">
                <?php $types = ['ring','necklace','earring','bracelet']; ?>
                <?php foreach ($types as $t): ?>
                    <option value="<?php echo $t; ?>" <?php if ($jewel['type']==$t) echo 'selected'; ?>><?php echo ucfirst($t); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Material</label>
            <input type="text" name="material" class="form-control" value="<?php echo htmlspecialchars($jewel['material']); ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Purity/Hallmark</label>
            <input type="text" name="purity" class="form-control" value="<?php echo htmlspecialchars($jewel['purity']); ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Weight (g)</label>
            <input type="number" step="0.01" name="weight" class="form-control" value="<?php echo htmlspecialchars($jewel['weight']); ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Price (MYR)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?php echo htmlspecialchars($jewel['price']); ?>">
        </div>
        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($jewel['description']); ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Supplier</label>
            <input type="text" name="supplier" class="form-control" value="<?php echo htmlspecialchars($jewel['supplier']); ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Date Acquired</label>
            <input type="date" name="date_acquired" class="form-control" value="<?php echo htmlspecialchars($jewel['date_acquired']); ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <?php $statuses = ['in_stock'=>'In Stock','sold'=>'Sold','display'=>'Display','retired'=>'Retired']; ?>
                <?php foreach ($statuses as $value => $label): ?>
                    <option value="<?php echo $value; ?>" <?php if ($jewel['status']==$value) echo 'selected'; ?>><?php echo $label; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Image</label>
            <?php if ($jewel['image_path']): ?>
                <img src="uploads/<?php echo htmlspecialchars($jewel['image_path']); ?>" width="80" class="d-block mb-2" alt="">
            <?php endif; ?>
            <input type="file" name="image" class="form-control">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</body>
</html>
