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
            <div class="col-auto">
                <a class="btn app-btn-primary" wire:click="test" {{-- href="{{ route('form.summary', ['store_name' => $store_name]) }}" --}}>Complete</a>
            </div>
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
                href="#cat{{ $data->id }}" role="tab" aria-controls="cat{{ $data->id }}"
                aria-selected="{{ $key == 0 ? 'true' : 'false' }}">
                {{ $data->name }}
            </a>
        @empty
            <p class="m-0 p-2">No category found!</p>
        @endforelse
    </nav>
    <div class="tab-content" id="audit-form-tab-content" wire:ignore>
        @forelse ($category_list as $key => $data)
            <div class="tab-pane fade show {{ $key == 0 ? 'active' : '' }}" id="cat{{ $data->id }}" role="tabpanel"
                aria-labelledby="cat{{ $data->id }}-tab">
                <div class="row g-4 mb-4">
                    <div class="col-12 col-lg-6">
                        <div class="app-card app-card-chart h-100 shadow-sm">
                            <div class="app-card-header p-3">
                                <h4 class="app-card-title">Overall Score</h4>

                            </div>

                            <div class="app-card-body p-3 p-lg-4">
                                <div class="row justify-content-between align-items-center">
                                    <div class="col-12">
                                        <table class="table app-table-hover mb-0 text-left">
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
                                                        <h5 class="app-card-title text-center">Total</h5>
                                                    </td>
                                                    <td class="text-center">{{ $data->sub_categ['total_base_score'] }}
                                                    </td>
                                                    <td class="text-center"> {{ $data->sub_categ['total_base_score'] }}
                                                    </td>
                                                    <td class="text-center">{{ $data->sub_categ['total_percentage'] }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                <div class="table-responsive">
                                    <table class="table overall-table m-0">
                                        <tbody>
                                            {{-- Less Critical & Major SD  --}}
                                            <tr>
                                                <td scope="col" colspan="4">Less Critical & Major SD</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <select class="form-select form-select-md" name="sd" id="sd">
                                                        <option selected hidden>Type of SD</option>
                                                        <option value="SD1">SD1</option>
                                                        <option value="SD3">SD3</option>
                                                        <option value="SD7">SD7</option>
                                                    </select>
                                                </td>
                                                <td class="w-50">
                                                    <input type="text" class="form-control" name="product" id="product"
                                                        placeholder="Product">
                                                </td>
                                                <td class="text-center">
                                                    <span x-on:click.prevent="addLcm">
                                                        <svg class="icon mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                            <path
                                                                d="M240 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H176V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H384c17.7 0 32-14.3 32-32s-14.3-32-32-32H240V80z" />
                                                        </svg>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    <select class="form-select form-select-md" name="sd" id="sd">
                                                        <option selected hidden>Score</option>
                                                        <option value="5%">5%</option>
                                                        <option value="15%">15%</option>
                                                        <option value="25%">25%</option>
                                                    </select>
                                                </td>
                                            </tr>
                                      {{--       <tr>
                                                <td colspan="4">
                                                    <ul>
                                                        @foreach ($lcm as $item)
                                                            <li>
                                                                {{ $item['sd'] }} - <span>{{ $item['product'] }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                            </tr> --}}
                                            {{-- Less Spoiled/Lapsed product  --}}

                                            <tr>
                                                <td scope="col" colspan="4">Less Spoiled/Lapsed product</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <input type="text" class="form-control" name="" id=""
                                                        placeholder="Product">
                                                </td>
                                                <td class="text-center">
                                                    <span>
                                                        <svg class="icon mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                            <path
                                                                d="M240 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H176V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H384c17.7 0 32-14.3 32-32s-14.3-32-32-32H240V80z" />
                                                        </svg>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    <select class="form-select form-select-md" name="sd" id="sd">
                                                        <option selected hidden>Score</option>
                                                        <option value="5%">5%</option>
                                                        <option value="15%">15%</option>
                                                        <option value="25%">25%</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-card app-card-orders-table shadow-sm mb-5 bg-none">
                    <div class="app-card-body">
                        @forelse ($data->sub_categ['data_items'] as  $key =>  $dataItem)
                            <div class="accordion mb-3" id="accordionCategory">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="{{ $dataItem['name'] }}">
                                        <button class="accordion-button " type="button" data-bs-toggle="collapse"
                                            data-bs-target="#accrod{{ $dataItem['id'] }}" aria-expanded="true"
                                            aria-controls="accrod{{ $dataItem['id'] }}">
                                            <h6 class="card-title product-name">{{ $dataItem['name'] }}</h6>
                                        </button>
                                    </h2>
                                    <div id="accrod{{ $dataItem['id'] }}" class="accordion-collapse collapse show"
                                        aria-labelledby="accrod{{ $dataItem['id'] }}"
                                        data-bs-parent="#accordionCategory">
                                        <div class="accordion-body">
                                            @if ($dataItem['is_sub'] == 0)
                                                @foreach ($dataItem['sub_category'] as $index => $auditLabel)
                                                    <div class="row mb-3">
                                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                                            <p @class(['pt-4' => $index == 0])>{{ $auditLabel['name'] }}
                                                            </p>
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
                                                                        id="bp" placeholder=""
                                                                        value="{{ $auditLabel['is_all_nothing'] }}">
                                                                </div>
                                                                <div class="col-sm-6 col-md-6">
                                                                    @if ($index == 0)
                                                                        <label for=""
                                                                            class="form-label">Point</label>
                                                                    @endif
                                                                    <input type="number"
                                                                        class="form-control text-center"
                                                                        name="points{{ $auditLabel['name'] }}"
                                                                        value="{{ $auditLabel['points'] }}"
                                                                        id="points">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                                            <div class="row">
                                                                <div
                                                                    class="col-sm-12 {{ $auditLabel['dropdown'] ? 'col-md-6' : 'col-md-12' }}">
                                                                    @if ($index == 0)
                                                                        <label for=""
                                                                            class="form-label">Remarks</label>
                                                                    @endif
                                                                    <textarea class="form-control"
                                                                        wire:model="data.{{ $loop->parent->parent->index }}.data_items.{{ $loop->parent->index }}.sub_category.{{ $loop->index }}.remarks"
                                                                        id="" rows="1"></textarea>
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
                                                                            <option value="0">Select a deviation
                                                                            </option>
                                                                            @foreach ($auditLabel['dropdown'] as $result)
                                                                                @if (isset($result['name']))
                                                                                    <option
                                                                                        value="{{ $result['id'] }}">
                                                                                        {{ $result['name'] }}</option>
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
                                                                            <div class="col-sm-12 col-md-4 col-lg-4">
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
                                                                            <div class="col-sm-12 col-md-6 col-lg-6 ">
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
                                                                                                <label for=""
                                                                                                    class="form-label">Deviation</label>
                                                                                            @endif
                                                                                            <select
                                                                                                class="form-select form-select-md"
                                                                                                wire:model="data.{{ $loop->parent->parent->index }}.data_items.{{ $loop->parent->index }}.sub_category.{{ $loop->index }}.tag"
                                                                                                name="tag{{ $auditLabel['name'] }}"
                                                                                                id="tag">
                                                                                                <option value="0">
                                                                                                    Select a deviation
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


                    {{--  <div class="app-card-header p-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <h4 class="app-card-title">Core Product</h4>
                            </div>
                        </div>
                    </div> --}}
                    {{--       @forelse ($data->sub_categ['data_items'] as $dataItem)
                        <div class="app-card-body">
                            <div class="table-responsive">
                                <table class="table app-table-hover mb-0 text-left">
                                    <thead>
                                        <tr>
                                            <th class="cell "></th>
                                            <th class="cell audit-points">Base Point</th>
                                            <th class="cell audit-points">Point</th>
                                            <th class="cell w-25">Remarks</th>
                                            <th class="cell w-25">Deviation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="{{ $dataItem['name'] }}">
                                            <td colspan="5">
                                                <h6 class="card-title product-name">{{ $dataItem['name'] }}</h6>
                                            </td>
                                        </tr>
                                        @if ($dataItem['is_sub'] == 0)
                                            @foreach ($dataItem['sub_category'] as $auditLabel)
                                                <tr>
                                                    <td class="product-audit">
                                                        <p>{{ $auditLabel['name'] }}</p>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control text-center"
                                                            disabled name="bp{{ $auditLabel['name'] }}"
                                                            id="bp" placeholder=""
                                                            value="{{ $auditLabel['is_all_nothing'] }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control text-center"
                                                            wire:model="data.{{ $loop->parent->parent->index }}.data_items.{{ $loop->parent->index }}.sub_category.{{ $loop->index }}.points"
                                                            name="points{{ $auditLabel['name'] }}" id="points"
                                                            value="{{ $auditLabel['points'] }}">
                                                    </td>
                                                    <td colspan="{{ $auditLabel['dropdown'] ? '' : 2 }}">
                                                        <input type="text" class="form-control"
                                                            wire:model="data.{{ $loop->parent->parent->index }}.data_items.{{ $loop->parent->index }}.sub_category.{{ $loop->index }}.remarks"
                                                            name="remarks{{ $auditLabel['name'] }}" id="remarks"
                                                            value="{{ $auditLabel['remarks'] }}">
                                                    </td>
                                                    <td>
                                                        @if (!empty($auditLabel['dropdown']))
                                                            <select class="form-select form-select-md"
                                                                wire:model="data.{{ $loop->parent->parent->index }}.data_items.{{ $loop->parent->index }}.sub_category.{{ $loop->index }}.tag"
                                                                name="tag{{ $auditLabel['name'] }}" id="tag">
                                                                <option value="0">Select a deviation</option>
                                                                @foreach ($auditLabel['dropdown'] as $result)
                                                                    @if (isset($result['name']))
                                                                        <option value="{{ $result['id'] }}">
                                                                            {{ $result['name'] }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @foreach ($dataItem['sub_category'] as $sub_category)
                                                @if ($sub_category['name'])
                                                    <tr>
                                                        <td class="product-sub-category " colspan="5">
                                                            <p>{{ $sub_category['name'] }}</p>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @foreach ($sub_category['label'] as $auditLabel)
                                                    <tr>
                                                        <td class="product-audit">
                                                            <p>{{ $auditLabel['name'] }}</p>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control text-center"
                                                                disabled name="bp{{ $auditLabel['name'] }}"
                                                                id="bp" placeholder=""
                                                                value="{{ $auditLabel['is_all_nothing'] }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control text-center"
                                                                wire:model="data.{{ $loop->parent->parent->index }}.data_items.{{ $loop->parent->index }}.sub_category.{{ $loop->index }}.points"
                                                                name="points{{ $auditLabel['name'] }}" id="points"
                                                                value="{{ $auditLabel['points'] }}">
                                                        </td>
                                                        <td colspan="{{ $auditLabel['dropdown'] ? '' : 2 }}">
                                                            <input type="text" class="form-control"
                                                                wire:model="data.{{ $loop->parent->parent->index }}.data_items.{{ $loop->parent->index }}.sub_category.{{ $loop->index }}.remarks"
                                                                name="remarks{{ $auditLabel['name'] }}"
                                                                id="remarks" value="{{ $auditLabel['remarks'] }}">
                                                        </td>
                                                        <td>
                                                            @if (!empty($auditLabel['dropdown']))
                                                                <select class="form-select form-select-md"
                                                                    wire:model="data.{{ $loop->parent->parent->index }}.data_items.{{ $loop->parent->index }}.sub_category.{{ $loop->index }}.tag"
                                                                    name="tag{{ $auditLabel['name'] }}"
                                                                    id="tag">
                                                                    <option value="0">Select a deviation
                                                                    </option>
                                                                    @foreach ($auditLabel['dropdown'] as $result)
                                                                        @if (isset($result['name']))
                                                                            <option value="{{ $result['id'] }}">
                                                                                {{ $result['name'] }}
                                                                            </option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            @endif
                                                        </td>
                                                @endforeach
                                            @endforeach
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @empty
                        <p class="m-0 p-2 text-center">No category found!</p>
                    @endforelse --}}
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
