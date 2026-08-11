<?php
require_once "../database/db.php";
$sql="SELECT * FROM products";
$stmt=$pdo->prepare($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Products Page</h1>
    <a href="dashboard.php">Back to Dashboard</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Compare Price</th>
                <th>Image</th>
                <th>badge</th>
                <th>Rating</th>
                <th>Reviews</th>
                <th>New Arrivals</th>
                <th>Best Sellers</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt->execute();
            while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                echo "<tr>";
                echo "<td>".$row['id']."</td>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['category']."</td>";
                echo "<td>".$row['price']."</td>";
                echo "<td>".$row['compare_price']."</td>";
                echo "<td><img src='../images/products/".$row['image']."' alt='".$row['name']."' width='100'></td>";
                echo "<td>".$row['badge']."</td>";
                echo "<td>".$row['rating']."</td>";
                echo "<td>".$row['reviews']."</td>";
                echo "<td>".($row['is_new'] ? 'Yes' : 'No')."</td>";
                echo "<td>".($row['is_best_seller'] ? 'Yes' : 'No')."</td>";
                echo "<td><a href='edit_product.php?id=".$row['id']."'>Edit</a> |  <a href='delete_product.php?id=" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "' 
       onclick=\"return confirm('Are you sure you want to delete this product?');\">
       Delete
    </a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
</body>
</html>