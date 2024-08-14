<?php

namespace App\Infrastructure\Repository;

use App\Core\Domain\Models\Email;
use App\Core\Domain\Models\User\User;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Repository\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlUserRepository implements UserRepositoryInterface
{
    public function persist(User $users): void
    {
        DB::table('users')->upsert([
            'id' => $users->getId()->toString(),
            'roles_id' => $users->getRoleId(),
            'email' => $users->getEmail()->toString(),
            'name' => $users->getName(),
            'password' => $users->getHashedPassword()
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(UserId $id): ?User
    {
        $row = DB::table('users')->where('id', $id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    /**
     * @throws Exception
     */
    public function findByEmail(Email $email): ?User
    {
        $row = DB::table('users')->where('email', $email->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    /**
     * @throws Exception
     */
    public function findByRoleId(int $role_id): ?array
    {
        $rows = DB::table('users')->where('roles_id', $role_id)->get();

        if (!$rows) {
            return null;
        }

        return $this->constructFromRows($rows->all());
    }

    /**
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $users = [];
        foreach ($rows as $row) {
            $users[] = new User(
                new UserId($row->id),
                $row->roles_id,
                new Email($row->email),
                $row->name,
                $row->password
            );
        }
        return $users;
    }

    public function getWithPagination(int $page, int $per_page): array
    {
        $rows = DB::table('users')
            ->paginate($per_page, ['*'], 'user_page', $page);
        $users = [];

        foreach ($rows as $row) {
            $users[] = $this->constructFromRows([$row])[0];
        }
        return [
            "data" => $users,
            "max_page" => ceil($rows->total() / $per_page)
        ];
    }

    public function delete(UserId $id): void
    {
        DB::table('users')->where('id', $id->toString())->delete();
    }
}
