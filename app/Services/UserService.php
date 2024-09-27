<?php

namespace App\Services;

use Nette\Database\Explorer;
use Nette\Security\Passwords;

class UserService
{
	public function __construct(
		private Explorer $database,
		private Passwords $passwords,
	)
	{}

	public function createUser(string $username, string $password): void
	{
		$this->database->table('users')->insert([
			'name' => $username,
			'email' => $this->passwords->hash($password),
		]);
	}
}