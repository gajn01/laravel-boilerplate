@section('title', 'Mary Grace Restaurant Operation System / Audit Forms')
<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('audit') }}">Audit</a></li>
            <li class="breadcrumb-item active" aria-current="page"> {{ $store->name }}</li>
        </ol>
    </nav>
    {{-- wire:poll.10s --}}
    <div class="page-utilities mb-3" >
        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
            <div class="col-auto mb-3">
              
                @if ($auditForm->audit_status == 0)
                    <a class="btn app-btn-primary" wire:click="onStartAudit"> Start Audit</a>
                @else
                    <a class="btn app-btn-primary" href="{{ route('audit.view.result', [$auditForm->id, $summary->id]) }}"> Result</a>
                @endif
            </div>
        </div>
    </div>
    <nav wire:ignore id="audit-form-tab"class="audit-form-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4 justify-content-center nav-sticky">
        @forelse ($categoryList as $key => $data)
            <a @class(['flex-sm-fill','text-sm-center','nav-link','active' => $key == $active_index,
            ]) id="cat{{ $data->id }}-tab" data-bs-toggle="tab"
                wire:click="setActive({{ $key }})" href="#cat{{ $data->id }}" role="tab"
                aria-controls="cat{{ $data->id }}"
                aria-selected="{{ $key == $active_index ? 'true' : 'false' }}">
                {{ $data->name }}
            </a>
        @empty
            <p class="m-0 p-2">No category found!</p>
        @endforelse
    </nav>
    <a href="#">
        <div class="floating-btn">
            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <path
                    d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8H288c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z" />
            </svg>
        </div>
    </a>
    <div class="tab-content" id="audit-form-tab-content">
        @forelse ($categoryList as $key => $category)
            <div class="tab-pane fade show {{ $key == $active_index ? 'active' : '' }}" id="cat{{ $category->id }}" role="tabpanel" aria-labelledby="cat{{ $category->id }}-tab">
                <div class="app-card app-card-orders-table shadow-sm mb-5 bg-none">
                    <div class="app-card-body">
                        {{-- Category List and Deviation --}}
                            <div class="row mb-2">
                                <div class="col-12  mb-4  {{ $category->critical_deviation->isNotEmpty() ? 'col-lg-6' : 'col-lg-12' }}">
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
                                                            @foreach ($category['sub_category'] as $sub_category)
                                                                <tr>
                                                                    <td class="core_name_total">
                                                                        <a href="#{{ $sub_category['name'] }}">{{ $sub_category['name'] }}</a>
                                                                    </td>
                                                                    <td class="text-center">{{ $sub_category['total_base_per_category'] }}</td>
                                                                    <td class="text-center">{{ $sub_category['total_points_per_category'] }}</td>
                                                                    <td class="text-center"> {{ $sub_category['total_percentage_per_category'] }}%</td>
                                                                </tr>
                                                            @endforeach
                                                            <tr>
                                                                <td>
                                                                    <h5 class="app-card-title ">Total</h5>
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $sub_category['total_base'] }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $sub_category['total_points'] }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $sub_category['total_percentage'] }}%
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($category->critical_deviation->isNotEmpty())
                                    <div class="col-12 col-lg-6">
                                        <div class="app-card app-card-chart h-100 shadow-sm">
                                            <div class="app-card-header p-3">
                                                <div class="row justify-content-between align-items-center">
                                                    <div class="col-auto">
                                                        <h4 class="app-card-title">Critical Deviation</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="app-card-body p-3 p-lg-4">
                                                @foreach ($category->critical_deviation as $item)
                                                    <label for="" class="form-label ">{{ $item['label'] }}</label>
                                                    @if ($item['is_sd'])
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="mb-2" wire:ignore>
                                                                    <select class="form-select form-select-md"
                                                                        wire:change="updateCriticalDeviation({{$this->auditForm->id}},{{ json_encode($item) }},$event.target.value,'sd')"
                                                                        name="sd{{ $item['id'] }}"
                                                                        id="sd{{ $item['id'] }}">
                                                                        <option value="0" {{ $item['saved_sd'] == '' ? 'selected' : '' }}> Select sd</option>
                                                                        @forelse ($sanitary_list as $sanitation)
                                                                            <option value="{{ $sanitation->code }}"
                                                                                {{ $sanitation->code === $item['saved_sd'] ? 'selected' : '' }}>
                                                                                {{ $sanitation->code }}
                                                                            </option>
                                                                        @empty
                                                                            <option value="0">No data found!</option>
                                                                        @endforelse
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($item['is_location'])
                                                        <div class="row " >
                                                            <div class="col-sm-12 col-md-6">
                                                                <div class="mb-2" wire:ignore>
                                                                    <select class="form-select form-select-md"
                                                                        wire:change="updateCriticalDeviation({{$this->auditForm->id}},{{ json_encode($item) }},$event.target.value,'location')"
                                                                        name="location{{ $item['id'] }}"
                                                                        id="location{{ $item['id'] }}">
                                                                        <option value="0" {{ $item['location'] == '' ? 'selected' : '' }}>Select location</option>
                                                                        @foreach ($item['location'] as $location_dropdown)
                                                                            <option value="{{ $location_dropdown['name'] }}"
                                                                                {{ $location_dropdown['name'] === $item['saved_location'] ? 'selected' : '' }}>
                                                                                {{ $location_dropdown['name'] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6">
                                                                <div class="mb-2" wire:ignore>
                                                                    <select class="form-select form-select-md"
                                                                        wire:change="updateCriticalDeviation({{$this->auditForm->id}},{{ json_encode($item) }},$event.target.value,'score')"
                                                                        name="loc_score{{ $item['id'] }}" id="loc_score{{ $item['id'] }}">
                                                                        <option value="0" {{ $item['score'] == '' ? 'selected' : '' }}> Select score</option>
                                                                        @foreach ($score as $scores)
                                                                            <option value="{{ $scores['name'] }}"
                                                                                {{ $scores['name'] === $item['saved_score'] ? 'selected' : '' }}>
                                                                                {{ $scores['name'] . '%' }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($item['is_product'])
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-6">
                                                                <div class="mb-2" wire:ignore.self>
                                                                    <select class="form-select form-select-md"
                                                                        wire:change="updateCriticalDeviation({{$this->auditForm->id}},{{ json_encode($item) }},$event.target.value,'product')"
                                                                        name="product{{ $item['id'] }}"
                                                                        id="product{{ $item['id'] }}">
                                                                        <option value="0"  {{ $item['product'] == '' ? 'selected' : '' }}>  Select product</option>
                                                                        @foreach ($item['product'] as $product_dropdown)
                                                                            <option value="{{ $product_dropdown['name'] }}"
                                                                                {{ $product_dropdown['name'] === $item['saved_product'] ? 'selected' : '' }}>
                                                                                {{ $product_dropdown['name'] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6">
                                                                <div class="mb-2" wire:ignore>
                                                                    <select class="form-select form-select-md"
                                                                        wire:change="updateCriticalDeviation({{$this->auditForm->id}},{{ json_encode($item) }},$event.target.value,'score')"
                                                                        name="product_score{{ $item['id'] }}"
                                                                        id="product_score{{ $item['id'] }}">
                                                                        <option value="0" {{ $item['score'] == '' ? 'selected' : '' }}>  Select score</option>
                                                                        @foreach ($score as $scores)
                                                                            <option value="{{ $scores['name'] }}"
                                                                                {{ $scores['name'] === $item['saved_score'] ? 'selected' : '' }}>
                                                                                {{ $scores['name'] . '%' }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($item['is_dropdown'])
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-6">
                                                                <div class="mb-2" wire:ignore.self>
                                                                    <select class="form-select form-select-md"
                                                                        wire:change="updateCriticalDeviation({{$this->auditForm->id}},{{ json_encode($item) }}, $event.target.value, 'dropdown')"
                                                                        name="dropdown{{ $item['id'] }}"
                                                                        id="dropdown{{ $item['id'] }}">
                                                                        <option value="0" {{ $item['dropdown'] == '' ? 'selected' : '' }}> Select deviation</option>
                                                                        @foreach ($item['dropdown'] as $dropdown)
                                                                            <option value="{{ $dropdown['name'] }}"
                                                                                {{ $dropdown['name'] === $item['saved_dropdown'] ? 'selected' : '' }}>
                                                                                {{ $dropdown['name'] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-6">
                                                                <div class="mb-2" wire:ignore.self>
                                                                    <select class="form-select form-select-md"
                                                                        wire:change="updateCriticalDeviation({{$this->auditForm->id}},{{ json_encode($item) }},$event.target.value,'score')"
                                                                        name="dp_score{{ $item['id'] }}"
                                                                        id="dp_score{{ $item['id'] }}">
                                                                        <option value="0" {{ $item['score'] == '' ? 'selected' : '' }}> Select score</option>
                                                                        @foreach ($score as $scores)
                                                                            <option value="{{ $scores['name'] }}"
                                                                                {{ $scores['name'] === $item['saved_score'] ? 'selected' : '' }}>
                                                                                {{ $scores['name'] . '%' }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($item['remarks'])
                                                        <div class="mb-2" wire:ignore.self>
                                                            <textarea class="form-control"
                                                                wire:change="updateCriticalDeviation({{$this->auditForm->id}},{{ json_encode($item) }},$event.target.value,'remarks')"
                                                                name="remarks{{ $item['id'] }}" id="remarks{{ $item['id'] }}" rows="2"
                                                                placeholder="Enter remarks here...">{{ $item['saved_remarks'] }}</textarea>
                                                        </div>
                                                    @endif
                                                    @if ($item['score_dropdown_id'])
                                                        <div class="mb-2" wire:ignore.self>
                                                            <select class="form-select form-select-md"
                                                                wire:change="updateCriticalDeviation({{$this->auditForm->id}},{{ json_encode($item) }},$event.target.value,'score')"
                                                                name="dp_score{{ $item['id'] }}"
                                                                id="dp_score{{ $item['id'] }}">
                                                                <option value="0"  {{ $item['score'] == '' ? 'selected' : '' }}> Select score</option>
                                                                @foreach ($score as $scores)
                                                                    <option value="{{ $scores['name'] }}"
                                                                        {{ $scores['name'] === $item['saved_score'] ? 'selected' : '' }}>
                                                                        {{ $scores['name'] . '%' }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        <div class="row">
                            @foreach ($category['sub_category'] as $sub_category)
                                <div class="accordion mb-2" id="accordionCategory">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="{{ $sub_category['name'] }}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accrod{{ $sub_category['id'] }}" aria-expanded="true" aria-controls="accrod{{ $sub_category['id'] }}">
                                                <h6 class="card-title product-name">{{ $sub_category['name'] }}</h6>
                                            </button>
                                        </h2>
                                        <div id="accrod{{ $sub_category['id'] }}"class="accordion-collapse collapse show"  aria-labelledby="accrod{{ $sub_category['id'] }}" data-bs-parent="#accordionCategory">
                                            <div class="accordion-body">
                                                @foreach ($sub_category['sub_sub_category'] as $index => $auditLabel)
                                                {{-- NO sub_sub_sub_category --}}
                                                    @if ($sub_category['is_sub'] == 0)
                                                        {{-- Deviation Header --}}
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-5">
                                                                </div>
                                                                @if ($index == 0)
                                                                    <div class="col-sm-1 col-md-1">
                                                                        <label for="" class="form-label">BP</label>
                                                                    </div>
                                                                    <div class="col-sm-1 col-md-1">
                                                                        <label for="points" class="form-label">Point(s)</label>
                                                                    </div>
                                                                @endif
                                                                <div class="col-sm-12 col-md-3 mb-2 {{ $auditLabel['dropdown'] ? 'col-md-3' : 'col-md-5' }}">
                                                                    @if ($index == 0)
                                                                        <label for="remarks"
                                                                            class="form-label">Remarks</label>
                                                                    @endif
                                                                </div>
                                                                @if (!empty($auditLabel['dropdown']))
                                                                    <div class="col-sm-12 col-md-2 mb-2 {{ $auditLabel['dropdown'] ? '' : 'd-none' }}">
                                                                        @if ($index == 0 || empty($auditLabel['dropdown']))
                                                                            <label for="" class="form-label">Deviation</label>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        <div class="row mb-3">
                                                            {{-- Deviation Label --}}
                                                                <div class="col-sm-12 col-md-5 col-lg-5">
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input mb-2" type="checkbox" id="toggle-switch"
                                                                            @disabled( $store->audit_status == 0 ? true : false)
                                                                            wire:change="updateNA({{ json_encode($auditLabel)}},$event.target.checked ? 0 : 1)"
                                                                            @checked($categoryList[$loop->parent->parent->index]['sub_category'][$loop->parent->index]['sub_sub_category'][$loop->index]['is_na'] ? false: true)>
                                                                        <label class="form-check-label "  @class(['pt-4' => $index == 0 ]) for="toggle-switch"> {{ $auditLabel['name'] }}</label>
                                                                    </div>
                                                                </div>
                                                            {{-- Deviation bp,points,remarks --}}
                                                                <div class="col-sm-12 col-md-1">
                                                                    <input type="text" class="form-control text-center mb-2" disabled name="bp{{ $auditLabel['name'] }}" id="bp" 
                                                                        value="{{ $auditLabel['is_all_nothing'] ? $auditLabel['bp'] . '*' : $auditLabel['bp'] }}">
                                                                </div>
                                                                <div class="col-sm-12 col-md-1">
                                                                    <input type="number" class="form-control text-center mb-2" @disabled($auditLabel['is_na'] == 1 || $store->audit_status == 0 ? true : false) 
                                                                        name="points{{ $auditLabel['id'] }}" 
                                                                        id="points{{ $auditLabel['id'] }}"
                                                                        value="{{$auditLabel['points']}}"
                                                                        wire:change="updatePoints({{$sub_category['is_sub']}},{{json_encode($auditLabel)}}, $event.target.value)"
                                                                        min="{{ $auditLabel['is_all_nothing'] ? $auditLabel['bp'] : 0 }}" 
                                                                        max="{{ $auditLabel['is_all_nothing'] ? 0 : $auditLabel['bp'] }}">
                                                                </div>
                                                                <div class="col-sm-12 col-md-3  mb-2 {{ $auditLabel['dropdown'] ? 'col-md-3' : 'col-md-5' }}">
                                                                    <textarea class="form-control" wire:change="updateRemarks({{$sub_category['is_sub']}},{{$auditLabel['result_id']}}, $event.target.value)"
                                                                    @disabled($auditLabel['is_na'] == 1 || $store->audit_status == 0  ? true : false) name="remarks" id="remarks" rows="1">{{$auditLabel['remarks']}}</textarea>
                                                                </div>
                                                                @if (!empty($auditLabel['dropdown']))
                                                                <div class="col-sm-12 col-md-2 {{ $auditLabel['dropdown'] ? '' : 'd-none' }}">
                                                                    <select class="form-select form-select-md" 
                                                                    wire:change="updateDeviation({{$sub_category['is_sub']}},{{$auditLabel['result_id']}}, $event.target.value)"
                                                                    @disabled($auditLabel['is_na'] == 1 || $store->audit_status == 0  ? true : false) name="tag{{ $auditLabel['name'] }}" id="tag">
                                                                        <option value="null"> Select a deviation </option>
                                                                        @foreach ($auditLabel['dropdown'] as $result)
                                                                            @isset($result['name'])
                                                                                <option
                                                                                    value="{{ $result['name'] }}"
                                                                                    {{ $result['name'] === $auditLabel['deviation'] ? 'selected' : '' }}>
                                                                                    {{ $result['name'] }}
                                                                                </option>
                                                                            @endisset
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @else
                                                        {{-- Deviation Header --}}
                                                            <div class="row mb-2">
                                                                <div class="col-12">
                                                                    <label class="form-check-label fw-bold " @class(['pt-4' => $index == 0 ]) for="toggle-switch"> {{ $auditLabel['name'] }}</label>
                                                                </div>
                                                            </div>
                                                            @if ($auditLabel['name'] == 'Cashier TAT')
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <svg class="icon" wire:click="addService(1)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                                            <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                                                                        </svg>
                                                                        {{-- <a class="btn app-btn-primary float-right" wire:ignore role="button" wire:click="setTime(0)">Set</a> --}}
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    @foreach ($cashier_tat as $index => $item)
                                                                        <div class="col-sm-12 col-md-12">
                                                                            <div class="row">
                                                                                <!-- Cashier Fields -->
                                                                                <div class="col-3 mb-2">
                                                                                    <label  for="name_{{ $loop->index }}">Cashier Name</label>
                                                                                    <input type="text" class="form-control"  name="cashier_name" id="name_{{ $loop->index }}"
                                                                                        value="{{ $item->name }}"
                                                                                        wire:change="updateService({{ $item }} ,'name', $event.target.value)">
                                                                                </div>
                                                                                <div class="col-2 mb-2">
                                                                                    <label for="time_{{ $loop->index }}">Time</label>
                                                                                    <input type="text" class="form-control"  name="time"
                                                                                        id="time_{{ $loop->index }}"
                                                                                        value="{{ $item->time }}"
                                                                                        wire:change="updateService({{ $item }} ,'time', $event.target.value)"
                                                                                        placeholder="hh:mm">
                                                                                </div>
                                                                                <div class="col-3 mb-2">
                                                                                    <label for="product_order{{ $loop->index }}">Product Ordered</label>
                                                                                    <input type="text" class="form-control" name="product_order"
                                                                                        id="product_order{{ $loop->index }}"
                                                                                        value="{{ $cashier_tat[$index]->product_ordered }}"
                                                                                        wire:change="updateService({{ $item }} ,'product_ordered', $event.target.value)">
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <div class="row">
                                                                                        <div class="col-4 mb-2">
                                                                                            <label>OT</label>
                                                                                            <input type="text" class="form-control" id="ot"
                                                                                                value="{{ $cashier_tat[$index]->ot }}"
                                                                                                wire:change="updateService({{ $item }} ,'ot', $event.target.value)">
                                                                                        </div>
                                                                                        <div class="col-4 mb-2">
                                                                                            <label>Assembly </label>
                                                                                            <input type="text" class="form-control" name="assembly"
                                                                                                id="assembly"
                                                                                                value="{{ $cashier_tat[$index]->assembly }}"
                                                                                                wire:change="updateService({{ $item }} ,'assembly', $event.target.value)">
                                                                                        </div>
                                                                                        <div class="col-4 mb-2">
                                                                                            <label>Point</label>
                                                                                            <input type="text" class="form-control" name="assembly_points"
                                                                                                id="assembly_points"
                                                                                                value="{{ $cashier_tat[$index]->assembly_points }}"
                                                                                                wire:change="updateService({{ $item }} ,'assembly_points', $event.target.value)">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-3">
                                                                                    <label for="" class="">TAT (1pt.)</label>
                                                                                    <div class="row">
                                                                                        <div class="col-6 mb-2">
                                                                                            <label>Time</label>
                                                                                            <input type="text" class="form-control" name="tat"
                                                                                                id="tat"
                                                                                                placeholder="hh:mm"
                                                                                                value="{{ $cashier_tat[$index]->tat }}"
                                                                                                wire:change="updateService({{ $item }} ,'tat', $event.target.value)">
                                                                                        </div>
                                                                                        <div class="col-6 mb-2">
                                                                                            <label >Point</label>
                                                                                            <input type="text" class="form-control" name="tat_points"
                                                                                                id="tat_points"
                                                                                                placeholder="Point"
                                                                                                value="{{ $cashier_tat[$index]->tat_points }}"
                                                                                                wire:change="updateService({{ $item }} ,'tat_points', $event.target.value)">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-2">
                                                                                    <label ></label>
                                                                                    <div class="row">
                                                                                        <div class="col-12 mb-2">
                                                                                            <label >Serving Time</label>
                                                                                            <input type="text" class="form-control" name="serving_time"
                                                                                                id="serving_time"
                                                                                                placeholder="minutes"
                                                                                                value="{{ $cashier_tat[$index]->serving_time }}"
                                                                                                wire:change="updateService({{ $item }} ,'serving_time', $event.target.value)">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-3">
                                                                                    <label for="" class="">FST (3 pts.)</label>
                                                                                    <div class="row">
                                                                                        <div class="col-6 mb-2" >
                                                                                            <label for="" class="">Time</label>
                                                                                            <input type="text"class="form-control" name="fst" id="fst"
                                                                                                placeholder="hh:mm"
                                                                                                value="{{ $cashier_tat[$index]->fst }}"
                                                                                                wire:change="updateService({{ $item }} ,'fst', $event.target.value)">
                                                                                        </div>
                                                                                        <div class="col-6 mb-2">
                                                                                            <label >Point</label>
                                                                                            <input type="text" class="form-control" name="fst_points"
                                                                                                id="fst_points"
                                                                                                value="{{ $cashier_tat[$index]->fst_points }}"
                                                                                                placeholder="Point"
                                                                                                wire:change="updateService({{ $item }} ,'fst_points', $event.target.value)">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-4 mb-2">
                                                                                    <label>Remarks </label>
                                                                                    <textarea class="form-control" name="" id="" rows="2" id="remarks_{{ $loop->index }}"
                                                                                        value="{{ $cashier_tat[$index]->remarks }}"  wire:change="updateService({{ $item }} ,'remarks', $event.target.value)"
                                                                                        placeholder="Remarks"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                    @endforeach
                                                                </div>
                                                            @elseif($auditLabel['name'] == 'Server CAT')
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <svg class="icon" wire:click="addService(0)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                                            <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                                                                        </svg>
                                                                        {{-- <a class="btn app-btn-primary float-right" wire:ignore role="button" wire:click="setTime(0)">Set</a> --}}
                                                                    </div>
                                                                </div>
                                                                @foreach ($server_cat as $index => $item)
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <div class="row">
                                                                                <div class="col-3 mb-2">
                                                                                    <label for="server_name">Server  Name</label>
                                                                                    <input type="text" class="form-control" name="server_name"  id="name_{{ $loop->index }}"
                                                                                        value="{{ $item->name }}"
                                                                                        wire:change="updateService({{ $item }} ,'name', $event.target.value)">
                                                                                </div>
                                                                                <div class="col-2 mb-2">
                                                                                    <label for="time">Time</label>
                                                                                    <input type="text" class="form-control" name="time"  id="time_{{ $loop->index }}"
                                                                                        value="{{ $item->time }}"
                                                                                        wire:change="updateService({{ $item }} ,'time', $event.target.value)" placeholder="hh:mm">
                                                                                </div>
                                                                                <div class="col-3 mb-2">
                                                                                    <label for="product_order">Product Ordered</label>
                                                                                    <input type="text" class="form-control" name="product_ordered"
                                                                                        id="product_ordered{{ $loop->index }}"
                                                                                        value="{{ $item->product_ordered }}"
                                                                                        wire:change="updateService({{ $item }} ,'product_ordered', $event.target.value)"
                                                                                        placeholder="Product Ordered">
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <div class="row">
                                                                                        <div class="col-4 mb-2">
                                                                                            <label>OT </label>
                                                                                            <input type="text" class="form-control" id="ot" value="{{ $item->ot }}"
                                                                                                wire:change="updateService({{ $item }} ,'ot', $event.target.value)">
                                                                                        </div>
                                                                                        <div class="col-4 mb-2">
                                                                                            <label>Assembly </label>
                                                                                            <input type="text" class="form-control" name="assembly" id="assembly"
                                                                                                value="{{ $item->assembly }}"
                                                                                                wire:change="updateService({{ $item }} ,'assembly', $event.target.value)">
                                                                                        </div>
                                                                                        <div class="col-4 mb-2">
                                                                                            <label>Point </label>
                                                                                            <input type="text"class=" form-control" name="assembly_points" id="assembly_points"
                                                                                                value="{{ $item->assembly_points }}"
                                                                                                wire:change="updateService({{ $item }} ,'assembly_points', $event.target.value)"
                                                                                                placeholder="Point">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-3">
                                                                                    <label for="" class="">CAT (1 pt.)</label>
                                                                                    <div class="row">
                                                                                        <div class="col-6 mb-2" >
                                                                                                <label for="" class="">Time</label>
                                                                                                <input type="text" class="form-control"  name="tat" id="tat"
                                                                                                    value="{{ $item->tat }}"
                                                                                                    wire:change="updateService({{ $item }} ,'tat', $event.target.value)"
                                                                                                    placeholder="hh:mm">
                                                                                        </div>
                                                                                        <div class="col-6 mb-2">
                                                                                            <label >Point </label>
                                                                                            <input type="text" class="form-control" name="tat_point" id="tat_point"
                                                                                                value="{{ $server_cat[$index]->tat_points }}"
                                                                                                wire:change="updateService({{ $item }} ,'tat_points', $event.target.value)"
                                                                                                placeholder="Point">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-2">
                                                                                    <label ></label>
                                                                                    <div class="row">
                                                                                        <div class="col-12 mb-2">
                                                                                            <label >Serving Time</label>
                                                                                            <input type="text"  class="form-control" name="serving_time" id="serving_time"
                                                                                                placeholder="hh:mm"
                                                                                                value="{{ $server_cat[$index]->serving_time }}"
                                                                                                wire:change="updateService({{ $item }} ,'serving_time', $event.target.value)">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-3">
                                                                                    <label >FST (3 pts.) </label>
                                                                                    <div class="row">
                                                                                        <div class="col-6 mb-2">
                                                                                                <label >Time</label>
                                                                                                <input type="text" class="form-control" name="fst" id="fst"
                                                                                                    value="{{ $item->fst }}"
                                                                                                    wire:change="updateService({{ $item }} ,'fst', $event.target.value)"
                                                                                                    placeholder="hh:mm">
                                                                                        </div>
                                                                                        <div class="col-6 mb-2">
                                                                                            <label for=""  class="">Point</label>
                                                                                            <input type="text" class="form-control" name="fst_point" id="fst_point"
                                                                                                value="{{ $server_cat[$index]->fst_points }}"
                                                                                                wire:change="updateService({{ $item}} ,'fst_points', $event.target.value)"
                                                                                                placeholder="Point">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <div class="mb-3">
                                                                                        <label for="">Remarks</label>
                                                                                        <textarea class="form-control" name="" id="" rows="2" id="remarks_{{ $loop->index }}"
                                                                                            value="{{ $server_cat[$index]->remarks }}"
                                                                                            wire:change="updateService({{ $item }} ,'remarks', $event.target.value)" placeholder="Remarks"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                @endforeach
                                                            @endif
                                                        @foreach ($auditLabel['sub_sub_sub_category'] as $index => $sub_sub_sub_category)
                                                            {{-- Deviation Label --}}
                                                                <div class="row mb-2">
                                                                    <div class="col-sm-12 col-md-5">
                                                                    </div>
                                                                    @if ($index == 0)
                                                                        <div class="col-sm-1 col-md-1">
                                                                            <label for="" class="form-label">BP</label>
                                                                        </div>
                                                                        <div class="col-sm-1 col-md-1">
                                                                            <label for="points" class="form-label">Point(s)</label>
                                                                        </div>
                                                                    @endif
                                                                    <div class="col-sm-12 col-md-3 mb-2 {{ $sub_sub_sub_category['dropdown'] ? 'col-md-3' : 'col-md-5' }}">
                                                                        @if ($index == 0)
                                                                            <label for="remarks"
                                                                                class="form-label">Remarks</label>
                                                                        @endif
                                                                    </div>
                                                                    @if (!empty($sub_sub_sub_category['dropdown']))
                                                                        <div class="col-sm-12 col-md-2 mb-2 {{ $sub_sub_sub_category['dropdown'] ? '' : 'd-none' }}">
                                                                            @if ($index == 0 || empty($sub_sub_sub_category['dropdown']))
                                                                                <label for="" class="form-label">Deviation</label>
                                                                            @endif
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            <div class="row mb-2">
                                                            {{-- Deviation Label --}}
                                                                <div class="col-sm-12 col-md-5 col-lg-5">
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input mb-2" type="checkbox" id="toggle-switch"
                                                                        @disabled( $store->audit_status == 0 ? true : false)
                                                                        wire:change="updateNA({{ json_encode($sub_sub_sub_category)}},$event.target.checked ? 0 : 1)"
                                                                        @checked($sub_sub_sub_category['is_na']? false: true)>
                                                                        <label class="form-check-label "  @class(['pt-4' => $index == 0 ]) for="toggle-switch"> {{ $sub_sub_sub_category['name'] }}</label>
                                                                    </div>
                                                                </div>
                                                                {{-- Deviation bp,points,remarks --}}
                                                                    <div class="col-sm-12 col-md-1">
                                                                        <input type="text" class="form-control text-center mb-2" disabled name="bp{{ $sub_sub_sub_category['name'] }}" id="bp" 
                                                                            value="{{ $sub_sub_sub_category['is_all_nothing'] ? $sub_sub_sub_category['bp'] . '*' : $sub_sub_sub_category['bp'] }}">
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-1">
                                                                        <input type="number" class="form-control text-center mb-2" 
                                                                        @disabled($sub_sub_sub_category['is_na'] == 1 || $store->audit_status == 0  ? true : false) 
                                                                            name="points{{ $sub_sub_sub_category['id'] }}" 
                                                                            id="points{{ $sub_sub_sub_category['id'] }}"
                                                                            value="{{$sub_sub_sub_category['points']}}"
                                                                            wire:change.defer="updatePoints({{$sub_category['is_sub']}},{{json_encode($sub_sub_sub_category)}}, $event.target.value)"
                                                                            min="{{ $sub_sub_sub_category['is_all_nothing'] ? $sub_sub_sub_category['bp'] : 0 }}" 
                                                                            max="{{ $sub_sub_sub_category['is_all_nothing'] ? 0 : $sub_sub_sub_category['bp'] }}">
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-3  mb-2 {{ $sub_sub_sub_category['dropdown'] ? 'col-md-3' : 'col-md-5' }}">
                                                                        <textarea class="form-control"
                                                                        wire:change="updateRemarks({{$sub_category['is_sub']}},{{$sub_sub_sub_category['result_id']}}, $event.target.value)"
                                                                        @disabled($sub_sub_sub_category['is_na'] == 1 || $store->audit_status == 0  ? true : false) name="remarks" id="remarks" rows="1">{{$sub_sub_sub_category['remarks']}}</textarea>
                                                                    </div>
                                                                    @if (!empty($sub_sub_sub_category['dropdown']))
                                                                        <div class="col-sm-12 col-md-2 {{ $sub_sub_sub_category['dropdown'] ? '' : 'd-none' }}">
                                                                            <select class="form-select form-select-md" 
                                                                            wire:change="updateDeviation({{$sub_category['is_sub']}},{{$sub_sub_sub_category['result_id']}}, $event.target.value)"
                                                                            @disabled($sub_sub_sub_category['is_na'] == 1 || $store->audit_status == 0  ? true : false) name="tag{{ $sub_sub_sub_category['name'] }}" id="tag">
                                                                                <option value="null"> Select a deviation </option>
                                                                                @foreach ($sub_sub_sub_category['dropdown'] as $result)
                                                                                    @isset($result['name'])
                                                                                        <option
                                                                                            value="{{ $result['name'] }}"
                                                                                            {{ $result['name'] === $sub_sub_sub_category['deviation'] ? 'selected' : '' }}>
                                                                                            {{ $result['name'] }}
                                                                                        </option>
                                                                                    @endisset
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    @endif
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="m-0 p-2">No category found!</p>
        @endforelse
    </div>
</div>