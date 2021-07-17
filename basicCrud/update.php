<?php

include_once 'connection.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location:index.php');
    exit;
}

$query = 'SELECT * FROM products WHERE id=:id';
$statement = $pdo->prepare($query);
$statement->execute(['id' => $id]);
$product = $statement->fetch(PDO::FETCH_ASSOC);


//update
$errors = array(
    'error_title' => '',
    'error_description' => '',
    'error_price' => '',
    'error_image' => ''
);

if (isset($_POST['submit'])) {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $price = htmlspecialchars($_POST['price']);
    $image = $_FILES['image'] ?? null;
    $img = $product['image'];

    if (empty($title)) {
        $errors['error_title'] = 'Product Title is Required';
    }

    if (empty($price)) {
        $errors['error_price'] = 'Product Price is Required';
    }

    if (!empty($image) && $image['tmp_name']) {
        if($img){
           unlink($img); 
        }
        $img = 'images/' . $title . rand(10000, 99999) . $image['name'];
        move_uploaded_file($image['tmp_name'], $img);
    }

    if (array_filter($errors)) {
        //
    } else {
        $query = 'UPDATE products SET title=:title, description=:description, price=:price, image=:image WHERE id=:id';
        $statement = $pdo->prepare($query);
        $statement->execute(['title' => $title, 'image' => $img,  'price' => $price, 'description' => $description, 'id' => $id]);
        header('Location:index.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Add Product</title>
</head>

<body>

    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-md">
                <a class="navbar-brand" href="index.php">Home</a>
                <a class="navbar-brand" href="create.php">Add Product</a>
            </div>
        </nav>
        <h4 class="text-center">Update Product</h4>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Product Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="<?php echo htmlspecialchars($product['title']) ?>">
                <div class="red-text"><?php echo $errors['error_title'] ?></div>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" class="form-control" id="image" name="image">
                <div class="red-text"><?php echo $errors['error_image'] ?></div>
                <div class="mb-3">
                    <?php if ($product['image']) : ?>
                        <a href="<?php echo $product["image"] ?>" target="_blank">
                        <img class="update-image" src="<?php echo $product["image"] ?>" alt="">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Product Price(₹)</label>
                <input type="number" class="form-control" id="price" name="price" placeholder="Enter Price(₹)" value="<?php echo htmlspecialchars($product['price']) ?>">
                <div class="red-text"><?php echo $errors['error_price'] ?></div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Product Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="Enter Description"><?php echo htmlspecialchars($product['description']) ?></textarea>
                <div class="red-text"><?php echo $errors['error_description'] ?></div>
            </div>
            <button type="submit" name="submit" value="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>