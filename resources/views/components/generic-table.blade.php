<table class="blueTable">
    <thead>
        <tr>
            @foreach($dinamicTableData as $dinTabDat)
                <th>{{ str_replace('"', '', $dinTabDat['title'])}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($dataRegisters as $reg)
        <tr>
            @foreach($dinamicTableData as $dinTabDat)
                {{ $col = str_replace('"', '', json_encode($dinTabDat['value'])) }}
                @if($dinTabDat['type'] == 'text')
                    <td style="width: {{ str_replace('"', '', json_encode($dinTabDat['width'])) }}">{!! trim($reg->$col) !!}</td>
                @elseif($dinTabDat['type'] == 'number')
                    <td style="width: {{ str_replace('"', '', json_encode($dinTabDat['width'])) }}">{!! trim($reg->$col) !!}</td>
                @elseif($dinTabDat['type'] == 'image')
                <td class="text-center" style="width: {{ str_replace('"', '', json_encode($dinTabDat['width'])) }}">
                    <img class="text-center" src="{{ asset('storage/'.trim($reg->$col)) }}" width="{{ str_replace('"', '', json_encode($dinTabDat['width'])) }}">
                </td>
                @else
                    <td style="width: {{ str_replace('"', '', json_encode($dinTabDat['width'])) }}">Algo</td>
                @endif
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>