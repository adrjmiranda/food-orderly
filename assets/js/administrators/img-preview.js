const fileInput = document.querySelector('#image-file');
const imagePreviewBox = document.querySelector('#image-preview');

fileInput.addEventListener('change', () => {
	let reader = new FileReader();
	reader.onload = function () {
		imagePreviewBox.style.backgroundImage = `url(${reader.result})`;
		imagePreviewBox.style.backgroundSize = 'cover';
	};
	reader.readAsDataURL(event.target.files[0]);
});
