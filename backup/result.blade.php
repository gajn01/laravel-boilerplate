@section('title', 'Audit Result')
<div class="">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('audit') }}">Audit</a></li>
            <li class="breadcrumb-item"><a href="{{ route('audit.form', [$store_id]) }}">{{ $store->name }}</a>
            <li class="breadcrumb-item active" aria-current="page">Result</li>
        </ol>
    </nav>
    <div class="page-utilities mb-3">
        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
            <div class="col-auto mb-3">
                <a class="btn app-btn-primary" href="{{ route('audit.view.summary', [$store_id, $result_id]) }}">Executive Summary</a>
            </div>
        </div>
        <nav wire:ignore id="audit-form-tab"
            class="audit-form-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4 justify-content-center nav-sticky">
            @forelse ($category_list as $key => $data)
                <a @class([
                    'flex-sm-fill',
                    'text-sm-center',
                    'nav-link',
                    'active' => $key == $active_index,
                ]) id="cat{{ $data->id }}-tab" data-bs-toggle="tab"
                    href="#cat{{ $data->id }}" role="tab" aria-controls="cat{{ $data->id }}"
                    aria-selected="{{ $key == $active_index ? 'true' : 'false' }}">
                    {{ $data->name }}
                </a>
            @empty
                <p class="m-0 p-2">No category found!</p>
            @endforelse
        </nav>
        <div class="tab-content" id="audit-form-tab-content">
            @forelse ($category_list as $key => $data)
                <div class="tab-pane fade show {{ $key == $active_index ? 'active' : '' }}" id="cat{{ $data->id }}"
                    role="tabpanel" aria-labelledby="cat{{ $data->id }}-tab">
                    <div class="row g-4 mb-4">
                        <div class="col-sm-12 col-md-6 }}">
                            <div class="app-card app-card-chart  shadow-sm">
                                <div class="app-card-header p-2">
                                    <h3 class="app-card-title">Score</h3>
                                </div>
                                <div class="app-card-body p-1 ">
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
                                                            <td class="text-center">{{ $sub['total_point'] }}</td>
                                                            <td class="text-center"> {{ $sub['total_percent'] }}%</td>
                                                        </tr>
                                                        @if ($sub['name'])
                                                        @endif
                                                    @endforeach
                                                    <tr>
                                                        <td>
                                                            <h5 class="app-card-title ">Total</h5>
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $sub['total_base'] }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $sub['total_score'] }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $data->sub_categ['total_percentage'] }}%
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="text-center">
                                                            <h5 class="app-card-title ">Overall Score</h5>
                                                        </td>

                                                        <td class="text-center">
                                                            {{ $data->sub_categ['overall_score'] }}%
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($data->critical_deviation->isNotEmpty())
                            <div class="col-sm-12 col-md-6 }}">
                                <div class="app-card app-card-chart h-100  shadow-sm">
                                    <div class="app-card-header p-2">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-12">
                                                <h4 class="app-card-title">Critical Deviation</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="app-card-body p-2 p-lg-4">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-12">
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
                                                        @foreach ($data->critical_deviation as $item)
                                                            <tr class="">
                                                                <td>{{ $item['label'] }}</td>
                                                                <td>{{ $item['saved_dropdown'] }}</td>
                                                                <td>{{ $item['saved_remarks'] }}</td>
                                                                <td>{{ $item['saved_score'] }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @forelse ($data->sub_categ['data_items'] as  $key =>  $dataItem)
                        <div class="row g-4 mb-4" id="{{ $dataItem['name'] }}">
                            <div class="col-12 }}">
                                <div class="app-card app-card-chart  shadow-sm">
                                    <div class="app-card-header p-2">
                                        <h5 class="app-card-title p-2">{{ $dataItem['name'] }}</h5>
                                    </div>
                                    <div class="app-card-body p-2 p-lg-4">
                                        <div class="table-responsive">
                                            <table class="table white-bg">
                                                @if ($dataItem['name'] != 'Speed and Accuracy')
                                                    <thead>
                                                        <tr>
                                                            <th scope="col"></th>
                                                            <th class="text-center" scope="col">Score</th>
                                                            <th class="text-center" scope="col">Remarks</th>
                                                            <th class="text-center" scope="col">Deviation</th>
                                                        </tr>
                                                    </thead>
                                                @endif
                                                <tbody>
                                                    @if ($dataItem['is_sub'] == 0)
                                                        @foreach ($dataItem['sub_category'] as $index => $auditLabel)
                                                            <tr>
                                                                <td class="w-50">
                                                                    <p @class(['pt-4' => $index == 0])>
                                                                        {{ $auditLabel['name'] }}
                                                                        @if ($auditLabel['is_all_nothing'])
                                                                            <span class="text-danger text-small"> (all or nothing)</span>
                                                                        @endif
                                                                    </p>
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $auditLabel['points'] != null ? $auditLabel['points'] : '0' }}
                                                                </td>
                                                                <td class="text-center">{{ $auditLabel['remarks'] }}
                                                                </td>
                                                                <td class="text-center">{{ $auditLabel['deviation'] }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        @foreach ($dataItem['sub_category'] as $sub_category)
                                                            <tr>
                                                                <td colspan="4">
                                                                    <h6 class="app-card-title">
                                                                        {{ $sub_category['name'] }}</h6>
                                                                </td>
                                                            </tr>
                                                            @if ($sub_category['name'] == 'Cashier TAT')
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
                                                            @elseif($sub_category['name'] == 'Server CAT')
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
                                                                                <td>{{ $item->serving_time }}</td>
                                                                                <td>{{ $item->remarks }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            @else
                                                                @foreach ($sub_category['label'] as $index => $auditLabel)
                                                                    <tr>
                                                                        <td class="w-50">
                                                                            <p @class(['pt-4' => $index == 0])>
                                                                                {{ $auditLabel['name'] }}
                                                                                @if ($auditLabel['is_all_nothing'])
                                                                                <span class="text-danger text-small"> (all or nothing)</span>
                                                                            @endif
                                                                            </p>
                                                                        </td>
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
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="m-0 p-2 text-center">No category found!</p>
                    @endforelse
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
