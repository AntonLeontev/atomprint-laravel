@props([
	'column' => '',
	'title' => '',
	])

<div class="col hstack justify-content-center cursor-pointer" @click="sort('{{ $column }}')">
    {{ $title }}
    <span x-show="status.sort === '{{ $column }}'" x-transition x-cloak>
		<svg class="icon" :class="status.order === 'ASC' && 'icon_rotated'" 
			width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
        </svg>
    </span>
</div>
