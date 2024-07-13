// TODO: in development
let baseUrl = 'http://localhost:8000';

const categoryButtons = document.querySelectorAll('.category-button');
const listContainer = document.querySelector('#dish-list .content');

// TODO: in development
const apiUrl = `${baseUrl}/api/v1`;

const getAllDishes = async (limit = '') => {
	try {
		const response = await fetch(
			apiUrl + `/dishes${limit ? '/' + limit : ''}`,
			{
				method: 'GET',
			}
		);

		if (!response.ok) {
			throw new Error(`HTTP error! status: ${response.status}`);
		}

		const res = await response.json();
		return res.data;
	} catch (e) {
		console.log(e.message);
		return null;
	}
};

const getDishesByCategory = async (categoryId) => {
	try {
		const response = await fetch(apiUrl + '/dishes/category/' + categoryId, {
			method: 'GET',
		});

		if (!response.ok) {
			throw new Error(`HTTP error! status: ${response.status}`);
		}

		const res = await response.json();
		return res.data;
	} catch (e) {
		console.log(e.message);
		return null;
	}
};

const updateListOfItems = (data) => {
	listContainer.innerHTML = null;

	data.forEach((dish) => {
		const innerContent = `
		<div class="dish-card">
			<div class="img">
				<img src="${baseUrl}/assets/img/dishes/${dish.image_name}" alt="${dish.name}">
			</div>
			<div class="info">
				<h3 class="name">${dish.name}</h3>
				<span class="price">$ ${dish.price}</span>
				<p class="description">
					${dish.description}
				</p>
				<button type="button" data-id=${dish.id} onclick="addToCart(event)" class="add-to-cart btn btn-secondary">Order</button>
			</div>
		</div>`;

		const item = document.createElement('div');
		item.innerHTML = innerContent;

		listContainer.appendChild(item);
	});
};

const storesAllItems = async () => {
	const data = await getAllDishes();
	sessionStorage.setItem('items', JSON.stringify(data));
};

(async () => {
	const data = await getAllDishes(12);
	updateListOfItems(data);
	storesAllItems();
})();

categoryButtons &&
	categoryButtons.forEach((button) => {
		button.addEventListener('click', async () => {
			categoryButtons.forEach((btn) => {
				btn.classList.remove('active');
			});

			button.classList.add('active');

			let categoryId = button.dataset.categoryId;
			let data = await getDishesByCategory(categoryId);

			updateListOfItems(data);
		});
	});
