@extends('layouts.dashboard')

@section('page_content')
@if(auth()->user()->type == 'admin')

    <div class="card mt-2">
        <div class="card-heading mx-4">
            <h3>Add Room</h3>
        </div>
        <div class="row card-body mx-5">
            <div class="col-8">

            <form method="Post" action="{{route('room.store')}}">
                @csrf
                <div class="form-group my-1">
                <label >Room Code</label>
                <input type="text" class="form-control"  placeholder="Enter code" name="code">

                </div>
                <div class="form-group my-1">
                    <label >Type </label>
                    <select class="form-control" name="type">
                    <option value="single">Single</option>
                    <option value="double">Double</option>
                    <option value="suite">Suite</option>

                    </select>
                </div>
                <div class="form-group my-1">
                    <label >Status </label>
                    <select class="form-control" name="status">
                    <option value="available">Available</option>
                    <option value="booked">Booked</option>
                    <option value="pending">Pending</option>

                    </select>
                </div>

                <button type="submit" class="btn btn-primary my-1">Submit</button>
            </form>
            </div>
        </div>
    </div>
@endif
<div class="card mt-3">
    <div class="card-body">
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Code</th>
            <th scope="col">Type</th>
            <th scope="col">Status</th>
            @if(auth()->user()->type == 'admin')
            <th scope="col">Action</th>
            @endif

        </tr>
    </thead>
    <tbody>
        @foreach($rooms as $key => $room)
        <tr>
            <th scope="row">{{$key+1}}</th>
            <td>{{$room->code}}</td>
            <td>{{$room->type}} </td>
            <td>
                <select class="form-control" id='tableRoomStatus' data-room-id="{{ $room->id }}">
                <option value="available" @selected($room->status == 'available')>Available</option>
                <option value="booked" @selected($room->status == 'booked')>Booked</option>
                <option value="pending" @selected($room->status == 'pending')>Pending</option>

              </select></td>
            @if(auth()->user()->type == 'admin')
            <td><a href="{{route('room.delete',['id'=>$room->id])}}" class="danger">Delete</a></td>
            @endif

        </tr>
        @endforeach


    </tbody>
</table>
    </div></div>


    <script>
        $(document).ready(function() {
            $('#tableRoomStatus').change(function() {
                var roomId = $(this).data('room-id');
                var status = $(this).val();

                $.ajax({
                    url: "{{route('room.uplodate')}}",
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
