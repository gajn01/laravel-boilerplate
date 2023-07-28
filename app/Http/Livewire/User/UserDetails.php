<?php
namespace App\Http\Livewire\User;

use App\Helpers\CustomHelper;
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
    public $isedit, $sameUser = false;
    private $allowUserAccessUpdate;
    public $moduleList = [
        ['module' => "module-user-management", 'module_name' => "User Management", 'access_type' => 1, 'parent' => null, 'description' => 'Manage users.'],
        ['module' => "module-reset-password", 'module_name' => "Reset Password", 'access_type' => 0, 'parent' => "module-user-management", 'description' => 'Reset user password.'],
        ['module' => "module-set-status", 'module_name' => "Set Status", 'access_type' => 0, 'parent' => "module-user-management", 'description' => 'Set user status to active/inactive.'],
        ['module' => "module-override-email-verification", 'module_name' => "Override Email Verifcation", 'access_type' => 0, 'parent' => "module-user-management", 'description' => 'Override user email verification.'],
        ['module' => "module-set-access-scope", 'module_name' => "Set Access Scope", 'access_type' => 0, 'parent' => "module-user-management", 'description' => 'Set access scope.'],
        ['module' => "module-set-module-access", 'module_name' => "Set Module Access", 'access_type' => 0, 'parent' => "module-user-management", 'description' => 'Set module access.'],
        ['module' => "module-transaction",'module_name' => "Transaction Type Settings",'access_type' => 1,'parent' => null,'description' => 'Access Transaction Type.'],
        ['module' => "module-test", 'module_name' => "Set test", 'access_type' => 0, 'parent' => "module-transaction", 'description' => 'Set module access.'],

    ];
    protected function rules()
    {
        return [
            'isactive' => 'boolean',
            'user.name' => 'required|string|max:255',
            'usertype' => 'required|integer',
            'user.email' => 'required|email|max:255|unique:users,email,' . $this->user->id . '',
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
        $this->sameUser = Auth::user()->id == $this->user->id ? true : false;
        $this->loadUserAccess();
    }
     /*    private function loadUserAccess()
        {
            $this->useraccess = null;
            $ua = $this->user->userAccessArray;
            foreach ($this->moduleList as $module) {
                $key = is_null($ua) == false && empty($ua) == false ? array_search($module['module'], array_column($ua, 'module')) : FALSE;
                if ($key === FALSE) {
                    $access = new UserAccess();
                    $access->module = $module['module'];
                    $access->enabled = false;
                    $access->access_level = 0;
                    $access->access_type = $module['access_type'];
                    $this->useraccess[] = $access;
                } else {
                    $this->useraccess[] = $ua[$key];
                }
            }
            dd($this->useraccess);
        } */
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
        // dd($this->useraccess);
    }

    public function edit()
    {
        if($this->usertype == 0 && $this->sameUser == false){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $this->isedit = true;
    }
    public function cancel()
    {
        $this->isedit = false;
        $this->user = User::findOrFail($this->user->id);
        $this->isactive = $this->user->is_active;
        $this->usertype = $this->user->user_type;
    }
    public function render()
    {
        return view('livewire.user.user-details')->extends('layouts.app');
    }
    public function onAlert($is_confirm = false, $title = null, $message = null, $type = null, $data = null)
    {
        CustomHelper::onShow($this, $is_confirm, $title, $message, $type, $data);
    }
    public function reset(...$properties)
    {
        $this->resetValidation();
    }
}