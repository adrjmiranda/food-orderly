<div id="categories-bar">
  <div class="container">
    <ul class="categories">
      <?php foreach ($categories as $category): ?>
        <li>
          <img src="<?= $base_url ?>/assets/img/categories/<?= $category->image_name . ".jpg" ?>"
            alt="<?= $category->name ?>">
          <span><?= $category->name ?></span>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>