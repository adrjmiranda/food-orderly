<div id="dish-list">
  <div class="container">
    <div class="content">
      <?php if (empty($items)): ?>
        <!-- TODO: say something -->
        <!-- ... -->
      <?php else: ?>
        <?php foreach ($items as $dish): ?>
          <?php require __DIR__ . "/dish-card.php"; ?>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>