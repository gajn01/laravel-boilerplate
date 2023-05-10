@section('title', 'Mary Grace Restaurant Operation System / Audit Forms')

<div class="container-xl">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('store') }}">Store</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $store_name }}</li>
        </ol>
    </nav>

    <div class="page-utilities mb-3">
        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
            <div class="col-auto mb-3">
                <a class="btn app-btn-primary"
                    wire:click="onStartAndComplete(true,'Are you sure?','warning')">{{ $actionTitle }}</a>
            </div>
        </div>
        <nav wire:ignore id="audit-form-tab"
            class="audit-form-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4 justify-content-center">
            @forelse ($category_list as $key => $data)
                <a @class([
                    'flex-sm-fill',
                    'text-sm-center',
                    'nav-link',
                    'active' => $key == 0,
                ]) id="cat{{ $data->id }}-tab" data-bs-toggle="tab"
                    wire:click="getCategoryIndex({{ $key }})" href="#cat{{ $data->id }}" role="tab"
                    aria-controls="cat{{ $data->id }}" aria-selected="{{ $key == 0 ? 'true' : 'false' }}">
                    {{ $data->name }}
                </a>
            @empty
                <p class="m-0 p-2">No category found!</p>
            @endforelse
        </nav>

        <div class="tab-content" id="audit-form-tab-content">
            @forelse ($category_list as $key => $data)
                <div class="tab-pane fade show {{ $key == 0 ? 'active' : '' }}" id="cat{{ $data->id }}"
                    role="tabpanel" aria-labelledby="cat{{ $data->id }}-tab">
                    <div class="row g-4 mb-4">
                        <div class="col-12  {{ $data->critical_deviation->isNotEmpty() ? 'col-lg-6' : 'col-lg-12' }}">
                            <div class="app-card app-card-chart  shadow-sm">
                                <div class="app-card-header p-3">
                                    <h4 class="app-card-title">Overall Score</h4>
                                </div>
                                <div class="app-card-body p-3 p-lg-4">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-12">
                                            <table class="table app-table-hover mb-0 text-left ">
                                                <thead>
                                                    <tr>
                                                        <th class="cell">Category</th>
                                                        <th class="cell text-center">Base</th>
                                                        <th class="cell text-center">Score</th>
                                                        <th class="cell text-center">%</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data->sub_categ['data_items'] as $sub)
                                                        <tr>
                                                            <td class="core_name_total"><a
                                                                    href="#{{ $sub['name'] }}">{{ $sub['name'] }}</a>
                                                            </td>
                                                            <td class="text-center">{{ $sub['base_score'] }}</td>
                                                            <td class="text-center">{{ $sub['base_score'] }}</td>
                                                            <td class="text-center"> {{ $sub['total_percent'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td>
                                                            <h5 class="app-card-title ">Total</h5>
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $data->sub_categ['total_base_score'] }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $data->sub_categ['total_base_score'] }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $data->sub_categ['total_percentage'] }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--      @if ($data->critical_deviation->isNotEmpty())
                            <div class="col-12 col-lg-6" wire:ignore>
                                <div class="app-card app-card-chart h-100 shadow-sm">
                                    <div class="app-card-header p-3">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-auto">
                                                <h4 class="app-card-title">Critical Deviation</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <livewire:component.deviation :data="$data->critical_deviation">
                                </div>
                            </div>
                        @endif --}}
                    </div>
                    <div class="app-card app-card-orders-table shadow-sm mb-5 bg-none">
                        <div class="app-card-body">
                            @if ($key == 0)
                                <div class="accordion mb-3" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                <h6 class="card-title product-name">Speed and Accuracy</h6>
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <label for="" class="mb-3">Cashier TAT</label>
                                                <svg class="icon" wire:click="addInput(0)"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                    <path
                                                        d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                                                </svg>
                                                <a class="btn app-btn-primary float-right" wire:ignore role="button"
                                                    wire:click="setTime(0)">Set</a>
                                                @foreach ($cashier_tat as $item)
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-9">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <input type="text" class="form-control"
                                                                            name="cashier_name"
                                                                            placeholder="Cashier Name"
                                                                            id="name_{{ $loop->index }}"
                                                                            wire:model.lazy="cashier_tat.{{ $loop->index }}.name"
                                                                            wire:focus="$set('currentIndex', '{{ $loop->index }}')">
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <input type="text" class="form-control"
                                                                            name="time"
                                                                            id="time_{{ $loop->index }}"
                                                                            wire:model="cashier_tat.{{ $loop->index }}.time"
                                                                            wire:focus="$set('currentField', 'time')"
                                                                            placeholder="hh:mm">
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <input type="text" class="form-control"
                                                                            name="product_order"
                                                                            id="product_order{{ $loop->index }}"
                                                                            wire:model="cashier_tat.{{ $loop->index }}.product_order"
                                                                            placeholder="Product Ordered">
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <label for="" class="">Accuracy (1
                                                                        pt.)</label>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="mb-3">
                                                                                <label for=""
                                                                                    class="">OT</label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    id="ot"
                                                                                    wire:model="cashier_tat.{{ $loop->index }}.ot"
                                                                                    wire:focus="$set('currentField', 'ot')"
                                                                                    placeholder="hh:mm">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="mb-3">
                                                                                <label for=""
                                                                                    class="">Point
                                                                                </label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    name="ot_point" id="ot_point"
                                                                                    wire:model="cashier_tat.{{ $loop->index }}.ot_point"
                                                                                    wire:focus="$set('currentField', 'ot_point')"
                                                                                    placeholder="Point">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <label for="" class="">TAT (1
                                                                        pt.)</label>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="mb-3">
                                                                                <label for=""
                                                                                    class="">Time</label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    name="tat" id="tat"
                                                                                    wire:model="cashier_tat.{{ $loop->index }}.tat"
                                                                                    wire:focus="$set('currentField', 'tat')"
                                                                                    placeholder="hh:mm">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-6">
                                                                            <div class="mb-3">
                                                                                <label for=""
                                                                                    class="">Point
                                                                                </label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    name="tat_point" id="tat_point"
                                                                                    wire:model="cashier_tat.{{ $loop->index }}.tat_point"
                                                                                    wire:focus="$set('currentField', 'tat_point')"
                                                                                    placeholder="Point">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <label for="" class="">FST (3 pts.)
                                                                    </label>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="mb-3">
                                                                                <label for=""
                                                                                    class="">Time</label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    name="fst" id="fst"
                                                                                    wire:model="cashier_tat.{{ $loop->index }}.fst"
                                                                                    wire:focus="$set('currentField', 'fst')"
                                                                                    placeholder="hh:mm">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-6">
                                                                            <div class="mb-3">
                                                                                <label for=""
                                                                                    class="">Point</label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    name="fst_point" id="fst_point"
                                                                                    wire:model="cashier_tat.{{ $loop->index }}.fst_point"
                                                                                    wire:focus="$set('currentField', 'fst_point')"
                                                                                    placeholder="Point">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-3">
                                                            <div class="mb-3">
                                                                <textarea class="form-control" name="" id="" rows="6" id="remarks_{{ $loop->index }}"
                                                                    wire:model="cashier_tat.{{ $loop->index }}.remarks" placeholder="Remarks"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <label for="" class="mb-3">Server CAT</label>
                                                <svg class="icon" wire:click="addInput(1)"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                    <path
                                                        d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                                                </svg>
                                                <a class="btn app-btn-primary float-right" wire:ignore role="button"
                                                    wire:click="setTime(1)">Set</a>
                                                @foreach ($server_cat as $item)
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-9">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <input type="text" class="form-control"
                                                                            name="server_name"
                                                                            placeholder="Server Name"
                                                                            id="name_{{ $loop->index }}"
                                                                            wire:model.lazy="server_cat.{{ $loop->index }}.name"
                                                                            wire:focus="$set('currentIndex', '{{ $loop->index }}')">
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <input type="text" class="form-control"
                                                                            name="time"
                                                                            id="time_{{ $loop->index }}"
                                                                            wire:model="server_cat.{{ $loop->index }}.time"
                                                                            wire:focus="$set('currentField', 'time')"
                                                                            placeholder="hh:mm">
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <input type="text" class="form-control"
                                                                            name="product_order"
                                                                            id="product_order{{ $loop->index }}"
                                                                            wire:model="server_cat.{{ $loop->index }}.product_order"
                                                                            placeholder="Product Ordered">
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <label for="" class="">Accuracy (1
                                                                        pt.)</label>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="mb-3">
                                                                                <label for=""
                                                                                    class="">OT</label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    id="ot"
                                                                                    wire:model="server_cat.{{ $loop->index }}.ot"
                                                                                    wire:focus="$set('currentField', 'ot')"
                                                                                    placeholder="hh:mm">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="mb-3">
                                                                                <label for=""
                                                                                    class="">Point
                                                                                </label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    name="ot_point" id="ot_point"
                                                                                    wire:model="server_cat.{{ $loop->index }}.ot_point"
                                                                                    wire:focus="$set('currentField', 'ot_point')"
                                                                                    placeholder="Point">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <label for="" class="">CAT (1
                                                                        pt.)</label>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="mb-3">
                                                                                <label for=""
                                                                                    class="">Time</label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    name="tat" id="tat"
                                                                                    wire:model="server_cat.{{ $loop->index }}.tat"
                                                                                    wire:focus="$set('currentField', 'tat')"
                                                                                    placeholder="hh:mm">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-6">
                                                                            <div class="mb-3">
                                                                                <label for=""
                                                                                    class="">Point
                                                                                </label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    name="tat_point" id="tat_point"
                                                                                    wire:model="server_cat.{{ $loop->index }}.tat_point"
                                                                                    wire:focus="$set('currentField', 'tat_point')"
                                                                                    placeholder="Point">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <label for="" class="">FST (3 pts.)
                                                                    </label>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="mb-3">
                                                                                <label for=""
                                                                                    class="">Time</label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    name="fst" id="fst"
                                                                                    wire:model="server_cat.{{ $loop->index }}.fst"
                                                                                    wire:focus="$set('currentField', 'fst')"
                                                                                    placeholder="hh:mm">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-6">
                                                                            <div class="mb-3">
                                                                                <label for=""
                                                                                    class="">Point</label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    name="fst_point" id="fst_point"
                                                                                    wire:model="server_cat.{{ $loop->index }}.fst_point"
                                                                                    wire:focus="$set('currentField', 'fst_point')"
                                                                                    placeholder="Point">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-3">
                                                            <div class="mb-3">
                                                                <textarea class="form-control" name="" id="" rows="6" id="remarks_{{ $loop->index }}"
                                                                    wire:model="server_cat.{{ $loop->index }}.remarks" placeholder="Remarks"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @forelse ($data->sub_categ['data_items'] as  $key =>  $dataItem)
                                <div class="accordion mb-3" id="accordionCategory">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="{{ $dataItem['name'] }}">
                                            <button class="accordion-button " type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#accrod{{ $dataItem['id'] }}" aria-expanded="true"
                                                aria-controls="accrod{{ $dataItem['id'] }}">
                                                <h6 class="card-title product-name">{{ $dataItem['name'] }}</h6>
                                            </button>
                                        </h2>
                                        <div id="accrod{{ $dataItem['id'] }}"
                                            class="accordion-collapse collapse show"
                                            aria-labelledby="accrod{{ $dataItem['id'] }}"
                                            data-bs-parent="#accordionCategory">
                                            <div class="accordion-body">
                                                @if ($dataItem['is_sub'] == 0)
                                                    @foreach ($dataItem['sub_category'] as $index => $auditLabel)
                                                        <div class="row mb-3">
                                                            <div class="col-sm-12 col-md-4 col-lg-4">
                                                                <p @class(['pt-4' => $index == 0])>
                                                                    {{ $auditLabel['name'] }}</p>
                                                            </div>
                                                            <div class="col-sm-12 col-md-2">
                                                                <div class="row">
                                                                    <div class="col-sm-6 col-md-6">
                                                                        @if ($index == 0)
                                                                            <label for=""
                                                                                class="form-label">BP</label>
                                                                        @endif
                                                                        <input type="text"
                                                                            class="form-control text-center" disabled
                                                                            name="bp{{ $auditLabel['name'] }}"
                                                                            id="bp"
                                                                            value="{{ $auditLabel['is_all_nothing'] ? $auditLabel['points'].'*'  : $auditLabel['points']}}"
                                                                            placeholder="">
                                                                    </div>
                                                                    <div class="col-sm-6 col-md-6">
                                                                        @if ($index == 0)
                                                                            <label for="points"
                                                                                class="form-label">Point(s)</label>
                                                                        @endif
                                                                        <input type="number"
                                                                            class="form-control text-center"
                                                                            name="points{{ $auditLabel['name'] }}"
                                                                            id="points"
                                                                            value="{{ $auditLabel['points'] }}"
                                                                            wire:change="updateRemarks(
                                                                                '{{ $loop->parent->parent->index }}', '{{ $loop->parent->index }}', '{{ $loop->index }}',
                                                                                '{{ $category_list[$loop->parent->parent->index]['id'] }}',
                                                                                '{{ $category_list[$loop->parent->parent->index]['sub_categ']['data_items'][$loop->parent->index]['id'] }}',
                                                                                '{{ $category_list[$loop->parent->parent->index]['sub_categ']['data_items'][$loop->parent->index]['sub_category'][$loop->index]['id'] }}',
                                                                                $event.target.value )">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                                <div class="row">
                                                                    <div
                                                                        class="col-sm-12 {{ $auditLabel['dropdown'] ? 'col-md-6' : 'col-md-12' }}">
                                                                        @if ($index == 0)
                                                                            <label for="remarks"
                                                                                class="form-label">Remarks</label>
                                                                        @endif
                                                                        <textarea class="form-control" name="remarks" id="remarks" rows="1"
                                                                            wire:change="updateRemarks('{{ $loop->parent->parent->index }}', '{{ $loop->parent->index }}', '{{ $loop->index }}', $event.target.value)">{{ $category_list[$loop->parent->parent->index]['sub_categ']['data_items'][$loop->parent->index]['sub_category'][$loop->index]['remarks'] }}</textarea>
                                                                    </div>

                                                                    @if (!empty($auditLabel['dropdown']))
                                                                        <div
                                                                            class="col-sm-12 col-md-6 {{ $auditLabel['dropdown'] ? '' : 'd-none' }}">
                                                                            @if ($index == 0 || empty($auditLabel['dropdown']))
                                                                                <label for=""
                                                                                    class="form-label">Deviation</label>
                                                                            @endif
                                                                            <select class="form-select form-select-md"
                                                                                wire:model="data.{{ $loop->parent->parent->index }}.data_items.{{ $loop->parent->index }}.sub_category.{{ $loop->index }}.tag"
                                                                                name="tag{{ $auditLabel['name'] }}"
                                                                                id="tag">
                                                                                <option value="0">Select a
                                                                                    deviation </option>
                                                                                @foreach ($auditLabel['dropdown'] as $result)
                                                                                    @if (isset($result['name']))
                                                                                        <option
                                                                                            value="{{ $result['id'] }}">
                                                                                            {{ $result['name'] }}
                                                                                        </option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    @foreach ($dataItem['sub_category'] as $sub_category)
                                                        <div class="accordion accordion-flush mb-3"
                                                            id="accordionFlushSubcategory">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="headingSub">
                                                                    <button class="accordion-button collapsed"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#flush-{{ $sub_category['id'] }}"
                                                                        aria-expanded="true"
                                                                        aria-controls="flush-{{ $sub_category['id'] }}">
                                                                        {{ $sub_category['name'] }}
                                                                    </button>
                                                                </h2>
                                                                <div id="flush-{{ $sub_category['id'] }}"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="flush-{{ $sub_category['id'] }}"
                                                                    data-bs-parent="#accordionFlushSubcategory">
                                                                    <div class="accordion-body">
                                                                        @foreach ($sub_category['label'] as $keyIndex => $auditLabel)
                                                                            <div class="row mb-3">
                                                                                <div
                                                                                    class="col-sm-12 col-md-4 col-lg-4">
                                                                                    <p @class(['pt-4' => $keyIndex == 0])>
                                                                                        {{ $auditLabel['name'] }}
                                                                                    </p>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-2  ">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-6 col-md-6">
                                                                                            @if ($keyIndex == 0)
                                                                                                <label for=""
                                                                                                    class="form-label">BP</label>
                                                                                            @endif
                                                                                            <input type="text"
                                                                                                class="form-control text-center"
                                                                                                disabled
                                                                                                name="bp{{ $auditLabel['name'] }}"
                                                                                                id="bp"
                                                                                                placeholder=""
                                                                                                value="{{ $auditLabel['is_all_nothing'] }}">
                                                                                        </div>
                                                                                        <div class="col-sm-6 col-md-6">
                                                                                            @if ($keyIndex == 0)
                                                                                                <label for=""
                                                                                                    class="form-label">Point</label>
                                                                                            @endif
                                                                                            <input type="number"
                                                                                                class="form-control text-center"
                                                                                                name="points{{ $auditLabel['name'] }}"
                                                                                                id="points"
                                                                                                value="{{ $auditLabel['points'] }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-sm-12 col-md-6 col-lg-6 ">
                                                                                    <div class="row">
                                                                                        <div
                                                                                            class="col-sm-12 {{ $auditLabel['dropdown'] ? 'col-md-6' : 'col-md-12' }}">
                                                                                            @if ($keyIndex == 0)
                                                                                                <label for=""
                                                                                                    class="form-label">Remarks</label>
                                                                                            @endif
                                                                                            <textarea class="form-control" name="" id="" rows="1"></textarea>
                                                                                        </div>
                                                                                        @if (!empty($auditLabel['dropdown']))
                                                                                            <div
                                                                                                class="col-sm-12 col-md-6 {{ $auditLabel['dropdown'] ? '' : 'd-none' }}">
                                                                                                @if ($keyIndex == 0 || empty($auditLabel['dropdown']))
                                                                                                    <label
                                                                                                        for=""
                                                                                                        class="form-label">Deviation</label>
                                                                                                @endif
                                                                                                <select
                                                                                                    class="form-select form-select-md"
                                                                                                    wire:model="data.{{ $loop->parent->parent->index }}.data_items.{{ $loop->parent->index }}.sub_category.{{ $loop->index }}.tag"
                                                                                                    name="tag{{ $auditLabel['name'] }}"
                                                                                                    id="tag">
                                                                                                    <option
                                                                                                        value="0">
                                                                                                        Select a
                                                                                                        deviation
                                                                                                    </option>
                                                                                                    @foreach ($auditLabel['dropdown'] as $result)
                                                                                                        @if (isset($result['name']))
                                                                                                            <option
                                                                                                                value="{{ $result['id'] }}">
                                                                                                                {{ $result['name'] }}
                                                                                                            </option>
                                                                                                        @endif
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="m-0 p-2 text-center">No category found!</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            @empty
                <p class="m-0 p-2">No category found!</p>
            @endforelse
        </div>
        <a href="#">
            <div class="floating-btn">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path
                        d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8H288c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z" />
                </svg>
            </div>
        </a>
    </div>
</div>
