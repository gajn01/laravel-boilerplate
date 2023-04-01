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
                <a class="btn app-btn-primary" href="#" wire:click="test">Complete</a>
            </div>
        </div><!--//row-->
    </div><!--//table-utilities-->

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

    <div class="tab-content" id="audit-form-tab-content">
        {{-- Service Forms --}}
        <div class="tab-pane fade show active" id="service" role="tabpanel" aria-labelledby="service-tab">
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
                            <table class="table app-table-hover mb-0 text-left">
                                <thead>
                                    <tr>
                                        <th class="cell">Category</th>
                                        <th class="cell">%</th>
                                        <th class="cell">Score</th>
                                        <th class="cell">% Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($service as $item)
                                        <tr>
                                            <td class="core_name_total"><a href="#speed">Speed And Accuracy</a> </td>
                                            <td><span>20%</span></td>
                                            <td><span>0</span></td>
                                            <td><span>0</span></td>
                                        </tr>
                                        @foreach ($item['data_items'] as $sub)
                                            <tr>
                                                <td class="core_name_total"><a
                                                        href="#{{ $sub['name'] }}">{{ $sub['name'] }}</a> </td>
                                                <td>{{ $sub['total_percentage'] }}</td>
                                                <td>{{ $sub['score'] }}</td>
                                                <td>{{ $sub['score'] }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td>{{ $item['overall_score'] }}</td>
                                            <td>{{ $item['score'] }}</td>
                                            <td>{{ $item['total_percentage'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

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
                            <x-service-issue />
                        </div>
                        <!--//app-card-body-->
                    </div>
                    <!--//app-card-->
                </div>
                <!--//col-->
            </div>
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

        {{-- Food Forms --}}
        <div class="tab-pane fade show " id="production" role="tabpanel" aria-labelledby="production-tab">
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
                            <x-overall :data="$production" />
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

            <livewire:component.production-form :data="$production" :lcm="$lcm">
        </div>

        {{-- Food Forms --}}
        <div class="tab-pane fade show " id="clean" role="tabpanel" aria-labelledby="clean-tab">
            <div class="row g-12 mb-4">
                <div class="col-12 col-lg-12">
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
                            <x-overall :data="$clean" />
                        </div>
                        <!--//app-card-body-->
                    </div>
                    <!--//app-card-->
                </div>
                <!--//col-->
            </div>

            <livewire:component.clean-form :data="$clean">
        </div>

        {{-- Food Forms --}}
        <div class="tab-pane fade show " id="document" role="tabpanel" aria-labelledby="document-tab">
            <div class="row g-12 mb-4">
                <div class="col-12 col-lg-12">
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
                            <x-overall :data="$document" />
                        </div>
                        <!--//app-card-body-->
                    </div>
                    <!--//app-card-->
                </div>
                <!--//col-->
            </div>

            <livewire:component.document-form :data="$document">
        </div>
        {{-- Food Forms --}}
        <div class="tab-pane fade show " id="people" role="tabpanel" aria-labelledby="people-tab">
            <div class="row g-12 mb-4">
                <div class="col-12 col-lg-12">
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
                            <x-overall :data="$people" />
                        </div>
                        <!--//app-card-body-->
                    </div>
                    <!--//app-card-->
                </div>
                <!--//col-->
            </div>

            <livewire:component.people-form :data="$people">
        </div>

    </div>
    <!--//tab-content-->


</div>
