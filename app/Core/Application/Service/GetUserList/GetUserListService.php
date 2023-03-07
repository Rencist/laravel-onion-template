<?php

namespace App\Core\Application\Service\GetUserList;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\User\User;
use App\Core\Application\Service\PaginationResponse;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;

class GetUserListService
{
    private UserRepositoryInterface $user_repository;
    private RoleRepositoryInterface $role_repository;

    /**
     * @param UserRepositoryInterface $user_repository
     */
    public function __construct(UserRepositoryInterface $user_repository, RoleRepositoryInterface $role_repository)
    {
        $this->user_repository = $user_repository;
        $this->role_repository = $role_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(GetUserListRequest $request)
    {
        $rows = DB::table('user')->leftJoin('role', 'user.role_id', '=', 'role.id');

        if ($request->getFilter())
            $rows->whereIn('role.name', $request->getFilter());
            // foreach ($request->getFilter() as $filter)
            //     $rows->where('role.name', '=', $filter);
        if($request->getSearch())
            $rows->where('user.name', 'like', '%'.$request->getSearch().'%');
        if ($request->getSort())
            $rows->orderBy($request->getSort(), $request->getType());

        $rows = $rows->paginate($request->getPerPage(), ['user.*'], 'user_page', $request->getPage());

        $users = [];
        foreach ($rows as $row) {
            $users[] = $this->user_repository->constructFromRows([$row])[0];
        }

        $users_pagination = [
            "data" => $users,
            "max_page" => ceil($rows->total() / $request->getPerPage())
        ];

        $max_page = $users_pagination['max_page'];

        $user_response = array_map(function (User $user) {
            $role = $this->role_repository->find($user->getRoleId());
            return new GetUserListResponse(
                $user,
                $role->getName()
            );
        }, $users_pagination['data']);

        return new PaginationResponse($user_response, $request->getPage(), $max_page);
    }
}
