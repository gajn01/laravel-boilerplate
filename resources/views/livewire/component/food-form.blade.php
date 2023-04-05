

<div wire:ignore class="app-card app-card-orders-table shadow-sm mb-5">
    <div class="app-card-header p-3">
        <div class="row justify-content-between align-items-center">
            <div class="col-auto">
                <h4 class="app-card-title">Core Product</h4>
            </div>
            <!--//col-->
        </div>
        <!--//row-->
    </div>
    <!--//app-card-header-->
    <div class="app-card-body">
        <div class="table-responsive">
            <table class="table app-table-hover mb-0 text-left">
                <thead>
                    <tr>
                        <th class="cell w-50"></th>
                        <th class="cell audit-points">Base Score</th>
                        <th class="cell audit-points">Score</th>
                        <th class="cell">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        @foreach ($item['data_items'] as $dataItem)
                            <tr id="{{ $dataItem['name'] }}">
                                <td colspan="4">
                                    <h6 class="card-title product-name">{{ $dataItem['name'] }}</h6>
                                </td>
                            </tr>
                            @foreach ($dataItem['audit_label'] as $auditLabel)
                                <tr>
                                    <td class="product-audit">
                                        <p>{{ $auditLabel['name'] }}</p>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control text-center" disabled
                                            name="bp{{ $auditLabel['name'] }}" id="bp" placeholder=""
                                            value="{{ $auditLabel['bp'] }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control text-center"
                                            wire:model="data.{{ $loop->parent->parent->index }}.data_items.{{ $loop->parent->index }}.audit_label.{{ $loop->index }}.points"
                                            name="points{{ $auditLabel['name'] }}" id="points"
                                            value="{{ $auditLabel['points'] }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control"
                                            wire:model="data.{{ $loop->parent->parent->index }}.data_items.{{ $loop->parent->index }}.audit_label.{{ $loop->index }}.remarks"
                                            name="remarks{{ $auditLabel['name'] }}" id="remarks"
                                            value="{{ $auditLabel['remarks'] }}">
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        <!--//table-responsive-->

    </div>
    <!--//app-card-body-->
</div>
<!--//app-card-->
