<div id="cart-container">
  <div id="cart">
    <div class="cart-header">
      <div class="bag">
        <i class="fa-solid fa-bag-shopping"></i>
      </div>
      <div class="user-info">
        <img src="" alt="">
        <span class="user-name">
          <?= $_SESSION["user"]["first_name"] . " " . $_SESSION["user"]["last_name"] ?>
        </span>
      </div>
    </div>

    <h5>My order</h5>

    <div class="items-list">
      <div class="item-card">
        <img src="" alt="">

        <div class="item-info">
          <div class="info">
            <div class="name"></div>
            <div class="quantity">
              <button type="button" class="minus"><i class="fa-solid fa-minus"></i></button>
              <span>1</span>
              <button type="button" class="plus"><i class="fa-solid fa-plus"></i></button>
            </div>
          </div>
          <span class="price">$ 22.50</span>
        </div>

      </div>
    </div>

    <div class="total">
      <p>Total amount</p>
      <p>$ 12.58</p>
    </div>

    <a href="#" class="btn btn-primary">Checkout</a>
  </div>
</div>