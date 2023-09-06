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
        @forelse ($form as $key => $data)
            <a @class(['flex-sm-fill','text-sm-center','nav-link','active' => $key == $active_index,
            ]) id="cat{{ $key}}-tab" data-bs-toggle="tab"
                wire:click="setActive({{ $key }})" href="#cat{{ $key}}" role="tab"
                aria-controls="cat{{ $key}}"
                aria-selected="{{ $key == $active_index ? 'true' : 'false' }}">
                {{ $data['category'] }}
            </a>
        @empty
            <p class="m-0 p-2">No category found!</p>
        @endforelse
    </nav>
   
    <div class="tab-content" id="audit-form-tab-content">
        @forelse ($form as $category_index => $category)
            <div class="tab-pane fade show {{ $category_index == $active_index ? 'active' : '' }}" id="cat{{ $category_index }}" role="tabpanel" aria-labelledby="cat{{ $category_index }}-tab">
                <div class="app-card app-card-orders-table shadow-sm mb-5 bg-none">
                    <div class="app-card-body">
                        <div class="row mb-2">
                            <div class="col-12  mb-4  {{-- {{ $category->critical_deviation->isNotEmpty() ? 'col-lg-6' : 'col-lg-12' }} --}}">
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
                                                        @foreach ($category['sub-category'] as $sub_category)
                                                            <tr>
                                                                <td class="core_name_total">
                                                                    <a href="#{{ $sub_category['title'] }}">{{ $sub_category['title'] }}</a>
                                                                </td>
                                                                <td class="text-center">{{ $sub_category['total-base'] }}</td>
                                                                <td class="text-center">{{ $sub_category['total-points'] }}</td>
                                                                <td class="text-center"> {{ ($sub_category['total-points'] == 0) ? 0 :  round(($sub_category['total-points']  / $sub_category['total-base']) * $sub_category['percent'] , 0) }}%</td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td>
                                                                <h5 class="app-card-title ">Total</h5>
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $category['total-base'] }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $category['total-points'] }}
                                                            </td>
                                                            <td class="text-center">
                                                                @php
                                                                    $cumulativePercentage = ($category['total-points'] == 0) ? 0 : round(($category['total-points'] / $category['total-base']) *  $category['percent'], 0);
                                                                @endphp
                                                                @if ($category['category'] == 'Food')
                                                                    @foreach ($category['sub-category'] as $item)
                                                                        @if ($item['total-base'] > 0)
                                                                            @php
                                                                                $cumulativePercentage += round(($item['total-points'] / $item['total-base']) * $item['percent'], 0);
                                                                            @endphp
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                                {{ $cumulativePercentage }}%
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            @foreach ($category['sub-category'] as $sub_category_index => $sub_category)
                                <div class="accordion mb-2" id="accordionCategory">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="{{ $sub_category['title'] }}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accrod{{ $sub_category['title'] }}" aria-expanded="true" aria-controls="accrod{{ $sub_category['title'] }}">
                                                <h6 class="card-title product-name">{{ $sub_category['title'] }}</h6>
                                            </button>
                                        </h2>
                                        <div id="accrod{{ $sub_category['title'] }}"class="accordion-collapse collapse show"  aria-labelledby="accrod{{ $sub_category['title'] }}" data-bs-parent="#accordionCategory">
                                            <div class="accordion-body pb-0">
                                                @isset($sub_category['deviation'])
                                                    @foreach ($sub_category['deviation'] as $sub_category_deviation_index => $sub_category_deviation)
                                                        @if(isset($sub_category_deviation['base']))
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-5">
                                                                </div>
                                                                @if ($sub_category_deviation_index == 0)
                                                                    <div class="col-sm-1 col-md-1">
                                                                        <label for="" class="form-label">BP</label>
                                                                    </div>
                                                                    <div class="col-sm-1 col-md-1">
                                                                        <label for="points" class="form-label">Point(s)</label>
                                                                    </div>
                                                                @endif
                                                                <div class="col-sm-12 col-md-3 mb-2 {{ isset($sub_category_deviation['deviation-dropdown']) ? 'col-md-3' : 'col-md-5' }}">
                                                                    @if ($sub_category_deviation_index == 0)
                                                                        <label for="remarks"
                                                                            class="form-label">Remarks</label>
                                                                    @endif
                                                                </div>
                                                                @if (isset($sub_category_deviation['deviation-dropdown']))
                                                                    <div class="col-sm-12 col-md-2 mb-2 {{ !empty($sub_category_deviation['deviation-dropdown']) ? '' : 'd-none'  }}">
                                                                        @if ($sub_category_deviation_index == 0 )
                                                                            <label for="" class="form-label">Deviation</label>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-sm-12 col-md-5 col-lg-5">
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input mb-2" type="checkbox" id="toggle-switch"
                                                                            {{-- @disabled( $store->audit_status == 0 ? true : false) --}}
                                                                            wire:model="form.{{ $category_index }}.sub-category.{{ $sub_category_index }}.deviation.{{ $sub_category_deviation_index }}.is-na"
                                                                            @if($form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_category_deviation_index]['is-na'] ?? false) checked @endif >
                                                                            <label class="form-check-label "  @class(['pt-4' => $sub_category_deviation_index == 0 ]) for="toggle-switch">  {{$sub_category_deviation['title']}}</label>
                                                                    </div>
                                                                </div>
                                                                {{-- Deviation bp,points,remarks --}}
                                                                <div class="col-sm-12 col-md-1">
                                                                {{-- {{$sub_category_deviation['base']}} --}}
                                                                <input type="text" class="form-control text-center mb-2" disabled 
                                                                    {{-- @disabled( $store->audit_status == 0 ? true : false) --}}
                                                                    wire:model="form.{{ $category_index }}.sub-category.{{ $sub_category_index }}.deviation.{{ $sub_category_deviation_index }}.base">
                                                                </div>
                                                                <div class="col-sm-12 col-md-1">
                                                                    <input type="number" class="form-control text-center mb-2"  
                                                                    {{ !($form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_category_deviation_index]['is-na'] ?? false) ? 'disabled' : '' }}
                                                                    min="{{ ($form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_category_deviation_index]['is-na'] ?? false) ? ($sub_category_deviation['is-aon'] ? $sub_category_deviation['base'] ?? 0 : 0) : 0 }}" 
                                                                    max="{{ ($form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_category_deviation_index]['is-na'] ?? false) ? ($sub_category_deviation['is-aon'] ? 0 : $sub_category_deviation['base'] ?? 0) : 0 }}"
                                                                    wire:model.lazy="form.{{ $category_index }}.sub-category.{{ $sub_category_index }}.deviation.{{ $sub_category_deviation_index }}.points"
                                                                    wire:change="onCaculatePoints({{ $category_index }}, {{ $sub_category_index }}, {{ $sub_category_deviation_index }}, $event.target.value, $event)"
                                                                    >
                                                                </div>
                                                                <div class="col-sm-12 col-md-3  mb-2  {{ !empty($sub_category_deviation['deviation-dropdown']) ? 'col-md-3' : 'col-md-5' }}">
                                                                    <textarea class="form-control" 
                                                                    {{ !($form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_category_deviation_index]['is-na'] ?? false) ? 'disabled' : '' }}
                                                                    wire:model="form.{{ $category_index }}.sub-category.{{ $sub_category_index }}.deviation.{{ $sub_category_deviation_index }}.remarks"
                                                                    {{-- @disabled($auditLabel['is_na'] == 1 || $store->audit_status == 0  ? true : false) --}}  rows="1"></textarea>
                                                                </div>
                                                                <div class="col-sm-12 col-md-2 {{ !empty($sub_category_deviation['deviation-dropdown']) ? '' : 'd-none'  }}">
                                                                    <select class="form-select form-select-md"
                                                                        {{ !($form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_category_deviation_index]['is-na'] ?? false) ? 'disabled' : '' }}
                                                                        wire:model="form.{{ $category_index }}.sub-category.{{ $sub_category_index }}.deviation.{{ $sub_category_deviation_index }}.critical-deviation"
                                                                        >
                                                                        <option value="null">Select a deviation</option>
                                                                        @isset($sub_category_deviation['deviation-dropdown'])
                                                                            @foreach ($sub_category_deviation['deviation-dropdown'] as $result)
                                                                                <option value="{{ $result['title'] }}">{{ $result['title'] }}</option>
                                                                            @endforeach
                                                                        @endisset
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="row mb-2">
                                                                <div class="col-12">
                                                                    @if ($sub_category_deviation_index != 0)
                                                                        <hr>
                                                                    @endif
                                                                    <label class="form-check-label fw-bold " @class(['pt-4' => $sub_category_deviation_index == 0 ]) for="toggle-switch"> {{ $sub_category_deviation['title']}}</label>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                @isset($sub_category_deviation['deviation'])
                                                                    @foreach ($sub_category_deviation['deviation'] as $sub_sub_category_deviation_index => $sub_sub_category_deviation)
                                                                            <div class="row">
                                                                                <div class="col-sm-12 col-md-5">
                                                                                </div>
                                                                                @if ($sub_sub_category_deviation_index == 0)
                                                                                    <div class="col-sm-1 col-md-1">
                                                                                        <label for="" class="form-label">BP</label>
                                                                                    </div>
                                                                                    <div class="col-sm-1 col-md-1">
                                                                                        <label for="points" class="form-label">Point(s)</label>
                                                                                    </div>
                                                                                @endif
                                                                                <div class="col-sm-12 col-md-3 mb-2 {{ isset($sub_sub_category_deviation['deviation-dropdown']) ? 'col-md-3' : 'col-md-5' }}">
                                                                                    @if ($sub_sub_category_deviation_index == 0)
                                                                                        <label for="remarks" class="form-label">Remarks</label>
                                                                                    @endif
                                                                                </div>
                                                                                @if (isset($sub_category_deviation['deviation-dropdown']))
                                                                                    <div class="col-sm-12 col-md-2 mb-2 {{ !empty($sub_sub_category_deviation['deviation-dropdown']) ? '' : 'd-none'  }}">
                                                                                        @if ($sub_sub_category_deviation_index == 0 )
                                                                                            <label for="" class="form-label">Deviation</label>
                                                                                        @endif
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                            
                                                                            <div class="row mb-3">
                                                                                <div class="col-sm-12 col-md-5 col-lg-5">
                                                                                    <div class="form-check form-switch">
                                                                                        <input class="form-check-input mb-2" type="checkbox" id="toggle-switch"
                                                                                            {{-- @disabled( $store->audit_status == 0 ? true : false) --}}
                                                                                            wire:model="form.{{ $category_index }}.sub-category.{{ $sub_category_index }}.deviation.{{ $sub_category_deviation_index }}.deviation.{{$sub_sub_category_deviation_index}}.is-na"
                                                                                            @if($form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_category_deviation_index]['deviation'][$sub_sub_category_deviation_index]['is-na'] ?? false) checked @endif >
                                                                                            <label class="form-check-label "  @class(['pt-4' => $sub_sub_category_deviation_index == 0 ]) for="toggle-switch">  {{$sub_sub_category_deviation['title']}}</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-1">
                                                                                    {{-- {{$sub_category_deviation['base']}} --}}
                                                                                    <input type="text" class="form-control text-center mb-2" disabled 
                                                                                        {{-- @disabled( $store->audit_status == 0 ? true : false) --}}
                                                                                        wire:model="form.{{ $category_index }}.sub-category.{{ $sub_category_index }}.deviation.{{ $sub_category_deviation_index }}.deviation.{{$sub_sub_category_deviation_index}}.base"
                                                                                        >
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-1">
                                                                                    <input type="number" class="form-control text-center mb-2"  
                                                                                        {{ ($form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_category_deviation_index]['deviation'][$sub_sub_category_deviation_index]['is-na'] ?? false) ? '' : 'disabled' }}
                                                                                        min="{{ ($form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_category_deviation_index]['deviation'][$sub_sub_category_deviation_index]['is-na'] ?? false) ? (isset($sub_sub_category_deviation['is-aon']) ? $sub_sub_category_deviation['base'] ?? 0 : 0) : 0 }}" 
                                                                                        max="{{ ($form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_category_deviation_index]['deviation'][$sub_sub_category_deviation_index]['is-na'] ?? false) ? (isset($sub_sub_category_deviation['is-aon']) ? 0 : $sub_sub_category_deviation['base'] ?? 0) : 0 }}"
                                                                                        wire:model="form.{{ $category_index }}.sub-category.{{ $sub_category_index }}.deviation.{{ $sub_category_deviation_index }}.deviation.{{ $sub_sub_category_deviation_index }}.points"
                                                                                        >
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-3  mb-2  {{ !empty($sub_sub_category_deviation['deviation-dropdown']) ? 'col-md-3' : 'col-md-5' }}">
                                                                                    <textarea class="form-control" 
                                                                                    {{ ($form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_category_deviation_index]['deviation'][$sub_sub_category_deviation_index]['is-na'] ?? false) ? '' : 'disabled' }}
                                                                                    wire:model="form.{{ $category_index }}.sub-category.{{ $sub_category_index }}.deviation.{{ $sub_category_deviation_index }}.deviation.{{ $sub_sub_category_deviation_index }}.remarks"
                                                                                    {{-- @disabled($auditLabel['is_na'] == 1 || $store->audit_status == 0  ? true : false) --}}  rows="1"></textarea>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-2 {{ !empty($sub_sub_category_deviation['deviation-dropdown']) ? '' : 'd-none'  }}">
                                                                                    <select class="form-select form-select-md"
                                                                                        {{ ($form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_category_deviation_index]['deviation'][$sub_sub_category_deviation_index]['is-na'] ?? false) ? '' : 'disabled' }}
                                                                                        wire:model="form.{{ $category_index }}.sub-category.{{ $sub_category_index }}.deviation.{{ $sub_category_deviation_index }}.deviation.{{ $sub_sub_category_deviation_index }}.critical-deviation"
                                                                                        >
                                                                                        <option value="null">Select a deviation</option>
                                                                                        @isset($sub_sub_category_deviation['deviation-dropdown'])
                                                                                            @foreach ($sub_sub_category_deviation['deviation-dropdown'] as $result)
                                                                                                <option value="{{ $result['title'] }}">{{ $result['title'] }}</option>
                                                                                            @endforeach
                                                                                        @endisset
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                    @endforeach
                                                                @endisset
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endisset
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

        @endforelse
    </div>

       {{--  @foreach ($form as $item)
            {{$item['category']}}
            <ul>
                @foreach ($item['sub-category'] as $sub_category)
                    <li>
                        {{$sub_category['title']}}
                    </li> 
                    @isset($sub_category['deviation'])
                        <ul>
                            @foreach ($sub_category['deviation'] as $sub_category_deviation)
                                    <li>
                                        {{ $sub_category_deviation['is-na'] ?? 'Default Value' }}
                                        {{$sub_category_deviation['title']}}
                                        {{ $sub_category_deviation['points'] ?? '' }}
                                        {{ $sub_category_deviation['remarks'] ?? 'Default Value' }}
                                        {{ $sub_category_deviation['critical-deviation'] ?? '' }}

                                      
                                    </li>
                                        @if (isset($sub_category_deviation['deviation']))
                                            <ul>
                                                @foreach ($sub_category_deviation['deviation'] as $sub_sub_category_deviation)
                                                        <li>
                                                            {{ $sub_sub_category_deviation['is-na'] ?? '' }}
                                                            {{ $sub_sub_category_deviation['title']}}
                                                            {{ $sub_sub_category_deviation['points'] ?? '' }}
                                                            {{ $sub_sub_category_deviation['remarks'] ?? '' }}
                                                            {{ $sub_sub_category_deviation['critical-deviation'] ?? '' }}
                                                        </li>
                                                @endforeach
                                            </ul>
                                        @endif
                            @endforeach
                        </ul>
                    @endisset
                @endforeach
            </ul>
        @endforeach --}}

        <a href="#">
            <div class="floating-btn">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path
                        d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8H288c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z" />
                </svg>
            </div>
        </a>
</div>