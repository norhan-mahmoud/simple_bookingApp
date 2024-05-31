@extends('layouts.dashboard')

@section('page_content')

<div class="card mt-3">
    <div class="card-body">
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Room</th>
            <th scope="col">Client</th>
            <th scope="col">Employee Accept</th>
            <th scope="col">Status</th>
            <th scope="col">Note</th>

        </tr>
    </thead>
    <tbody>
        @foreach($requests as $key => $request)
        <tr>
            <th scope="row">{{$key+1}}</th>
            <td>{{@$request->room->code}}</td>
            <td>{{@$request->client->name}} </td>
            <td>{{@$request->employee->name}} </td>
            <td>
                <select class="form-control" id='tableRequestStatus' data-status-id="{{ $request->id }}">
                <option value="approve" @selected($request->status == 'approve')>Approve</option>
                <option value="reject" @selected($request->status == 'reject')>Reject</option>
                <option value="pending" @selected($request->status == 'pending')>Pending</option>

              </select></td>
            <td>{{$request->note}}</td>

        </tr>
        @endforeach


    </tbody>
</table>
    </div></div>


    <script>
        $(document).ready(function() {
            $('#tableRequestStatus').change(function() {
                var roomId = $(this).data('status-id');
                var status = $(this).val();

                $.ajax({
                    url: "{{route('room.uplodate.request')}}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: roomId,
                        status: status
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Failed to update room status');
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while updating the room status');
                    }
                });
            });
        });
    </script>
@endsection
