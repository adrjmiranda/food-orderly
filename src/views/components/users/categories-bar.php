<div id="categories-bar">
  <div class="container">
    <ul class="categories">
      <?php foreach ($categories as $category): ?>
        <li>
          <a href="/">
            <img src="<?= $base_url ?>/assets/img/categories/<?= $category->image_name . ".jpg" ?>"
              alt="<?= $category->name ?>">
            <span><?= $category->name ?></span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>