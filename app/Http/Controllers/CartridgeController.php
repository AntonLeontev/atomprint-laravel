<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartridgeUpdateRequest;
use App\Models\Cartridge;
use App\ViewModels\CartridgeViewModel;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartridgeController extends Controller
{
    public function update(Cartridge $cartridge, CartridgeUpdateRequest $request)
	{
		$cartridge->updateOrFail($request->validated());

		return response()->json(['ok' => true]);
	}

	public function index(CartridgeViewModel $viewModel)
	{
		return response()->json($viewModel->index());
	}
}
