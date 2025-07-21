<div style="display: flex; gap: 20px;">
    {{-- Left Stage --}}
    <div style="flex: 1;">
        <div class="section-title">Left Stage</div>
        <table>
            <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>RPM</th>
                    <th>Total Revs</th>
                    <th>Load (kN)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leftData as $row)
                <tr @if($row->alarm) style="background-color: #f88" @endif>
                    <td>{{ $row->timestamp }}</td>
                    <td>{{ $row->rpm }}</td>
                    <td>{{ $row->total_revs }}</td>
                    <td>{{ $row->load_kn }}</td>
                    <td>{{ $row->alarm ? 'ALARM' : 'Normal' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $leftData->links() }}
        </div>
    </div>

    {{-- Right Stage --}}
    <div style="flex: 1;">
        <div class="section-title">Right Stage</div>
        <table>
            <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>RPM</th>
                    <th>Total Revs</th>
                    <th>Load (kN)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rightData as $row)
                <tr @if($row->alarm) style="background-color: #f88" @endif>
                    <td>{{ $row->timestamp }}</td>
                    <td>{{ $row->rpm }}</td>
                    <td>{{ $row->total_revs }}</td>
                    <td>{{ $row->load_kn }}</td>
                    <td>{{ $row->alarm ? 'ALARM' : 'Normal' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $rightData->links() }}
        </div>
    </div>
</div>
