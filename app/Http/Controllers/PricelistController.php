<?php

namespace App\Http\Controllers;

use App\Actions\DbToXlsxAction;
use App\Actions\XlsxAction;
use App\Http\Requests\PricelistUploadRequest;
use App\ViewModels\CartridgeViewModel;
use DomainException;
use Illuminate\Http\Request;

class PricelistController extends Controller
{
    public function upload(
		PricelistUploadRequest $request, 
		XlsxAction $action,
	)
	{
		$path = $request->file('file')->store('public/cartridges');
		
		try {
			$action($path);
		} catch (DomainException $e) {
			return response()->json(['errors' => $e->getMessage()]);
		}

		return response()->json(['ok' => true]);
	}

	public function download(CartridgeViewModel $viewModel, DbToXlsxAction $action)
	{
		$action($viewModel->forXlsx());
	}
}
