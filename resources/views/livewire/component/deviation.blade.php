<div class="app-card-body p-3 p-lg-4">
    @foreach ($deviation_list as $item)
        <label for="" class="form-label ">{{ $item['label'] }}</label>
        @if ($item['is_sd'])
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <select class="form-select form-select-md"
                            wire:change="updateCriticalDeviation({{ json_encode($item) }},$event.target.value,'sd')"
                            name="sd{{ $item['id'] }}" id="sd{{ $item['id'] }}">
                            <option value="">Select sd</option>
                            @forelse ($sanitation_list as $sanitation)
                                <option value="{{ $sanitation->code  }}"
                                    {{ $sanitation->code === $item['saved_sd'] ? 'selected' : '' }}>
                                    {{ $sanitation->code }}
                                </option>
                            @empty
                                <option value="0">No data found!</option>
                            @endforelse
                        </select>
                    </div>
                </div>
            </div>
        @endif
        @if ($item['is_location'])
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        <select class="form-select form-select-md"
                            wire:change="updateCriticalDeviation({{ json_encode($item) }},$event.target.value,'location')"
                            name="location{{ $item['id'] }}" id="location{{ $item['id'] }}">
                            <option selected hidden>Select location</option>
                            @foreach ($item['location'] as $location_dropdown)
                                <option value="{{  $location_dropdown['name'] }}"
                                    {{ $location_dropdown['name'] === $item['saved_location'] ? 'selected' : '' }}>
                                    {{ $location_dropdown['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        <select class="form-select form-select-md"
                            wire:change="updateCriticalDeviation({{ json_encode($item) }},$event.target.value,'score')"
                            name="loc_score{{ $item['id'] }}" id="loc_score{{ $item['id'] }}">
                            <option selected value="">Select score</option>
                            <option value="5%" {{ $item['saved_score'] == '5%' ? 'selected' : '' }}>5%
                            </option>
                            <option value="10%" {{ $item['saved_score'] == '10%' ? 'selected' : '' }}>10%
                            </option>
                            <option value="15%" {{ $item['saved_score'] == '15%' ? 'selected' : '' }}>15%
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        @endif
        @if ($item['is_product'])
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        <select class="form-select form-select-md"
                            wire:change="updateCriticalDeviation({{ json_encode($item) }},$event.target.value,'product')"
                            name="product{{ $item['id'] }}" id="product{{ $item['id'] }}">
                            <option selected value="">Select product</option>
                            @foreach ($item['product'] as $product_dropdown)
                                <option value="{{ $product_dropdown['name'] }}"
                                    {{ $product_dropdown['name'] === $item['saved_product'] ? 'selected' : '' }}>
                                    {{ $product_dropdown['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        <select class="form-select form-select-md"
                            wire:change="updateCriticalDeviation({{ json_encode($item) }},$event.target.value,'score')"
                            name="product_score{{ $item['id'] }}" id="product_score{{ $item['id'] }}">
                            <option selected value="">Select score</option>
                            <option value="5%" {{ $item['saved_score'] == '5%' ? 'selected' : '' }}>5%
                            </option>
                            <option value="10%" {{ $item['saved_score'] == '10%' ? 'selected' : '' }}>10%
                            </option>
                            <option value="15%" {{ $item['saved_score'] == '15%' ? 'selected' : '' }}>15%
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        @endif
        @if ($item['is_dropdown'])
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        <select class="form-select form-select-md"
                            wire:change="updateCriticalDeviation({{ json_encode($item) }}, $event.target.value, 'dropdown')"
                            name="dropdown{{ $item['id'] }}" id="dropdown{{ $item['id'] }}">
                            <option value="">Select deviation</option>
                            @foreach ($item['dropdown'] as $dropdown)
                                <option value="{{ $dropdown['name'] }}"
                                    {{ $dropdown['name'] === $item['saved_dropdown'] ? 'selected' : '' }}>
                                    {{ $dropdown['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        {{--  <input type="text" class="form-control"
                                wire:change="updateCriticalDeviation({{ json_encode($item) }},$event.target.value,'score')"
                                name="dp_score{{ $item['id'] }}" id="dp_score{{ $item['id'] }}" value="{{$item['saved_score']}}"> --}}

                        <select class="form-select form-select-md"
                            wire:change="updateCriticalDeviation({{ json_encode($item) }},$event.target.value,'score')"
                            name="dp_score{{ $item['id'] }}" id="dp_score{{ $item['id'] }}">
                            <option selected value="">Select score</option>
                            <option value="5%" {{ $item['saved_score'] == '5%' ? 'selected' : '' }}>5%
                            </option>
                            <option value="10%" {{ $item['saved_score'] == '10%' ? 'selected' : '' }}>10%
                            </option>
                            <option value="15%" {{ $item['saved_score'] == '15%' ? 'selected' : '' }}>15%
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        @endif
        @if ($item['remarks'])
            <div class="mb-3">
                <textarea class="form-control"
                    wire:change="updateCriticalDeviation({{ json_encode($item) }},$event.target.value,'remarks')"
                    name="remarks{{ $item['id'] }}" id="remarks{{ $item['id'] }}" rows="2"
                    placeholder="Enter remarks here...">{{ $item['saved_remarks'] }}</textarea>
            </div>
        @endif
    @endforeach
</div>
