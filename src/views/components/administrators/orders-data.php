<?php if (empty($items)): ?>
  <p id="data-empty">There are no orders</p>
<?php else: ?>
  <div id="data">
    <table>
      <thead>
        <tr>
          <th>Id</th>
          <th>Customer</th>
          <th>Time</th>
          <th>Amount</th>
          <th>Actions</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($items as $order): ?>
          <tr>
            <td><?= $order->id ?></td>
            <td><?= $order->customers_first_name . " " . $order->customers_last_name ?></td>
            <td><?= (new DateTime($order->created_at))->format('F jS, Y') ?></td>
            <td>$ <?= $order->amount ?></td>
            <td>
              <form action="#">
                <select name="action">
                  <option value="production">production</option>
                  <option value="sent">sent</option>
                  <option value="delivered">delivered</option>
                </select>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>