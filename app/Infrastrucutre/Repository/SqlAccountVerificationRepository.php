<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Email;
use App\Core\Domain\Models\AccountVerification\AccountVerification;
use App\Core\Domain\Models\AccountVerification\AccountVerificationId;
use App\Core\Domain\Repository\AccountVerificationRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlAccountVerificationRepository implements AccountVerificationRepositoryInterface
{
    public function persist(AccountVerification $account_verification): void
    {
        DB::table('account_verification')->upsert([
            'id' => $account_verification->getId()->toString(),
            'email' => $account_verification->getEmail()->toString(),
            'token' => $account_verification->getToken(),
            'is_active' => $account_verification->getIsActive(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(AccountVerificationId $id): ?AccountVerification
    {
        $row = DB::table('account_verification')->where('id', $id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRow($row);
    }

    /**
     * @throws Exception
     */
    public function findByEmail(Email $email): ?AccountVerification
    {
        $row = DB::table('account_verification')->where('email', $email->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRow($row);
    }

    /**
     * @throws Exception
     */
    private function constructFromRow($row): AccountVerification
    {
        return new AccountVerification(
            new AccountVerificationId($row->id),
            new Email($row->email),
            $row->token,
            $row->is_active,
        );
    }
}
