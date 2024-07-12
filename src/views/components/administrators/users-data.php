<?php if (empty($items)): ?>
  <p id="data-empty">No users registered in the system</p>
<?php else: ?>
  <div id="data">
    <table>
      <thead>
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>E-mail</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($items as $user): ?>
          <tr>
            <td><?= $user->id ?></td>
            <td><?= $user->first_name . " " . $user->last_name ?></td>
            <td><?= $user->email ?></td>
            <td><?= (new DateTime($user->created_at))->format('F jS, Y') ?></td>
            <td>
              <form action="#">
                <input type="hidden" name="id" value="<?= $user->id ?>">
                <button type="submit">
                  <i class="fa-solid fa-user"></i>
                </button>
              </form>

              <form action="/admin/user/remove" method="get">
                <input type="hidden" name="id" value="<?= $user->id ?>">
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
<?php endif; ?>