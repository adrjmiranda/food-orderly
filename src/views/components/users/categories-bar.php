<div id="categories-bar">
  <div class="container">
    <ul class="categories">
      <li>
        <button type="button" class="category-button active" data-category-id="">
          <img src="<?= $base_url ?>/assets/img/chef-hat.png" alt="All Categories">
          <span>All</span>
        </button>
      </li>

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