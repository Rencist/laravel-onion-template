<?php

namespace App\Infrastructure\Repository;

use Exception;
use App\Core\Domain\Models\Email;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\Kecamatan\Kecamatan;
use App\Core\Domain\Models\PasswordReset\PasswordReset;
use App\Core\Domain\Repository\PasswordResetRepositoryInterface;

class SqlPasswordResetRepository implements PasswordResetRepositoryInterface
{
    /**
     * @param array $rows
     * @return Kecamatan[]
     * @throws Exception
     */
    public function persist(PasswordReset $password_reset): void
    {
        DB::table('password_resets')->updateOrInsert(
            ['email' => $password_reset->getEmail()->toString()],
            [
                'email' => $password_reset->getEmail()->toString(),
                'token' => $password_reset->getToken(),
                'created_at' => now()->toDateTimeString(),
            ]
        );
    }

    public function delete(string $email): void
    {
        DB::table('password_resets')->where('email', $email)->delete();
    }

    public function findByEmail(string $email): ?PasswordReset
    {
        $row = DB::table('password_resets')->where('email', $email)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRow($row);
    }

    /**
     * @throws Exception
     */
    private function constructFromRow($row): PasswordReset
    {
        return new PasswordReset(
            new Email($row->email),
            $row->token
        );
    }
}
