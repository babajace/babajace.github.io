<?php
require 'config.php';

if (!isset($_GET['id'])) {
    die('No ID specified');
}
$id = (int)$_GET['id'];

// Fetch to delete image
$stmt = $pdo->prepare('SELECT image_path FROM jewels WHERE id = ?');
$stmt->execute([$id]);
$jewel = $stmt->fetch();

if ($jewel) {
    if ($jewel['image_path'] && file_exists('uploads/' . $jewel['image_path'])) {
        unlink('uploads/' . $jewel['image_path']);
    }
    $del = $pdo->prepare('DELETE FROM jewels WHERE id = ?');
    $del->execute([$id]);
}
header('Location: index.php');
exit;
?>
