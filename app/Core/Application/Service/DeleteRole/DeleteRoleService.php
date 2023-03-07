<?php

namespace App\Core\Application\Service\DeleteRole;

use Exception;
use App\Exceptions\UserException;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\RoleHasPermissionRepositoryInterface;

class DeleteRoleService
{
    private RoleRepositoryInterface $role_repository;
    private UserRepositoryInterface $user_repository;
    private RoleHasPermissionRepositoryInterface $role_has_permission_repository;

    /**
     * @param RoleRepositoryInterface $role_repository
     * @param UserRepositoryInterface $user_repository
     * @param RoleHasPermissionRepositoryInterface $role_has_permission_repository
     */

    public function __construct(RoleRepositoryInterface $role_repository, UserRepositoryInterface $user_repository, RoleHasPermissionRepositoryInterface $role_has_permission_repository)
    {
        $this->role_repository = $role_repository;
        $this->user_repository = $user_repository;
        $this->role_has_permission_repository = $role_has_permission_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(DeleteRoleRequest $request)
    {
        $role = $this->role_repository->find($request->getRoleId());
        if (!$role) {
            UserException::throw("Role Tidak Ditemukan", 1008, 400);
        }
        $user = $this->user_repository->findByRoleId($request->getRoleId());
        if ($user) {
            UserException::throw("Role Masih Digunakan Pada User", 1008, 400);
        }
        $role_has_permission = $this->role_has_permission_repository->findByRoleId($request->getRoleId());
        if ($role_has_permission) {
            UserException::throw("Role Masih Digunakan Pada Aktivitas Lain", 1008, 400);
        }
        $this->role_repository->delete($request->getRoleId());
    }
}
