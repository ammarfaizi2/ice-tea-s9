<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

namespace IceTeaS9;

abstract class LoggerFoundation
{
	/**
	 * @var DB
	 */
	protected DB $db;

	/**
	 * @var Telegram
	 */
	protected Telegram $tg;

	/**
	 * Constructor.
	 *
	 * @param DB       $db
	 * @param Telegram $tg
	 */
	public function __construct(DB $db, Telegram $tg)
	{
		$this->db = $db;
		$this->tg = $tg;
	}

	abstract public function execute();
}
