<div class="vstack gap-2" x-data="files">
	<button class="btn btn-danger" x-show="!_.isEmpty(errors)" @click="showErrors" x-cloak>Смотреть ошибки</button>
	<form class="position-relative d-flex justify-content-center gap-2"
		action="{{ route('pricelists.upload') }}" method="post" enctype="multipart/form-data"
			
	>
		<input class="visually-hidden" id="file-input" type="file" name="file" @change="submit">
		<label for="file-input">
			<p class="btn btn-outline-primary h-100 d-flex align-items-center" title="Загрузить прайслист">
				<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-file-earmark-arrow-up-fill" viewBox="0 0 16 16">
					<path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM6.354 9.854a.5.5 0 0 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 8.707V12.5a.5.5 0 0 1-1 0V8.707L6.354 9.854z"/>
				</svg>
			</p>
		</label>
		
		<a class="btn btn-outline-primary d-flex align-items-center"  
		title="Скачать прайслист" role="button" @click.prevent="download">
			<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-file-earmark-arrow-down" viewBox="0 0 16 16">
				<path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293V6.5z"/>
				<path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
			</svg>
		</a>
		<div class="position-absolute top-0 end-0" x-show="loading" x-cloak>
			<div class="spinner-border spinner-border-sm" role="status">
				<span class="visually-hidden">Loading...</span>
			</div>
		</div>
	</form>
</div>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('files', () => ({
			errors: '',
			loading: false,
			async submit(event){
				this.loading = true;
				let response = await submitForm(event);

				this.errors = response?.errors;
				
				if(response?.ok === true) {
					this.$dispatch('toast-success', {message: 'Прайс обновлен'})
				}
				
				this.loading = false;
			},
			showErrors(){
				this.$dispatch('errors-button-click', {
					title: 'Ошибки в файле', 
					body: this.errors,
				});
			},
			async download(){
				this.loading = true;
				
				await axios.get(
					"{{ route('pricelists.download') }}", 
					{responseType: 'blob'}
				)
				.then(response => {
					this.giveFile(response.data);
				});

				this.loading = false;
			},
			giveFile(data){
				let blob = new Blob([data]);

				let link = document.createElement('a');
				link.download = `pricelist-${(new Date).toISOString()}.xlsx`;
				link.href = URL.createObjectURL(blob);

				link.click();

				URL.revokeObjectURL(link.href);
			}
		}))
	})
</script>
