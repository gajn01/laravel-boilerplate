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
    <a href="#">
        <div class="floating-btn">
            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <path
                    d="M182.6 137.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-9.2 9.2-11.9 22.9-6.9 34.9s16.6 19.8 29.6 19.8H288c12.9 0 24.6-7.8 29.6-19.8s2.2-25.7-6.9-34.9l-128-128z" />
            </svg>
        </div>
    </a>


    @foreach ($datatest as $index1 => $item1)
    @foreach ($item1['data'] as $index2 => $item2)
        <input type="text" wire:model="datatest.{{ $index1 }}.data.{{ $index2 }}.name">
        <p>{{ $item2['name'] }}</p>
        <input type="text" wire:model="datatest.{{ $index1 }}.data.{{ $index2 }}.number">
        <p>{{ $item2['number'] }}</p>
    @endforeach
    <p>{{ $item1['total'] }}</p>
@endforeach







    <div class="tab-content" id="audit-form-tab-content">
        @forelse ($categoryList as $key => $category)
            <div class="tab-pane fade show {{ $key == $active_index ? 'active' : '' }}" id="cat{{ $key }}" role="tabpanel" aria-labelledby="cat{{ $key }}-tab">
                <div class="app-card app-card-orders-table shadow-sm mb-5 bg-none">
                    <div class="app-card-body">
                        <div class="row mb-2">
                           
                        </div>
                        <div class="row mb-2">
                            @foreach ($category['sub-category'] as $index => $sub_category)
                                <div class="accordion mb-2" id="accordionCategory">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="{{ $sub_category['title'] }}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accrod{{ $sub_category['title'] }}" aria-expanded="true" aria-controls="accrod{{ $sub_category['title'] }}">
                                                <h6 class="card-title product-name">{{ $sub_category['title'] }}</h6>
                                            </button>
                                        </h2>
                                        <div id="accrod{{ $sub_category['title'] }}"class="accordion-collapse collapse show"  aria-labelledby="accrod{{ $sub_category['title'] }}" data-bs-parent="#accordionCategory">
                                            <div class="accordion-body">
                                                @isset($sub_category['deviation'])
                                                    @foreach ($sub_category['deviation'] as $index => $sub_category_deviation)
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
                                                                <div class="col-sm-12 col-md-3 mb-2 {{-- {{ $auditLabel['dropdown'] ? 'col-md-3' : 'col-md-5' }} --}}">
                                                                    @if ($index == 0)
                                                                        <label for="remarks"
                                                                            class="form-label">Remarks</label>
                                                                    @endif
                                                                </div>
                                                            {{--  @if (!empty($auditLabel['dropdown']))
                                                                    <div class="col-sm-12 col-md-2 mb-2 {{ $auditLabel['dropdown'] ? '' : 'd-none' }}">
                                                                        @if ($index == 0 || empty($auditLabel['dropdown']))
                                                                            <label for="" class="form-label">Deviation</label>
                                                                        @endif
                                                                    </div>
                                                                @endif --}}
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-12 col-md-5 col-lg-5">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input mb-2" type="checkbox" id="toggle-switch"
                                                                        {{-- @disabled( $store->audit_status == 0 ? true : false) --}}
                                                                        wire:change="updateNA({{ json_encode($sub_category_deviation)}},$event.target.checked ? 0 : 1)"
                                                                        {{-- @checked($categoryList[$loop->parent->parent->index]['sub_category'][$loop->parent->index]['sub_sub_category'][$loop->index]['is_na'] ? false: true) --}}
                                                                        >
                                                                    <label class="form-check-label "  @class(['pt-4' => $index == 0 ]) for="toggle-switch">  {{$sub_category_deviation['title']}}</label>
                                                                </div>
                                                            </div>
                                                               {{-- Deviation bp,points,remarks --}}
                                                               <div class="col-sm-12 col-md-1">
                                                                {{-- {{$sub_category_deviation['base']}} --}}
                                                                <input type="text" class="form-control text-center mb-2" disabled name="bp{{ $sub_category_deviation['title'] }}" id="bp"
                                                                    {{-- @disabled( $store->audit_status == 0 ? true : false) --}}
                                                                    value="{{ isset($sub_category_deviation['base']) ? $sub_category_deviation['base'] : '' }}"
                                                                    >
                                                            </div>
                                                           
                                                        </div>
                                                    @endforeach

                                                @endisset
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <ul>
                            @foreach ($category['sub-category'] as $sub_category)
                                <li>
                                    {{$sub_category['title']}}
                                </li> 
                                @isset($sub_category['deviation'])
                                    <ul>
                                        @foreach ($sub_category['deviation'] as $sub_category_deviation)
                                                <li>
                                                    {{$sub_category_deviation['title']}}
                                                    {{ isset($sub_category_deviation['base']) ? $sub_category_deviation['base'] : '' }}
                                                </li>
                                                    @if (isset($sub_category_deviation['deviation']))
                                                        <ul>
                                                            @foreach ($sub_category_deviation['deviation'] as $sub_sub_category_deviation)
                                                                    <li>
                                                                        {{$sub_sub_category_deviation['title']}}
                                                                        @isset($sub_sub_category_deviation['base'])
                                                                        {{$sub_sub_category_deviation['base']}}
                                                                    @endisset
                                                                    </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                        @endforeach
                                    </ul>
                                @endisset
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @empty

        @endforelse
    </div>
 
{{-- 
        @foreach ($categoryList as $item)
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
                                        {{$sub_category_deviation['title']}}
                                    </li>
                                        @if (isset($sub_category_deviation['deviation']))
                                            <ul>
                                                @foreach ($sub_category_deviation['deviation'] as $sub_sub_category_deviation)
                                                        <li>
                                                            {{$sub_sub_category_deviation['title']}}
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
</div>