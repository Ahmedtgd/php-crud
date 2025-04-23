<?php
include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    
    if (!empty($_FILES['image']['name'])) {
        // Delete old image
        unlink("uploads/{$item['image']}");
        
        // Upload new image
        $image = $_FILES['image']['name'];
        $target = "uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $image = $item['image'];
    }

    $stmt = $pdo->prepare("UPDATE items SET name = ?, description = ?, image = ? WHERE id = ?");
    $stmt->execute([$name, $description, $image, $id]);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Item</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?= $item['name'] ?>" required>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control"><?= $item['description'] ?></textarea>
            </div>
            <div class="mb-3">
                <label>Current Image</label>
                <img src="uploads/<?= $item['image'] ?>" width="100" class="d-block mb-2">
                <input type="file" name="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>