<?php declare(strict_types=1);

namespace App\Services;

use Nette\Database\Explorer;
use Nette\DI\Attributes\Inject;
use Nette\Security\AuthenticationException;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;
use Nette\Security\SimpleIdentity;

class Authenticator implements \Nette\Security\Authenticator
{
	public function __construct(
		private Explorer $database,
		private Passwords $passwords,
	)
	{}

	public function authenticate(string $username, string $password): IIdentity
	{
		$user = $this->database->table('users')
			->where('username', $username)
			->fetch();

		if ($user === null)
			throw new AuthenticationException('User not found.');

		if ($this->passwords->verify($password, $user->password) === false)
			throw new AuthenticationException('Wrong password.');

		return new SimpleIdentity($user->id, ['username' => $user->username, 'password' => $user->password]);
	}
}