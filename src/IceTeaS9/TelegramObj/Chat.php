<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

namespace IceTeaS9\TelegramObj;

use IceTeaS9\TelegramObjFoundation;
use IceTeaS9\TelegramObj\Chat\PrivateChat;
use IceTeaS9\TelegramObj\Chat\SuperGroup;

abstract class Chat extends TelegramObjFoundation
{
	/**
	 * @var int
	 */
	public int $id;

	/**
	 * @var string
	 */
	public string $title;

	/**
	 * @var ?string
	 */
	public ?string $type = NULL;

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
		$this->id = $data["id"];
		$this->title = $data["title"];
		$this->type = $data["type"] ?? NULL;
		$this->username = $data["username"] ?? NULL;
	}

	/**
	 * @return Chat
	 */
	public static function create(array $data): Chat
	{
		switch ($data["type"]) {
		case "private":
			return new PrivateChat($data);
		case "supergroup":
			return new SuperGroup($data);
		default:
			throw new Exception("Unsupported chat type: {$data["type"]}");
		}
	}

	public function jsonSerialize(): array
	{
		return [
			"id" => $this->id,
			"title" => $this->title,
			"type" => $this->type,
			"username" => $this->username
		];
	}
}
