<div wire:ignore class="app-card app-card-orders-table shadow-sm mb-5">
    <div class="app-card-header p-3">
        <div class="row justify-content-between align-items-center">
            <div class="col-auto">
                <h4 class="app-card-title">Category </h4>
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
                        @foreach ($item['data_items'] as $item_name)
                            <tr id="{{ $item_name['name'] }}">
                                <td colspan="4">
                                    <h6 class="card-title product-name">{{ $item_name['name'] }}</h6>
                                </td>
                            </tr>
                            @foreach ($item_name['sub_category'] as $sub)
                                @if ($sub['name'])
                                    <tr>
                                        <td class="product-sub-category " colspan="4">
                                            <p>{{ $sub['name'] }}</p>
                                        </td>
                                    </tr>
                                @endif
                                @foreach ($sub['label'] as $item)
                                    <tr>
                                        <td class="product-audit">
                                            <p>{{ $item['name'] }}</p>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control  text-center" disabled
                                                name="bp" id="bp" placeholder=""
                                                value="{{ $item['bp'] }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control  text-center" name="points"
                                                id="points" value="{{ $item['points'] }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="remarks{{ $item['name'] }}"
                                                id="remarks" value="{{ $item['remarks'] }}">
                                        </td>
                                    </tr>
                                @endforeach
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
