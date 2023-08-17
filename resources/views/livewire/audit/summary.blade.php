@section('title', 'Excutive Summary')
<div class="">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('audit') }}">Audit</a></li>
            <li class="breadcrumb-item"><a href="{{ route('audit.form', [$auditForm->id]) }}">{{ $store->name }}</a>
            <li class="breadcrumb-item"><a href="{{ route('audit.view.result', [$auditForm->id, $summary->id]) }}">Result</a>
            <li class="breadcrumb-item active" aria-current="page">Executive Summary</li>
        </ol>
    </nav>
    <div class="card mb-3 ">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="table-responsive">
                        <table class="">
                            <tbody>
                                <tr class="v-align-items-baseline">
                                    <td>
                                        <label class="form-label">Store Name:</label>
                                    </td>
                                    <td class="pl-3">
                                        <input type="text" class="form-control" disabled value="{{ $store->name }}">
                                    </td>
                                </tr>
                                <tr class="v-align-items-baseline">
                                    <td>
                                        <label class="form-label">Store Code:</label>
                                    </td>
                                    <td class="pl-3">
                                        <input type="text" class="form-control" disabled value="{{ $store->code }}">
                                    </td>
                                </tr>
                                <tr class="v-align-items-baseline">
                                    <td>
                                        <label class="form-label">Store Type:</label>
                                    </td>
                                    <td class="pl-3">
                                        <input type="text" class="form-control" disabled
                                            value="{{ $store->type == 1 ? 'Cafe' : 'Kiosk' }}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="table-responsive webkit-right">
                        <table class="">
                            <tbody>

                                <tr class="v-align-items-baseline">
                                    <td>
                                        <label class="form-label">Conducted by:</label>
                                    </td>
                                    <td class="pl-3">
                                        <input type="text" wire:model="summary.conducted_by" class="form-control" @disabled($store->audit_status ? false :true)>
                                    </td>
                                </tr>
                                <tr class="v-align-items-baseline">
                                    <td>
                                        <label class="form-label">Received by: <span
                                                class="text-danger">*</span></label>
                                    </td>
                                    <td class="pl-3">
                                        <input type="text" wire:model="summary.received_by" class="form-control" @disabled($store->audit_status ? false :true)>
                                        @error('summary.received_by')
                                            <span class="text-danger mt-1 ">{{ $message }}</span>
                                        @enderror
                                    </td>

                                </tr>
                                <tr class="v-align-items-baseline">
                                    <td>
                                        <label class="form-label">Date of visit:</label>
                                    </td>
                                    <td class="pl-3">
                                        <input type="date" wire:model="summary.date_of_visit" class="form-control" @disabled($store->audit_status ? false :true)>

                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-6">
            <div class="app-card app-card-chart  shadow-sm">
                <div class="app-card-header p-3">
                    <h4 class="app-card-title">Summary of Scores</h4>
                </div>
                <div class="app-card-body p-3 p-lg-4">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12">
                            <table class="table app-table-hover mb-0 text-left ">
                                <thead>
                                    <tr>
                                        <th class="cell w-50">Category</th>
                                        <th class="cell text-center">% Base</th>
                                        <th class="cell text-center">% Score</th>
                                        <th class="cell text-center">Final Rating</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($summaryList as $key => $data)
                                        <tr>
                                            <td class="core_name_total"><a
                                                    href="#{{ $data['category_name'] }}">{{ $data['category_name'] }}</a>
                                            </td>
                                            <td class="text-center"> {{$data['percent']}} %</td>
                                            <td class="text-center {{ $data['percentage'] < 80 ? 'text-danger' : '' }}">
                                                {{ $data['percentage'] }}%</td>
                                            @php
                                                $overallScore = $data['percentage'];
                                            @endphp

                                            @switch(true)
                                                @case($overallScore >= 90)
                                                    <td class="text-center">A</td>
                                                @break

                                                @case($overallScore >= 80 && $overallScore <= 89)
                                                    <td class="text-center">B</td>
                                                @break

                                                @case($overallScore >= 70 && $overallScore <= 79)
                                                    <td class="text-center text-danger">C</td>
                                                @break

                                                @case($overallScore >= 60 && $overallScore <= 69)
                                                    <td class="text-center text-danger">D</td>
                                                @break

                                                @default
                                                    <td class="text-center text-danger">E</td>
                                            @endswitch
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="app-card-body p-3 p-lg-4">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-12">
                            <table class="table app-table-hover mb-0 text-left ">
                                <thead>
                                    <tr>
                                        <th class="cell w-50">Category</th>
                                        <th class="cell text-center">% Base</th>
                                        <th class="cell text-center">% Score</th>
                                        <th class="cell text-center">Final Rating</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($documentAndPeopleList as $key => $data)
                                        <tr>
                                            <td class="core_name_total"><a href="#{{ $data['category_name'] }}">{{ $data['category_name'] }}</a></td>
                                            <td class="text-center ">{{ $data['percent'] }}%</td>
                                            <td class="text-center "> {{ $data['percentage'] }}%</td>
                                            <td></td>
                                      
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="text-center fw-bold" colspan="2">Total</td>
                                        <td class="text-center ">{{ collect($documentAndPeopleList)->sum('percentage') }}%</td>
                                        @php
                                            $overallScore = collect($documentAndPeopleList)->sum('percentage');
                                        @endphp
                                        @switch(true)
                                            @case($overallScore >= 90)
                                                <td class="text-center">A</td>
                                            @break

                                            @case($overallScore >= 80 && $overallScore <= 89)
                                                <td class="text-center">B</td>
                                            @break

                                            @case($overallScore >= 70 && $overallScore <= 79)
                                                <td class="text-center text-danger">C</td>
                                            @break

                                            @case($overallScore >= 60 && $overallScore <= 69)
                                                <td class="text-center text-danger">D</td>
                                            @break

                                            @default
                                                <td class="text-center text-danger">E</td>
                                        @endswitch
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="app-card app-card-chart shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">Legend</h4>
                        </div>
                    </div>
                </div>
                <div class="app-card-body p-3 p-lg-4">
                    <table class="table app-table-hover mb-0 text-left ">
                        <thead>
                            <tr>
                                <th class="cell text-center">% Score</th>
                                <th class="cell text-center">Final Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">90-100</td>
                                <td class="text-center">A</td>
                            </tr>
                            <tr>
                                <td class="text-center">80-89</td>
                                <td class="text-center">B</td>
                            </tr>
                            <tr>
                                <td class="text-center">70-79</td>
                                <td class="text-center">C</td>
                            </tr>
                            <tr>
                                <td class="text-center">60-69</td>
                                <td class="text-center">D</td>
                            </tr>
                            <tr>
                                <td class="text-center">Below 60</td>
                                <td class="text-center">E</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">Critical Deviation</h4>
                        </div>
                    </div>
                </div>
                <div class="app-card-body p-3 p-lg-4">
                    <table class="table app-table-hover mb-0 text-left ">
                        <thead>
                            <tr>
                                <th class="cell">Category</th>
                                <th class="cell">Deviation</th>
                                <th class="cell">Remarks</th>
                                <th class="cell">Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($criticalDeviationResultList as $deviation)
                                <tr>
                                    <td>{{ $deviation->category->name }}</td>
                                    <td>{{ $deviation->CriticalDeviationMenu->label }}</td>
                                    <td>{{ $deviation->remarks }}</td>
                                    <td>{{ $deviation->score }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-danger text-center" colspan="4">No Critical Deviation</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if ($store->audit_status)
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="app-card app-card-chart  shadow-sm">
                    <div class="app-card-header p-3">
                        <h4 class="app-card-title">Auditor`s Overall Assessment</h4>
                    </div>
                    <div class="app-card-body p-3 p-lg-4">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-12 ">
                                <div class="3">
                                    <label for="" class="form-label">Areas of Strength<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" wire:model="summary.strength" rows="3"></textarea>
                                    @error('summary.strength')
                                        <span class="text-danger mt-1 ">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label">Areas for Improvement<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" wire:model="summary.improvement" rows="3"></textarea>
                                    @error('summary.improvement')
                                        <span class="text-danger mt-1 ">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
            <div class="col-auto mb-3">
                <a class="btn app-btn-primary"
                    wire:click="onStartAndComplete(true,'Are you sure?','warning')">Complete</a>
            </div>
        </div>
    @endif
</div>
