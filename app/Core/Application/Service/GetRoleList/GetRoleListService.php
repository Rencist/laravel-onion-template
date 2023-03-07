<?php

namespace App\Core\Application\Service\GetRoleList;

use App\Core\Application\Service\PaginationResponse;
use Exception;
use App\Core\Domain\Models\Role\Role;
use App\Core\Domain\Repository\RoleRepositoryInterface;

class GetRoleListService
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
    public function execute(GetRoleListRequest $request)
    {
        $roles_pagination = $this->role_repository->getWithPagination($request->getPage(), $request->getPerPage());
        $max_page = $roles_pagination['max_page'];

        $role_response = array_map(function (Role $role){
            return new GetRoleListResponse(
                $role
                //yang dibutuhin untuk ditampilkan apa aja
            );
        }, $roles_pagination['data']);

        return new PaginationResponse($role_response, $request->getPage(), $max_page);
    }
}
