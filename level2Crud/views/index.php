<?php

include_once '../db/connection.php';
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

//search
$search = $_GET['search'] ?? '';

if ($search) {
    $statement = $pdo->prepare('SELECT * FROM products WHERE title LIKE :title ORDER BY created_at DESC');
    $statement->bindValue(':title', "%$search%");
} else {
    $statement = $pdo->prepare('SELECT * FROM products ORDER BY created_at DESC');
}


$statement->execute();

$products = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include_once 'partials/header.php' ?>

<h4 class="text-center">Products</h4>
<div class="d-grid gap-2 d-md-flex justify-content-md-end" style="margin-bottom: 10px;">
    <a href="create.php" class="btn btn-success">Add Product</a>
</div>
<table class="table">
    <div class="input-group mb-3">
        <form action="index.php" method="get">
            <input type="text" autocomplete="off" name="search" value="<?php echo $search ?? '' ?>" class="form-control" placeholder="Search" aria-label="Search for products" aria-describedby="basic-addon1">
            <button type="submit" class="btn btn-outline-primary">Search</button>
        </form>
    </div>
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

<?php include_once 'partials/footer.php' ?>