<?php

namespace App\Core\Application\Service\UpdateRole;

use Exception;
use App\Exceptions\UserException;
use App\Core\Domain\Models\Role\Role;
use App\Core\Domain\Repository\RoleRepositoryInterface;

class UpdateRoleService
{
    private RoleRepositoryInterface $role_repository;

    /**
     * @param RoleRepositoryInterface $role_repository
     */

    public function __construct(RoleRepositoryInterface $role_repository)
    {
        $this->role_repository = $role_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(UpdateRoleRequest $request)
    {
        $role = $this->role_repository->find($request->getId());
        if (!$role) {
            UserException::throw("Role Tidak Ditemukan", 1008, 400);
        }
        $role = new Role(
            $request->getId(),
            $request->getName()
        );
        
        $this->role_repository->persist($role);
    }
}
