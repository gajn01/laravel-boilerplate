@section('title', 'Audit Result')
<div class="container-xl">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('store') }}">Store</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form', [$store_id]) }}">{{ $store_name }}</a>
            <li class="breadcrumb-item active" aria-current="page">Result</li>
        </ol>
    </nav>
    <div class="page-utilities mb-3">


        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
            <div class="col-auto mb-3">
                <a class="btn app-btn-primary" href="{{ route('form.summary', [$store_id]) }}">Go to Executive Summary</a>
            </div>
        </div>

     {{--    @if ($audit_status)
            <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                <div class="col-auto mb-3">
                    <a class="btn app-btn-primary"
                        wire:click="onStartAndComplete(true,'Are you sure?','warning')">{{ $actionTitle }}</a>
                </div>
            </div>
        @else
            <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                <div class="col-auto mb-3">
                    <a class="btn app-btn-primary" href="{{ route('form.summary', [$store_id]) }}">Go to Executive Summary</a>
                </div>
            </div>
        @endif --}}
        <nav wire:ignore id="audit-form-tab"
            class="audit-form-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4 justify-content-center">
            @forelse ($category_list as $key => $data)
                <a @class([
                    'flex-sm-fill',
                    'text-sm-center',
                    'nav-link',
                    'active' => $key == $active_index,
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
        <div class="tab-content" id="audit-form-tab-content">
            @forelse ($category_list as $key => $data)
                <div class="tab-pane fade show {{ $key == $active_index ? 'active' : '' }}"
                    id="cat{{ $data->id }}" role="tabpanel" aria-labelledby="cat{{ $data->id }}-tab">
                    <div class="row g-4 mb-4">
                        <div class="col-12 }}">
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
                            <div class="col-12 }}">
                                <div class="app-card app-card-chart  shadow-sm">
                                    <div class="app-card-header p-3">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-12">
                                                <h4 class="app-card-title">Critical Deviation</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="app-card-body p-3 p-lg-4">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-12">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col"></th>
                                                            <th scope="col">Deviation</th>
                                                            <th scope="col">Ramerks</th>
                                                            <th scope="col">Score</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($data->critical_deviation as $item)
                                                            <tr class="">
                                                                <td>{{ $item['label'] }}</td>
                                                                <td>{{ $item['saved_dropdown'] != null ? $item['saved_dropdown'] : 'n/a' }}
                                                                </td>
                                                                <td>{{ $item['saved_remarks'] != null ? $item['saved_remarks'] : 'n/a' }}
                                                                </td>
                                                                <td>{{ $item['saved_score'] != null ? $item['saved_score'] : 'n/a' }}
                                                                </td>
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

                    {{--     @if ($key == 0)

                                <div class="accordion mb-3" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                <h6 class="card-title product-name">Speed and Accuracy</h6>
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show "
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <label for="" class="mb-3">Cashier TAT</label>
                                                @foreach ($cashier_tat as $item)
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-9">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <input type="text" class="form-control"
                                                                            disabled name="cashier_name"
                                                                            placeholder="Cashier Name"
                                                                            id="name_{{ $loop->index }}"
                                                                            wire:model.lazy="cashier_tat.{{ $loop->index }}.name"
                                                                            wire:focus="$set('currentIndex', '{{ $loop->index }}')">
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <input type="text" class="form-control"
                                                                            disabled name="time"
                                                                            id="time_{{ $loop->index }}"
                                                                            wire:model="cashier_tat.{{ $loop->index }}.time"
                                                                            wire:focus="$set('currentField', 'time')"
                                                                            placeholder="hh:mm">
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <input type="text" class="form-control"
                                                                            disabled name="product_order"
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
                                                                                <input type="text" disabled
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
                                                                                <input type="text" disabled
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
                                                                                <input type="text" disabled
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
                                                                                <input type="text" disabled
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
                                                                                <input type="text" disabled
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
                                                                                <input type="text" disabled
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
                                                                <textarea class="form-control" disabled name="" id="" rows="6"
                                                                    id="remarks_{{ $loop->index }}" wire:model="cashier_tat.{{ $loop->index }}.remarks" placeholder="Remarks"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <label for="" class="mb-3">Server CAT</label>
                                                @foreach ($server_cat as $item)
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-9">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <input type="text" disabled
                                                                            class="form-control" name="server_name"
                                                                            placeholder="Server Name"
                                                                            id="name_{{ $loop->index }}"
                                                                            wire:model.lazy="server_cat.{{ $loop->index }}.name"
                                                                            wire:focus="$set('currentIndex', '{{ $loop->index }}')">
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <input type="text" disabled
                                                                            class="form-control" name="time"
                                                                            id="time_{{ $loop->index }}"
                                                                            wire:model="server_cat.{{ $loop->index }}.time"
                                                                            wire:focus="$set('currentField', 'time')"
                                                                            placeholder="hh:mm">
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="mb-3">
                                                                        <input type="text" disabled
                                                                            class="form-control" name="product_order"
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
                                                                                <input type="text" disabled
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
                                                                                <input type="text" disabled
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
                                                                                <input type="text" disabled
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
                                                                                <input type="text" disabled
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
                                                                                <input type="text" disabled
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
                                                                                <input type="text" disabled
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
                                                                <textarea class="form-control" disabled rows="6" id="remarks_{{ $loop->index }}"
                                                                    wire:model="server_cat.{{ $loop->index }}.remarks" placeholder="Remarks"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif --}}


                    @forelse ($data->sub_categ['data_items'] as  $key =>  $dataItem)
                        <div class="row g-4 mb-4" id="{{ $dataItem['name'] }}">
                            <div class="col-12 }}">
                                <div class="app-card app-card-chart  shadow-sm">
                                    <div class="app-card-header p-3">
                                        <h5 class="app-card-title">{{ $dataItem['name'] }}</h5>
                                    </div>
                                    <div class="app-card-body p-3 p-lg-4">
                                        <div class="table-responsive">
                                            <table class="table white-bg">
                                                <thead>
                                                    <tr>
                                                        <th scope="col"></th>
                                                        <th scope="col">Score</th>
                                                        <th scope="col">Remarks</th>
                                                        <th scope="col">Deviation</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @if ($dataItem['is_sub'] == 0)
                                                        @foreach ($dataItem['sub_category'] as $index => $auditLabel)
                                                            <tr>
                                                                <td class="w-50">
                                                                    <p @class(['pt-4' => $index == 0])>
                                                                        {{ $auditLabel['name'] }}</p>
                                                                </td>
                                                                <td>{{ $auditLabel['points'] != null ? $auditLabel['points'] : '0' }}
                                                                </td>
                                                                <td>{{ $auditLabel['remarks'] != null ? $auditLabel['remarks'] : 'n/a' }}
                                                                </td>
                                                                <td>{{ $auditLabel['deviation'] != null ? $auditLabel['deviation'] : 'n/a' }}
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
                                                            @foreach ($sub_category['label'] as $index => $auditLabel)
                                                                <tr>
                                                                    <td class="w-50">
                                                                        <p @class(['pt-4' => $index == 0])>
                                                                            {{ $auditLabel['name'] }}</p>
                                                                    </td>
                                                                    <td>{{ $auditLabel['points'] != null ? $auditLabel['points'] : 'n/a' }}
                                                                    </td>
                                                                    <td>{{ $auditLabel['remarks'] != null ? $auditLabel['remarks'] : 'n/a' }}
                                                                    </td>
                                                                    <td>{{ $auditLabel['deviation'] != null ? $auditLabel['deviation'] : 'n/a' }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
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
