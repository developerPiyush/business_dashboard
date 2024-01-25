@extends('layouts.app')

@section('content')
    <div class="container">
        <h5>Working Hours for {{ $branch->name }}</h5>

        <label for="selectedDate">Select Date:</label>
        <input type="date" id="selectedDate" class="form-control mb-3">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Working Hours</th>
                </tr>
            </thead>
            <tbody id="workingHoursTable">
                @foreach ($branch->workingHours as $workingHour)
                    <tr class="day-row" data-day="{{ $workingHour->day }}">
                        <td>{{ $workingHour->day }}</td>
                        <td>
                            @if ($workingHour->closed)
                                Closed
                            @else
                                <div class="time-slot">
                                    {{ $workingHour->start_time }} - {{ $workingHour->end_time }}
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <style>
            .time-slot {
                border: 1px solid #ccc;
                padding: 5px;
                margin: 2px;
                display: inline-block;
            }
        </style>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                function fetchAndDisplayWorkingHours(selectedDate) {
                    $.get('/branch/{{ $branch->id }}/working-hours/' + selectedDate, function(data) {
                        var workingHoursTable = $('#workingHoursTable');
                        workingHoursTable.empty();

                        var daysWithWorkingHours = data.map(function(workingHour) {
                            return workingHour.day;
                        });

                        ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'].forEach(
                            function(day) {
                                var workingHoursForDay = data.filter(function(workingHour) {
                                    return workingHour.day === day;
                                });

                                if (workingHoursForDay.length > 0) {
                                    var workingHoursHtml = workingHoursForDay.map(function(workingHour) {
                                        var startTime = workingHour.start_time !== null ?
                                            workingHour.start_time : 'NA';
                                        var endTime = workingHour.end_time !== null ? workingHour
                                            .end_time : 'NA';

                                        return `<div class="time-slot">${startTime} - ${endTime}</div>`;
                                    }).join('');


                                    workingHoursTable.append(`
                                    <tr>
                                        <td>${day}</td>
                                        <td>${workingHoursHtml}</td>
                                    </tr>
                                `);
                                } else {
                                    workingHoursTable.append(`
                                    <tr>
                                        <td>${day}</td>
                                        <td>Closed</td>
                                    </tr>
                                `);
                                }
                            });

                        if (daysWithWorkingHours.length === 0) {
                            alert('No records found for the selected date' + (selectedDate ? ' (' +
                                selectedDate + ')' : '') + '.');
                        }

                    }).fail(function(error) {
                        console.error('Error fetching working hours:', error.responseText);
                    });
                }

                var today = new Date();
                var formattedToday = today.toISOString().split('T')[0];
                fetchAndDisplayWorkingHours(formattedToday);

                $('#selectedDate').change(function() {
                    var selectedDate = $(this).val();
                    fetchAndDisplayWorkingHours(selectedDate);
                });
            });
        </script>
    </div>
@endsection
