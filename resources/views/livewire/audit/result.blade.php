@section('title', 'Audit Result')
<div class="">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @if ($auditForm->audit_status != 2 )
                <li class="breadcrumb-item"><a href="{{ route('audit') }}">Audit</a></li>
                <li class="breadcrumb-item"><a href="{{ route('audit.forms', [$auditForm->id]) }}">{{ $store->name }}</a>
            @else
                <li class="breadcrumb-item"><a href="{{ route('audit.details', [$store->id]) }}">{{ $store->name }}</a>
            @endif
            <li class="breadcrumb-item active" aria-current="page">Result</li>
        </ol>
    </nav>
    <div class="page-utilities mb-3">
        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
            <div class="col-auto mb-3">
                <a class="btn app-btn-primary" href="{{ route('audit.summary', [$auditForm->id]) }}">Executive Summary</a>
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
                            <div class="col-12  mb-4  {{ isset($category['critical-deviation']) ? 'col-lg-6' : 'col-lg-12' }}">
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
                                                                {{ $category['total-percent'] }} %
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (isset($category['critical-deviation']))
                                <div class="col-sm-12 mb-4 col-lg-6">
                                    <div class="app-card app-card-chart  shadow-sm">
                                        <div class="app-card-header p-3">
                                            <h4 class="app-card-title">Critical Deviation</h4>
                                        </div>
                                        <div class="app-card-body p-3 p-lg-4">
                                            <div class="row">
                                                
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col"></th>
                                                            <th scope="col">Deviation</th>
                                                            <th scope="col">Remarks</th>
                                                            <th scope="col">Score</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($category['critical-deviation'] as $critical_deviation)
                                                            <tr class="">
                                                                <td>{{ $critical_deviation['title'] }}</td>
                                                                <td>
                                                                    @if ($critical_deviation['dropdown'])
                                                                        {{$critical_deviation['dropdown']}}
                                                                    @elseif($critical_deviation['location'])
                                                                        {{$critical_deviation['location']}}
                                                                    @elseif($critical_deviation['sd'])
                                                                        {{ $critical_deviation['sd']}}
                                                                    @else
                                                                        {{ $critical_deviation['product'] ?? ''}}
                                                                    @endif
                                                                <td>{{ $critical_deviation['remarks'] }}</td>
                                                                <td>{{ $critical_deviation['score'] }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        
                                                        @foreach ($sub_category['deviation'] as $sub_category_deviation_index => $sub_category_deviation)
                                                            @if(isset($sub_category_deviation['base']))
                                                                @if ($sub_category_deviation_index == 0)
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col" class="w-50"></th>
                                                                            <th class="text-center" scope="col">BP</th>
                                                                            <th class="text-center" scope="col">Score</th>
                                                                            <th class="text-center w-25" scope="col">Remarks</th>
                                                                            <th class="text-center w-25" scope="col">Deviation</th>
                                                                        </tr>
                                                                    </thead>
                                                                @endif
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="w-50">
                                                                            <span> {{ $sub_category_deviation['title'] }}
                                                                                @if ($sub_category_deviation['is-aon'])
                                                                                    <span class="text-danger text-small">(all or nothing)</span>
                                                                                @endif
                                                                            </span>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $sub_category_deviation['base'] }}
                                                                        <td class="text-center">
                                                                            {{ $sub_category_deviation['points'] != null ? $sub_category_deviation['points'] : '0' }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $sub_category_deviation['remarks'] }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $sub_category_deviation['critical-deviation'] }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            @else
                                                                <div class="row">
                                                                    @isset($sub_category_deviation['deviation'])
                                                                        @foreach ($sub_category_deviation['deviation'] as $sub_sub_category_deviation_index => $sub_sub_category_deviation)
                                                                                @if (isset($sub_sub_category_deviation['title'] ))
                                                                                    @if ($sub_category_deviation_index == 0 &&  $sub_sub_category_deviation_index == 0)
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th scope="col" class="w-50"></th>
                                                                                                <th class="text-center" scope="col">BP</th>
                                                                                                <th class="text-center" scope="col">Score</th>
                                                                                                <th class="text-center w-25" scope="col">Remarks</th>
                                                                                                <th class="text-center w-25" scope="col">Deviation</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                    @endif
                                                                                    <tbody>
                                                                                        @if ($sub_sub_category_deviation_index == 0)
                                                                                            <tr>
                                                                                                <td colspan="5">
                                                                                                    <label class="form-check-label fw-bold " @class(['pt-4' => $sub_category_deviation_index == 0 ]) for="toggle-switch"> {{ $sub_category_deviation['title']}}</label>
                                                                                                </td>
                                                                                            </tr>
                                                                                        @endif
                                                                                        <tr>
                                                                                            <td class="w-50">
                                                                                                <span> {{ $sub_sub_category_deviation['title'] }}
                                                                                                    @if ($sub_sub_category_deviation['is-aon'])
                                                                                                        <span class="text-danger text-small">(all or nothing)</span>
                                                                                                    @endif
                                                                                                </span>
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                {{ $sub_sub_category_deviation['base'] }}
                                                                                            <td class="text-center">
                                                                                                {{ $sub_sub_category_deviation['points'] != null ? $sub_sub_category_deviation['points'] : '0' }}
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                {{ $sub_sub_category_deviation['remarks'] }}
                                                                                            </td>
                                                                                            <td class="text-center">
                                                                                                {{ $sub_sub_category_deviation['critical-deviation'] }}
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                @else
                                                                                    @if (isset($sub_sub_category_deviation['cashier_name']) )
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Name</th>
                                                                                                <th>Time</th>
                                                                                                <th>Product Ordered</th>
                                                                                                <th>OT</th>
                                                                                                <th>Assembly</th>
                                                                                                <th>Assembly Points</th>
                                                                                                <th>TAT</th>
                                                                                                <th>TAT Points</th>
                                                                                                <th>FST</th>
                                                                                                <th>FST Points</th>
                                                                                                <th>Serving Time</th>
                                                                                                <th colspan="3">Remarks</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <tr class="">
                                                                                                <td>{{ $sub_sub_category_deviation['cashier_name'] }}</td>
                                                                                                <td>{{ $sub_sub_category_deviation['product_ordered'] }}</td>
                                                                                                <td>{{ $sub_sub_category_deviation['ot_time'] }}</td>
                                                                                                <td>{{ $sub_sub_category_deviation['ot'] }}</td>
                                                                                                <td>{{ $sub_sub_category_deviation['assembly'] }}</td>
                                                                                                <td>{{ $sub_sub_category_deviation['assembly_point'] }}</td>
                                                                                                <td>{{ $sub_sub_category_deviation['tat_time'] }}</td>
                                                                                                <td>{{ $sub_sub_category_deviation['tat_point'] }}</td>
                                                                                                <td>{{ $sub_sub_category_deviation['fst_time'] }}</td>
                                                                                                <td>{{ $sub_sub_category_deviation['fst_point'] }}</td>
                                                                                                <td>{{ $sub_sub_category_deviation['serving_time'] }}</td>
                                                                                                <td colspan="3">{{ $sub_sub_category_deviation['remarks'] }}</td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    @else
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>Name</th>
                                                                                            <th>Time</th>
                                                                                            <th>Product Ordered</th>
                                                                                            <th>OT</th>
                                                                                            <th>Assembly</th>
                                                                                            <th>Assembly Points</th>
                                                                                            <th>TAT</th>
                                                                                            <th>TAT Points</th>
                                                                                            <th>FST</th>
                                                                                            <th>FST Points</th>
                                                                                            <th>ATT</th>
                                                                                            <th>ATT Points</th>
                                                                                            <th>Serving Time</th>
                                                                                            <th>Remarks</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <tr class="">
                                                                                            <td>{{ $sub_sub_category_deviation['server_name'] }}</td>
                                                                                            <td>{{ $sub_sub_category_deviation['product_ordered'] }}</td>
                                                                                            <td>{{ $sub_sub_category_deviation['ot_time'] }}</td>
                                                                                            <td>{{ $sub_sub_category_deviation['ot'] }}</td>
                                                                                            <td>{{ $sub_sub_category_deviation['assembly'] }}</td>
                                                                                            <td>{{ $sub_sub_category_deviation['assembly_point'] }}</td>
                                                                                            <td>{{ $sub_sub_category_deviation['tat_time'] }}</td>
                                                                                            <td>{{ $sub_sub_category_deviation['tat_point'] }}</td>
                                                                                            <td>{{ $sub_sub_category_deviation['fst_time'] }}</td>
                                                                                            <td>{{ $sub_sub_category_deviation['fst_point'] }}</td>
                                                                                            <td>{{ $sub_sub_category_deviation['att_time'] }}</td>
                                                                                            <td>{{ $sub_sub_category_deviation['att_point'] }}</td>
                                                                                            <td>{{ $sub_sub_category_deviation['serving_time'] }}</td>
                                                                                            <td>{{ $sub_sub_category_deviation['remarks'] }}</td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                    @endif
                                                                                @endif
                                                                        @endforeach
                                                                    @endisset
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </table>
                                                </div>
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
    <a href="#">
        <div class="floating-btn">
            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <path
                    d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8H288c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z" />
            </svg>
        </div>
    </a>
</div>
