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
		$this->logFrom();
	}

	/**
	 * Log from.
	 */
	private function logFrom()
	{
		$e = $this->it->event();
		$u = $e->message->from;

		$logger = new Logger\User($this->it->db(), $this->it->tg());
		$logger->setUser($u);
		$logger->execute();
	}
}
