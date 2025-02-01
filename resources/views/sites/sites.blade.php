
@extends('layouts.main')

@section('content')
    <div class='row'>
        <div class='col-lg-6 col-md-6 col-sm-12'>
            <h1>All Sites</h1>
        </div>
        <div class='col-lg-6 col-md-6 col-sm-12' style='text-align: right;'>
            <a href='{{ route('sites.create') }}'>
                <button class='btn btn-success' style='font-size: 12px;'><i class='fas fa-plus'></i> Add Sites</button>
            </a>
        </div>
    </div>
    <!-- Search Form -->
    <form action='{{ url('/sites-search') }}' method='GET' class='mb-4 mt-2'>
        <div class='input-group'>
            <input type='text' name='search' value='{{ request()->get('search') }}' class='form-control' placeholder='Search...'>
            <div class='input-group-append'>
                <button class='btn btn-success' type='submit'><i class='fa fa-search'></i></button>
            </div>
        </div>
    </form>
    <div class='table-responsive'>
        <table class='table table-striped'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th><th>Users_id</th><th>Folder_name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sites as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td><td>{{ $item->users_id }}</td><td>{{ $item->folder_name }}</td>
                        <td>
                            {{-- <a href='{{ route('sites.show', $item->id) }}'><i class='fas fa-eye text-success'></i></a> --}}
                            <a href='{{ url('websites/'.$item->folder_name.'/editor.html') }}'><i class='fas fa-eye text-success'></i></a>
                            <a href='{{ route('sites.edit', $item->id) }}'><i class='fas fa-edit text-info'></i></a>
                            <a href='{{ route('sites.delete', $item->id) }}'><i class='fas fa-trash text-danger'></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>No Record...</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $sites->links('pagination::bootstrap-5') }}
@endsection
