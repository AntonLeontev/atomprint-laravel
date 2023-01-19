window.submitForm = async function(event) {
	let form = event.target.closest("form");
    let formData = new FormData(form);

	if (! _.isObjectLike(formData)) {
		return;
	}

    let result;

    await axios
        .request({
            url: form.action,
            method: form.method,
            data: formData,
        })
        .then((response) => {
			console.log('then', response);
            if (response.error) {
                handleServerError(response.error);
                return;
            }
            result = response.data;
        })
        .catch((response) => {
			console.log('Error', response);
            if (response.response.data.errors) {
                handleValidationError(response.response.data.errors);
                return;
            }

            if (response.response.data.exception) {
                handleServerError(response.response.data.message);
                return;
            }

            console.log("Ошибка, которой нет в обработчике");
        });

    if (result) {
        return result;
    }
};

function handleValidationError(errors) {
    Alpine.store("app").validationErrors = errors;
}

function handleServerError(message) {
    Alpine.store("app").serverErrorMessage = message;
    Alpine.store("app").serverError = true;
}
