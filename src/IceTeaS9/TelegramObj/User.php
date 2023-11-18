<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

namespace IceTeaS9\TelegramObj;

use IceTeaS9\TelegramObjFoundation;

class User extends TelegramObjFoundation
{
	/**
	 * @var int
	 */
	public int $id;

	/**
	 * @var string
	 */
	public string $first_name;

	/**
	 * @var ?string
	 */
	public ?string $last_name = NULL;

	/**
	 * @var ?string
	 */
	public ?string $username = NULL;

	/**
	 * @var ?string
	 */
	public ?string $language_code = NULL;

	/**
	 * @var ?bool
	 */
	public bool $is_bot = false;

	/**
	 * @var bool
	 */
	public bool $is_premium = false;

	/**
	 * Constructor.
	 *
	 * @param array $data
	 */
	public function __construct(array $data)
	{
		$this->id = $data["id"];
		$this->first_name = $data["first_name"];
		$this->last_name = $data["last_name"] ?? NULL;
		$this->username = $data["username"] ?? NULL;
		$this->language_code = $data["language_code"] ?? NULL;

		if (isset($data["is_bot"]))
			$this->is_bot = (bool)$data["is_bot"];

		if (isset($data["is_premium"]))
			$this->is_premium = (bool)$data["is_premium"];
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array
	{
		return [
			"id" => $this->id,
			"first_name" => $this->first_name,
			"last_name" => $this->last_name,
			"username" => $this->username,
			"language_code" => $this->language_code,
			"is_bot" => $this->is_bot,
			"is_premium" => $this->is_premium
		];
	}
}
