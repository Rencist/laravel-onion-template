<?php

namespace App\Core\Application\Service\ChangePassword;

use Exception;
use App\Core\Domain\Models\Email;
use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\ChangePasswordRepositoryInterface;

class ChangePasswordService
{
    private UserRepositoryInterface $user_repository;

    /**
     * @param UserRepositoryInterface $user_repository
     */
    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(ChangePasswordRequest $request)
    {
        
        $user = $this->user_repository->findByEmail(new Email($request->getEmail()));

        if (!$user) {
            UserException::throw("user tidak ditemukan", 1006, 404);
        }

        if($request->getRePassword() != $request->getNewPassword()){
            UserException::throw("Password baru tidak sama", 1007, 400);
        }

        if($request->getCurrentPassword() == $request->getNewPassword()){
            UserException::throw("Password baru harus berbeda dengan password lama", 1008, 400);
        }

        $user->beginVerification()
             ->checkPassword($request->getCurrentPassword())
             ->verify();

        $user->changePassword($request->getNewPassword());
        $this->user_repository->persist($user);
    }
}
