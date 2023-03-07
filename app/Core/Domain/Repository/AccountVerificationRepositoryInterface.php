<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Email;
use App\Core\Domain\Models\AccountVerification\AccountVerification;
use App\Core\Domain\Models\AccountVerification\AccountVerificationId;

interface AccountVerificationRepositoryInterface
{
    public function persist(AccountVerification $AccountVerification): void;

    public function find(AccountVerificationId $id): ?AccountVerification;

    public function findByEmail(Email $email): ?AccountVerification;
}
