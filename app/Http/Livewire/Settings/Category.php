<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Category as CategoryModel;
use App\Models\SubCategory as SubCategoryModel;
use App\Models\SubCategoryLabel as SubCategoryLabelModel;


class Category extends Component
{
    public $category_list = [];
    public $category_id;
    public $name;
    public $type;
    public $test = [];

    public function render()
    {
        return view('livewire.settings.category')->extends('layouts.app');
    }
    public function mount()
    {
        $this->category_list = CategoryModel::all(['id', 'name', 'type'])->toArray();

        $categories = CategoryModel::select(
            'categories.*',
            'sub_categories.name AS sub_category_name',
            'sub_categories.id AS sub_category_id',
            'sub_category_labels.name AS label_name',
            'sub_category_labels.id AS label_id'
        )
            ->join('sub_categories', 'sub_categories.category_id', '=', 'categories.id')
            ->join('sub_category_labels', 'sub_category_labels.sub_category_id', '=', 'sub_categories.id')
            ->where('categories.id', 2)
            ->get()->toArray();

     /*    $this->test = [
            [
                'data_items' => [
                    collect(SubCategoryModel::where('category_id', 2)->get())->map(function ($item) {
                        return [
                            'id' => $item['id'],
                            'name' => $item['name'],
                            'audit_label' => [
                                collect(SubCategoryLabelModel::where('sub_category_id', $item['id'])->get())->map(function ($item) {
                                                return [
                                                    'id' => $item['id'],
                                                    'name' => $item['name'],
                                                    'points' => '',
                                                    'remarks' => '',
                                                ];
                                            })

                            ]
                        ];
                    }),

                ],
            ]
        ]; */

        $subCategories = SubCategoryModel::where('category_id', 2)->with('labels')->get();

            $this->test = [
                [
                    'data_items' => $subCategories->map(function ($subCategory) {
                        return [
                            'id' => $subCategory->id,
                            'name' => $subCategory->name,
                            'audit_label' => $subCategory->labels->map(function ($label) {
                                return [
                                    'id' => $label->id,
                                    'name' => $label->name,
                                    'points' => '',
                                    'remarks' => '',
                                ];
                            })
                        ];
                    })
                ]
            ];



    }

    public function onSave()
    {
        $this->validate(
            [
                'name' => 'required|max:255',
                'type' => 'required|in:0,1',
            ]
        );

        if ($this->category_id) {
            $category = CategoryModel::findOrFail($this->category_id);
        } else {
            $category = new CategoryModel();
        }
        $category->name = $this->name;
        $category->type = $this->type;
        $category->save();

        $this->reset();
        $this->category_list = CategoryModel::all(['id', 'name', 'type'])->toArray();
        $this->onAlert(false, 'Success', 'Category saved successfully!', 'success');
        $this->dispatchBrowserEvent('remove-modal', ['modalName' => '#category_modal']);
        $this->emit('saved');

    }

    public function onAlert($is_confirm = false, $title = null, $message = null, $type = null, $data = null)
    {
        $alert = $is_confirm ? 'confirm-alert' : 'show-alert';
        $this->dispatchBrowserEvent($alert, [
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'data' => $data
        ]);
    }
    public function reset(...$properties)
    {
        $this->name = '';
        $this->category_id = '';
        $this->type = '';
        $this->resetValidation();
    }
    public function onAlertSent($data)
    {
        $this->onDelete($data);
    }
}
