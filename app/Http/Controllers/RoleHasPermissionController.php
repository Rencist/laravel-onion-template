<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Core\Application\Service\AddRoleHasPermission\AddRoleHasPermissionRequest;
use App\Core\Application\Service\AddRoleHasPermission\AddRoleHasPermissionService;
use App\Core\Application\Service\DeleteRoleHasPermission\DeleteRoleHasPermissionRequest;
use App\Core\Application\Service\DeleteRoleHasPermission\DeleteRoleHasPermissionService;
use App\Core\Application\Service\GetRolePermission\GetRolePermissionService;

class RoleHasPermissionController extends Controller
{
    public function add(Request $request, AddRoleHasPermissionService $service): JsonResponse
    {
        $input = array_map(function (array $role_permission) {
            return new AddRoleHasPermissionRequest(
                $role_permission['role_id'],
                $role_permission['permission_id'],
            );
        }, $request->input('role_permission'));

        DB::beginTransaction();
        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Hubungan Role Dan Permission Berhasil Ditambahkan");
    }

    public function delete(Request $request, DeleteRoleHasPermissionService $service): JsonResponse
    {
        $input = new DeleteRoleHasPermissionRequest(
            $request->input('role_id'),
            $request->input('permission_id'),
        );

        DB::beginTransaction();
        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Hubungan Role Dan Permission Berhasil Dicabut");
    }

    public function getRolePermission($id_role, GetRolePermissionService $service): JsonResponse
    {
        $response = $service->execute($id_role);
        return $this->successWithData($response, "Berhasil mendapatkan data permission dari role");
    }
}
