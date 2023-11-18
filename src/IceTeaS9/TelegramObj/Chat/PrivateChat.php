<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

namespace IceTeaS9\TelegramObj\Chat;

use IceTeaS9\TelegramObj\Chat;
use IceTeaS9\TelegramObj\UserTrait;

class PrivateChat extends Chat
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
	 * Constructor.
	 *
	 * @param array $data
	 */
	public function __construct(array $data)
	{
		$title = $data["first_name"];
		if (isset($data["last_name"]))
			$title .= " ".$data["last_name"];

		$data["title"] = $title;
		parent::__construct($data);
		$this->first_name = $data["first_name"];
		$this->last_name = $data["last_name"] ?? NULL;
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array
	{
		return [
			"id" => $this->id,
			"type" => "public",
			"username" => $this->username,
			"first_name" => $this->first_name,
			"last_name" => $this->last_name,
		];
	}
}
