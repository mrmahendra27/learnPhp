<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="title" class="form-label">Product Title</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="<?php echo htmlspecialchars($title) ?>">
        <div class="red-text"><?php echo $errors['error_title'] ?></div>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Product Image</label>
        <input type="file" class="form-control" id="image" name="image">
        <div class="red-text"><?php echo $errors['error_image'] ?></div>
        <div class="mb-3">
            <?php if ($image) : ?>
                <a href="<?php echo $image ?>" target="_blank">
                    <img class="update-image" src="<?php echo $image ?>" alt="">
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Product Price(₹)</label>
        <input type="number" class="form-control" id="price" name="price" placeholder="Enter Price(₹)" value="<?php echo htmlspecialchars($price) ?>">
        <div class="red-text"><?php echo $errors['error_price'] ?></div>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Product Description</label>
        <textarea class="form-control" id="description" name="description" placeholder="Enter Description"><?php echo htmlspecialchars($description) ?></textarea>
        <div class="red-text"><?php echo $errors['error_description'] ?></div>
    </div>
    <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
</form>