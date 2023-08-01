<?php
namespace App\Http\Livewire\Settings;
use Illuminate\Support\Facades\Gate;
use App\Models\SanitaryModel;
use Livewire\Component;
use Livewire\WithPagination;
use App\Helpers\CustomHelper;
use App\Helpers\ActivityLogHelper;

class Sanitary extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];
    public $sanitary_id;
    public $title;
    public $code;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public $limit = 10;
    protected  ActivityLogHelper $activity;
    public function __construct()
    {
        $this->activity = new ActivityLogHelper;
    }
    public function mount(){
        if (!Gate::allows('allow-view', 'module-sanitation-defect-management')) {
            return redirect()->route('dashboard');
        }
    }    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $sanitary_list = SanitaryModel::select('id', 'title', 'code')
            ->where('title', 'like', $searchTerm)
            ->orWhere('code', 'like', $searchTerm)
            ->paginate($this->limit);
        return view('livewire.settings.sanitary', ['sanitary_list' => $sanitary_list])->extends('layouts.app');
    }
    public function showModal($sanitary_id = null)
    {
        $sanitary = SanitaryModel::find($sanitary_id);
        $this->title = optional($sanitary)->title;
        $this->code = optional($sanitary)->code;
        $this->sanitary_id = $sanitary_id;
        $this->modalTitle = $this->sanitary_id ? 'Edit Sanitation Defect' : 'Add Sanitation Defect';
        $this->modalButtonText = $this->sanitary_id ? 'Update' : 'Add';
    }
    public function onSave()
    {
        $access = 'allow-create';
        if($this->sanitary_id){
            $access = 'allow-edit';
        }
        if(!Gate::allows($access,'module-sanitation-defect-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }

        $this->validate(
            [
                'title' => 'required',
                'code' => 'required',
            ]
        );
        SanitaryModel::updateOrCreate(
            ['id' => $this->sanitary_id ?? null],
            [
                'title' => strip_tags($this->title),
                'code' => strip_tags($this->code),
            ]
        );
        $this->reset();
        $this->onAlert(false, 'Success', 'Sanitation defect saved successfully!', 'success');
        CustomHelper::onRemoveModal($this, '#sanitaryModal');
        $action = $this->sanitary_id ?  'update' : 'create';
        $this->activity->onLogAction($action,'Sanitary', $this->sanitary_id ?? null);
    }
    public function onDelete($sanitary_id)
    {
        if(!Gate::allows('allow-delete','module-sanitation-defect-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $sanitary = SanitaryModel::find($sanitary_id);
        $sanitary->delete();
        $this->activity->onLogAction('delete','Sanitary', $sanitary_id ?? null);

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
