<?php

namespace App\Core\Application\Service\GetRolePermission;

use App\Exceptions\UserException;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\RoleHasPermissionRepositoryInterface;
use App\Core\Domain\Models\Permission\Permission;

class GetRolePermissionService
{
    private RoleHasPermissionRepositoryInterface $role_has_permission_repository;
    private RoleRepositoryInterface $role_repository;

    /**
     * @param RoleHasPermissionRepositoryInterface $role_has_permission_repository
     * @param RoleRepositoryInterface $role_repository
     */

    public function __construct(RoleHasPermissionRepositoryInterface $role_has_permission_repository, RoleRepositoryInterface $role_repository)
    {
        $this->role_has_permission_repository = $role_has_permission_repository;
        $this->role_repository = $role_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $id_role)
    {
        $role = $this->role_repository->find($id_role);
        if (!$role) {
            UserException::throw("Role Tidak Ditemukan", 1008, 400);
        }

        $result = $this->role_has_permission_repository->getPermissionByRole($role->getId());
        return ['permission' => $result];
    }
}
