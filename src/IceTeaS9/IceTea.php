<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

namespace IceTeaS9;

use IceTeaS9\Logger;
use IceTeaS9\Logger\User;

class IceTea
{
	/**
	 * @var ?DB
	 */
	private ?DB $db = NULL;

	/**
	 * @var Telegram
	 */
	private Telegram $tg;

	/**
	 * @var TelegramEvent
	 */
	private TelegramEvent $event;

	/**
	 * Constructor.
	 *
	 * @param string $json
	 */
	public function __construct(string $json)
	{
		$this->tg = new Telegram($json);
		$this->event = new TelegramEvent($this->tg->getData());
	}

	/**
	 * @return DB
	 */
	public function db(): DB
	{
		if (!isset($this->db))
			$this->db = new DB;

		return $this->db;
	}

	/**
	 * @return Telegram
	 */
	public function tg(): Telegram
	{
		return $this->tg;
	}

	/**
	 * @return TelegramEvent
	 */
	public function event(): TelegramEvent
	{
		return $this->event;
	}

	/**
	 * Execute.
	 */
	public function execute()
	{
		$logger = new DataLogger($this);
		$logger->execute();
	}

	/**
	 * Destructor.
	 */
	public function __destruct()
	{
	}
}
