<?php

namespace App\Core\Application\Service\RegisterUser;

use Exception;
use App\Core\Domain\Models\Email;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Core\Domain\Models\User\User;
use App\Core\Application\Mail\AccountVerificationEmail;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Models\AccountVerification\AccountVerification;
use App\Core\Domain\Repository\AccountVerificationRepositoryInterface;
use App\Core\Domain\Repository\RoleRepositoryInterface;

class RegisterUserService
{
    private UserRepositoryInterface $user_repository;
    private AccountVerificationRepositoryInterface $account_verification_repository;
    private RoleRepositoryInterface $role_repository;

    /**
     * @param UserRepositoryInterface $user_repository
     * @param AccountVerificationRepositoryInterface $account_verification_repository
     */
    public function __construct(UserRepositoryInterface $user_repository, AccountVerificationRepositoryInterface $account_verification_repository, RoleRepositoryInterface $role_repository)
    {
        $this->user_repository = $user_repository;
        $this->account_verification_repository = $account_verification_repository;
        $this->role_repository = $role_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(RegisterUserRequest $request)
    {
        $registeredUser = $this->user_repository->findByEmail(new Email($request->getEmail()));
        if ($registeredUser) {
            UserException::throw("Mohon Periksa Email Anda Untuk Proses Verifikasi Akun", 1022, 404);
        }
        $role = $this->role_repository->find($request->getStatus());
        if (!$role) {
            UserException::throw("Role yang anda masukkan tidak terdaftar.", 1023, 404);
        }

        $user = User::create(
            $request->getStatus(),
            new Email($request->getEmail()),
            $request->getNoTelp(),
            $request->getName(),
            false,
            $request->getPassword()
        );
        $this->user_repository->persist($user);
        $token = Hash::make($user->getId()->toString());
        $AccountVerification = AccountVerification::create(
            $user->getEmail(),
            $token,
        );
        $this->account_verification_repository->persist($AccountVerification);
        Mail::to($user->getEmail()->toString())->send(new AccountVerificationEmail(
            $user->getEmail()->toString(),
            $token,
        ));
    }
}
