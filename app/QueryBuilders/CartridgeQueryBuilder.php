<?php

namespace App\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class CartridgeQueryBuilder extends Builder
{
	public function filter(): CartridgeQueryBuilder
	{
		return $this->when(request()->has('vendor'), function(Builder $query){
			$query->whereIn('vendor_id', request('vendor'));
		})
		->when(request()->has('color'), function(Builder $query){
			$query->whereIn('color_id', request('color'));
		});
	}

	public function sort(): CartridgeQueryBuilder
	{
		return $this->when(request()->has('sort'), function(Builder $query){
			$query->orderBy(request('sort'), request('order', 'ASC'));
		});
	}

	public function search(): CartridgeQueryBuilder
	{
		return $this->when(request()->has('search'), function(Builder $query){
			$query->where(function($query){
				$query->where('cartridges.title', 'like', '%'.request('search').'%')
					->orWhere('cartridges.printers', 'like', '%'.request('search').'%');
			});
		});
	}
}
