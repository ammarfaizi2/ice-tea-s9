<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

namespace IceTeaS9\Logger;

use PDO;
use PDOException;
use IceTeaS9\Mutex;
use IceTeaS9\LoggerFoundation;
use IceTeaS9\TelegramObj\User as TelegramUser;

class User extends LoggerFoundation
{
	/**
	 * @var TelegramUser
	 */
	private TelegramUser $user;

	/**
	 * @param TelegramUser $user
	 * @return void
	 */
	public function setUser(TelegramUser $user)
	{
		$this->user = $user;
	}

	/**
	 * @return bool
	 */
	private function saveNewUser()
	{
		$gu = $this->tg->getChat(["chat_id" => $this->user->id]);
		if (isset($gu["result"]))
			$gu = $gu["result"];

		$q = "INSERT INTO `tg_users`
		(
			`user_id`,
			`username`,
			`first_name`,
			`last_name`,
			`photo`,
			`is_bot`,
			`bio`,
			`created_at`
		)
			VALUES
		(
			:user_id,
			:username,
			:first_name,
			:last_name,
			:photo,
			:is_bot,
			:bio,
			:created_at
		)";
		$d = [
			":user_id"    => $this->user->id,
			":username"   => $this->user->username,
			":first_name" => $this->user->first_name,
			":last_name"  => $this->user->last_name,
			":photo"      => NULL,
			":is_bot"     => $this->user->is_bot ? 1 : 0,
			":bio"        => $gu["bio"] ?? NULL,
			":created_at" => date("Y-m-d H:i:s")
		];
		$st = $this->db->prepare($q);
		return $st->execute($d);
	}

	/**
	 * If user exists, update the user data and return true.
	 * If user does not exists, return false.
	 *
	 * @return bool
	 */
	private function updateUser(): bool
	{
		$q = "SELECT * FROM `tg_users` WHERE `user_id`=:user_id LIMIT 1";
		$st = $this->db->prepare($q);
		$st->execute([":user_id" => $this->user->id]);
		$r = $st->fetch(PDO::FETCH_ASSOC);
		if (!$r)
			return false;

		$q = "UPDATE `tg_users` SET ";
		$d = [];

		if ($r["username"] !== $this->user->username) {
			$q .= "`username`=:username,";
			$d[":username"] = $this->user->username;
		}

		if ($r["first_name"] !== $this->user->first_name) {
			$q .= "`first_name`=:first_name,";
			$d[":first_name"] = $this->user->first_name;
		}

		if ($r["last_name"] !== $this->user->last_name) {
			$q .= "`last_name`=:last_name,";
			$d[":last_name"] = $this->user->last_name;
		}

		$is_bot = $this->user->is_bot ? 1 : 0;
		if ((int)$r["is_bot"] !== $is_bot) {
			$q .= "`is_bot`=:is_bot,";
			$d[":is_bot"] = $is_bot;
		}

		if (count($d) === 0)
			return true;

		$q .= "`updated_at`=:updated_at";
		$d[":updated_at"] = date("Y-m-d H:i:s");

		$q .= " WHERE `user_id`=:user_id LIMIT 1";
		$d[":user_id"] = $this->user->id;
		$st = $this->db->prepare($q);
		return $st->execute($d);
	}

	/**
	 * @return void
	 */
	public function execute()
	{
		$mutex = new Mutex("user-{$this->user->id}");
		$mutex->lock();
		try {
			$this->db->beginTransaction();

			if (!$this->updateUser())
				$this->saveNewUser();

			$this->db->commit();
		} catch (PDOException $e) {
			$this->db->rollBack();
			$mutex->unlock();
			throw $e;
		}
		$mutex->unlock();
	}
}
