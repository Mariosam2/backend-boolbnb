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
                @forelse($apartments as $apartment)
                    @forelse($apartment->views as $view)
                        <div>{{ $view->apartment_id . ' ' . $view->date }}</div>
                    @empty
                    @endforelse

                @empty
                @endforelse
                <div class="canvas_container">

                    <canvas id="acquisitions"></canvas>
                </div>
            </div>


        </div>


    </div>

    </div>
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    <script>
        //console.log(new Date().getDay());
        const week = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        function createData() {
            const today = new Date().getDay();
            let data = [];
            week.forEach((day, index) => {
                if (index === today - 1) {
                    data.push({
                        day: 'Today',
                        value: 10
                    });
                } else {
                    data.push({
                        day: day,
                        value: 10
                    });
                }

            })
            console.log(data);
            const prevDays = data.slice(0, today);
            const nextDays = data.slice(today);
            console.log(prevDays, nextDays, week);
            data = nextDays.concat(prevDays);
            return data;

        }

        /*  const data = [{
                 day: 'Mon',
                 value: 10
             },
             {
                 day: 'Tue',
                 value: 20
             },
             {
                 day: 'Wed',
                 value: 15
             },
             {
                 day: 'Thu',
                 value: 25
             },
             {
                 day: 'Fri',
                 value: 22
             },
             {
                 day: 'Sat',
                 value: 30
             },
             {
                 day: 'Sun',
                 value: 28
             },
         ]; */
        const data = createData();

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
                    labels: data.map(row => row.day),
                    datasets: [{
                        data: data.map(row => row.value)
                    }]
                }
            }
        );
    </script>
@endsection
