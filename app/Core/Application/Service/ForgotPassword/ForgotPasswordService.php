<?php

namespace App\Core\Application\Service\ForgotPassword;

use App\Exceptions\UserException;
use Illuminate\Support\Facades\Mail;
use App\Core\Application\Mail\RequestPasswordEmail;
use App\Core\Domain\Models\PasswordReset\PasswordReset;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\PasswordResetRepositoryInterface;
use App\Core\Domain\Service\JwtManagerInterface;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordService
{
    private $user_repository;
    private $password_reset_repository;
    private JwtManagerInterface $jwt_manager;

    public function __construct(
        JwtManagerInterface $jwt_manager,
        UserRepositoryInterface $user_repository,
        PasswordResetRepositoryInterface $password_reset_repository
    ) {
        $this->jwt_manager = $jwt_manager;
        $this->user_repository = $user_repository;
        $this->password_reset_repository = $password_reset_repository;
    }

    /*
    * @param ForgotPasswordRequest $input
    * @return void
    */
    public function send(ForgotPasswordRequest $input): void
    {
        $email = $input->getEmail();
        $user = $this->user_repository->findByEmail($email);
        // create token
        $forgot = $this->jwt_manager->createForgotPasswordToken($user);
        // save to db
        $password_reset = new PasswordReset(
            $email,
            Hash::make($forgot['token'])
        );
        $this->password_reset_repository->persist($password_reset);
        // send email
        Mail::to($user->getEmail()->toString())->send(new RequestPasswordEmail(
            $forgot['jwt'],
        ));
    }

    /*
    * @param ChangePasswordRequest $input
    * @return void
    */
    public function change(ChangePasswordRequest $input): void
    {
        $token = $input->getToken();
        $password = $input->getPassword();
        $re_password = $input->getRepassword();

        $decoded = $this->jwt_manager->decodeForgotPasswordToken($token);
        $user = $this->user_repository->find($decoded['user']->getUserId());

        if ($password !== $re_password) {
            UserException::throw("Password dan Repassword tidak sama", 6665, 404);
        }

        if (!$user) {
            UserException::throw("User tidak ditemukan", 6667, 404);
        }
        $password_reset = $this->password_reset_repository->findByEmail($user->getEmail()->toString());
        if (!$password_reset) {
            UserException::throw("Token tidak ditemukan", 6668, 401);
        }

        // check for payload
        $decodedJWT = $decoded['decoded'];
        if (!isset($decodedJWT->token)) {
            UserException::throw("Token payload tidak valid", 6669, 401);
        }
        // check token
        $isTokenValid = Hash::check($decodedJWT->token, $password_reset->getToken());
        if (!$isTokenValid) {
            UserException::throw("Token tidak valid", 66670, 401);
        }
        // change password
        $user->changePassword($password);
        $this->user_repository->persist($user);
        // delete token
        $this->password_reset_repository->delete($user->getEmail()->toString());
    }
}
