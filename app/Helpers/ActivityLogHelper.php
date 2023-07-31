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
                 $this->activityLog->activity = $data['activity'] = $this->logUpdate($entity,$id);
                break;
            case 'delete':
                 $this->activityLog->activity = $data['activity'] = $this->logDelete($entity,$id);
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
        $this->activityLog->created_by_id = auth()->user()->id;
        $this->activityLog->save();
    }
    public function logCreate($entityName)
    {
        return $message = "A new {$entityName} record has been created.";
    }
    public function logUpdate($entityName, $id = null)
    {
        return $message = "A {$entityName} record with ID: {$id} has been updated.";
    }

    public function logDelete($entityName, $id = null)
    {
        return $message =  "{$entityName} record with ID: {$id} has been deleted.";
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