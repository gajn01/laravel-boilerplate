<div class="app-card-body p-3 p-lg-4">
    @forelse ($deviation_list as $item)
        <label for="" class="form-label ">{{ $item['label'] }}</label>
        @if ($item['remarks'])
            <div class="mb-3">
                <textarea class="form-control" name="" id="" rows="2" placeholder="Enter remarks here..."></textarea>
            </div>
        @endif
        @if ($item['is_sd'])
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <select class="form-select form-select-md" name="" id="">
                            <option selected hidden>Select sd</option>
                            @forelse ($sanitation_list as $sanitation)
                                <option value="{{ $sanitation->id }}">{{ $sanitation->code }}
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
                        <select class="form-select form-select-md" name="" id="">
                            <option selected hidden>Select location</option>
                            @foreach ($item['location'] as $location_dropdown)
                                <option value="{{ $location_dropdown['id'] }}">{{ $location_dropdown['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        <select class="form-select form-select-md" name="sd" id="sd">
                            <option selected hidden>Select score</option>
                            <option value="5%">5%</option>
                            <option value="10%">10%</option>
                            <option value="15%">15%</option>
                        </select>
                    </div>
                </div>
            </div>
        @endif
        @if ($item['is_product'])
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        <select class="form-select form-select-md" name="" id="">
                            <option selected hidden>Select product</option>
                            @foreach ($item['product'] as $product_dropdown)
                                <option value="{{ $product_dropdown['id'] }}">{{ $product_dropdown['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        <select class="form-select form-select-md" name="sd" id="sd">
                            <option selected hidden>Select score</option>
                            <option value="5%">5%</option>
                            <option value="10%">10%</option>
                            <option value="15%">15%</option>
                        </select>
                    </div>
                </div>
            </div>
        @endif
        @if ($item['is_dropdown'])
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        <select class="form-select form-select-md" name="" id="">
                            <option selected hidden>Select deviation</option>
                            @foreach ($item['dropdown'] as $dropdown)
                                <option value="{{ $dropdown['id'] }}">{{ $dropdown['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        <select class="form-select form-select-md" name="" id="">
                            <option selected hidden>Select score</option>
                            <option value="5%">5%</option>
                            <option value="10%">10%</option>
                            <option value="15%">15%</option>
                        </select>
                    </div>
                </div>
            </div>
        @endif
    @empty
    @endforelse
</div>
