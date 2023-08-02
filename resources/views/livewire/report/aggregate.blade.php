@section('title', 'Mary Grace Restaurant Operation System / Report Aggregation')
<div class="">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Aggregate</li>
        </ol>
    </nav>
    <h1 class="app-page-title">Aggregate</h1>
    <div class="page-utilities mb-3">
        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
            {{-- <div class="col-auto">
                <a href="">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path
                            d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z" />
                    </svg>
                </a>
            </div> --}}
            <div class="col-auto d-flex flex-column">
                <label for="store" class="form-label">Category</label>
                <select class="form-select form-select-sm ms-auto d-inline-flex w-auto" wire:model="category">
                    <option value hidden selected>--Select Category--</option>
                    <option value="">All</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item}}">{{ $item}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="app-card app-card-orders-table shadow-sm mb-5">
        <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead >
                        <tr>
                            <th class="cell">Category</th>
                            <th class="cell">Deviation</th>
                            <th class="cell">Remarks</th>
                            <th class="cell">Additonal Info</th>
                            <th class="cell">Store</th>
                            <th class="cell">Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($aggregate as $index => $results)
                            <tr>
                                <td class="cell">{{ $results['category_name'] }}</td>
                                <td class="cell">
                                    <table>
                                        @foreach ($results['data'] as $item)
                                            <tr>
                                                <td>{{$item['deviation']}}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="cell">
                                    <table>
                                        @foreach ($results['data'] as $item)
                                            <tr>
                                                <td>{{$item['remarks']}}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="cell">
                                    <table>
                                        @foreach ($results['data'] as $item)
                                            <tr>
                                                <td>{{$item['details']}}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="cell">
                                    <table>
                                        @foreach ($results['data'] as $item)
                                            <tr>
                                                <td>{{$item['store']}}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                                <td class="cell">{{ $results['score'].'%' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11">
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
    {{-- Pagination --}}
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="page-utilities d-flex justify-start">
                <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                    <div class="col-auto">
                        <label for="limit">Display</label>
                    </div>
                    <div class="col-auto">
                        <select class="form-select-sm w-auto" id="limit" wire:model="limit">
                            <option selected value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <label for="">entries</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <nav class="app-pagination">
                  {{-- {{ $aggregate->onEachSide(0)->links() }} --}}
            </nav>
        </div>
    </div>
</div>
