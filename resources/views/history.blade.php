@extends('layouts.app') <!-- optional if using layout -->

@section('content')
    <h1>Machine History</h1>
    <body class="history-page">

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Timestamp</th>
            <th>RPM</th>
            <th>Total Revs</th>
            <th>Load (kN)</th>
            <th>Status</th> <!-- For alarms maybe -->
        </tr>
        @foreach($data as $row)
            <tr @if($row->alarm) style="background-color: #f88" @endif>
                <td>{{ $row->timestamp }}</td>
                <td>{{ $row->rpm }}</td>
                <td>{{ $row->total_revs }}</td>
                <td>{{ $row->load_kn }}</td>
                <td>{{ $row->alarm ? 'ALARM' : 'Normal' }}</td>
            </tr>
        @endforeach
    </table>

    {{ $data->links() }} <!-- Laravel pagination -->
@endsection
