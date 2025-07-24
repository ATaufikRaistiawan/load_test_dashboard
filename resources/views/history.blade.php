<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>History - Durability Load Test M/C</title>
    <link rel="icon" href="{{ asset('images/ypmi_logo.png') }}" type="image/png">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #e6f7ff;
        }

        header {
            background: #79c0f2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .logo {
            /* font-size: 24px; */
            width: 6%;
            font-weight: bold;
            color: red;
        }

        .title {
            font-size: 30px;
            font-weight: bold;
            text-align: center;
        }

        .container {
            margin: 20px;
        }

        .section-title {
            background: #333;
            color: #fff;
            padding: 6px;
            margin-bottom: 10px;
            text-align: center;
            font-weight: bold;
            border-radius: 4px;
        }

        .machine-logo {
            /* background-color: #fff; */
            padding: 10px;
            transform-origin: center;
            width: 200px;
            display: block;
            margin: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        thead {
            background: darkgrey;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr[style*="background-color: #f88"] {
            font-weight: bold;
            color: #000;
        }


        form {
            padding: 10px;
        }

        footer {
            background: #79c0f2;
            padding: 10px;
            display: flex;
            justify-content: space-around;
        }

        nav a {
            text-decoration: none;
            padding: 8px 16px;
            margin: 0 10px;
            font-weight: bold;
            border-radius: 4px;
            color: black;
            background-color: white;
            border: 1px solid #000;
        }

        nav a.active {
            background-color: #000;
            color: white;
            border: 2px solid #000;
        }

        .pagination {
            margin-top: 10px;
            text-align: center;
        }

    </style>
</head>

<body>

    <header>
        <div class="logo">
            <img src="{{ asset('images/ypmi_logo_big.png') }}" class="machine-logo">
        </div>
        <div class="title">DURABILITY LOAD TEST M/C</br>HISTORY</div>
        <div id="clock" style="font-weight:bold">
            <div id="time">--:--:--</div>
            <div id="date">--, -- --- ----</div>
        </div>
    </header>

    <div class="container">
        <div class="section-title">Machine History</div>

        <form method="GET" action="{{ route('history') }}"
            style="display: flex; align-items: flex-end; flex-wrap: wrap; gap: 10px;">
            {{-- Filter Inputs --}}
            <div>
                <label>
                    From:<br>
                    <input type="date" name="from" value="{{ request('from') }}">
                </label>
            </div>
            <div>
                <label>
                    To:<br>
                    <input type="date" name="to" value="{{ request('to') }}">
                </label>
            </div>
            <div>
                <label>
                    Status:<br>
                    <select name="status">
                        <option value="">All</option>
                        <option value="normal" {{ request('status') == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="alarm" {{ request('status') == 'alarm' ? 'selected' : '' }}>ALARM</option>
                    </select>
                </label>
            </div>
            <div>
                <label>
                    Min RPM:<br>
                    <input type="number" name="min_rpm" value="{{ request('min_rpm') }}">
                </label>
            </div>

            {{-- Filter and Reset Buttons --}}
            <div>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('history') }}">Reset</a>
            </div>

            <div>
                <label>
                    Show:
                    <select name="per_page">
                        @foreach([10, 20, 50, 100] as $size)
                        <option value="{{ $size }}" {{ request('per_page', 20) == $size ? 'selected' : '' }}>
                            {{ $size }}
                        </option>
                        @endforeach
                    </select>
                    <!-- {{ $leftData->links() }} -->
                </label>
            </div>

            {{-- Spacer to push export to right --}}
            <div style="flex: 1 1 auto;"></div>

            {{-- Export Button --}}
            <div>
                <a href="{{ route('history.export', request()->query()) }}"
                    style="padding: 6px 16px; background-color: green; color: white; text-decoration: none; border-radius: 4px;">
                    Export Excel
                </a>
            </div>
        </form>


        <div style="display: flex; gap: 20px;">
            <!-- Left stage history table -->
            <div style="flex: 1;">
                <div class="section-title">Left Stage</div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
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
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->timestamp }}</td>
                            <td>{{ $row->rpm }}</td>
                            <td>{{ $row->total_revs }}</td>
                            <td>{{ $row->load_kn }}</td>
                            <td>{{ $row->alarm ? 'ALARM' : 'Normal' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            <!-- Right stage history -->
            <div style="flex: 1;">
                <div class="section-title">Right Stage</div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
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
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->timestamp }}</td>
                            <td>{{ $row->rpm }}</td>
                            <td>{{ $row->total_revs }}</td>
                            <td>{{ $row->load_kn }}</td>
                            <td>{{ $row->alarm ? 'ALARM' : 'Normal' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>


    <footer class="footer-nav">
        <nav>
            <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">🖥 Dashboard</a>
            <a href="{{ route('history') }}" class="{{ request()->is('history') ? 'active' : '' }}">📜 History</a>
        </nav>
    </footer>

    <script src="{{ asset('js/clock.js') }}"></script>

</body>

</html>
