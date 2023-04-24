<div class="app-card-body p-3 p-lg-4">
    <div class="table-responsive">
        <table class="table overall-table m-0">
            <tbody>
                {{-- Less Critical & Major SD  --}}
                <tr>
                    <td scope="col" colspan="4">Less Critical & Major SD</td>
                </tr>
                <tr>
                    <td>
                        <select class="form-select form-select-md" name="sd" wire:model="sanitation_defect"
                            id="sd">
                            <option selected hidden>Type of SD</option>
                            @forelse ($sanitation_list as $item)
                                <option value="{{ $item->id }}">{{ $item->code }}
                                </option>
                            @empty
                                <option value="0">No data found!</option>
                            @endforelse
                        </select>
                    </td>
                    <td class="w-50">
                        <input type="text" class="form-control" name="location" id="location" placeholder="Location"
                            wire:model="f_product">
                    </td>
                    <td class="text-center">
                        <span wire:click="onAddSd()">
                            <svg class="icon mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path
                                    d="M240 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H176V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H384c17.7 0 32-14.3 32-32s-14.3-32-32-32H240V80z" />
                            </svg>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <ul>
                            @forelse ($f_major_sd as $item)
                                <li>{{ $item['remarks'] }} - {{ $item['code'] }}</li>
                            @empty
                                <li>No data Found!</li>
                            @endforelse
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <select class="form-select form-select-md" name="sd" id="sd">
                            <option selected hidden>Score</option>
                            <option value="5%">5%</option>
                            <option value="15%">15%</option>
                            <option value="25%">25%</option>
                        </select>
                    </td>
                </tr>
                {{--       <tr>
                    <td colspan="4">
                        <ul>
                            @foreach ($lcm as $item)
                                <li>
                                    {{ $item['sd'] }} - <span>{{ $item['product'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr> --}}
                {{-- Less Spoiled/Lapsed product  --}}

                <tr>
                    <td scope="col" colspan="4">Less Spoiled/Lapsed product</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="text" class="form-control" name="" id="" placeholder="Product">
                    </td>
                    <td class="text-center">
                        <span>
                            <svg class="icon mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path
                                    d="M240 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H176V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H384c17.7 0 32-14.3 32-32s-14.3-32-32-32H240V80z" />
                            </svg>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <select class="form-select form-select-md" name="sd" id="sd">
                            <option selected hidden>Score</option>
                            <option value="5%">5%</option>
                            <option value="15%">15%</option>
                            <option value="25%">25%</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
