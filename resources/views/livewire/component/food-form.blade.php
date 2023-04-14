<div class="app-card app-card-orders-table shadow-sm mb-5">
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
                        <th class="cell audit-points">Base Point</th>
                        <th class="cell audit-points">Point</th>
                        <th class="cell">Remarks</th>
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
                            @foreach ($dataItem['sub_category'] as $auditLabel)
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
                                    <td colspan="{{$auditLabel['dropdown'] ? '': 2}}">
                                        <input type="text" class="form-control"
                                            wire:model="data.{{ $loop->parent->parent->index }}.data_items.{{ $loop->parent->index }}.sub_category.{{ $loop->index }}.remarks"
                                            name="remarks{{ $auditLabel['name'] }}" id="remarks"
                                            value="{{ $auditLabel['remarks'] }}">
                                    </td>
                                    <td>

                                        {{-- {{ $test += $auditLabel['bp'] }}
                                         @if (!empty($search1_results))
                                            <datalist id="search1_list">
                                                @foreach ($search1_results as $result)
                                                    <option value="{{ $result['name'] }}">
                                                @endforeach
                                            </datalist>
                                        @endif --}}
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
