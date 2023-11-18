<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

namespace IceTeaS9;

class Mutex
{
	/*
	 * @var resource
	 */
	private $handle;

	/**
	 * Constructor.
	 *
	 * @param string $key
	 */
	public function __construct(string $key)
	{
		$lock_file = "/tmp/ice-tea-s9-{$key}.lock";
		$this->handle = fopen($lock_file, "a+");
		if (!$this->handle)
			throw new Exception("Cannot open lock file: {$lockFile}");
	}

	/**
	 * @return bool
	 */
	public function lock(): bool
	{
		return flock($this->handle, LOCK_EX);
	}

	/**
	 * @return bool
	 */
	public function try_lock(): bool
	{
		return flock($this->handle, LOCK_EX | LOCK_NB);
	}

	/**
	 * @return bool
	 */
	public function unlock(): bool
	{
		return flock($this->handle, LOCK_UN);
	}

	/**
	 * Destructor.
	 */
	public function __destruct()
	{
		fclose($this->handle);
	}
}
