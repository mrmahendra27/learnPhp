<?php

include_once 'connection.php';

//delete
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    if (!$id) {
        echo "Id is required";
    }

    $query = 'DELETE FROM products WHERE id = :id';
    $statement = $pdo->prepare($query);
    $statement->execute(['id' => $id]);
    // echo  'Deleted';
}


$statement = $pdo->prepare('SELECT * FROM products');
$statement->execute();

$products = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>PRODUCT CRUD</title>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-md">
                <a class="navbar-brand" href="index.php">Home</a>
            </div>
        </nav>
        <h4 class="text-center">Products</h4>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="create.php" class="btn btn-success">Add Product</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price(₹)</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $key => $product) : ?>
                    <tr>
                        <th scope="row"><?php echo $key + 1 ?></th>
                        <td><img class="thumb-image" src="<?php echo $product["image"] ?>" alt=""></td>
                        <td><?php echo $product["title"] ?></td>
                        <td><?php echo $product['description'] ?? 'N/A'  ?></td>
                        <td>₹<?php echo $product['price'] ?? 0  ?></td>
                        <td><?php echo $product['created_at'] ?? ''  ?></td>
                        <td>
                            <a href="update.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form style="display: inline-block;" action="index.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                                <button type="submit" name="delete" value="delete" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>