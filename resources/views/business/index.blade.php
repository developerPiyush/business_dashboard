@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Businesses</h2>
        <a href="{{ route('business.create') }}" class="btn btn-primary">Add Business</a>
        <br><br>
        <table id="business-table" class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Logo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($businesses as $business)
                    <tr>
                        <td>{{ $business->name }}</td>
                        <td>{{ $business->email }}</td>
                        <td>{{ $business->phone_number }}</td>
                        <td>
                            @if ($business->logo)
                                <img src="{{ asset('storage/' . $business->logo) }}" alt="Logo" width="50">
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('business.destroy', $business->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this business?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No Business available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#business-table').DataTable({
                "order": [
                    [0, 'asc']
                ],
                "searching": true,
            });
        });
    </script>
@endsection
