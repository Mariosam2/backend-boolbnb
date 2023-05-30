@extends('layouts.user')

@section('content')
    <div class="col flex-grow-1 spacing" style="min-height: 500px; height: 100vh; overflow-y:auto">
        <div class="container-lg d-flex flex-column align-items-center px-3">
            <h1 class="mb-4">Dashboard</h1>
            <div class="w-100 dashboard_container">
                <div class="mb-4 d-flex flex-column align-items-center d-sm-block">
                    <label for="apartment_id" class="form-label">I tuoi appartamenti</label>
                    <div class="apartment-select">
                        <select class="form-select form-select-md ms_dashboard-select" name="apartment_id" id="apartment_id">
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
    <script type="module">
        //console.log(new Date().getDay());
        const axios = window.axios;
        const selectEl = document.getElementById('apartment_id');
        let currentApartmentId = selectEl.value;
        const weekDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        //console.log(currentApartmentId);
        async function getCurrentApartmentViews(){
            const url = 'https://boolbnb-host.com/api/views/'+ currentApartmentId;
            let views;
            const response = await axios.get(url);
            return response.data.results;
           
                    
        }

        function createWeek() {
            const today = new Date().getDay();
            let week = [];
            weekDays.forEach((day, index) => {
                if (index === today - 1) {
                    week.push('Today');
                } else {
                    week.push(day);
                }

            })
            //console.log(week);
            const prevDays = week.slice(0, today);
            const nextDays = week.slice(today);
            //console.log(prevDays, nextDays, week);
            week = nextDays.concat(prevDays);
            //console.log(week);
            return week;

        }


        function setWeek(){
            const week = createWeek();
            let temp = [];
            let numOfDaysToRemove = 6;
            for(let i = 0; i < week.length; i++){
                const date = new Date();
                let day = date.getDate() - numOfDaysToRemove;
                date.setDate(day);
                //console.log(date);
                
                //const formattedDate = `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`;
                //console.log(formattedDate);
                // push oggetto con nome e temp
               
                const formattedDay = date.toLocaleDateString('en-US', {weekday: 'short'});
                const formattedDate = date.toLocaleDateString('en-US', {year:  "numeric"}) + '-' + date.toLocaleDateString('en-US', {month: "2-digit"}) + '-' + date.toLocaleDateString('en-US', {day: "2-digit"});
                const today = new Date().toLocaleDateString('en-US', {weekday: 'short'});
                if(today === formattedDay){
                    temp.push({
                    day: 'Today',
                    date: formattedDate
                })
                } else {
                    temp.push({
                    day: formattedDay,
                    date: formattedDate
                })
                }
                
                numOfDaysToRemove--;

            }
            //console.log(temp);
            return temp;
            
        }

        


        async function createData(){
            const week = setWeek();
            console.log(week);
            let views = await getCurrentApartmentViews();
            console.log(views);
          
            let data = [];
            week.forEach(day=> {
                let count = 0;
                for(let i = 0; i < views.length; i++){
                    if(views[i].date == day.date){
                        count++;

                    }
                    console.log(count);
                }
                const obj = {day: day.day, value: count, date: day.date};
                data.push(obj);
            })
            return data;
        }

        const data = await createData();

        let dashboard = new Chart(
            document.getElementById('acquisitions'), {
                type: 'bar',
                options: {
                    elements: {
                        bar: {
                            borderRadius: 100,
                            borderSkipped: false,
                            backgroundColor: '#5A57FF',
                            
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                display:false,
                            },
                            ticks: {
                                stepSize: 1,
                                
                            }
                        },
                        x: {
                            border: {
                               display: false,
                            },
                            grid: {
                                display:false,
                            },
                        }
                    },
                    animation: true,
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true,
                            xAlign: 'left',
                            yAlign: 'center'
                        }
                    }
                },
                data: {
                    labels: data.map(row => row.day),
                    datasets: [{
                        barPercentage: 0.6,
                        minBarLength: 2,
                        data: data.map(row => row.value),
                    }]
                }
            }
        );


        //When select value changes

        function removeData(chart) {
            const temp = chart.data.labels.length;
            for(let i = 0; i < temp; i++){
                //console.log('elimino label');
                chart.data.labels.pop();
            }
           
            const dataLen = chart.data.datasets['0'].data.length;
            for(let i = 0; i < dataLen; i++){
                let chartData = chart.data.datasets['0'].data;
                chartData.pop();
            }
            
            chart.update();
        }

        function addData(chart, data) {
            data.forEach((el, index) => {
                chart.data.labels[index] = el.day;
                
            })
            for(let i = 0; i< data.length; i++){
                chart.data.datasets['0'].data[i] = data[i].value;
                
            }
            chart.update();
           
        }
        selectEl.addEventListener('change', async function() {
            currentApartmentId = this.value;
            console.log(currentApartmentId);
            const newData = await createData();
            //console.log(newData);
            removeData(dashboard);
            //console.log(dashboard.data)
            addData(dashboard,newData)
            //console.log(dashboard.data)
           
        })
    </script>
@endsection
