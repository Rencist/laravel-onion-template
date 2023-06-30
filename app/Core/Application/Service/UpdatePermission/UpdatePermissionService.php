<?php

namespace App\Core\Application\Service\UpdatePermission;

use Exception;
use App\Exceptions\UserException;
use App\Core\Domain\Models\Permission\Permission;
use App\Core\Domain\Repository\PermissionRepositoryInterface;

class UpdatePermissionService
{
    private PermissionRepositoryInterface $permission_repository;

    /**
     * @param PermissionRepositoryInterface $permission_repository
     */

    public function __construct(PermissionRepositoryInterface $permission_repository)
    {
        $this->permission_repository = $permission_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(UpdatePermissionRequest $request)
    {
        $permission = $this->permission_repository->find($request->getId());
        if (!$permission) {
            UserException::throw("Permission Tidak Ditemukan", 1008, 400);
        }
        $permission = new Permission(
            $request->getId(),
            $request->getName()
        );
        
        $this->permission_repository->persist($permission);
    }
}
