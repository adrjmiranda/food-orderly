<div id="categories-bar">
  <div class="container">
    <ul class="categories">
      <?php foreach ($categories as $category): ?>
        <li>
          <button type="button" class="category-button" data-category-id="<?= $category->id ?>">
            <img src="<?= $base_url ?>/assets/img/categories/<?= $category->image_name . ".jpg" ?>"
              alt="<?= $category->name ?>">
            <span><?= $category->name ?></span>
          </button>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>