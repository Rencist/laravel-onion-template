<?php

namespace App\Core\Application\Service\DeleteRoleHasPermission;

use App\Core\Domain\Repository\PermissionRepositoryInterface;
use Exception;
use App\Exceptions\UserException;
use App\Core\Domain\Repository\RoleHasPermissionRepositoryInterface;
use App\Core\Domain\Repository\RoleRepositoryInterface;

class DeleteRoleHasPermissionService
{
    private RoleHasPermissionRepositoryInterface $role_has_permission_repository;
    private RoleRepositoryInterface $role_repository;
    private PermissionRepositoryInterface $permission_repository;

    /**
     * @param RoleHasPermissionRepositoryInterface $role_has_permission_repository
     * @param RoleRepositoryInterface $role_repository
     * @param PermissionRepositoryInterface $permission_repository
     */

    public function __construct(RoleHasPermissionRepositoryInterface $role_has_permission_repository, RoleRepositoryInterface $role_repository, PermissionRepositoryInterface $permission_repository)
    {
        $this->role_has_permission_repository = $role_has_permission_repository;
        $this->role_repository = $role_repository;
        $this->permission_repository = $permission_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(DeleteRoleHasPermissionRequest $request)
    {
        $role = $this->role_repository->find($request->getRoleId());
        if (!$role) {
            UserException::throw("Role Tidak Ditemukan", 1008, 400);
        }
        $permission = $this->permission_repository->find($request->getPermissionId());
        if (!$permission) {
            UserException::throw("Permission Tidak Ditemukan", 1008, 400);
        }
        $role_has_permission = $this->role_has_permission_repository->findByBoth($request->getRoleId(), $request->getPermissionId());
        if (!$role_has_permission) {
            UserException::throw("Hubungan Role Dan Permission Tidak Ditemukan", 1008, 400);
        }
        $this->role_has_permission_repository->delete($role_has_permission->getId());
    }
}
