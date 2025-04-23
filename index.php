<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CRUD with Images</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Items List</h2>
        
        <!-- Search Bar -->
        <form method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search items...">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

        <a href="create.php" class="btn btn-success mb-3">Create New</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $sql = "SELECT * FROM items WHERE name LIKE ? OR description LIKE ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(["%$search%", "%$search%"]);
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['description']}</td>
                            <td><img src='uploads/{$row['image']}' width='100'></td>
                            <td>
                                <a href='edit.php?id={$row['id']}' class='btn btn-primary'>Edit</a>
                                <a href='delete.php?id={$row['id']}' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>