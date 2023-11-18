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
	private int $id;

	/**
	 * @var string
	 */
	private string $first_name;

	/**
	 * @var ?string
	 */
	private ?string $last_name = NULL;

	/**
	 * @var ?string
	 */
	private ?string $username = NULL;

	/**
	 * @var ?string
	 */
	private ?string $language_code = NULL;

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
