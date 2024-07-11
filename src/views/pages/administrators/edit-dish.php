<?php
/**
 * @var Src\Config\Template\View $this
 */

$this->extend('administrators/master', [
  "page_title" => "New dish"
]);
?>

<div id="dashboard">
  <div class="container">
    <!-- Session Bar -->

    <?php require_once __DIR__ . "/../../components/administrators/session-bar.php"; ?>

    <!-- Data Form -->

    <form action="/admin/dish/update" method="post" enctype="multipart/form-data" id="data-form">

      <!-- TODO: fill csrf value -->
      <input type="hidden" name="csrf" value="">
      <input type="hidden" name="id" value="<?= isset($dish->id) ? $dish->id : "" ?>">

      <div class="col">
        <?php if (isset($errors["update_error"])): ?>
          <p class="form-error"><?= $errors["update_error"] ?></p>
        <?php endif; ?>

        <div class="input-field">
          <label for="image-file">Image</label>
          <input type="file" name="image_file" id="image-file">

          <?php if (isset($errors["image_file"])): ?>
            <p class="form-error"><?= $errors["image_file"] ?></p>
          <?php endif; ?>
        </div>

        <div class="input-field">
          <label for="name">Name</label>
          <input type="text" name="name" id="name" placeholder="Name of the dish"
            value="<?= isset($dish->name) ? $dish->name : "" ?>">

          <?php if (isset($errors["name"])): ?>
            <p class="form-error"><?= $errors["name"] ?></p>
          <?php endif; ?>
        </div>

        <div class="input-field">
          <label for="description">Description</label>
          <textarea name="description" id="description" placeholder="Description of the dish"
            rows="4"><?= isset($dish->description) ? $dish->description : "" ?></textarea>

          <?php if (isset($errors["description"])): ?>
            <p class="form-error"><?= $errors["description"] ?></p>
          <?php endif; ?>
        </div>

        <div class="input-field">
          <label for="price">Price</label>
          <input type="text" name="price" id="price" placeholder="Price of the dish"
            value="<?= isset($dish->price) ? $dish->price : "" ?>">

          <?php if (isset($errors["price"])): ?>
            <p class="form-error"><?= $errors["price"] ?></p>
          <?php endif; ?>
        </div>

        <div class="input-field">
          <label for="category">Category</label>
          <select name="category" id="category">
            <option value="">Choose a category</option>
            <?php foreach ($categories as $category): ?>
              <option value="<?= $category->id ?>" <?= ($dish->category_id ?? null) === $category->id ? "selected" : "" ?>>
                <?= $category->name ?>
              </option>
            <?php endforeach; ?>
          </select>

          <?php if (isset($errors["category"])): ?>
            <p class="form-error"><?= $errors["category"] ?></p>
          <?php endif; ?>
        </div>
      </div>

      <div class="col">
        <div id="image-preview" style="background-image: url('<?= $base_url ?>/assets/img/empty-plate.png');"></div>
      </div>

      <button class="btn btn-primary">Update</button>
    </form>
  </div>
</div>