
@extends('layouts.main')

@section('content')
    <h1>Edit Sites</h1>

    <form action='{{ route('sites.update', $item->id) }}' method='POST'>
        @csrf

        <div class='form-group'>
            <label for='name'>Name</label>
            <input type='text' class='form-control' id='name' name='name' value='{{ $item->name }}' required>
        </div>

        <button type='submit' class='btn btn-primary mt-3'>Update</button>
    </form>
@endsection
