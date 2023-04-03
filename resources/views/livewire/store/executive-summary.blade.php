@section('title', 'Excutive Summary')

<div class="container-xl">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('store') }}">Store</a></li>
            <li class="breadcrumb-item " aria-current="page"> <a
                    href="{{ route('form', ['store_name' => $store_name]) }}">{{ $store_name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Executive Summary</li>
        </ol>
    </nav>


    <div class="row g-4 mb-4">
        <div class="col-12 col-lg-8">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">Summary of Scores</h4>
                        </div>
                        <!--//col-->
                    </div>
                    <!--//row-->
                </div>
                <!--//app-card-header-->
                <div class="app-card-body p-3 p-lg-4">
                    <div class="table-responsive ">
                        <table class="table table-borderless ">
                            <thead>
                                <tr>
                                    <th scope="col">Category</th>
                                    <th scope="col">% Score</th>
                                    <th scope="col">Final Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="core_name_total"> <a href="#service">Service</a> </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="core_name_total"> <a href="#food">Food</a> </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="core_name_total"> <a href="#pp">Production Process</a> </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="core_name_total"> <a href="#cc">Cleanliness & Condition</a> </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="core_name_total"> <a href="#document">Document</a> </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="core_name_total"> <a href="#people">People</a> </td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td>
                                        <p class="font-bold">Total Score:</p>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!--//app-card-body-->
            </div>
            <!--//app-card-->
        </div>
        <!--//col-->
        <div class="col-12 col-lg-4">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">Legend</h4>
                        </div>
                        <!--//col-->
                    </div>
                    <!--//row-->
                </div>
                <!--//app-card-header-->
                <div class="app-card-body p-3 p-lg-4">
                    <div class="table-responsive text-center">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">% Score</th>
                                    <th scope="col">Final Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p class="font-600 m-0 ">90-100 </p>
                                    </td>
                                    <td>
                                        <p class="font-600 m-0 ">A </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="font-600 m-0 ">80-89</p>
                                    </td>
                                    <td>
                                        <p class="font-600 m-0 ">B </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="font-600 m-0 ">70-79 </p>
                                    </td>
                                    <td>
                                        <p class="font-600 m-0 ">C </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="font-600 m-0 ">60-69 </p>
                                    </td>
                                    <td>
                                        <p class="font-600 m-0 ">D </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="font-600 m-0 ">Below 60 </p>
                                    </td>
                                    <td>
                                        <p class="font-600 m-0 ">E </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!--//app-card-body-->
            </div>
            <!--//app-card-->
        </div>
        <!--//col-->
        <div class="col-12 col-lg-12">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">Auditor`s Overall Assesment</h4>
                        </div>
                        <!--//col-->
                    </div>
                    <!--//row-->
                </div>
                <!--//app-card-header-->
                <div class="app-card-body p-3 p-lg-4">
                    <div class="mb-3">
                        <label for="area_strength" class="form-label font-600">Areas of Strength</label>
                        <textarea class="form-control" name="area_strength" id="area_strength" rows="4"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="area_improvement" class="form-label font-600">Areas for Improvement</label>
                        <textarea class="form-control" name="area_improvement" id="area_improvement" rows="4"></textarea>
                    </div>
                </div>
                <!--//app-card-body-->
            </div>
            <!--//app-card-->
        </div>

        <div class="col-12 col-lg-12" id="service">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">Service</h4>
                        </div>
                        <!--//col-->
                    </div>
                    <!--//row-->
                </div>
                <!--//app-card-header-->
                <div class="app-card-body p-3 p-lg-4">
                    <livewire:component.service-form :data="$service" :lcm="$lcm">
                </div>
            </div>
            <!--//app-card-->
        </div>

        <div class="col-12 col-lg-12" id="food">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">Food</h4>
                        </div>
                        <!--//col-->
                    </div>
                    <!--//row-->
                </div>
                <!--//app-card-header-->
                <div class="app-card-body p-3 p-lg-4">
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
            </div>
            <!--//app-card-->
        </div>

        <div class="col-12 col-lg-12" id="production">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">Production</h4>
                        </div>
                        <!--//col-->
                    </div>
                    <!--//row-->
                </div>
                <!--//app-card-header-->
                <div class="app-card-body p-3 p-lg-4">
                    <livewire:component.production-form :data="$production" :lcm="$lcm">
                </div>
            </div>
            <!--//app-card-->
        </div>

        <div class="col-12 col-lg-12" id="clean">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">Cleanliness & Condition</h4>
                        </div>
                        <!--//col-->
                    </div>
                    <!--//row-->
                </div>
                <!--//app-card-header-->
                <div class="app-card-body p-3 p-lg-4">
                    <livewire:component.clean-form :data="$clean">

                </div>
            </div>
            <!--//app-card-->
        </div>

        <div class="col-12 col-lg-12" id="document">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">Document</h4>
                        </div>
                        <!--//col-->
                    </div>
                    <!--//row-->
                </div>
                <!--//app-card-header-->
                <div class="app-card-body p-3 p-lg-4">
                    <livewire:component.document-form :data="$document">
                </div>
            </div>
            <!--//app-card-->
        </div>

        <div class="col-12 col-lg-12" id="people">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">People</h4>
                        </div>
                        <!--//col-->
                    </div>
                    <!--//row-->
                </div>
                <!--//app-card-header-->
                <div class="app-card-body p-3 p-lg-4">
                    <livewire:component.people-form :data="$people">

                </div>
            </div>
            <!--//app-card-->
        </div>
    </div>
    <!--//row-->
</div>
