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
                        <td class="w-25"></td>
                        <td class="audit-points">CLN BS </td>
                        <td class="audit-points">Score</td>
                        <td>Remarks</td>
                        <td class="audit-points">CON BS </td>
                        <td class="audit-points">Score</td>
                        <td>Remarks</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    @foreach ($item['data_items'] as $item_name)
                        <tr id="{{ $item_name['name'] }}">
                            <td colspan="8" class="product-name">
                                <p class="m-0">{{ $item_name['name'] }}</p>
                            </td>
                        </tr>
                        @foreach ($item_name['sub_category'] as $sub)
                            @if ($sub['name'])
                                <tr>
                                    <td class="product-sub-category " colspan="8">
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
                                        <input type="text" class="form-control " disabled
                                            name="bp" id="bp" placeholder=""
                                            value="{{ $item['bp'] }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control " name="points"
                                            id="points" value="{{ $item['points'] }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control " name="points"
                                            id="points">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control " disabled
                                            name="bp" id="bp" placeholder=""
                                            value="{{ $item['bp'] }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control " name="points"
                                            id="points" value="{{ $item['points'] }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control " name="points"
                                            id="points">
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
