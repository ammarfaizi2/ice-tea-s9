<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

namespace IceTeaS9;

use JsonSerializable;

abstract class TelegramObjFoundation implements JsonSerializable
{
	/**
	 * @param string $key
	 * @return mixed
	 */
	public function __get(string $key)
	{
		return $this->{$key};
	}

	/**
	 * @param array $data
	 */
	public static function create(array $data)
	{
		return new static($data);
	}
}
