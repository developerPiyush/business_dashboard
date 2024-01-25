@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Add Branch</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('branch.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="business_id">Business:</label>
                <select class="form-control" id="business_id" name="business_id" required>
                    @foreach ($businesses as $business)
                        <option value="{{ $business->id }}">{{ $business->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                    required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}"
                    required>
            </div>

            <div class="form-group">
                <label for="images">Images:</label>
                <input type="file" class="form-control" name="images[]" multiple>
            </div>


            <div class="form-group">
                <label for="working_hours">Working Hours:</label>
                <table class="table table-bordered" id="workingHoursTable">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Closed</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <tr class="day-row" data-day="{{ $day }}">
                                <td>{{ $day }}</td>
                                <td>
                                    <input type="date" name="working_hours[{{ $day }}][dates][]"
                                        class="form-control" value="{{ old('working_hours.' . $day . '.dates.0') }}">
                                </td>
                                <td>
                                    <input type="time" name="working_hours[{{ $day }}][start_times][]"
                                        class="form-control" value="{{ old('working_hours.' . $day . '.start_times.0') }}">
                                </td>
                                <td>
                                    <input type="time" name="working_hours[{{ $day }}][end_times][]"
                                        class="form-control" value="{{ old('working_hours.' . $day . '.end_times.0') }}">
                                </td>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            name="working_hours[{{ $day }}][closed]"
                                            {{ old('working_hours.' . $day . '.closed') ? 'checked' : '' }}>
                                        <label class="form-check-label">Closed</label>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success add-time-slot">Add More Slot</button>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-primary">Add Branch</button>
        </form>
    </div>
@endsection
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $(".add-time-slot").click(function() {
            alert()
            var day = $(this).closest('.day-row').data('day');

            var templateRow = $("#workingHoursTable tbody tr.day-row[data-day='" + day + "']").first();
            var newRow = templateRow.clone();

            newRow.find('input').val('');

            templateRow.after(newRow);
        });
    });
</script>
