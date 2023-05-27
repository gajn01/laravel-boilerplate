@section('title', 'Mary Grace Restaurant Operation System / Audit Forms')
<div class="container-xl">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('audit') }}">Audit</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $store_name }}</li>
        </ol>
    </nav>
    {{--     <div>
        <input type="text" wire:model="message">
        <p>Message: {{ $message }}</p>
        <p>Uppercase Message: {{ $uppercaseMessage }}</p>
    </div> --}}
    <div class="page-utilities mb-3" wire:poll.10s>
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
                <div class="tab-pane fade show {{ $key == $active_index ? 'active' : '' }}" id="cat{{ $data->id }}"
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
                                                            <td class="text-center">
                                                                {{ $sub['base_score'] == 0 ? 'n/a' : $sub['base_score'] }}
                                                            </td>
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
                                        @foreach ($data->critical_deviation as $item)
                                            <label for="" class="form-label ">{{ $item['label'] }}</label>
                                            @if ($item['is_sd'])
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3" wire:ignore>
                                                            <select class="form-select form-select-md"
                                                                wire:change="updateCriticalDeviation({{ json_encode($item) }},$event.target.value,'sd')"
                                                                name="sd{{ $item['id'] }}"
                                                                id="sd{{ $item['id'] }}">
                                                                <option value=""
                                                                    {{ $item['saved_sd'] == '' ? 'selected' : '' }}>
                                                                    Select sd</option>
                                                                @forelse ($sanitation_list as $sanitation)
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
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6">
                                                        <div class="mb-3" wire:ignore>
                                                            <select class="form-select form-select-md"
                                                                wire:change="updateCriticalDeviation({{ json_encode($item) }},$event.target.value,'location')"
                                                                name="location{{ $item['id'] }}"
                                                                id="location{{ $item['id'] }}">
                                                                <option value=""
                                                                    {{ $item['saved_location'] == '' ? 'selected' : '' }}>
                                                                    Select location</option>
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
                                                        <div class="mb-3" wire:ignore>
                                                            <select class="form-select form-select-md"
                                                                wire:change="updateCriticalDeviation({{ json_encode($item) }},$event.target.value,'score')"
                                                                name="loc_score{{ $item['id'] }}"
                                                                id="loc_score{{ $item['id'] }}">
                                                                <option value=""
                                                                    {{ $item['saved_score'] == '' ? 'selected' : '' }}>
                                                                    Select score</option>
                                                                @foreach ($score as $scores)
                                                                    <option value="{{ $scores['name'] }}"
                                                                        {{ $scores['name'] === $item['saved_score'] ? 'selected' : '' }}>
                                                                        {{ $scores['name'] }}
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
                                                        <div class="mb-3" wire:ignore.self>
                                                            <select class="form-select form-select-md"
                                                                wire:change="updateCriticalDeviation({{ json_encode($item) }},$event.target.value,'product')"
                                                                name="product{{ $item['id'] }}"
                                                                id="product{{ $item['id'] }}">
                                                                <option value=""
                                                                    {{ $item['saved_product'] == '' ? 'selected' : '' }}>
                                                                    Select product</option>
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
                                                        <div class="mb-3" wire:ignore>
                                                            <select class="form-select form-select-md"
                                                                wire:change="updateCriticalDeviation({{ json_encode($item) }},$event.target.value,'score')"
                                                                name="product_score{{ $item['id'] }}"
                                                                id="product_score{{ $item['id'] }}">
                                                                <option value=""
                                                                    {{ $item['saved_score'] == '' ? 'selected' : '' }}>
                                                                    Select score</option>
                                                                @foreach ($score as $scores)
                                                                    <option value="{{ $scores['name'] }}"
                                                                        {{ $scores['name'] === $item['saved_score'] ? 'selected' : '' }}>
                                                                        {{ $scores['name'] }}
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
                                                        <div class="mb-3" wire:ignore.self>
                                                            <select class="form-select form-select-md"
                                                                wire:change="updateCriticalDeviation({{ json_encode($item) }}, $event.target.value, 'dropdown')"
                                                                name="dropdown{{ $item['id'] }}"
                                                                id="dropdown{{ $item['id'] }}">
                                                                <option value=""
                                                                    {{ $item['saved_dropdown'] == '' ? 'selected' : '' }}>
                                                                    Select deviation</option>
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
                                                        <div class="mb-3" wire:ignore.self>
                                                            <select class="form-select form-select-md"
                                                                wire:change="updateCriticalDeviation({{ json_encode($item) }},$event.target.value,'score')"
                                                                name="dp_score{{ $item['id'] }}"
                                                                id="dp_score{{ $item['id'] }}">
                                                                <option value=""
                                                                    {{ $item['saved_score'] == '' ? 'selected' : '' }}>
                                                                    Select score</option>

                                                                @foreach ($score as $scores)
                                                                    <option value="{{ $scores['name'] }}"
                                                                        {{ $scores['name'] === $item['saved_score'] ? 'selected' : '' }}>
                                                                        {{ $scores['name'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>
                                            @endif
                                            @if ($item['remarks'])
                                                <div class="mb-3" wire:ignore.self>
                                                    <textarea class="form-control"
                                                        wire:change="updateCriticalDeviation({{ json_encode($item) }},$event.target.value,'remarks')"
                                                        name="remarks{{ $item['id'] }}" id="remarks{{ $item['id'] }}" rows="2"
                                                        placeholder="Enter remarks here...">{{ $item['saved_remarks'] }}</textarea>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
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
                                        <div id="collapseOne" class="accordion-collapse collapse show "
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
                                                        <div class="col-sm-12 col-md-12">
                                                            <div class="row">
                                                                <div class="col-3">
                                                                    <div class="mb-3">
                                                                        <label for="name_{{ $loop->index }}">Cashier
                                                                            Name </label>
                                                                        <input type="text" class="form-control"
                                                                            name="cashier_name"
                                                                            id="name_{{ $loop->index }}"
                                                                            wire:model.lazy="cashier_tat.{{ $loop->index }}.name"
                                                                            wire:focus="$set('currentIndex', '{{ $loop->index }}')">
                                                                    </div>
                                                                </div>
                                                                <div class="col-2">
                                                                    <div class="mb-3">
                                                                        <label for="time_{{ $loop->index }}">Time
                                                                        </label>
                                                                        <input type="text" class="form-control"
                                                                            name="time"
                                                                            id="time_{{ $loop->index }}"
                                                                            wire:model="cashier_tat.{{ $loop->index }}.time"
                                                                            wire:focus="$set('currentField', 'time')"
                                                                            placeholder="hh:mm">
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="mb-3">
                                                                        <label
                                                                            for="product_order{{ $loop->index }}">Product
                                                                            Ordered </label>
                                                                        <input type="text" class="form-control"
                                                                            name="product_order"
                                                                            id="product_order{{ $loop->index }}"
                                                                            wire:model="cashier_tat.{{ $loop->index }}.product_order">
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <div class="mb-3">
                                                                                <label>OT </label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    id="ot"
                                                                                    wire:model="cashier_tat.{{ $loop->index }}.ot">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="mb-3">
                                                                                <label>Assembly </label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    name="assembly" id="assembly"
                                                                                    wire:model="cashier_tat.{{ $loop->index }}.assembly">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="mb-3">
                                                                                <label>Point </label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    name="ac_point" id="ac_point"
                                                                                    wire:model="cashier_tat.{{ $loop->index }}.ac_point"
                                                                                    placeholder="Point">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <label for="" class="">TAT (1pt.)
                                                                    </label>
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
                                                                <div class="col-3">
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
                                                                <div class="col-6">
                                                                    <div class="mb-3">
                                                                        <label>Remarks </label>
                                                                        <textarea class="form-control" name="" id="" rows="2" id="remarks_{{ $loop->index }}"
                                                                            wire:model="cashier_tat.{{ $loop->index }}.remarks" placeholder="Remarks"></textarea>
                                                                    </div>
                                                                </div>
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
                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <div class="col-3">
                                                                    <div class="mb-3">
                                                                        <label for="server_name">Server Name</label>
                                                                        <input type="text" class="form-control"
                                                                            name="server_name"
                                                                            id="name_{{ $loop->index }}"
                                                                            wire:model.lazy="server_cat.{{ $loop->index }}.name"
                                                                            wire:focus="$set('currentIndex', '{{ $loop->index }}')">
                                                                    </div>
                                                                </div>
                                                                <div class="col-2">
                                                                    <div class="mb-3">
                                                                        <label for="time">Time</label>
                                                                        <input type="text" class="form-control"
                                                                            name="time"
                                                                            id="time_{{ $loop->index }}"
                                                                            wire:model="server_cat.{{ $loop->index }}.time"
                                                                            wire:focus="$set('currentField', 'time')"
                                                                            placeholder="hh:mm">
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="mb-3">
                                                                        <label for="product_order">Product
                                                                            Ordered</label>
                                                                        <input type="text" class="form-control"
                                                                            name="product_order"
                                                                            id="product_order{{ $loop->index }}"
                                                                            wire:model="server_cat.{{ $loop->index }}.product_order"
                                                                            placeholder="Product Ordered">
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <div class="mb-3">
                                                                                <label>OT </label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    id="ot"
                                                                                    wire:model="cashier_tat.{{ $loop->index }}.ot">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="mb-3">
                                                                                <label>Assembly </label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    name="assembly" id="assembly"
                                                                                    wire:model="cashier_tat.{{ $loop->index }}.assembly">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="mb-3">
                                                                                <label>Point </label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    name="ac_point" id="ac_point"
                                                                                    wire:model="cashier_tat.{{ $loop->index }}.ac_point"
                                                                                    placeholder="Point">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
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
                                                                <div class="col-3">
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
                                                                <div class="col-6">
                                                                    <div class="mb-3">
                                                                        <label for="">Remarks</label>
                                                                        <textarea class="form-control" name="" id="" rows="2" id="remarks_{{ $loop->index }}"
                                                                            wire:model="server_cat.{{ $loop->index }}.remarks" placeholder="Remarks"></textarea>
                                                                    </div>
                                                                </div>
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
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
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
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="toggle-switch"
                                                                    wire:model="is_na.{{ $auditLabel['id'] }}"
                                                                    wire:change="updateNa(
                                                                    '{{ $auditLabel['id'] }}',
                                                                    '{{ $loop->parent->parent->index }}',
                                                                    '{{ $loop->parent->index }}',
                                                                    '{{ $loop->index }}',
                                                                    '',
                                                                    '{{ $category_list[$loop->parent->parent->index]['id'] }}',
                                                                    '{{ $category_list[$loop->parent->parent->index]['sub_categ']['data_items'][$loop->parent->index]['id'] }}',
                                                                    '{{ $category_list[$loop->parent->parent->index]['sub_categ']['data_items'][$loop->parent->index]['sub_category'][$loop->index]['id'] }}',
                                                                    '',
                                                                    '{{ $dataItem['is_sub'] }}',
                                                                    $event.target.value
                                                                )">
                                                                <label class="form-check-label"
                                                                    for="toggle-switch">n/a</label>
                                                            </div>
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
                                                                            value="{{ $auditLabel['is_all_nothing'] ? $auditLabel['bp'] . '*' : $auditLabel['bp'] }}"
                                                                            placeholder="">
                                                                    </div>
                                                                    <div class="col-sm-6 col-md-6">
                                                                        @if ($index == 0)
                                                                            <label for="points"
                                                                                class="form-label">Point(s)</label>
                                                                        @endif

                                                                        <input type="number"
                                                                            class="form-control text-center"
                                                                            @disabled($auditLabel['is_na'] ? true : false)
                                                                            name="points{{ $auditLabel['id'] }}"
                                                                            id="points{{ $auditLabel['id'] }}"
                                                                            value="{{ $auditLabel['points'] }}"
                                                                            min="{{ $auditLabel['is_all_nothing'] ? $auditLabel['bp'] : 0 }}"
                                                                            max="{{ $auditLabel['is_all_nothing'] ? 0 : $auditLabel['bp'] }}"
                                                                            wire:change="updatePoints(
                                                                            'points{{ $auditLabel['id'] }}',
                                                                            '{{ $loop->parent->parent->index }}',
                                                                            '{{ $loop->parent->index }}',
                                                                            '{{ $loop->index }}',
                                                                            '',
                                                                            '{{ $category_list[$loop->parent->parent->index]['id'] }}',
                                                                            '{{ $category_list[$loop->parent->parent->index]['sub_categ']['data_items'][$loop->parent->index]['id'] }}',
                                                                            '{{ $category_list[$loop->parent->parent->index]['sub_categ']['data_items'][$loop->parent->index]['sub_category'][$loop->index]['id'] }}',
                                                                            '',
                                                                            '{{ $dataItem['is_sub'] }}',
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

                                                                        <textarea class="form-control" @disabled($auditLabel['is_na'] ? true : false) name="remarks" id="remarks" rows="1"
                                                                            wire:change="updateRemarks(
                                                                            '{{ $category_list[$loop->parent->parent->index]['id'] }}',
                                                                            '{{ $category_list[$loop->parent->parent->index]['sub_categ']['data_items'][$loop->parent->index]['id'] }}',
                                                                            '{{ $category_list[$loop->parent->parent->index]['sub_categ']['data_items'][$loop->parent->index]['sub_category'][$loop->index]['id'] }}',
                                                                            '',
                                                                            '{{ $dataItem['is_sub'] }}',
                                                                            $event.target.value )">{{ $category_list[$loop->parent->parent->index]['sub_categ']['data_items'][$loop->parent->index]['sub_category'][$loop->index]['remarks'] }}</textarea>
                                                                    </div>
                                                                    @if (!empty($auditLabel['dropdown']))
                                                                        <div
                                                                            class="col-sm-12 col-md-6 {{ $auditLabel['dropdown'] ? '' : 'd-none' }}">
                                                                            @if ($index == 0 || empty($auditLabel['dropdown']))
                                                                                <label for=""
                                                                                    class="form-label">Deviation</label>
                                                                            @endif
                                                                            <select class="form-select form-select-md"
                                                                                wire:change="updateDeviation('{{ $category_list[$loop->parent->parent->index]['id'] }}',
                                                                                '{{ $category_list[$loop->parent->parent->index]['sub_categ']['data_items'][$loop->parent->index]['id'] }}',
                                                                                '{{ $category_list[$loop->parent->parent->index]['sub_categ']['data_items'][$loop->parent->index]['sub_category'][$loop->index]['id'] }}',
                                                                                '',
                                                                                '{{ $dataItem['is_sub'] }}',
                                                                                $event.target.value )"
                                                                                name="tag{{ $auditLabel['name'] }}"
                                                                                id="tag">
                                                                                <option value="0">Select a
                                                                                    deviation</option>
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
                                                                    class="accordion-collapse "
                                                                    aria-labelledby="flush-{{ $sub_category['id'] }}"
                                                                    data-bs-parent="#accordionFlushSubcategory">
                                                                    <div class="accordion-body">
                                                                        @foreach ($sub_category['label'] as $index => $auditLabel)
                                                                            <div class="row mb-3">
                                                                                <div class="form-check form-switch">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        id="toggle-switch"
                                                                                        wire:model="is_na.{{ $auditLabel['id'] }}"
                                                                                        wire:change="updateNa(
                                                                                        '{{ $auditLabel['id'] }}',
                                                                                        '{{ $loop->parent->parent->parent->index }}',
                                                                                        '{{ $loop->parent->parent->index }}',
                                                                                        '{{ $loop->parent->index }}',
                                                                                        '{{ $loop->index }}',
                                                                                        '{{ $category_list[$loop->parent->parent->parent->index]['id'] }}',
                                                                                        '{{ $category_list[$loop->parent->parent->parent->index]['sub_categ']['data_items'][$loop->parent->parent->index]['id'] }}',
                                                                                        '{{ $category_list[$loop->parent->parent->parent->index]['sub_categ']['data_items'][$loop->parent->parent->index]['sub_category'][$loop->parent->index]['id'] }}',
                                                                                        '{{ $category_list[$loop->parent->parent->parent->index]['sub_categ']['data_items'][$loop->parent->parent->index]['sub_category'][$loop->parent->index]['label'][$loop->index]['id'] }}',
                                                                                        '{{ $dataItem['is_sub'] }}',
                                                                                        $event.target.value )">
                                                                                    <label class="form-check-label"
                                                                                        for="toggle-switch">n/a</label>
                                                                                </div>
                                                                                <div
                                                                                    class="col-sm-12 col-md-4 col-lg-4">
                                                                                    <p @class(['pt-4' => $index == 0])>
                                                                                        {{ $auditLabel['name'] }}
                                                                                    </p>
                                                                                </div>
                                                                                <div class="col-sm-12 col-md-2  ">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-6 col-md-6">
                                                                                            @if ($index == 0)
                                                                                                <label for=""
                                                                                                    class="form-label">BP</label>
                                                                                            @endif
                                                                                            <input type="text"
                                                                                                class="form-control text-center"
                                                                                                disabled
                                                                                                name="bp{{ $auditLabel['name'] }}"
                                                                                                id="bp"
                                                                                                placeholder=""
                                                                                                value="{{ $auditLabel['is_all_nothing'] ? $auditLabel['bp'] . '*' : $auditLabel['bp'] }}">
                                                                                        </div>
                                                                                        <div class="col-sm-6 col-md-6">
                                                                                            @if ($index == 0)
                                                                                                <label for=""
                                                                                                    class="form-label">Point</label>
                                                                                            @endif
                                                                                            <input type="number"
                                                                                                class="form-control text-center"
                                                                                                @disabled($auditLabel['is_na'] ? true : false)
                                                                                                name="points{{ $auditLabel['id'] }}"
                                                                                                id="points{{ $auditLabel['id'] }}"
                                                                                                value="{{ $auditLabel['points'] }}"
                                                                                                min="{{ $auditLabel['is_all_nothing'] ? $auditLabel['bp'] : 0 }}"
                                                                                                max="{{ $auditLabel['is_all_nothing'] ? 0 : $auditLabel['bp'] }}"
                                                                                                wire:change="updatePoints(
                                                                                                'points{{ $auditLabel['id'] }}',
                                                                                                '{{ $loop->parent->parent->parent->index }}',
                                                                                                '{{ $loop->parent->parent->index }}',
                                                                                                '{{ $loop->parent->index }}',
                                                                                                '{{ $loop->index }}',
                                                                                                '{{ $category_list[$loop->parent->parent->parent->index]['id'] }}',
                                                                                                '{{ $category_list[$loop->parent->parent->parent->index]['sub_categ']['data_items'][$loop->parent->parent->index]['id'] }}',
                                                                                                '{{ $category_list[$loop->parent->parent->parent->index]['sub_categ']['data_items'][$loop->parent->parent->index]['sub_category'][$loop->parent->index]['id'] }}',
                                                                                                '{{ $category_list[$loop->parent->parent->parent->index]['sub_categ']['data_items'][$loop->parent->parent->index]['sub_category'][$loop->parent->index]['label'][$loop->index]['id'] }}',
                                                                                                '{{ $dataItem['is_sub'] }}',
                                                                                                $event.target.value )">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-sm-12 col-md-6 col-lg-6 ">
                                                                                    <div class="row">
                                                                                        <div
                                                                                            class="col-sm-12 {{ $auditLabel['dropdown'] ? 'col-md-6' : 'col-md-12' }}">
                                                                                            @if ($index == 0)
                                                                                                <label for=""
                                                                                                    class="form-label">Remarks</label>
                                                                                            @endif
                                                                                            <textarea class="form-control" name="" id="" rows="1" @disabled($auditLabel['is_na'] ? true : false)
                                                                                                wire:change="updateRemarks(
                                                                                                '{{ $category_list[$loop->parent->parent->parent->index]['id'] }}',
                                                                                                '{{ $category_list[$loop->parent->parent->parent->index]['sub_categ']['data_items'][$loop->parent->parent->index]['id'] }}',
                                                                                                '{{ $category_list[$loop->parent->parent->parent->index]['sub_categ']['data_items'][$loop->parent->parent->index]['sub_category'][$loop->parent->index]['id'] }}',
                                                                                                '{{ $category_list[$loop->parent->parent->parent->index]['sub_categ']['data_items'][$loop->parent->parent->index]['sub_category'][$loop->parent->index]['label'][$loop->index]['id'] }}',
                                                                                                '{{ $dataItem['is_sub'] }}',
                                                                                                $event.target.value )">{{ $category_list[$loop->parent->parent->parent->index]['sub_categ']['data_items'][$loop->parent->parent->index]['sub_category'][$loop->parent->index]['label'][$loop->index]['remarks'] }}</textarea>
                                                                                        </div>
                                                                                        @if (!empty($auditLabel['dropdown']))
                                                                                            <div
                                                                                                class="col-sm-12 col-md-6 {{ $auditLabel['dropdown'] ? '' : 'd-none' }}">
                                                                                                @if ($index == 0 || empty($auditLabel['dropdown']))
                                                                                                    <label
                                                                                                        for=""
                                                                                                        class="form-label">Deviation</label>
                                                                                                @endif
                                                                                                <select
                                                                                                    class="form-select form-select-md"
                                                                                                    @disabled($auditLabel['is_na'] ? true : false)
                                                                                                    wire:change="updateDeviation(
                                                                                                    '{{ $category_list[$loop->parent->parent->parent->index]['id'] }}',
                                                                                                    '{{ $category_list[$loop->parent->parent->parent->index]['sub_categ']['data_items'][$loop->parent->parent->index]['id'] }}',
                                                                                                    '{{ $category_list[$loop->parent->parent->parent->index]['sub_categ']['data_items'][$loop->parent->parent->index]['sub_category'][$loop->parent->index]['id'] }}',
                                                                                                    '{{ $category_list[$loop->parent->parent->parent->index]['sub_categ']['data_items'][$loop->parent->parent->index]['sub_category'][$loop->parent->index]['label'][$loop->index]['id'] }}',
                                                                                                    '{{ $dataItem['is_sub'] }}',
                                                                                                    $event.target.value )"
                                                                                                    name="tag{{ $auditLabel['name'] }}"
                                                                                                    id="tag">
                                                                                                    <option
                                                                                                        value="0">
                                                                                                        Select a
                                                                                                        deviation
                                                                                                    </option>
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
