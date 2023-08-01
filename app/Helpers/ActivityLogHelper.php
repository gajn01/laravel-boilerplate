<?php

namespace App\Helpers;

use Jenssegers\Agent\Agent;
use App\Models\ActivityLog;

class ActivityLogHelper
{
    public Agent $agent;
    public ActivityLog $activityLog;

    public function __construct()
    {
        $this->agent = new Agent();
        $this->activityLog = new ActivityLog;
    }
    public function onLogAction($activity, $entity, $id = null)
    {
        $data = $this->getUserDeviceDetails();
        switch ($activity) {
            case 'create':
                $this->activityLog->activity = $data['activity'] = $this->logCreate($entity);
                break;
            case 'update':
                $this->activityLog->activity = $data['activity'] = $this->logUpdate($entity, $id);
                break;
            case 'delete':
                $this->activityLog->activity = $data['activity'] = $this->logDelete($entity, $id);
                break;
            case 'update-status':
                $this->activityLog->activity = $data['activity'] = $this->logUpdateStatus($entity, $id);
                break;
            case 'update-access':
                $this->activityLog->activity = $data['activity'] = $this->logUpdateAccess($entity, $id);
                break;
            case 'verify-email':
                $this->activityLog->activity = $data['activity'] = $this->LogVerifyEmail($entity, $id);
                break;
            case 'reset-password':
                $this->activityLog->activity = $data['activity'] = $this->logResetPassword($entity, $id);
                break;
            default:
                # code...
                break;
        }
        $this->activityLog->ip_address = $data['ip_address'];
        $this->activityLog->device = $data['device'];
        $this->activityLog->browser = $data['browser'];
        $this->activityLog->platform = $data['platform'];
        $this->activityLog->date_updated = now();
        $this->activityLog->created_at = now();
        $this->activityLog->created_by_id = auth()->user()->id;
        $this->activityLog->save();
    }
    public function logResetPassword($entityName, $id = null)
    {
        return "The password of {$entityName} with ID: {$id} has been reset";
    }
    public function LogVerifyEmail($entityName, $id = null)
    {
        return "{$entityName} email verification status with ID: {$id} has been updated.";
    }
    public function logUpdateAccess($entityName, $id = null)
    {
        return "{$entityName} module access with ID: {$id} has been updated.";
    }
    public function logUpdateStatus($entityName, $id = null)
    {
        return "{$entityName} status with ID: {$id} has been updated.";
    }
    public function logCreate($entityName)
    {
        return $message = "A new {$entityName} record has been created.";
    }
    public function logUpdate($entityName, $id = null)
    {
        return $message = "{$entityName} record with ID: {$id} has been updated.";
    }
    public function logDelete($entityName, $id = null)
    {
        return $message = "{$entityName} record with ID: {$id} has been deleted.";
    }
    public function getUserDeviceDetails()
    {
        $deviceInfo = [
            'ip_address' => file_get_contents('https://api.ipify.org'),
            'device' => $this->agent->deviceType(),
            'browser' => $this->agent->browser(),
            'platform' => $this->agent->platform(),
            'created_by_id' => auth()->user()->id,
        ];
        return $deviceInfo;
    }
}