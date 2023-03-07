<?php

namespace App\Core\Application\Service\DeletePermission;

use Exception;
use App\Exceptions\UserException;
use App\Core\Domain\Repository\PermissionRepositoryInterface;
use App\Core\Domain\Repository\RoleHasPermissionRepositoryInterface;

class DeletePermissionService
{
    private PermissionRepositoryInterface $permission_repository;
    private RoleHasPermissionRepositoryInterface $role_has_permission_repository;

    /**
     * @param PermissionRepositoryInterface $permission_repository
     * @param RoleHasPermissionRepositoryInterface $role_has_permission_repository
     */

    public function __construct(PermissionRepositoryInterface $permission_repository, RoleHasPermissionRepositoryInterface $role_has_permission_repository)
    {
        $this->permission_repository = $permission_repository;
        $this->role_has_permission_repository = $role_has_permission_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(DeletePermissionRequest $request)
    {
        $role_has_permission = $this->role_has_permission_repository->findByPermissionId($request->getPermissionId());
        if ($role_has_permission) {
            UserException::throw("Permission Masih Digunakan Pada Aktivitas Lain", 1008, 400);
        }
        $permission = $this->permission_repository->find($request->getPermissionId());
        if (!$permission) {
            UserException::throw("Permission Tidak Ditemukan", 1008, 400);
        }
        $this->permission_repository->delete($request->getPermissionId());
    }
}
