const items = JSON.parse(sessionStorage.getItem('items'));
const cartItems = [];

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

	console.log(cartItems);
};
