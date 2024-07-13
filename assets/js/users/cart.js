const cartIcon = document.querySelector('#show-cart');
const cartQuantity = document.querySelector('#show-cart span');
const cartTotal = document.querySelector('#cart .total span');
const innerCart = document.querySelector('#cart .items-list');

const items = JSON.parse(sessionStorage.getItem('items'));
const cartItems = JSON.parse(sessionStorage.getItem('cartItems') || '[]');

const updateCartTotal = (cartItems) => {
	const total = cartItems.reduce((total, dish) => {
		return (total += dish.quantity * dish.price);
	}, 0);

	return total;
};

const removeItem = (event) => {
	const dishId = parseInt(event.target.dataset.id);
	const indexToRemove = cartItems.findIndex((item) => item.id === dishId);

	if (indexToRemove !== -1) {
		cartItems.splice(indexToRemove, 1);
	}

	updateCart(cartItems);
};

const removeOne = (event) => {
	const dishId = parseInt(event.target.dataset.id);
	const dishItem = cartItems.find((item) => item.id === dishId);

	if (dishItem) {
		if (dishItem.quantity <= 1) {
			const indexToRemove = cartItems.findIndex(
				(item) => item.id === dishItem.id
			);
			cartItems.splice(indexToRemove, 1);
		} else {
			dishItem.quantity -= 1;
		}
	}

	updateCart(cartItems);
};

const addOne = (event) => {
	const dishId = parseInt(event.target.dataset.id);
	const dishItem = cartItems.find((item) => item.id === dishId);

	if (dishItem) {
		if (dishItem.quantity < 1) {
			dishItem.quantity = 1;
		} else {
			dishItem.quantity += 1;
		}
	}

	updateCart(cartItems);
};

const updateCart = (cartItems) => {
	innerCart.innerHTML = null;

	cartItems.forEach((item) => {
		const card = document.createElement('div');
		card.innerHTML = `
			<div class="cart-item">
        <img
          src="${baseUrl}/assets/img/dishes/${item.image_name}"
          alt="${item.name}">

        <div class="item-info">
          <div class="info">
            <div class="name">${item.name}</div>
            <div class="quantity">
              <button type="button" data-id="${item.id}" onclick="removeOne(event)" class="minus"><i class="fa-solid fa-minus"></i></button>
              <span>${item.quantity}</span>
              <button type="button" data-id="${item.id}" onclick="addOne(event)" class="plus"><i class="fa-solid fa-plus"></i></button>
            </div>
          </div>

          <span class="price">$ ${item.price}</span>
        </div>

        <button type="button" data-id="${item.id}" onclick="removeItem(event)" class="remove-item">
          <i class="fa-regular fa-trash-can"></i>
        </button>
      </div>
		`;

		innerCart.appendChild(card);
	});

	if (cartItems.length === 0) {
		cartIcon.style.display = 'none';
	} else {
		cartQuantity.innerHTML = cartItems.length;
	}

	cartTotal.innerHTML = updateCartTotal(cartItems);

	sessionStorage.setItem('cartItems', JSON.stringify(cartItems));
};

const addToCart = (event) => {
	const dishId = parseInt(event.target.dataset.id);
	const dishItem = items.find((item) => item.id === dishId);

	if (dishItem) {
		const cartItem = cartItems.find((item) => item.id === dishId);

		if (cartItem) {
			cartItem.quantity += 1;
		} else {
			cartItems.push({ ...dishItem, quantity: 1 });
		}
	}

	updateCart(cartItems);
};

updateCart(cartItems);
