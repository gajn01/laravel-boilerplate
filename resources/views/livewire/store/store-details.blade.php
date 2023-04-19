@section('title', 'Mary Grace Restaurant Operation System / Store Details')

<div class="container-xl">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('store') }}">Store</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $store->name }}</li>
        </ol>
    </nav>

    <div class="row gy-4 mb-3">
        <!--//col-->
        <div class="col-12 col-lg-6">
            <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start">
                <div class="app-card-header p-3 border-bottom-0">
                    <div class="row align-items-center gx-3">
                        <div class="col-auto">
                        </div>
                        <!--//col-->
                        <div class="col-auto">
                            <h4 class="app-card-title">Store Details</h4>
                        </div>
                        <!--//col-->
                    </div>
                    <!--//row-->
                </div>
                <!--//app-card-header-->
                <div class="app-card-body px-4 w-100">

                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <div class="item-label mb-1"><strong>Store Type</strong></div>
                                <div class="item-data">{{ $store->type == 1 ? 'Cafe' : 'Kiosk'  }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <div class="item-label mb-1"><strong>Store Code</strong></div>
                                <div class="item-data">{{ $store->code}}</div>
                            </div>
                        </div>
                    </div>

                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <div class="item-label mb-1"><strong>Store Name</strong></div>
                                <div class="item-data">{{ $store->name}}</div>
                            </div>
                        </div>
                    </div>

                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <div class="item-label mb-1"><strong>Store Area</strong></div>
                                <div class="item-data">{{ $store->area}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--//app-card-->
        </div>
        <div class="col-12 col-lg-6">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">Schedule</h4>
                        </div><!--//col-->
                        <div class="col-auto">
                            <div class="card-header-action col ">
                                <a class="btn-sm app-btn-secondary" href="#" data-bs-toggle="modal" data-bs-target="#assignModal" >Assign Auditor</a>
                            </div><!--//card-header-actions-->
                        </div><!--//col-->
                    </div><!--//row-->
                </div><!--//app-card-header-->
                <div class="app-card-body p-3 p-lg-4">
                    <div class="mb-3 d-flex">
                        <select class="form-select form-select-sm ms-auto d-inline-flex w-auto">
                            <option value="1" >This week</option>
                            <option value="2 " selected>Today</option>
                            <option value="3">This Month</option>
                            <option value="3">This Year</option>
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table class="table app-table-hover mb-0 text-left">
                            <thead>
                                <tr>
                                    <th class="cell">Date </th>
                                    <th class="cell">Auditor</th>
                                    <th class="cell">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <td class="cell">April 23 2023</td>
                                <td class="cell">Juan Miguel</td>
                                <td class="cell">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#assignModal" data-toggle="tooltip" data-placement="top" title="Update">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                                    </a>
                                </td>
                            </tbody>
                        </table>
                    </div>

                </div><!--//app-card-body-->
            </div><!--//app-card-->
            <!--//app-card-->
        </div>
    </div>
    <!--//row-->

    <div class="app-card app-card-orders-table shadow-sm mb-5">
        <div class="app-card-header p-3">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h4 class="app-card-title">Audit Records</h4>
                </div>
                <!--//col-->
            </div>
            <!--//row-->
        </div>
        <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                            <th class="cell">Date </th>
                            <th class="cell">Auditor</th>
                            <th class="cell">Overall Score</th>
                            <th class="cell">Wave</th>
                            <th class="cell">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td class="cell">March 15 2023</td>
                        <td class="cell">Juan Miguel</td>
                        <td class="cell">95%</td>
                        <td class="cell">Wave 1</td>
                        <td class="cell">
                            <a href="" data-toggle="tooltip" data-placement="top" title="View">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>
                            </a>
                        </td>
                    </tbody>
                </table>
            </div>
            <!--//table-responsive-->
        </div>
        <!--//app-card-body-->
    </div>

    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div class="modal fade" id="assignModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Assign Auditor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="" class="form-label">Auditor</label>
                        <select class="form-select form-select-md" name="" id="">
                            <option selected hidden>Select one</option>
                            <option value="">New Delhi</option>
                            <option value="">Istanbul</option>
                            <option value="">Jakarta</option>
                        </select>
                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">Date of Audit</label>
                      <input type="date"
                        class="form-control" name="" id="" aria-describedby="helpId" placeholder="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

</div>
