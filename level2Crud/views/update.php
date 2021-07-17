<?php

/** @var $pdo \PDO */
include_once '../db/connection.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location:index.php');
    exit;
}

$query = 'SELECT * FROM products WHERE id=:id';
$statement = $pdo->prepare($query);
$statement->execute(['id' => $id]);
$product = $statement->fetch(PDO::FETCH_ASSOC);

$title = $product['title'];
$description = $product['description'] ?? null;
$price = $product['price'];
$image = $product['image'] ?? null;

//update
$errors = array(
    'error_title' => '',
    'error_description' => '',
    'error_price' => '',
    'error_image' => ''
);

if (isset($_POST['submit'])) {
    require_once 'validate.php';

    if (!empty($image) && $image['tmp_name']) {
        if ($img) {
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

<?php include_once 'partials/header.php' ?>

<h4 class="text-center">Update Product for <strong><?php echo $title ?></strong></h4>

<?php include_once 'form.php' ?>

<?php include_once 'partials/footer.php' ?>