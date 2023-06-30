<?php

namespace App\Http\Middleware;

use Closure;
use App\Exceptions\UserException;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\PermissionRepositoryInterface;
use App\Core\Domain\Repository\RoleHasPermissionRepositoryInterface;

class PermissionMiddleware
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
    public function __construct(UserRepositoryInterface $user_repository, RoleRepositoryInterface $role_repository, PermissionRepositoryInterface $permission_repository, RoleHasPermissionRepositoryInterface $role_has_permission_repository)
    {
        $this->user_repository = $user_repository;
        $this->role_repository = $role_repository;
        $this->permission_repository = $permission_repository;
        $this->role_has_permission_repository = $role_has_permission_repository;
    }
    
    public function handle($request, Closure $next, $permission)
    {
        $account = $request->get('account');
        if (!$account) {
            UserException::throw("User Tidak Ditemukan", 2056, 404);
        }
        $user = $this->user_repository->find($account->getUserId());
        $role = $this->role_repository->find($user->getRoleId());
        $role_has_permission = $this->role_has_permission_repository->findByRoleId($role->getId());
        foreach ($role_has_permission as $key) {
            $permission_repository = $this->permission_repository->find($key->getPermissionId());
            if ($permission == $permission_repository->getName()) {
                return $next($request);
            }
        }
        UserException::throw("User Tidak Bisa Mengakses Endpoint Ini", 2056, 404);
    }
}
