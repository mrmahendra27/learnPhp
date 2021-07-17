<?php
 $title = htmlspecialchars($_POST['title']);
 $description = htmlspecialchars($_POST['description']);
 $price = htmlspecialchars($_POST['price']);
 $image = $_FILES['image'] ?? null;

 if (empty($title)) {
     $errors['error_title'] = 'Product Title is Required';
 }

 if (empty($price)) {
     $errors['error_price'] = 'Product Price is Required';
 }