<?php

namespace App\Core\Application\Service\UserVerification;

use Exception;
use App\Core\Domain\Models\Email;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\Mail;
use App\Core\Application\Mail\AccountVerificationEmail;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\AccountVerificationRepositoryInterface;

class UserVerificationService
{
    private UserRepositoryInterface $user_repository;
    private AccountVerificationRepositoryInterface $account_verification_repository;

    /**
     * @param UserRepositoryInterface $user_repository
     * @param AccountVerificationRepositoryInterface $account_verification_repository
     */
    public function __construct(UserRepositoryInterface $user_repository, AccountVerificationRepositoryInterface $account_verification_repository)
    {
        $this->user_repository = $user_repository;
        $this->account_verification_repository = $account_verification_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(UserVerificationRequest $request)
    {
        $user = $this->user_repository->findByEmail(new Email($request->getEmail()));
        if (!$user) {
            UserException::throw("User Tidak Ditemukan", 1006, 404);
        }
        $account_verification = $this->account_verification_repository->findByEmail(new Email($request->getEmail()));
        if ($account_verification->getIsActive() == true) {
            UserException::throw("Akun User Sudah Aktif", 1019, 404);
        }
        if (strcmp($request->getToken(), $account_verification->getToken()) !== 0) {
            UserException::throw("Token Tidak Cocok Dengan Email Yang Didaftarkan", 1007, 404);
        }
        $user->setIsValid(true);
        $account_verification->setIsActive(true);
        $this->account_verification_repository->persist($account_verification);
        $this->user_repository->persist($user);
    }

    /**
     * @throws Exception
     */
    public function reExecute(ReUserVerificationRequest $request)
    {
        $user = $this->user_repository->findByEmail(new Email($request->getEmail()));
        if (!$user) {
            UserException::throw("User Tidak Ditemukan", 1006, 404);
        }
        $account_verification = $this->account_verification_repository->findByEmail(new Email($request->getEmail()));
        if ($account_verification->getIsActive() == true) {
            UserException::throw("Akun User Sudah Aktif", 1019, 404);
        }
        Mail::to($user->getEmail()->toString())->send(new AccountVerificationEmail(
            $user->getEmail()->toString(),
            $account_verification->getToken()
        ));
    }
}
