<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

namespace IceTeaS9\TelegramObj;

use IceTeaS9\TelegramObjFoundation;

class Message extends TelegramObjFoundation
{
	/**
	 * @var int
	 */
	public int $message_id;

	/**
	 * @var User
	 */
	public User $from;

	/**
	 * @var Chat
	 */
	public Chat $chat;

	/**
	 * @var ?int
	 */
	public ?int $date = NULL;

	/**
	 * @var ?string
	 */
	public ?string $text = NULL;

	/**
	 * @var ?Message
	 */
	public ?Message $reply_to_message = NULL;

	/**
	 * @var array
	 */
	public array $entities = [];

	/**
	 * Constructor.
	 * 
	 * @param array $msg
	 */
	public function __construct(array $msg)
	{
		$this->message_id = $msg["message_id"];
		$this->from = User::create($msg["from"]);
		$this->chat = Chat::create($msg["chat"]);

		if (isset($msg["date"]))
			$this->date = $msg["date"];

		if (isset($msg["text"]))
			$this->text = $msg["text"];

		if (isset($msg["entities"])) {
			foreach ($msg["entities"] as $entity)
				$this->entities[] = Entity::create($entity);
		}

		if (isset($msg["reply_to_message"]))
			$this->reply_to_message = new self($msg["reply_to_message"]);
	}

	/**
	 * @return array
	 */
	public function jsonSerialize(): array
	{
		$ret = [
			"from" => $this->from,
			"chat" => $this->chat
		];

		if (isset($this->date))
			$ret["date"] = $this->date;

		if (isset($this->reply_to_message))
			$ret["reply_to_message"] = $this->reply_to_message;

		if (isset($this->text))
			$ret["text"] = $this->text;

		if (isset($this->entities))
			$ret["entities"] = $this->entities;

		return $ret;
	}
}
