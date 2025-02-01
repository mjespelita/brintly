
@extends('layouts.main')

@section('content')
    <h1>Sites Details</h1>
    <table class='table'>
        <tr>
            <th>ID</th>
            <td>{{ $item->id }}</td>
        </tr>
        
        <tr>
            <th>Name</th>
            <td>{{ $item->name }}</td>
        </tr>
    
        <tr>
            <th>Users_id</th>
            <td>{{ $item->users_id }}</td>
        </tr>
    
        <tr>
            <th>Folder_name</th>
            <td>{{ $item->folder_name }}</td>
        </tr>
    
    </table>

    <a href='{{ route('sites.index') }}' class='btn btn-primary'>Back to List</a>
@endsection
