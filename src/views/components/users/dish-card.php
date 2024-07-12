<div class="dish-card">
  <div class="img">
    <img src="<?= $base_url ?>/assets/img/dishes/<?= $dish->image_name ?>" alt="<?= $dish->name ?>">
  </div>
  <div class="info">
    <h3 class="name"><?= $dish->name ?></h3>
    <span class="price">$ <?= $dish->price ?></span>
    <p class="description">
      <?= $dish->description ?>
    </p>

    <a href="#" class="btn btn-secondary">Order</a>
  </div>

</div>