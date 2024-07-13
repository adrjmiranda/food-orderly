<?php
/**
 * @var Src\Config\Template\View $this
 */

$this->extend('users/master', [
  "page_title" => "Payment",
  "scripts" => [
    "cart"
  ]
]);
?>

<div id="payment-area">
  <div class="container">
    <div class="content">
      <!-- User info -->

      <div class="user-info">
        <h1>Payment Information</h1>

        <form action="/payment" method="post">
          <!-- Address info -->

          <div class="row">
            <div class="input-field">
              <label for="first-name">First name</label>
              <input type="text" name="first_name" id="first-name" placeholder="Your first name"
                value="<?= isset($user->first_name) ? $user->first_name : "" ?>">

              <?php if (isset($errors["first_name"])): ?>
                <p class="form-error"><?= $errors["first_name"] ?></p>
              <?php endif; ?>
            </div>

            <div class="input-field">
              <label for="last-name">Last name</label>
              <input type="text" name="last_name" id="last-name" placeholder="Your last name"
                value="<?= isset($user->last_name) ? $user->last_name : "" ?>">

              <?php if (isset($errors["last_name"])): ?>
                <p class="form-error"><?= $errors["last_name"] ?></p>
              <?php endif; ?>
            </div>
          </div>

          <div class="row">
            <div class="input-field">
              <label for="street">Street</label>
              <input type="text" name="street" id="street" placeholder="Your street"
                value="<?= isset($user->street) ? $user->street : "" ?>">

              <?php if (isset($errors["street"])): ?>
                <p class="form-error"><?= $errors["street"] ?></p>
              <?php endif; ?>
            </div>

            <div class="input-field">
              <label for="number">Number</label>
              <input type="text" name="number" id="number" placeholder="Number"
                value="<?= isset($user->number) ? $user->number : "" ?>">

              <?php if (isset($errors["number"])): ?>
                <p class="form-error"><?= $errors["number"] ?></p>
              <?php endif; ?>
            </div>
          </div>

          <div class="row">
            <div class="input-field">
              <label for="neighborhood">Neighborhood</label>
              <input type="text" name="neighborhood" id="neighborhood" placeholder="Your neighborhood"
                value="<?= isset($user->neighborhood) ? $user->neighborhood : "" ?>">

              <?php if (isset($errors["neighborhood"])): ?>
                <p class="form-error"><?= $errors["neighborhood"] ?></p>
              <?php endif; ?>
            </div>

            <div class="input-field">
              <label for="complement">Complement</label>
              <input type="text" name="complement" id="complement" placeholder="Complement (optional)"
                value="<?= isset($user->complement) ? $user->complement : "" ?>">

              <?php if (isset($errors["complement"])): ?>
                <p class="form-error"><?= $errors["complement"] ?></p>
              <?php endif; ?>
            </div>
          </div>

          <!-- Payment info -->

          <div class="row">
            <div class="input-field">
              <label for="cardholder">Cardholder</label>
              <input type="text" name="name_on_credit_card" id="cardholder" placeholder="Cardholder"
                value="<?= isset($user->name_on_credit_card) ? $user->name_on_credit_card : "" ?>">

              <?php if (isset($errors["name_on_credit_card"])): ?>
                <p class="form-error"><?= $errors["name_on_credit_card"] ?></p>
              <?php endif; ?>
            </div>

            <div class="input-field">
              <label for="person-code">CPF/CNPJ</label>
              <input type="text" name="person_code" id="person-code" placeholder="Person code"
                value="<?= isset($user->person_code) ? $user->person_code : "" ?>">

              <?php if (isset($errors["person_code"])): ?>
                <p class="form-error"><?= $errors["person_code"] ?></p>
              <?php endif; ?>
            </div>
          </div>

          <div class="row">
            <div class="input-field">
              <label for="card-number">Card number</label>
              <input type="text" name="card_number" id="card-number" placeholder="Your card number"
                value="<?= isset($user->card_number) ? $user->card_number : "" ?>">

              <?php if (isset($errors["card_number"])): ?>
                <p class="form-error"><?= $errors["card_number"] ?></p>
              <?php endif; ?>
            </div>

            <div class="input-field">
              <label for="complement">Validity</label>
              <input type="text" name="validity" id="complement" placeholder="00/00"
                value="<?= isset($user->validity) ? $user->validity : "" ?>">

              <?php if (isset($errors["validity"])): ?>
                <p class="form-error"><?= $errors["validity"] ?></p>
              <?php endif; ?>
            </div>

            <div class="input-field">
              <label for="cvv">CVV</label>
              <input type="text" name="cvv" id="cvv" placeholder="000"
                value="<?= isset($user->cvv) ? $user->cvv : "" ?>">

              <?php if (isset($errors["cvv"])): ?>
                <p class="form-error"><?= $errors["cvv"] ?></p>
              <?php endif; ?>
            </div>
          </div>

          <div class="input-field">
            <button type="submit" class="btn btn-secondary">Finalize purchase</button>
          </div>
        </form>
      </div>

      <!-- Cart info -->

      <div class="cart-info">
        <h3>My order</h3>

        <div id="cart">

          <div class="items-list">
            <!-- Filled in cart -->
          </div>

          <div class="total">
            <p>Total amount</p>
            <p><span></span></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>