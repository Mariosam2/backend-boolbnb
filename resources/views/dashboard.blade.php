@extends('layouts.user')

@section('content')
    <div class="col flex-grow-1 spacing">
        <div class="container-fluid d-flex flex-column align-items-center">
            <h1 class="mb-4">Dashboard</h1>
            <div>
                <div class="mb-4">
                    <label for="apartment_id" class="form-label">I tuoi appartamenti</label>
                    <div class="w-25">
                        <select class="form-select form-select-md" name="apartment_id" id="apartment_id">
                            @forelse($apartments as $key=>$apartment)
                                @if ($key == 0)
                                    <option class="p-2" selected value="{{ $apartment->id }}">{{ $apartment->title }}
                                    </option>
                                @else
                                    <option class="p-2" value="{{ $apartment->id }}">{{ $apartment->title }}</option>
                                @endif
                            @empty
                            @endforelse
                        </select>
                    </div>

                </div>
                <div class="canvas_container">

                    <canvas id="acquisitions"></canvas>
                </div>
            </div>


        </div>


    </div>

    </div>
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    <script>
        (async function() {
            const data = [{
                    year: 2010,
                    count: 10
                },
                {
                    year: 2011,
                    count: 20
                },
                {
                    year: 2012,
                    count: 15
                },
                {
                    year: 2013,
                    count: 25
                },
                {
                    year: 2014,
                    count: 22
                },
                {
                    year: 2015,
                    count: 30
                },
                {
                    year: 2016,
                    count: 28
                },
            ];

            new Chart(
                document.getElementById('acquisitions'), {
                    type: 'bar',
                    options: {
                        animation: true,
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: true
                            }
                        }
                    },
                    data: {
                        labels: data.map(row => row.year),
                        datasets: [{
                            label: 'Acquisitions by year',
                            data: data.map(row => row.count)
                        }]
                    }
                }
            );
        })();
    </script>
@endsection
