<div class="row g-3 mb-4">
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
                <x-overall :data="$data" />
            </div>
            <!--//app-card-body-->
        </div>
        <!--//app-card-->
    </div>
    <!--//col-->
</div>
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
                        <td class="audit-points">BP</td>
                        <td class="audit-points">Points</td>
                        <td>Remarks</td>
                        <th class="cell">Deviation</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        @foreach ($item['data_items'] as $dataItem)
                            <tr id="{{ $dataItem['name'] }}">
                                <td colspan="5">
                                    <h6 class="card-title product-name">{{ $dataItem['name'] }}</h6>
                                </td>
                            </tr>
                            @foreach ($dataItem['sub_category'] as $sub_category)
                                @if ($sub_category['name'])
                                    <tr>
                                        <td class="product-sub-category " colspan="5">
                                            <p>{{ $sub_category['name'] }}</p>
                                        </td>
                                    </tr>
                                @endif

                                @foreach ($sub_category['label'] as $auditLabel)
                                    <tr>
                                        <td class="product-audit">
                                            <p>{{ $auditLabel['name'] }}</p>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control text-center" disabled
                                                name="bp{{ $auditLabel['name'] }}" id="bp" placeholder=""
                                                value="{{ $auditLabel['is_all_nothing'] }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control text-center"
                                                wire:model="data.{{ $loop->parent->parent->index }}.data_items.{{ $loop->parent->index }}.sub_category.{{ $loop->index }}.points"
                                                name="points{{ $auditLabel['name'] }}" id="points"
                                                wire:keydown="onUpdateBP({{ $auditLabel['id'] }}, $event.target.value)"
                                                value="{{ $auditLabel['points'] }}">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control"
                                                wire:model="data.{{ $loop->parent->parent->index }}.data_items.{{ $loop->parent->index }}.sub_category.{{ $loop->index }}.remarks"
                                                name="remarks{{ $auditLabel['name'] }}" id="remarks"
                                                value="{{ $auditLabel['remarks'] }}">
                                        </td>
                                        <td>
                                            @if (!empty($auditLabel['dropdown']))
                                                <select class="form-select form-select-md"
                                                    wire:model="data.{{ $loop->parent->parent->index }}.data_items.{{ $loop->parent->index }}.sub_category.{{ $loop->index }}.tag"
                                                    name="tag{{ $auditLabel['name'] }}" id="tag">
                                                    <option value="0">Select a deviation</option>
                                                    @foreach ($auditLabel['dropdown'] as $result)
                                                        @if (isset($result['name']))
                                                            <option value="{{ $result['id'] }}">{{ $result['name'] }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
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
