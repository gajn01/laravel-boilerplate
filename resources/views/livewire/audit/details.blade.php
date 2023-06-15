@section('title', 'Mary Grace Restaurant Operation System / Store Details')

<div class="container-xl">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('audit.schedule') }}">Audit</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $store->name }}</li>
        </ol>
    </nav>
    <div class="app-card app-card-orders-table shadow-sm mb-5 p-3">
        <div class="app-card-header p-3">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h4 class="app-card-title">Audit Records</h4>
                </div>
            </div>
        </div>
        <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                            <th class="cell">Date </th>
                            <th class="cell">Conducted by</th>
                            <th class="cell">Recieved by</th>
                            <th class="cell">Wave</th>
                            <th class="cell">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($summary_list as $item)
                        <tr>
                            <td class="cell">{{ \Carbon\Carbon::parse($item->date_of_visit)->format('F d Y') }}</td>
                            <td class="cell">{{ $item->conducted_by }}</td>
                            <td class="cell">{{ $item->received_by }}</td>
                            <td class="cell">{{ $item->wave }}</td>
                            <td class="cell">
                                <a  data-toggle="tooltip" data-placement="top" title="View" href="{{ route('audit.view.result', ['store_id' => $item->store_id, 'result_id' => $item->id]) }}">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path
                                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <p class="text-center m-0">
                                    No data found.
                                </p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="store_assign_modal" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Assign Auditor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="reset"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">Auditor</label>
                        <select class="form-select form-select-md" name="" id=""
                            wire:model="auditor_name">
                            <option selected hidden>Select auditor</option>
                            @foreach ($user_list as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Date of Audit</label>
                        <input type="date" class="form-control" name="audit_date" id="audit_date"
                            wire:model="audit_date">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn app-btn-primary" wire:click="onAssign">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
