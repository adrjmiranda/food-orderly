<div id="cart-container">
  <div id="cart">
    <div class="cart-header">
      <button type="button" id="close-cart">
        <i class="fa-solid fa-angles-right"></i>
      </button>
      <h5>My order</h5>
    </div>


    <div class="items-list">
      <div class="cart-item">
        <img
          src="<?= $base_url ?>/assets/img/dishes/78d469e138acd9b77597fcab1f561ad602c62e0159b47b898f21f9403a4896e9eb10ff2a5bd7c73136379a5c66d69cfb.jpg"
          alt="...">

        <div class="item-info">
          <div class="info">
            <div class="name">Super cake cake cake cake</div>
            <div class="quantity">
              <button type="button" class="minus"><i class="fa-solid fa-minus"></i></button>
              <span>1</span>
              <button type="button" class="plus"><i class="fa-solid fa-plus"></i></button>
            </div>
          </div>

          <span class="price">$ 22.50</span>
        </div>

        <button type="button" class="remove-item">
          <i class="fa-regular fa-trash-can"></i>
        </button>
      </div>
    </div>

    <div class="total">
      <p>Total amount</p>
      <p>$ 12.58</p>
    </div>

    <a href="#" class="btn btn-primary">Checkout</a>
  </div>
</div>