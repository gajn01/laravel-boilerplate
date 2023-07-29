<?php
namespace App\Http\Livewire\User;

use App\Helpers\CustomHelper;
use Illuminate\Database\QueryException;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\NonDBModel\UserAccess;
use Auth;

class UserDetails extends Component
{
    public User $user;
    public $useraccess, $usertype, $isactive;
    public $isedit, $isSameUser = false;
    private $allowUserAccessUpdate;
    public $moduleList = [
        ['module' => "module-user-management", 'module_name' => "User Management", 'access_type' => 1, 'parent' => null, 'description' => 'Manage users.'],
        ['module' => "module-reset-password", 'module_name' => "Reset Password", 'access_type' => 0, 'parent' => "module-user-management", 'description' => 'Reset user password.'],
        ['module' => "module-set-status", 'module_name' => "Set Status", 'access_type' => 0, 'parent' => "module-user-management", 'description' => 'Set user status to active/inactive.'],
        ['module' => "module-override-email-verification", 'module_name' => "Override Email Verifcation", 'access_type' => 0, 'parent' => "module-user-management", 'description' => 'Override user email verification.'],
        ['module' => "module-set-access-scope", 'module_name' => "Set Access Scope", 'access_type' => 0, 'parent' => "module-user-management", 'description' => 'Set access scope.'],
        ['module' => "module-set-module-access", 'module_name' => "Set Module Access", 'access_type' => 0, 'parent' => "module-user-management", 'description' => 'Set module access.'],
        ['module' => "module-transaction", 'module_name' => "Transaction Type Settings", 'access_type' => 1, 'parent' => null, 'description' => 'Access Transaction Type.'],
        ['module' => "module-test", 'module_name' => "Set test", 'access_type' => 0, 'parent' => "module-transaction", 'description' => 'Set module access.'],

    ];
    protected function rules()
    {
        return [
            'user.is_active' => 'boolean',
            'user.name' => 'required|string|max:255',
            'usertype' => 'required|integer',
            'user.email' => 'required|email|max:255|unique:user,email,' . $this->user->id . '',
            'user.contact_number' => 'string|max:30',
        ];
    }
    public function mount($id = null)
    {
        if (!Gate::allows('allow-view', 'module-user-management')) {
            return redirect()->route('dashboard');
        }
        $this->user = User::findOrFail($id);
        $this->isactive = $this->user->is_active;
        $this->usertype = $this->user->user_type;
        $this->isSameUser = Auth::user()->id == $this->user->id ? true : false;
        $this->loadUserAccess();
    }

    private function loadUserAccess()
    {
        $this->useraccess = [];
        $ua = $this->user->userAccessArray ?? [];
        foreach ($this->moduleList as $module) {
            $key = array_search($module['module'], array_column($ua, 'module'));
            if ($key === FALSE) {
                $access = new UserAccess();
                $access->module = $module['module'];
                $access->enabled = false;
                $access->access_level = 0;
                $access->access_type = $module['access_type'];
            } else {
                $access = $ua[$key];
            }
            $this->useraccess[] = $access;
        }
    }
    public function render()
    {
        return view('livewire.user.user-details')->extends('layouts.app');
    }
    public function onAlert($is_confirm = false, $title = null, $message = null, $type = null, $data = null)
    {
        CustomHelper::onShow($this, $is_confirm, $title, $message, $type, $data);
    }
    public function edit()
    {
        if ($this->usertype == 0 && $this->isSameUser == false) {
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $this->isedit = true;
    }
    public function cancel()
    {
        $this->isedit = false;
        $this->user = User::findOrFail($this->user->id);
    }
    public function save(){
        if (!Gate::allows('allow-edit', 'module-user-management')) {
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        try {
            $this->validate();
            $getCurrentData = User::findOrFail($this->user->id);
            if ($getCurrentData->email != $this->user->email)
                $getCurrentData->email_verified_at = null;
            $getCurrentData->last_updated_by_id = auth()->user()->id;
            $getCurrentData->name = $this->user->name;
            $getCurrentData->email = $this->user->email;
            $getCurrentData->user_type = $this->usertype;
            $getCurrentData->contact_number = $this->user->contact_number;
            $getCurrentData->save();
            $this->onAlert(false, 'Update Successful', 'User account details updated.', 'success');
            $this->isedit = false;
        } catch (QueryException $e) {
            $this->onAlert(false, 'Error', $e->getMessage(), 'warning');
        }
    }
    public function resetPassword(){
        if (!Gate::allows('access-enabled', 'module-reset-password')) {
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        try {
            if ($this->user->user_type == 0 && $this->sameUser == false) {
                $this->onAlert(false, 'Unauthorized Action', 'Cannot reset Super User password!', 'warning');
                return;
            }
            $this->user->password = Hash::make("Password123");
            $this->user->save();
            $this->onAlert(false, 'Password Reset Successful', 'Password was reset to "Password123', 'success');
        } catch (QueryException $e) {
            $this->onAlert(false, 'Error', $e->getMessage(), 'warning');
        }
    }
    public function overrideEmailVerification()
    {
        if (!Gate::allows('access-enabled', 'module-override-email-verification')) {
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        try {
            $this->user->last_updated_by_id = auth()->user()->id;
            $this->user->email_verified_at = now();
            $this->user->save();
            $this->onAlert(false, 'Update Successful', 'E-mail verification override successful.', 'success');
        } catch (QueryException $e) {
            $this->onAlert(false, 'Error', $e->getMessage(), 'warning');
        }
    }
    public function onUpdateStatus()
    {
        if (!Gate::allows('access-enabled', 'module-set-status')) {
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        if ($this->isSameUser) {
            $this->onAlert(false, 'Action Cancelled', 'Cannot deactivate own account!', 'warning');
            return;
        }
        try {
            $this->user->save();
            $this->onAlert(false, 'Update Successful', 'User status updated.', 'success');
        } catch (QueryException $e) {
            $this->onAlert(false, 'Error', $e->getMessage(), 'warning');
        }
    }
    public function updateUserAccess()
    {
        $this->allowUserAccessUpdate = Gate::allows('access-enabled','module-set-module-access');
        if($this->allowUserAccessUpdate == false){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $this->user->user_access = json_encode($this->useraccess);
        $this->user->save();
        $this->loadUserAccess();
        $this->onAlert(false, 'Update Successful', 'User access updated.', 'success');
    }
}