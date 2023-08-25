@section('title', 'Audit Result')
<div class="">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @if ($auditForm->audit_status != 2 )
                <li class="breadcrumb-item"><a href="{{ route('audit') }}">Audit</a></li>
                <li class="breadcrumb-item"><a href="{{ route('audit.form', [$auditForm->id]) }}">{{ $store->name }}</a>
            @else
                <li class="breadcrumb-item"><a href="{{ route('audit.details', [$store->id]) }}">{{ $store->name }}</a>
            @endif
            <li class="breadcrumb-item active" aria-current="page">Result</li>
        </ol>
    </nav>
    <div class="page-utilities mb-3">
        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
            <div class="col-auto mb-3">
                <a class="btn app-btn-primary" href="{{ route('audit.view.summary', [$auditForm->id, $summary->id]) }}">Executive Summary</a>
            </div>
        </div>
    </div>
    <nav wire:ignore
        id="audit-form-tab"class="audit-form-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4 justify-content-center nav-sticky">
        @forelse ($categoryList as $key => $data)
            <a @class(['flex-sm-fill', 'text-sm-center', 'nav-link','active' => $key == $active_index,]) id="cat{{ $data->id }}-tab" data-bs-toggle="tab"
                wire:click="setActive({{ $key }})" href="#cat{{ $data->id }}" role="tab"
                aria-controls="cat{{ $data->id }}" aria-selected="{{ $key == $active_index ? 'true' : 'false' }}">
                {{ $data->name }}
            </a>
        @empty
            <p class="m-0 p-2">No category found!</p>
        @endforelse
    </nav>
    <a href="#">
        <div class="floating-btn">
            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <path d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8H288c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z" />
            </svg>
        </div>
    </a>
    <div class="tab-content" id="audit-form-tab-content">
        @forelse ($categoryList as $key => $category)
            <div class="tab-pane fade show {{ $key == $active_index ? 'active' : '' }}" id="cat{{ $category->id }}"
                role="tabpanel" aria-labelledby="cat{{ $category->id }}-tab">
                <div class="app-card app-card-orders-table shadow-sm mb-5 bg-none">
                    <div class="app-card-body">
                        {{-- Category List and Deviation --}}
                        <div class="row mb-2">
                            <div
                                class="col-12  mb-4  {{ $category->critical_deviation->isNotEmpty() ? 'col-lg-6' : 'col-lg-12' }}">
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
                                                                    <a
                                                                        href="#{{ $sub_category['name'] }}">{{ $sub_category['name'] }}</a>
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $sub_category['total_base_per_category'] }}</td>
                                                                <td class="text-center">
                                                                    {{ $sub_category['total_points_per_category'] }}
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $sub_category['total_percentage_per_category'] }}%
                                                                </td>
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
                                    <div class="app-card app-card-chart  shadow-sm">
                                        <div class="app-card-header p-3">
                                            <div class="row justify-content-between align-items-center">
                                                <div class="col-auto">
                                                    <h4 class="app-card-title">Critical Deviation</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="app-card-body p-3 p-lg-4">
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
                                                    @foreach ($category->critical_deviation as $item)
                                                        <tr class="">
                                                            <td>{{ $item['label'] }}</td>
                                                            <td>{{ $item['saved_dropdown'] ?? $item['saved_location'] ?? $item['saved_sd']}}</td>
                                                            <td>{{ $item['saved_remarks'] }}</td>
                                                            <td>{{ $item['saved_score'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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
                                        <div id="accrod{{ $sub_category['id'] }}"class="accordion-collapse collapse show" aria-labelledby="accrod{{ $sub_category['id'] }}" data-bs-parent="#accordionCategory">
                                            <div class="accordion-body">
                                                @if ($sub_category['is_sub'] == 0)
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" class="w-50"></th>
                                                                    <th class="text-center" scope="col">BP</th>
                                                                    <th class="text-center" scope="col">Score</th>
                                                                    <th class="text-center w-25" scope="col">Remarks</th>
                                                                    <th class="text-center w-25" scope="col">Deviation
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            @foreach ($sub_category['sub_sub_category'] as $index => $auditLabel)
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="w-50">
                                                                            <span> {{ $auditLabel['name'] }}
                                                                                @if ($auditLabel['is_all_nothing'])
                                                                                    <span class="text-danger text-small">(all or nothing)</span>
                                                                                @endif
                                                                            </span>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $auditLabel['bp'] }}
                                                                        <td class="text-center">
                                                                            {{ $auditLabel['points'] != null ? $auditLabel['points'] : '0' }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $auditLabel['remarks'] }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $auditLabel['deviation'] }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                @else
                                                    @foreach ($sub_category['sub_sub_category'] as $index => $auditLabel)
                                                        @if ($auditLabel['name'] == 'Cashier TAT')
                                                            <div class="table-responsive">
                                                                <table class="table ">
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
                                                                            <th>Remarks</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($cashier_tat as $item)
                                                                            <tr class="">
                                                                                <td>{{ $item->name }}</td>
                                                                                <td>{{ $item->time }}</td>
                                                                                <td>{{ $item->product_ordered }}</td>
                                                                                <td>{{ $item->ot }}</td>
                                                                                <td>{{ $item->assembly }}</td>
                                                                                <td>{{ $item->assembly_points }}</td>
                                                                                <td>{{ $item->tat }}</td>
                                                                                <td>{{ $item->tat_points }}</td>
                                                                                <td>{{ $item->fst }}</td>
                                                                                <td>{{ $item->fst_points }}</td>
                                                                                <td>{{ $item->serving_time }}</td>
                                                                                <td>{{ $item->remarks }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @elseif($auditLabel['name'] == 'Server CAT')
                                                            <div class="table-responsive">
                                                                <table class="table ">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Name</th>
                                                                            <th>Time</th>
                                                                            <th>Product Ordered</th>
                                                                            <th>OT</th>
                                                                            <th>Assembly</th>
                                                                            <th>Assembly Points</th>
                                                                            <th>CAT</th>
                                                                            <th>CAT Points</th>
                                                                            <th>FST</th>
                                                                            <th>FST Points</th>
                                                                            <th>ATT</th>
                                                                            <th>ATT Points</th>
                                                                            <th>Serving Time</th>
                                                                            <th>Remarks</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($server_cat as $item)
                                                                            <tr class="">
                                                                                <td>{{ $item->name }}</td>
                                                                                <td>{{ $item->time }}</td>
                                                                                <td>{{ $item->product_ordered }}</td>
                                                                                <td>{{ $item->ot }}</td>
                                                                                <td>{{ $item->assembly }}</td>
                                                                                <td>{{ $item->assembly_points }}</td>
                                                                                <td>{{ $item->tat }}</td>
                                                                                <td>{{ $item->tat_points }}</td>
                                                                                <td>{{ $item->fst }}</td>
                                                                                <td>{{ $item->fst_points }}</td>
                                                                                <td>{{ $item->att }}</td>
                                                                                <td>{{ $item->att_points }}</td>
                                                                                <td>{{ $item->serving_time }}</td>
                                                                                <td>{{ $item->remarks }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @else
                                                            <div class="table-responsive">
                                                                <table class="table mb-3">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col" class="w-50"> {{ $auditLabel['name'] }} </th>
                                                                            <th class="text-center" scope="col"> BP</th>
                                                                            <th class="text-center" scope="col"> Score</th>
                                                                            <th class="text-center w-25" scope="col"> Remarks</th>
                                                                            <th class="text-center w-25" scope="col">  Deviation</th>
                                                                        </tr>
                                                                    </thead>
                                                                    @foreach ($auditLabel['sub_sub_sub_category'] as $index => $sub_sub_sub_category)
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="w-50">
                                                                                    <span>
                                                                                        {{ $sub_sub_sub_category['name'] }}
                                                                                        @if ($sub_sub_sub_category['is_all_nothing'])
                                                                                            <span class="text-danger text-small">(all or nothing)</span>
                                                                                        @endif
                                                                                    </span>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    {{ $sub_sub_sub_category['bp'] }}
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    {{ $sub_sub_sub_category['points'] != null ? $sub_sub_sub_category['points'] : '0' }}
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    {{ $sub_sub_sub_category['remarks'] }}
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    {{ $sub_sub_sub_category['deviation'] }}
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    @endforeach
                                                                </table>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
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
