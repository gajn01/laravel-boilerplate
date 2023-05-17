<?php
namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Models\SanitaryModel as SanitaryModel;
use App\Models\CriticalDeviationResult as CriticalDeviationResultModel;

class Deviation extends Component
{
    public $f_major_sd = [];
    public $f_product;
    public $deviation_list;
    public $audit_status;
    public $audit_forms_id;

    public function mount($data = null, $status = null, $id = null)
    {
        $this->deviation_list = $data;
        $this->audit_status = $status;
        $this->audit_forms_id = $id;
    }
    public function render()
    {
        $sanitation_defect = SanitaryModel::select('id', 'title', 'code')->get();
        return view('livewire.component.deviation', ['sanitation_list' => $sanitation_defect])->extends('layouts.app');
    }
    public function updateCriticalDeviation($data = null, $value = null, $deviation = null)
    {
        if (!$this->audit_status) {
            return;
        }
        $query = CriticalDeviationResultModel::where('form_id', $this->audit_forms_id)
            ->where('category_id', $data['category_id'])
            ->where('deviation_id', $data['id'])
            ->where('critical_deviation_id', $data['critical_deviation_id']);
        if ($deviation == "remarks") {
            $query->update(['remarks' => $value]);
        } else if ($deviation == "dropdown") {
            $query->update(['dropdown' => $value]);
        } else if ($deviation == "score") {
            $query->update(['score' => $value]);
        } else if ($deviation == "sd") {
            $query->update(['sd' => $value]);
        } else if ($deviation == "location") {
            $query->update(['location' => $value]);
        } else if ($deviation == "product") {
            $query->update(['product' => $value]);
        }
    }
}
