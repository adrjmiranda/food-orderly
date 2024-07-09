<?php
/**
 * @var Src\Config\Template\View $this
 */

$this->extend('administrators/master', [
  "page_title" => "Requests"
]);
?>

<div id="dashboard">
  <div class="container">
    <!-- Session Bar -->

    <div class="sessions-bar">
      <ul>
        <li><a href="#">Requests</a></li>
        <li><a href="#">Users</a></li>
        <li><a href="#">Dishes</a></li>
        <li><a href="#">Add new dish</a></li>
      </ul>
    </div>

    <!-- Search Area -->

    <div class="search-area">
      <form action="#" class="search-form">
        <input type="search" name="search" placeholder="Search for order">
        <button type="submit">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      </form>

      <form action="#" class="order-form">
        <select name="order">
          <option value="production">production</option>
          <option value="sent">sent</option>
          <option value="delivered">delivered</option>
          <option value="recent">recent</option>
          <option value="old">old</option>
        </select>

        <button type="submit">
          <i class="fa-solid fa-arrows-rotate"></i>
        </button>
      </form>
    </div>

    <!-- Data -->

    <div class="data">
      <table>
        <thead>
          <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Amount</th>
            <th>Date</th>
            <th>User</th>
            <th>Actions</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>1</td>
            <td>Special pasta</td>
            <td>2</td>
            <td>$ 58.69</td>
            <td>August 2, 2022</td>
            <td>John Doe</td>
            <td>
              <select name="action">
                <option value="production">production</option>
                <option value="sent">sent</option>
                <option value="delivered">delivered</option>
              </select>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>