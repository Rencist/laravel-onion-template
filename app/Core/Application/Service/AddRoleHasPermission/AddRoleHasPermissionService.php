<?php

namespace App\Core\Application\Service\AddRoleHasPermission;

use Exception;
use App\Exceptions\UserException;
use App\Core\Domain\Models\RoleHasPermission\RoleHasPermission;
use App\Core\Domain\Repository\PermissionRepositoryInterface;
use App\Core\Domain\Repository\RoleHasPermissionRepositoryInterface;
use App\Core\Domain\Repository\RoleRepositoryInterface;

class AddRoleHasPermissionService
{
    private RoleHasPermissionRepositoryInterface $role_has_permission_repository;
    private PermissionRepositoryInterface $permission_repository;
    private RoleRepositoryInterface $role_repository;

    /**
     * @param RoleHasPermissionRepositoryInterface $role_has_permission_repository
     * @param PermissionRepositoryInterface $permission_repository
     * @param RoleRepositoryInterface $role_repository
     */

    public function __construct(RoleHasPermissionRepositoryInterface $role_has_permission_repository, PermissionRepositoryInterface $permission_repository, RoleRepositoryInterface $role_repository)
    {
        $this->role_has_permission_repository = $role_has_permission_repository;
        $this->permission_repository = $permission_repository;
        $this->role_repository = $role_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(array $requests)
    {
        foreach ($requests as $request) {
            $check = $this->role_has_permission_repository->findByBoth($request->getRoleId(), $request->getPermissionId());
            if ($check) {
                UserException::throw("Role ini sudah memiliki Permission tersebut", 1008, 400);
            }
            $permission = $this->permission_repository->find($request->getPermissionId());
            if (!$permission) {
                UserException::throw("Permission Tidak Ditemukan", 1008, 400);
            }
            $role = $this->role_repository->find($request->getRoleId());
            if (!$role) {
                UserException::throw("Role Tidak Ditemukan", 1008, 400);
            }
            $id = $this->role_has_permission_repository->findLargestId();
            $role_has_permission = RoleHasPermission::create(
                ++$id,
                $request->getRoleId(),
                $request->getPermissionId()
            );
            $this->role_has_permission_repository->persist($role_has_permission);
        }
    }
}
