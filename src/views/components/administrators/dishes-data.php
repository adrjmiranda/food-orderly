<div id="data">
  <table>
    <thead>
      <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Date</th>
        <th>Category</th>
        <th>Price</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($items as $dish): ?>
        <tr>
          <td><?= $dish->id ?></td>
          <td><?= $dish->name ?></td>
          <td><?= (new DateTime($dish->updated_at))->format('F jS, Y') ?></td>
          <td>
            <?php foreach ($categories as $category): ?>
              <?php if ($category->id === $dish->category_id): ?>
                <?= $category->name ?>
              <?php endif; ?>
            <?php endforeach; ?>
          </td>
          <td>
            $ <?= $dish->price ?>
          </td>
          <td>
            <form action="/admin/dish/edit" method="get">
              <input type="hidden" name="id" value="<?= $dish->id ?>">
              <button type="submit">
                <i class="fa-regular fa-pen-to-square"></i>
              </button>
            </form>

            <form action="/admin/dish/remove" method="get">
              <input type="hidden" name="id" value="<?= $dish->id ?>">
              <button type="submit">
                <i class="fa-solid fa-trash-can"></i>
              </button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>