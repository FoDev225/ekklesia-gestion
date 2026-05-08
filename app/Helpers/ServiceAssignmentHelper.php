<?php

namespace App\Helpers;

use App\Models\ServiceAssignment;
use App\Models\ServiceRole;

class ServiceAssignmentHelper
{
    public static function assign($service, $roleCode, $believerId = null, $groupId = null, $isBackup = false)
    {
        if (!$believerId && !$groupId) return;

        $role = ServiceRole::where('code', $roleCode)->first();
        if (!$role) return;

        // ANTI-CONFLIT (SEULEMENT ENTRE CULTES)
        if ($believerId && $groupId) {

            if (self::hasConflict($service, $believerId)) {
                throw new \Exception("Ce fidèle est déjà programmé pour un autre culte ce jour.");
            }
        }

        ServiceAssignment::create([
            'service_id' => $service->id,
            'service_role_id' => $role->id,
            'believer_id' => $believerId,
            'group_id' => $groupId,
            'is_backup' => $isBackup,
        ]);
    }

    public static function hasConflict($service, $believerId)
    {
        return ServiceAssignment::whereHas('service', function ($q) use ($service) {
                $q->where('service_date', $service->service_date);
            })
            ->where('believer_id', $believerId)
            ->exists();
    }

    public static function hasConflictInSameService($service, $believerId)
    {
        return ServiceAssignment::where('service_id', $service->id)
            ->where('believer_id', $believerId)
            ->exists();
    }
}