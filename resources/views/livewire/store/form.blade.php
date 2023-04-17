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
                <a class="btn app-btn-primary"
                    href="{{ route('form.summary', ['store_name' => $store_name]) }}">Complete</a>
            </div>
        </div>
        <!--//row-->
    </div>
    <!--//table-utilities-->

    {{-- <nav wire:ignore id="audit-form-tab"
        class="audit-form-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4 justify-content-center">
        @forelse ($category_list as $key => $data)
            <a @class([
                'flex-sm-fill',
                'text-sm-center',
                'nav-link',
                'active' => $key == 0,
            ]) id="cat{{ $data->id }}-tab" data-bs-toggle="tab" href="#cat{{ $data->id }}"
                role="tab" aria-controls="cat{{ $data->id }}" aria-selected="{{ $key == 0 ? 'true' : 'false' }}">
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
                {{ $data->name }}
            </div>
        @empty
            <p class="m-0 p-2">No category found!</p>
        @endforelse
    </div>
 --}}
    <nav wire:ignore id="audit-form-tab" class="audit-form-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
        <a class="flex-sm-fill text-sm-center nav-link active " id="service-tab" data-bs-toggle="tab" href="#service"
            role="tab" aria-controls="service" aria-selected="true">Service</a>
        <a class="flex-sm-fill text-sm-center nav-link " id="food-tab" data-bs-toggle="tab" href="#food"
            role="tab" aria-controls="food" aria-selected="false">Food</a>
        <a class="flex-sm-fill text-sm-center nav-link" id="production-tab" data-bs-toggle="tab" href="#production"
            role="tab" aria-controls="production" aria-selected="false">Production Process</a>
        <a class="flex-sm-fill text-sm-center nav-link" id="clean-tab" data-bs-toggle="tab" href="#clean"
            role="tab" aria-controls="clean" aria-selected="false">Cleanliness & Condition</a>
        <a class="flex-sm-fill text-sm-center nav-link" id="document-tab" data-bs-toggle="tab" href="#document"
            role="tab" aria-controls="document" aria-selected="false">Document</a>
        <a class="flex-sm-fill text-sm-center nav-link" id="people-tab" data-bs-toggle="tab" href="#people"
            role="tab" aria-controls="people" aria-selected="false">People</a>
    </nav>

    <div class="tab-content" id="audit-form-tab-content" wire:ignore>
        {{-- Service Forms --}}
        <div class="tab-pane fade show active" id="service" role="tabpanel" aria-labelledby="service-tab">
            <livewire:component.service-form :data="$service" :lcm="$lcm">
        </div>

        {{-- Food Forms --}}
        <div class="tab-pane fade show " id="food" role="tabpanel" aria-labelledby="food-tab">
            <div class="row g-4 mb-4">
                <div class="col-12 col-lg-6">
                    <div class="app-card app-card-chart h-100 shadow-sm">
                        <div class="app-card-header p-3">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <h4 class="app-card-title">Overall Score</h4>
                                </div>
                                <!--//col-->
                            </div>
                            <!--//row-->
                        </div>
                        <div class="app-card-body p-3 p-lg-4">
                            <x-overall :data="$food" />
                        </div>
                        <!--//app-card-body-->
                    </div>
                    <!--//app-card-->
                </div>
                <!--//col-->
                <div class="col-12 col-lg-6">
                    <div class="app-card app-card-chart h-100 shadow-sm">
                        <div class="app-card-header p-3">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <h4 class="app-card-title">Issues</h4>
                                </div>
                            </div>
                        </div>
                        <div class="app-card-body p-3 p-lg-4">
                            <x-issue />
                        </div>
                        <!--//app-card-body-->
                    </div>
                    <!--//app-card-->
                </div>
                <!--//col-->
            </div>

            <livewire:component.food-form :data="$food" :lcm="$lcm">
        </div>

        {{-- production Forms --}}
        <div class="tab-pane fade show " id="production" role="tabpanel" aria-labelledby="production-tab">
            <livewire:component.production-form :data="$production" :lcm="$lcm">
        </div>

        {{-- clean Forms --}}
        <div class="tab-pane fade show " id="clean" role="tabpanel" aria-labelledby="clean-tab">
            <livewire:component.clean-form :data="$clean">
        </div>

        {{-- document Forms --}}
        <div class="tab-pane fade show " id="document" role="tabpanel" aria-labelledby="document-tab">
            <livewire:component.document-form :data="$document">
        </div>

        {{-- people Forms --}}
        <div class="tab-pane fade show " id="people" role="tabpanel" aria-labelledby="people-tab">
            <livewire:component.people-form :data="$people">
        </div>

    </div>
    <!--//tab-content-->


</div>
