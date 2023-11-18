<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

namespace IceTeaS9;

class DataLogger
{
	/**
	 * @var IceTea
	 */
	private IceTea $it;

	/**
	 * Constructor.
	 *
	 * @param IceTea $it
	 */
	public function __construct(IceTea $it)
	{
		$this->it = $it;
	}

	/**
	 * Execute.
	 */
	public function execute()
	{
	}
}
