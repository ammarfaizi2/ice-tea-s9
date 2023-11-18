<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

namespace IceTeaS9;

use Exception;
use JsonSerializable;
use IceTeaS9\TelegramObj\Chat;
use IceTeaS9\TelegramObj\User;
use IceTeaS9\TelegramObj\Message;
use IceTeaS9\TelegramObj\Chat\PrivateChat;
use IceTeaS9\TelegramObj\Chat\SuperGroup;

class TelegramEvent implements JsonSerializable
{
	/**
	 * @var int
	 */
	public int $update_id;

	/**
	 * @var ?Message
	 */
	public ?Message $message = NULL;

	/**
	 * Constructor.
	 * 
	 * @param array $data
	 */
	public function __construct(array $data)
	{
		$this->update_id = $data["update_id"];
		if (isset($data["message"]))
			$this->message = Message::create($data["message"]);
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array
	{
		$ret = [
			"update_id" => $this->update_id
		];

		if (isset($this->message))
			$ret["message"] = $this->message;

		return $ret;
	}

	/**
	 * @param string $key
	 * @return mixed
	 */
	public function __get(string $key)
	{
		return $this->{$key};
	}
}
