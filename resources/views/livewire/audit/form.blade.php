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
              
                @if ($auditDate->is_complete == 0)
                    <a class="btn app-btn-primary" wire:click="onStartAudit"> Start Audit</a>
                @else
                    <a class="btn app-btn-primary" href="{{ route('audit.view.result', [$store->id, 3]) }}"> Result</a>
                @endif
            </div>
        </div>
        <nav wire:ignore id="audit-form-tab"class="audit-form-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4 justify-content-center nav-sticky">
        @forelse ($categoryList as $key => $data)
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
        {{-- <ul>
            @foreach ($categoryList as $category)
                <li>{{$category['name']}}</li>
                <ul>
                    @foreach ($category['sub_category'] as $sub_category)
                        <li>{{$sub_category['name']}}</li>
                        <ul>
                            @forelse ($sub_category['sub_sub_category'] as $sub_sub_category)
                                <li>{{$sub_sub_category['name']}}</li>
                                <ul>
                                    @forelse ($sub_sub_category['sub_sub_sub_category'] as $sub_sub_sub_category)
                                        <li>{{$sub_sub_sub_category['name']}}</li>
                                    @empty
                                    @endforelse
                                </ul>
                            @empty
                            @endforelse
                        </ul>
                    @endforeach 
                </ul>
            @endforeach
        </ul> --}}
        <a href="#">
            <div class="floating-btn">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <path
                        d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8H288c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z" />
                </svg>
            </div>
        </a>
    </div>

    <div class="tab-content" id="audit-form-tab-content">
        @forelse ($categoryList as $key => $category)
            <div class="tab-pane fade show {{ $key == $active_index ? 'active' : '' }}" id="cat{{ $category->id }}" role="tabpanel" aria-labelledby="cat{{ $category->id }}-tab">
                <div class="app-card app-card-orders-table shadow-sm mb-5 bg-none">
                    <div class="app-card-body">
                        <div class="row">
                          {{--   {{ $data->critical_deviation->isNotEmpty() ? 'col-lg-6' : 'col-lg-12' }} --}}
                            <div class="col-12  mb-4 ">
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
                                                                <td class="text-center">
                                                                    {{-- {{$sub_category->BpTotal}} --}}
                                                                </td>
                                                                
                                                                <td class="text-center">{{ $sub_category['total_point'] }}</td>
                                                                <td class="text-center"> {{ $sub_category['total_percent'] }}%</td>
                                                            </tr>
                                                          {{--   @if ($sub_category->name)
                                                            @endif --}}
                                                        @endforeach
                                                      {{--   <tr>
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
                                                        </tr> --}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                                                    <div class="col-sm-6 col-md-1">
                                                                        <label for="" class="form-label">BP</label>
                                                                    </div>
                                                                    <div class="col-sm-6 col-md-1">
                                                                        <label for="points" class="form-label">Point(s)</label>
                                                                    </div>
                                                                @endif
                                                                <div class="col-sm-12 col-md-5">
                                                                    <div class="row">
                                                                        <div
                                                                            class="col-sm-12 mb-2 {{ $auditLabel['dropdown'] ? 'col-md-6' : 'col-md-12' }}">
                                                                            @if ($index == 0)
                                                                                <label for="remarks"
                                                                                    class="form-label">Remarks</label>
                                                                            @endif
                                                                        </div>
                                                                        @if (!empty($auditLabel['dropdown']))
                                                                            <div
                                                                                class="col-sm-12 col-md-6 mb-2 {{ $auditLabel['dropdown'] ? '' : 'd-none' }}">
                                                                                @if ($index == 0 || empty($auditLabel['dropdown']))
                                                                                    <label for=""
                                                                                        class="form-label">Deviation</label>
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <div class="row mb-3">
                                                            {{-- Deviation Label --}}
                                                                <div class="col-sm-12 col-md-5 col-lg-5">
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input mb-2" type="checkbox" id="toggle-switch">
                                                                        <label class="form-check-label "  @class(['pt-4' => $index == 0 ]) for="toggle-switch"> {{ $auditLabel['name'] }}</label>
                                                                    </div>
                                                                </div>
                                                            {{-- Deviation bp,points,remarks --}}
                                                                <div class="col-sm-6 col-md-1">
                                                                    <input type="text" class="form-control text-center mb-2" disabled name="bp{{ $auditLabel['name'] }}" id="bp" 
                                                                        value="{{ $auditLabel['is_all_nothing'] ? $auditLabel['bp'] . '*' : $auditLabel['bp'] }}">
                                                                </div>
                                                                <div class="col-sm-6 col-md-1">
                                                                    <input type="number" class="form-control text-center mb-2" @disabled($auditLabel['is_na'] ? true : false) 
                                                                        name="points{{ $auditLabel['id'] }}" 
                                                                        id="points{{ $auditLabel['id'] }}"
                                                                        value="{{$categoryList[$loop->parent->parent->index]['sub_category'][$loop->parent->index]['sub_sub_category'][$loop->index]['points']}}"
                                                                        min="{{ $auditLabel['is_all_nothing'] ? $auditLabel['bp'] : 0 }}" 
                                                                        max="{{ $auditLabel['is_all_nothing'] ? 0 : $auditLabel['bp'] }}">
                                                                </div>
                                                        </div>

                                                    @else
                                                    {{-- Deviation Header --}}
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label class="form-check-label fw-bold "  @class(['pt-4' => $index == 0 ]) for="toggle-switch"> {{ $auditLabel['name'] }}</label>
                                                            </div>
                                                        </div>
                                                    {{-- Deviation Label --}}

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
