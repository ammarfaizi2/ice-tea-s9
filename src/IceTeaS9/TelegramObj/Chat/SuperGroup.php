<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

namespace IceTeaS9\TelegramObj\Chat;

use IceTeaS9\TelegramObj\Chat;

class SuperGroup extends Chat
{
	/**
	 * @var ?string
	 */
	public ?string $description = NULL;

	/**
	 * @var ?string
	 */
	public ?string $invite_link = NULL;

	/**
	 * @var ?string
	 */
	public ?string $sticker_set_name = NULL;

	/**
	 * Constructor.
	 * 
	 * @param array $data
	 */
	public function __construct(array $data)
	{
		parent::__construct($data);
	}
}
