<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    
    // Image upload
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $stmt = $pdo->prepare("INSERT INTO items (name, description, image) VALUES (?, ?, ?)");
        $stmt->execute([$name, $description, $image]);
        header("Location: index.php");
        exit();
    } else {
        echo "Failed to upload image";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Create New Item</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label>Image</label>
                <input type="file" name="image" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>