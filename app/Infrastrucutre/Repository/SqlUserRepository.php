<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Email;
use App\Core\Domain\Models\User\User;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\User\UserType;
use App\Core\Domain\Repository\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlUserRepository implements UserRepositoryInterface
{
    public function persist(User $user): void
    {
        DB::table('user')->upsert([
            'id' => $user->getId()->toString(),
            'user_type' => $user->getType()->value,
            'email' => $user->getEmail()->toString(),
            'no_telp' => $user->getNoTelp(),
            'name' => $user->getName(),
            'password' => $user->getHashedPassword()
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(UserId $id): ?User
    {
        $row = DB::table('user')->where('id', $id->toString())->first();

        if (!$row) return null;

        return $this->constructFromRow($row);
    }

    /**
     * @throws Exception
     */
    public function findByEmail(Email $email): ?User
    {
        $row = DB::table('user')->where('email', $email->toString())->first();

        if (!$row) return null;

        return $this->constructFromRow($row);
    }

    /**
     * @throws Exception
     */
    private function constructFromRow($row): User
    {
        return new User(
            new UserId($row->id),
            UserType::from($row->user_type),
            new Email($row->email),
            $row->no_telp,
            $row->name,
            $row->password
        );
    }
}
