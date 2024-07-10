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

    <form action="#" id="data-form">
      <!-- TODO: fill csrf value -->
      <input type="hidden" name="csrf" value="">

      <div class="col">
        <div class="input-field">
          <label for="image-name">Image</label>
          <input type="file" name="image_name" id="image-name">
        </div>

        <div class="input-field">
          <label for="name">Name</label>
          <input type="text" name="name" id="name" placeholder="Name of the dish">
        </div>

        <div class="input-field">
          <label for="description">Description</label>
          <textarea name="description" id="description" placeholder="Description of the dish" rows="4"></textarea>
        </div>

        <div class="input-field">
          <label for="price">Price</label>
          <input type="text" name="price" id="price" placeholder="Price of the dish">
        </div>

        <div class="input-field">
          <label for="category">Category</label>
          <select name="category" id="category">
            <option value="" selected disabled>Choose a category</option>
            <?php foreach ($items as $category): ?>
              <option value="<?= $category->id ?>"><?= $category->name ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="col">
        <div id="image-preview" style="background-image: url('<?= $base_url ?>/assets/img/empty-plate.png');"></div>
      </div>

      <button class="btn btn-primary">Create</button>
    </form>
  </div>
</div>