<div id="session-bar">
  <ul>
    <li><a href="/admin/dashboard/orders" class="<?= $session === "orders" ? "active" : "" ?>">Orders</a></li>
    <li><a href="/admin/dashboard/users" class="<?= $session === "users" ? "active" : "" ?>">Users</a></li>
    <li><a href="/admin/dashboard/dishes" class="<?= $session === "dishes" ? "active" : "" ?>">Dishes</a></li>
    <li><a href="#">Add new dish</a></li>
  </ul>
</div>