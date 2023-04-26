@section('title', 'Mary Grace Restaurant Operation System / Sub Category Label Settings')

<div class="container-xl">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a href="{{ route('category') }}">Category</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category-details', [$category_id]) }}">{{ $category_name }}</a>
            </li>
            <li class="breadcrumb-item"><a
                    href="{{ route('sub-category-label', ['category_id' => $category_id, 'sub_category_id' => $sub_category_id]) }}">{{ $sub_category_name }}</a>
            </li>
            <li class="breadcrumb-item active">{{ $sub_sub_category_name }}</li>
        </ol>
    </nav>

    <div class="page-utilities mb-3">
        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
            <div class="col-auto">
                <form class="docs-search-form row gx-1 align-items-center">
                    <div class="col-auto">
                        <input type="text" id="search-docs" name="searchdocs" class="form-control search-docs"
                            wire:model.debounce.100ms="searchTerm" placeholder="Search">
                    </div>
                </form>
            </div>
            <!--//col-->
            <div class="col-auto">
                <div class="col-auto">
                    <a class="btn app-btn-primary" data-bs-toggle="modal" data-bs-target="#sub_category_label_modal"
                        wire:click="showModal">Create</a>
                </div>
            </div>
        </div>
        <!--//row-->
    </div>
    <div class="app-card app-card-orders-table shadow-sm mb-5">
        <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                            <th class="cell">Name</th>
                            <th class="cell table-action-sm">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($label_list as $label)
                            <tr>
                                <td class="cell">{{ $label['name'] }}</td>
                                <td class="cell table-action-sm">
                                    <a href="" wire:click="showModal({{ $label['id'] }})" data-bs-toggle="modal"
                                        data-bs-target="#sub_category_label_modal">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
                                        </svg>
                                    </a>
                                    <a href="#"
                                        wire:click="onAlert(true,'Confirm','Are you sure you want to delete this label record?','Successfully deleted','warning',{{ $label['id'] }})">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                            <!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <p class="text-center m-0">
                                        No data found.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
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
                        <select class="form-select-sm w-auto" id="limit" wire:model="limit">
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
                {{ $label_list->onEachSide(0)->links() }}
            </nav>
            <!--//app-pagination-->

        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="sub_category_label_modal" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">
                        {{ $modalTitle }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="reset" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="onSave">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" wire:model="name" id="name">
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Base Points</label>
                            <input type="number" class="form-control" wire:model="bp" id="bp">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="toggle-switch"
                                    wire:model="is_all_nothing">
                                <label class="form-check-label" for="toggle-switch">All Or Nothing</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="dropdown_id" class="form-label">Dropdown</label>
                            <select class="form-select form-select-md" name="dropdown_id" id="dropdown_id"
                                wire:model="dropdown_id">
                                <option selected value="0">Select one</option>
                                @foreach ($dropdown_list as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn app-btn-primary"
                        wire:click="onSave">{{ $modalButtonText }}</button>
                </div>
            </div>
        </div>
    </div>

</div>
