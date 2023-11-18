<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

namespace IceTeaS9;

use Exception;

class Telegram
{
	/**
	 * @var ?array
	 */
	private ?array $data = NULL;

	/**
	 * @var resource
	 */
	private $curl = NULL;

	/*
	 * @param string $json
	 * @throws \Exception
	 */
	public function __construct(string $json)
	{
		$this->data = json_decode($json, true);
		if (!is_array($this->data))
			throw new Exception("Invalid JSON!");

		$this->curl = curl_init();
		if (!$this->curl)
			throw new Exception("Cannot initialize cURL!");
	}

	/**
	 * Destructor.
	 */
	public function __destruct()
	{
		@curl_close($this->curl);
	}

	/**
	 * @return array
	 */
	public function getData(): array
	{
		return $this->data;
	}

	/**
	 * @throws \Exception
	 * @return void
	 */
	public function reset(): void
	{
		curl_close($this->curl);
		$this->curl = curl_init();
		if (!$this->curl)
			throw new Exception("Cannot initialize cURL!");
	}

	/**
	 * @param string $name
	 * @param array  $arguments
	 * @return array
	 */
	public function __call(string $name, array $args): array
	{
		$url = sprintf("%s%s/%s", ICT_TG_BOT_ENDPOINT, ICT_TG_BOT_TOKEN, $name);

		curl_setopt_array($this->curl, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query($args[0]),
			CURLOPT_HTTPHEADER => [
				"Content-Type: application/x-www-form-urlencoded"
			]
		]);

		$out = curl_exec($this->curl);
		$err = curl_error($this->curl);
		$ern = curl_errno($this->curl);
		if ($ern || $err) {
			$this->reset();
			throw new Exception("cURL error: {$err} ({$ern})");
		}

		$out = json_decode($out, true);
		if (!is_array($out)) {
			$this->reset();
			throw new Exception("Invalid JSON!");
		}

		return $out;
	}
}
