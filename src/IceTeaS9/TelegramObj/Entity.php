<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

namespace IceTeaS9\TelegramObj;

use IceTeaS9\TelegramObjFoundation;

class Entity extends TelegramObjFoundation
{
	/**
	 * @var int
	 */
	public int $offset;

	/**
	 * @var int
	 */
	public int $length;

	/**
	 * @var string
	 */
	public string $type;

	/**
	 * @var ?User
	 */
	public ?User $user = NULL;

	/**
	 * @var ?string
	 */
	public ?string $url = NULL;

	/**
	 * @var ?string
	 */
	public ?string $text = NULL;

	/**
	 * Constructor.
	 * 
	 * @param array $data
	 */
	public function __construct(array $data)
	{
		$this->offset = $data["offset"];
		$this->length = $data["length"];
		$this->type = $data["type"];

		if (isset($data["user"]))
			$this->user = User::create($data["user"]);

		if (isset($data["url"]))
			$this->url = $data["url"];

		if (isset($data["text"]))
			$this->text = $data["text"];
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array
	{
		$ret = [
			"offset" => $this->offset,
			"length" => $this->length,
			"type" => $this->type
		];

		if (isset($this->user))
			$ret["user"] = $this->user;

		if (isset($this->url))
			$ret["url"] = $this->url;

		if (isset($this->text))
			$ret["text"] = $this->text;

		return $ret;
	}
}
