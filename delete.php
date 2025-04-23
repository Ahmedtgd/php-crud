<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Get image name
    $stmt = $pdo->prepare("SELECT image FROM items WHERE id = ?");
    $stmt->execute([$id]);
    $image = $stmt->fetchColumn();
    
    // Delete file
    if ($image) {
        unlink("uploads/$image");
    }
    
    // Delete record
    $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: index.php");
exit();
?>