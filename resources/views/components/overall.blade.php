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
            @foreach ($item['data_items'] as $sub)
            <tr>
                <td class="core_name_total"><a href="#{{$sub['name']}}">{{$sub['name']}}</a> </td>
                <td>{{$sub['total_percentage']}}</td>
                <td>{{$sub['score']}}</td>
                <td>{{$sub['score']}}</td>
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td >{{$item['overall_score']}}</td>
                <td>{{$item['score']}}</td>
                <td>{{$item['total_percentage']}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
