<?php

include_once '../../db/connection.php';

$title = $description = $price = $image = '';
$errors = array(
    'error_title' => '',
    'error_description' => '',
    'error_price' => '',
    'error_image' => ''
);

if (isset($_POST['submit'])) {

    $img = '';

    require_once '../../views/validate.php';

    if (!empty($image) && $image['tmp_name']) {
        if (!is_dir('images')) {
            mkdir('images');
        }

        $img = 'images/' . $title . rand(10000, 99999) . $image['name'];
        move_uploaded_file($image['tmp_name'], $img);
    }

    if (array_filter($errors)) {
        //
    } else {
        $query = 'INSERT INTO products(title, image, price, description) VALUES(:title, :image, :price, :description)';
        $statement = $pdo->prepare($query);
        $statement->execute(['title' => $title, 'image' => $img,  'price' => $price, 'description' => $description]);
        header('Location:index.php');
    }
}

?>

<?php include_once '../../views/partials/header.php' ?>

<h4 class="text-center">Add Product</h4>

<?php include_once '../../views/form.php' ?>

<?php include_once '../../views/partials/footer.php' ?>