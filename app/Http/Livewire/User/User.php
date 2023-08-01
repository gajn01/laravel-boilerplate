<?php
namespace App\Http\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Livewire\WithPagination;
use App\Helpers\CustomHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User as UserModel;
use App\Models\Store;
use App\Helpers\ActivityLogHelper;


class User extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];
    public $search = '';
    public $displaypage = 10;
    public UserModel $user;
    public $password,$password_confirmation;
    protected  ActivityLogHelper $activity;
    public function __construct()
    {
        $this->activity = new ActivityLogHelper;
    }
    protected function rules()
    {
        return [
            'user.name' => 'required|string|max:255',
            'user.email' => 'required|email|max:255|unique:user,email,' . $this->user->id . '',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8|same:password',
            'user.contact_number' => 'string|max:30',
            'user.user_type' => 'required|integer',
        ];
    }
    public function mount()
    {
        if(!Gate::allows('allow-view','module-user-management')) redirect()->route('dashboard');

    }
    public function render()
    {
        $store = Store::get();
        $users = UserModel::when(auth()->user()->user_type > 1, fn($q)=>
             $q->where('user_type','>',1)
                ->whereNot('id', auth()->user()->id)
        )
        ->where(fn($q) =>
             $q->where('name','like','%'.$this->search.'%')
                ->orWhere('email','like','%'.$this->search.'%')
        )
        ->paginate($this->displaypage);
        return view('livewire.user.user', ['user_list' => $users, 'store_list' => $store])->extends('layouts.app');
    }
    public function create()
    {
        $this->user = new UserModel();
    }
    public function cancel(){
        $this->resetValidation();
    }
    public function getId($id)
    {
        $this->user = UserModel::findOrFail($id);
    }
    public function save()
    {
        if(!Gate::allows('allow-create','module-user-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        try
        {
            $this->validate();
            $this->user->date_created = now();
            $this->user->date_updated = now();
            $this->user->created_by_id = auth()->user()->id;
            $this->user->last_updated_by_id = auth()->user()->id;
            $this->user->password = Hash::make($this->password);
            $this->user->is_active = true;
            $this->user->user_access = '';
            $this->user->save();
            //event(new Registered($this->user)); //Enable when email is set up
            redirect()->route('user-details',['id' => $this->user->id]);
            $this->activity->onLogAction('create','Account', null);
        }
        catch(QueryException $e)
        {
            $this->onAlert(false, 'Error', $e->getMessage(), 'warning');
        }
        CustomHelper::onRemoveModal($this, '#createModal');
        $this->resetValidation();
    }
    public function delete()
    {
        if(!Gate::allows('allow-delete','module-user-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
             CustomHelper::onRemoveModal($this, '#deleteModal');
            return;
        }
        try
        {
            $this->user->delete();
            $this->onAlert(false, 'Delete Successful', 'User deleted!', 'success');
            $this->user = new UserModel();
            $this->activity->onLogAction('delete','Account',$this->user->id ?? null);
        }
        catch(QueryException $e)
        {
            if($e->getCode() == 23000)
            {
                $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            }else{
                $this->onAlert(false, 'Error', $e->getMessage(), 'warning');
            }
        }
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