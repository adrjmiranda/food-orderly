const showCartButton = document.querySelector('#show-cart');
const hideCartButton = document.querySelector('#hide-cart');

const cartContainer = document.querySelector('#cart-container');
const cart = document.querySelector('#cart');

showCartButton &&
	showCartButton.addEventListener('click', () => {
		cartContainer.classList.remove('hide');
		cart.classList.remove('hide');

		cartContainer.classList.add('show');
		cart.classList.add('show');
	});

hideCartButton &&
	hideCartButton.addEventListener('click', () => {
		cartContainer.classList.add('hide');
		cart.classList.add('hide');

		cartContainer.classList.remove('show');
		cart.classList.remove('show');
	});
