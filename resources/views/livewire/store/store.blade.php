@section('title', 'Mary Grace Restaurant Operation System / Store')

<div class="container-xl">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Store</li>
        </ol>
    </nav>
    <div class="page-utilities mb-3">
        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
            <div class="col-auto">
                <a href="">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                            d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z" />
                    </svg>
                </a>
                {{--  <select class="form-select w-auto">
                    <option selected="" value="option-1">All</option>
                    <option value="option-2">Text file</option>
                    <option value="option-3">Image</option>
                    <option value="option-4">Spreadsheet</option>
                    <option value="option-5">Presentation</option>
                    <option value="option-6">Zip file</option>

                </select> --}}
            </div>
            <div class="col-auto">
                <form class="docs-search-form row gx-1 align-items-center">
                    <div class="col-auto">
                        <input type="text" id="search-docs" name="searchdocs" class="form-control search-docs"
                            placeholder="Search">
                    </div>
                    <div class="col-auto">
                        <a class="btn app-btn-primary" href="#" wire:click="test">Search</a>
                    </div>
                </form>

            </div>
            <!--//col-->

        </div>
        <!--//row-->
    </div>
    <!--//table-utilities-->

    <div class="app-card app-card-orders-table shadow-sm mb-5">
        <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                            <th class="cell">Store Code</th>
                            <th class="cell">Store Name</th>
                          {{--   <th class="cell">Wave1</th>
                            <th class="cell">Wave2</th> --}}
                            <th class="cell">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($store_list as $store)
                            <tr>
                                <td class="cell">{{ $store['code'] }}</td>
                                <td class="cell">{{ $store['name'] }}</td>
                               {{--  <td class="cell">{{ $store['wave1'] }}</td>
                                <td class="cell">{{ $store['wave2'] }}</td> --}}
                                <td class="cell">
                                    <a href="{{ route('details', ['store_name' => $store['name']]) }}">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('form', ['store_name' => $store['name']]) }}">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                        </svg>
                                    </a>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <!--//table-responsive-->
        </div>
        <!--//app-card-body-->
    </div>

    {{-- Pagination --}}

    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="page-utilities d-flex justify-start">
                <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                    <div class="col-auto">
                        <label for="limit">Display</label>
                    </div>
                    <div class="col-auto">
                        <select class="form-select-sm w-auto" id="limit">
                            <option selected value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <!--//col-->
                    <div class="col-auto">
                        <label for="">entries</label>
                    </div>
                </div>
                <!--//row-->
            </div>
            <!--//table-utilities-->
        </div>
        <div class="col-sm-12 col-md-6">
            <nav class="app-pagination">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
            <!--//app-pagination-->

        </div>
    </div>


</div>
