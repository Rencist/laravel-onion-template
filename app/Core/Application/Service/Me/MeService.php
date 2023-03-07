<?php

namespace App\Core\Application\Service\Me;

use App\Core\Domain\Models\ListEvent\ListEvent;
use Exception;
use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Models\Permission\Permission;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\ListEventRepositoryInterface;
use App\Core\Domain\Repository\PermissionRepositoryInterface;
use App\Core\Domain\Models\RoleHasPermission\RoleHasPermission;
use App\Core\Domain\Repository\UserHasListEventRepositoryInterface;
use App\Core\Domain\Repository\RoleHasPermissionRepositoryInterface;

class MeService
{
    private UserRepositoryInterface $user_repository;
    private RoleRepositoryInterface $role_repository;
    private PermissionRepositoryInterface $permission_repository;
    private RoleHasPermissionRepositoryInterface $role_has_permission_repository;

    /**
     * @param UserRepositoryInterface $user_repository
     * @param RoleRepositoryInterface $role_repository
     * @param PermissionRepositoryInterface $permission_repository
     * @param RoleHasPermissionRepositoryInterface $role_has_permission_repository
     */
    public function __construct(
        UserRepositoryInterface $user_repository,
        RoleRepositoryInterface $role_repository,
        PermissionRepositoryInterface $permission_repository,
        RoleHasPermissionRepositoryInterface $role_has_permission_repository
    ) {
        $this->user_repository = $user_repository;
        $this->role_repository = $role_repository;
        $this->permission_repository = $permission_repository;
        $this->role_has_permission_repository = $role_has_permission_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(UserAccount $account): MeResponse
    {
        $user = $this->user_repository->find($account->getUserId());
        $role = $this->role_repository->find($user->getRoleId());
        if (!$user) {
            UserException::throw("user tidak ditemukan", 1006, 404);
        }
        
        $routes = $this->role_has_permission_repository->findByRoleId($role->getId());
        $routes_array = array_map(function (RoleHasPermission $route) {
            return new RoutesResponse(
                $this->permission_repository->find($route->getPermissionId())->getRoutes()
            );
        }, $routes);

        return new MeResponse($user, $role->getName(), $routes_array);
    }
}
