@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    <h3>Colors
                        <a href="{{ url('admin/color/create') }}" class="btn btn-primary btn-sm text-white float-end">Add
                            color</a>
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($colors as $color)
                                <tr>
                                    <td>{{ $color->id }}</td>
                                    <td>{{ $color->name }}</td>
                                    <td>{{ $color->code }}</td>
                                    <td>{{ $color->status == '1' ? 'Hidden' : 'Visible' }}</td>
                                    <td>
                                        <a href="{{ url('admin/color/' . $color->id . '/edit') }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <a href="{{ url('admin/color/' . $color->id . '/delete') }}"
                                            onclick="return confirm('Are You Sure, You Want To Delete This Data')"
                                            class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-2 float-end">
                        {{ $colors->links() }}

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
