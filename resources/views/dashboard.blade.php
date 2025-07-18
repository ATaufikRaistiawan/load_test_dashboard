<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Durability Load Test M/C</title>
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
            font-size: 24px;
            font-weight: bold;
            color: red;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
        }

        .stage {
            width: 48%;
            background: #d6fdd6;
            margin: 1%;
            padding: 10px;
            display: inline-block;
            vertical-align: top;
            border-radius: 8px;
        }

        .section-title {
            background: #333;
            color: #fff;
            padding: 6px;
            margin-bottom: 5px;
            text-align: center;
            font-weight: bold;
        }

        .card {
            background: #f9f9f9;
            padding: 8px;
            margin: 5px 0;
            font-weight: bold;
        }

        .data-box {
            display: flex;
            justify-content: center;
            padding: 0px 0;
        }

        .data-box-h2 {
            text-align: center;
            background: darkgrey;
            border: 1px solid #ccc;
            padding: 5px;
        }

        .data-box-h3 {
            display: flex;
            justify-content: center;
            padding: 0px 0;
            background: black;
            color: #fff;
        }

        .data-box span {
            width: 50%;
            text-align: center;
            background: #fff;
            border: 1px solid #ccc;
            padding: 4px;
        }

        .data-box-h3 span {
            width: 50%;
            text-align: center;
            border: 1px solid #ccc;
            padding: 4px;
        }

        .buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 10px;
        }

        .buttons button {
            padding: 10px 20px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: center;
        }

        footer {
            background: #79c0f2;
            padding: 10px;
            display: flex;
            justify-content: space-around;
        }

        .nav-icon {
            font-size: 28px;
        }

        .machine-image {
            width: 100px;
            display: block;
            margin: auto;
        }

        .status-box {
            padding: 10px 20px;
            font-weight: bold;
            color: white;
            border-radius: 4px;
            text-align: center;
            width: 80px;

    </style>

</head>

<body>
    <header>
        <div class="logo">YAMAHA</div>
        <div class="title">DURABILITY LOAD TEST M/C</div>
        <div id="clock">
            <div id="time">--:--:--</div>
            <div id="date">--, -- --- ----</div>
        </div>
    </header>

    <div style="display: flex; justify-content: center;">
        <!-- Left Stage -->
        <div class="stage">
            <div class="section-title">Left Stage</div>
            <img src="{{ asset('images/wheel.png') }}" class="machine-image">

            <div class="section-title">Work Status</div>
            <div class="buttons">
                <div id="left-run" class="status-box">RUN</div>
                <div id="left-stop" class="status-box">STOP</div>
            </div>

            <div class="card">
                <div class="data-box-h2">
                    <span>Speed (RPM)</span>
                </div>
                <div class="data-box-h3">
                    <span>ACTUAL</span>
                    <span>TARGET</span>
                </div>
                <div class="data-box">
                    <span id="left-rpm">{{ $left->rpm ?? 'N/A' }}</span>
                    <span>0</span>
                </div>
                <div class="data-box-h2">
                    <span>Rev Counter</span>
                </div>
                <div class="data-box-h3">
                    <span>ACTUAL</span>
                    <span>TARGET</span>
                </div>
                <div class="data-box">
                    <span id="left-revs">{{ $left->total_revs ?? 'N/A' }}</span>
                    <span>0</span>
                </div>
                <div class="data-box-h2">
                    <span>Load (kN)</span>
                </div>
                <div class="data-box-h3">
                    <span>ACTUAL</span>
                    <span>TARGET</span>
                </div>
                <div class="data-box">
                    <span id="left-load">{{ $left->load_kn ?? 'N/A' }} kN</span>
                    <span>0</span>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Date Time</th>
                        <th>Rev</th>
                        <th>RPM</th>
                        <th>Torque</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->timestamp }}</td>
                        <td>{{ $row->rpm }}</td>
                        <td>{{ $row->total_revs }}</td>
                        <td>{{ $row->load_kn }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Right Stage -->
        <div class="stage">
            <div class="section-title">Right Stage</div>
            <img src="{{ asset('images/wheel.png') }}" class="machine-image">

            <div class="section-title">Work Status</div>
            <div class="buttons">
                <div id="right-run" class="status-box">RUN</div>
                <div id="right-stop" class="status-box">STOP</div>
            </div>

            <div class="card">
                <div class="data-box">
                    <span>Speed (RPM)<br>ACTUAL: 0</span>
                    <span>TARGET: 0</span>
                </div>
                <div class="data-box">
                    <span>Rev Counter<br>ACTUAL: 0</span>
                    <span>TARGET: 0</span>
                </div>
                <div class="data-box">
                    <span>Load (kN)<br>ACTUAL: 0</span>
                    <span>TARGET: 0</span>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Date Time</th>
                        <th>Rev</th>
                        <th>RPM</th>
                        <th>Torque</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->timestamp }}</td>
                        <td>{{ $row->rpm }}</td>
                        <td>{{ $row->total_revs }}</td>
                        <td>{{ $row->load_kn }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- <x-footer /> -->
    <footer class="footer-nav">
        <nav>
            <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">🖥 Dashboard</a>
            <a href="{{ route('history') }}" class="{{ request()->is('history') ? 'active' : '' }}">📜 History</a>
        </nav>
    </footer>

    <script src="{{ asset('js/status-indicator.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/clock.js') }}"></script>
</body>



</html>
