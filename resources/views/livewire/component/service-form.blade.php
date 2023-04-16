<div class="row g-4 mb-4">
    <div class="col-12 col-lg-6">
        <div class="app-card app-card-chart h-100 shadow-sm">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title">Overall Score</h4>
                    </div>
                </div>
            </div>
            <div class="app-card-body p-3 p-lg-4">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                            <th class="cell">Category</th>
                            <th class="cell">%</th>
                            <th class="cell">Score</th>
                            <th class="cell">% Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td class="core_name_total"><a href="#speed">Speed And Accuracy</a> </td>
                                <td><span>20%</span></td>
                                <td><span>0</span></td>
                                <td><span>0</span></td>
                            </tr>
                            @foreach ($item['data_items'] as $sub)
                                <tr>
                                    <td class="core_name_total"><a href="#{{ $sub['name'] }}">{{ $sub['name'] }}</a>
                                    </td>
                                    <td>{{ $sub['total_percentage'] }}</td>
                                    <td>{{ $sub['score'] }}</td>
                                    <td>{{ $sub['score'] }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td>{{ $item['overall_score'] }}</td>
                                <td>{{ $item['score'] }}</td>
                                <td>{{ $item['total_percentage'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
                <x-service-issue />
            </div>
        </div>
    </div>
</div>
<div wire:ignore class="app-card app-card-orders-table shadow-sm mb-5">
    <div class="app-card-header p-3">
        <div class="row justify-content-between align-items-center">
            <div class="col-auto">
                <h4 class="app-card-title">Category </h4>
            </div>
        </div>
    </div>
    <div class="app-card-body">
        <div class="table-responsive">
            <table class="table app-table-hover mb-0 text-left">
                <tbody>
                    <tr id="speed">
                        <td colspan="8">
                            <h6 class="card-title product-name">SPEED AND ACCURACY</h6>
                        </td>
                    </tr>
                    <tr>
                        <td class="product-sub-category " colspan="8">
                            <p>Cashier TAT</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="service-speed">Name</td>
                        <td>Time (hh:mm)</td>
                        <td>Product Ordered</td>
                        <td>OT </td>
                        <td>Assembly</td>
                        <td>TAT</td>
                        <td>FST</td>
                        <td>Remarks</td>
                    </tr>
                    <tr>
                        <td class="service-speed">
                            <input type="text" class="form-control " name="bp" id="bp" placeholder="">
                        </td>
                        <td>
                            <input type="text" class="form-control " name="bp" id="bp" placeholder="">
                        </td>
                        <td>
                            <input type="text" class="form-control " name="bp" id="bp" placeholder="">
                        </td>
                        <td>
                            <input type="text" class="form-control " name="bp" id="bp" placeholder="">
                        </td>
                        <td>
                            <input type="text" class="form-control " name="bp" id="bp" placeholder="">
                        </td>
                        <td>
                            <input type="text" class="form-control " name="bp" id="bp" placeholder="">
                        </td>
                        <td>
                            <input type="text" class="form-control " name="bp" id="bp" placeholder="">
                        </td>
                        <td>
                            <input type="text" class="form-control " name="bp" id="bp" placeholder="">
                        </td>
                    </tr>

                    <tr>
                        <td class="product-sub-category " colspan="8">
                            <p>Server CAT</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="service-speed">Name</td>
                        <td>Time (hh:mm)</td>
                        <td>Product Ordered</td>
                        <td>OT </td>
                        <td>Assembly</td>
                        <td>TAT</td>
                        <td>FST</td>
                        <td>Remarks</td>
                    </tr>
                    <tr>
                        <td class="service-speed">
                            <input type="text" class="form-control " name="bp" id="bp" placeholder="">
                        </td>
                        <td>
                            <input type="text" class="form-control " name="bp" id="bp" placeholder="">
                        </td>
                        <td>
                            <input type="text" class="form-control " name="bp" id="bp" placeholder="">
                        </td>
                        <td>
                            <input type="text" class="form-control " name="bp" id="bp" placeholder="">
                        </td>
                        <td>
                            <input type="text" class="form-control " name="bp" id="bp"
                                placeholder="">
                        </td>
                        <td>
                            <input type="text" class="form-control " name="bp" id="bp"
                                placeholder="">
                        </td>
                        <td>
                            <input type="text" class="form-control " name="bp" id="bp"
                                placeholder="">
                        </td>
                        <td>
                            <input type="text" class="form-control " name="bp" id="bp"
                                placeholder="">
                        </td>
                    </tr>
                </tbody>
            </table>
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
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
