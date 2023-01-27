<div class="row" x-show="cartridges.prev_page_url || cartridges.next_page_url" x-cloak>
	<div class="col d-flex justify-content-end">
		<button class="btn btn-outline-primary" :disabled="!cartridges.prev_page_url" @click="changePage"
			:data-link="cartridges.prev_page_url">
			Prev
		</button>
	</div>
	<div class="col d-flex justify-content-center align-items-center" x-text="cartridges.current_page"></div>
	<div class="col d-flex justify-content-start">
		<button class="btn btn-outline-primary" :disabled="!cartridges.next_page_url" @click="changePage"
			:data-link="cartridges.next_page_url">
			Next
		</button>
	</div>
</div>
