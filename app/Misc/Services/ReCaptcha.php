<?php

/*

 * Recapture
 * Project: Rai
 * Developed by Rai Omido
 * Copyright (C) Sep 13, 2017 Rai Omido
 * <raiomido@gmail.com>
 * UTF-8
 * 1:10:41 PM
 */

namespace App\Misc\Services\Helpers;

use GuzzleHttp\Client;

class ReCaptcha
{

	public function validate ($attribute, $value, $parameters, $validator)
	{
		$client = new Client();

		$response = $client->post(
			'https://www.google.com/recaptcha/api/siteverify', ['form_params' =>
				[
					'secret' => config('sys.settings.recaptcha.secret'),
					'response' => $value
				]
			]
		);
		$body = json_decode((string)$response->getBody());

		return $body->success;
	}

}
