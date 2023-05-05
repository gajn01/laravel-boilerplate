<?php
namespace App\Http\Livewire\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;
use App\Helpers\CustomHelper;
use App\Models\User as UserModel;
use App\Models\Store as StoreModel;
class User extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];
    public $account_id;
    public $employee_id;
    public $store_id;
    public $name;
    public $email;
    public $password;
    public $user_level = 1;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public $limit = 10;
    public $is_toggle = false;
    public function render()
    {
        $store = StoreModel::select('*')->get();
        $searchTerm = '%' . $this->searchTerm . '%';
        $user_list = UserModel::select('id', 'name', 'employee_id', 'email', 'password', 'user_level','status')
            ->where('name', 'like', $searchTerm)
            ->orWhere('employee_id', 'like', $searchTerm)
            ->orWhere('email', 'like', $searchTerm)
            ->paginate($this->limit);
        return view('livewire.user.user', ['user_list' => $user_list,'store_list' => $store])->extends('layouts.app');
    }
    public function showModal($account_id = null)
    {
        $this->account_id = $account_id;
        $account = UserModel::find($account_id);
        $this->employee_id = optional($account)->employee_id;
        $this->name = optional($account)->name;
        $this->email = optional($account)->email;
        $this->password = optional($account)->password;
        $this->resetValidation();
        $this->modalTitle = $this->account_id ? 'Edit Account' : 'Add Account';
        $this->modalButtonText = $this->account_id ? 'Update' : 'Add';
    }
    public function onSave()
    {
        $this->validate(
            [
                'user_level' => 'required|numeric',
                'employee_id' => 'required|min:4',
                'name' => 'required|max:255',
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]
        );
        UserModel::updateOrCreate(
            ['id' => $this->account_id ?? null],
            [
                'user_level' => strip_tags($this->user_level),
                'employee_id' => strip_tags($this->employee_id),
                'name' => strip_tags($this->name),
                'email' => strip_tags($this->email),
                'password' => strip_tags(Hash::make($this->password)),
                'status' => '1'
            ]
        );
        $this->resetValidation();
        $this->onAlert(false, 'Success', 'Account saved successfully!', 'success');
        CustomHelper::onRemoveModal($this, '#user_modal');
    }
    public function onTogglePassword(){
      /*   $this->is_toggle = !$this->is_toggle; */
        $this->emit('toggleEye');
    }
    public function onAlert($is_confirm = false, $title = null, $message = null,  $type = null, $data = null)
    {
        CustomHelper::onShow($this, $is_confirm, $title, $message, $type, $data);
    }
    public function reset(...$properties)
    {
        $this->resetValidation();
    }
}
