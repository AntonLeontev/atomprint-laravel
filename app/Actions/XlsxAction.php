<?php

namespace App\Actions;

use DomainException;
use Illuminate\Support\Facades\Storage;

class XlsxAction
{
	public function __construct(
		private XlsxToDbAction $saver, 
		private XlsxValidateAction $validator, 
	)
	{	  
	}

	public function __invoke(string $path)
	{
		$this->validator->validate($path);

		if($this->validator->fails()) {
			Storage::delete($path);
			
			throw new DomainException(implode('<br>', $this->validator->getErrors()));
		}

		$this->saver->save($path);

		Storage::delete($path);
	}
}
