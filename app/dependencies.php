<?php

use App\Infrastrucutre\Service\GetIP;
use App\Infrastrucutre\Service\JwtManager;
use App\Core\Domain\Service\GetIPInterface;
use App\Core\Domain\Service\JwtManagerInterface;
use App\Infrastrucutre\Repository\SqlRoleRepository;
use App\Infrastrucutre\Repository\SqlUserRepository;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Infrastrucutre\Repository\SqlProvinsiRepository;
use App\Infrastrucutre\Repository\SqlKabupatenRepository;
use App\Infrastrucutre\Repository\SqlPermissionRepository;
use App\Core\Domain\Repository\ProvinsiRepositoryInterface;
use App\Core\Domain\Repository\KabupatenRepositoryInterface;
use App\Core\Domain\Repository\PermissionRepositoryInterface;
use App\Infrastrucutre\Repository\SqlPasswordResetRepository;
use App\Core\Domain\Repository\PasswordResetRepositoryInterface;
use App\Infrastrucutre\Repository\SqlRoleHasPermissionRepository;
use App\Infrastrucutre\Repository\SqlAccountVerificationRepository;
use App\Core\Domain\Repository\RoleHasPermissionRepositoryInterface;
use App\Core\Domain\Repository\AccountVerificationRepositoryInterface;



/** @var Application $app */

$app->singleton(UserRepositoryInterface::class, SqlUserRepository::class);
$app->singleton(ProvinsiRepositoryInterface::class, SqlProvinsiRepository::class);
$app->singleton(KabupatenRepositoryInterface::class, SqlKabupatenRepository::class);
$app->singleton(RoleRepositoryInterface::class, SqlRoleRepository::class);
$app->singleton(PermissionRepositoryInterface::class, SqlPermissionRepository::class);
$app->singleton(RoleHasPermissionRepositoryInterface::class, SqlRoleHasPermissionRepository::class);
$app->singleton(AccountVerificationRepositoryInterface::class, SqlAccountVerificationRepository::class);
$app->singleton(JwtManagerInterface::class, JwtManager::class);
$app->singleton(GetIPInterface::class, GetIP::class);
$app->singleton(PasswordResetRepositoryInterface::class, SqlPasswordResetRepository::class);
