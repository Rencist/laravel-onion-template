<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Core\Application\Service\AddPermission\AddPermissionRequest;
use App\Core\Application\Service\AddPermission\AddPermissionService;
use App\Core\Application\Service\DeletePermission\DeletePermissionRequest;
use App\Core\Application\Service\DeletePermission\DeletePermissionService;
use App\Core\Application\Service\UpdatePermission\UpdatePermissionRequest;
use App\Core\Application\Service\UpdatePermission\UpdatePermissionService;
use App\Core\Application\Service\GetPermissionList\GetPermissionListRequest;
use App\Core\Application\Service\GetPermissionList\GetPermissionListService;

class PermissionController extends Controller
{
    public function add(Request $request, AddPermissionService $service): JsonResponse
    {
        $request->validate([
            'routes' => 'unique:permission',
        ]);
        $input = new AddPermissionRequest(
            $request->input('routes')
        );

        DB::beginTransaction();
        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Permission Berhasil ditambahkan");
    }

    public function delete(Request $request, DeletePermissionService $service): JsonResponse
    {
        $input = new DeletePermissionRequest(
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
        return $this->success("Permission Berhasil Dihapus");
    }

    public function update(Request $request, UpdatePermissionService $service): JsonResponse
    {
        $input = new UpdatePermissionRequest(
            $request->input('id'),
            $request->input('routes')
        );

        DB::beginTransaction();
        try {
            $service->execute($input);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Permission Berhasil diupdate");
    }

    public function getPermissionList(Request $request, GetPermissionListService $service): JsonResponse
    {
        $input = new GetPermissionListRequest(
            $request->input('page'),
            $request->input('per_page')
        );
        
        $response = $service->execute($input);
        return $this->successWithData($response, "Berhasil Mendapatkan List Permission");
    }
}
