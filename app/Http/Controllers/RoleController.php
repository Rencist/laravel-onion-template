<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Core\Application\Service\AddRole\AddRoleRequest;
use App\Core\Application\Service\AddRole\AddRoleService;
use App\Core\Application\Service\DeleteRole\DeleteRoleRequest;
use App\Core\Application\Service\DeleteRole\DeleteRoleService;
use App\Core\Application\Service\UpdateRole\UpdateRoleRequest;
use App\Core\Application\Service\UpdateRole\UpdateRoleService;
use App\Core\Application\Service\GetRoleList\GetRoleListRequest;
use App\Core\Application\Service\GetRoleList\GetRoleListService;

class RoleController extends Controller
{
    public function add(Request $request, AddRoleService $service): JsonResponse
    {
        $request->validate([
            'name' => 'unique:roles',
        ]);
        $input = new AddRoleRequest(
            $request->input('name')
        );

        DB::beginTransaction();
        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Role Berhasil Ditambahkan");
    }

    public function delete(Request $request, DeleteRoleService $service): JsonResponse
    {
        $input = new DeleteRoleRequest(
            $request->input('id')
        );

        DB::beginTransaction();
        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Role Berhasil Dihapus");
    }

    public function update(Request $request, UpdateRoleService $service): JsonResponse
    {
        $input = new UpdateRoleRequest(
            $request->input('id'),
            $request->input('name')
        );

        DB::beginTransaction();
        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Role Berhasil Diupdate");
    }

    public function getRoleList(Request $request, GetRoleListService $service): JsonResponse
    {
        $input = new GetRoleListRequest(
            $request->input('page'),
            $request->input('per_page')
        );
        
        $response = $service->execute($input);
        return $this->successWithData($response, "Berhasil Mendapatkan List Role");
    }
}
