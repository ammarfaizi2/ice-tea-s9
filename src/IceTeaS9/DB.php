<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

namespace IceTeaS9;

use PDO;

class DB
{
	/**
	 * @var PDO
	 */
	private PDO $pdo;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->pdo = new PDO(...ICT_DB_PDO_ARGS);
	}

	/**
	 * @return DB
	 */
	public static function create(): DB
	{
		return new self;
	}

	/**
	 * @param string $name
	 * @param array  $arguments
	 * @return mixed
	 */
	public function __call(string $name, array $arguments)
	{
		return $this->pdo->{$name}(...$arguments);
	}
}
