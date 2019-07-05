function previewFiles() {

	let preview = document.querySelector('#imagens-carregadas');
	let files = document.querySelector('#adicionar-foto').files;

	function readAndPreview(file) {

		let reader = new FileReader();
		reader.addEventListener("load", function () {
			let image = new Image();
			image.height = 100;
			image.width = 100;
			image.title = file.name;
			// noinspection JSValidateTypes
			image.src = this.result;
			preview.appendChild(image);
		}, false);

		reader.readAsDataURL(file);

	}

	if (files) {

		[].forEach.call(files, readAndPreview);
	}
}

