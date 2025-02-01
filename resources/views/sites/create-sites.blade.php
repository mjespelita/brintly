
@extends('layouts.main')

@section('content')
    <h1>Create a new sites</h1>

    <form action='{{ route('sites.store') }}' method='POST'>
        @csrf

        <div class='form-group'>
            <label for='name'>Name</label>
            <input type='text' class='form-control' id='name' name='name' required>
        </div>

        <button type='submit' class='btn btn-primary mt-3'>Create</button>
    </form>
@endsection
