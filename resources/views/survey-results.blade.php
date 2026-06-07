{{-- @extends('layouts.admin.master') --}}


@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h2 class="mb-4">📊 Survey Dashboard</h2>

    <!-- 🔹 Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h5>Total Responses</h5>
                <h3>{{ $total }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h5>Average Score</h5>
                <h3>{{ $avgScore }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h5>Top Party</h5>
                <h3>
                    {{ collect($partyStats)->sortDesc()->keys()->first() ?? '-' }}
                </h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h5>Export Data</h5>
                <a href="{{ url('/survey-export') }}" class="btn btn-success mt-2">
                    Download Excel
                </a>
            </div>
        </div>
    </div>

    <!-- 🔹 Party Chart -->
    <div class="card mb-4 p-3 shadow-sm">
        <h5>Party Preference</h5>
        <canvas id="partyChart"></canvas>
    </div>

    <!-- 🔹 Question Insights -->
    <div class="card mb-4 p-3 shadow-sm">
        <h5>Question-wise Average</h5>
        <div class="row">
            @foreach($questionAvg as $q => $avg)
                <div class="col-md-2 mb-2">
                    <div class="border p-2 text-center">
                        <strong>{{ strtoupper($q) }}</strong>
                        <br>
                        <span class="{{ $avg < 2 ? 'text-danger' : ($avg < 3 ? 'text-warning' : 'text-success') }}">
                            {{ $avg }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 🔹 Full Data Table -->
    <div class="card p-3 shadow-sm">
        <h5>All Responses</h5>

        <input type="text" id="search" class="form-control mb-3" placeholder="Search by name or phone...">

        <div class="table-responsive">
            <table class="table table-bordered" id="surveyTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Avg Score</th>
                        <th>Party</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($surveys as $s)
                        <tr>
                            <td>{{ $s->id }}</td>
                            <td>{{ $s->name }}</td>
                            <td>{{ $s->phone }}</td>
                            <td>
                                <span class="{{ $s->average_score < 2 ? 'text-danger' : ($s->average_score < 3 ? 'text-warning' : 'text-success') }}">
                                    {{ $s->average_score }}
                                </span>
                            </td>
                            <td>{{ $s->q11 }}</td>
                            <td>{{ $s->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- 🔹 Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Party Chart Data
    const partyData = @json($partyStats);

    const labels = Object.keys(partyData);
    const data = Object.values(partyData);

    new Chart(document.getElementById('partyChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Votes',
                data: data
            }]
        }
    });

    // 🔍 Search Filter
    document.getElementById('search').addEventListener('keyup', function () {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll("#surveyTable tbody tr");

        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
        });
    });
</script>

@endsection