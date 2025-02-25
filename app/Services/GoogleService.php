<?php

namespace App\Services;

use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_Permission;


class GoogleService
{

    private $client;

    private $service;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setClientId(env('GOOGLE_CLIENT_ID'));
        $this->client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $this->client->refreshToken(env('GOOGLE_REFRESH_TOKEN'));
        $this->client->setScopes([
            Google_Service_Drive::DRIVE,
        ]);

        $this->service = new Google_Service_Drive($this->client);
    }

    /**
     * Check if folder id exists
     * 
     * @param string $folderId
     * 
     * @return bool
     */
    public function checkFolderIdExists(string $folderId): bool
    {
        try {
            $this->service->files->get($folderId);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Give permission to email
     * 
     * @param string $fileId
     * @param string $email
     * 
     * @return array {
     *  success: bool,
     *  permissionId?: string,
     *  message: string
     * }
     */
    public function givePermission($fileId, $email): array
    {
        try {
            $permission = new Google_Service_Drive_Permission();
            $permission->setEmailAddress($email);
            $permission->setType('user');
            $permission->setRole('reader');
            $result = $this->service->permissions->create($fileId, $permission);

            return [
                'success' => true,
                'permissionId' => $result->id,
                'message' => 'Permission granted successfully'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => $th->getMessage()
            ];
        }
    }

    /**
     * Delete permission
     * 
     * @param string $fileId
     * @param string $permissionId
     * 
     * @return array {
     *  success: bool,
     *  message: string
     * }
     */
    public function deletePermission($fileId, $permissionId): array
    {
        try {
            $permissions = $this->service->permissions->listPermissions($fileId);
            foreach ($permissions as $permission) {
                if ($permission->id == $permissionId) {
                    $this->service->permissions->delete($fileId, $permission->id);
                }
            }

            return [
                'success' => true,
                'message' => 'Permission deleted successfully'
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => $th->getMessage()
            ];
        }
    }

    /**
     * Check if email has permission
     * 
     * @param string $fileId
     * @param string $permissionId
     * 
     * @return bool
     */
    public function checkIfEmailHasPermission($fileId, $permissionId): bool
    {
        $permissions = $this->service->permissions->listPermissions($fileId);
        foreach ($permissions as $permission) {
            // \Log::info((array)$permission);
            if ($permission->id == $permissionId) {
                return true;
            }
        }

        return false;
    }

    /**
     * Count permissions
     * 
     * @param string $fileId
     * 
     * @return array
     */
    public function countPermissions($fileId): array
    {
        try {
            $permissions = $this->service->permissions->listPermissions($fileId);
            return [
                'success' => true,
                'count' => count($permissions)
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => $th->getMessage()
            ];
        }
    }
}
