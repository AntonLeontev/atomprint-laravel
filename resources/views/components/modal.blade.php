<div class="modal" id="modal" tabindex="-1" x-data="modal" @errors-button-click.window="show">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" x-text="title">Modal title</h5>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body" x-html="body">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Закрыть</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('modal', () => ({
            title: '',
			body: '',
            modal: new bootstrap.Modal('.modal'),
            show(event) {
				this.title = event.detail.title;
				this.body = event.detail.body;
                this.modal.show();
            }
        }))
    })
</script>
