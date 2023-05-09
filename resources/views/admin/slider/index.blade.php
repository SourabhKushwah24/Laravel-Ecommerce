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
                    <h3>Sliders List
                        <a href="{{ url('admin/slider/create') }}" class="btn btn-primary btn-sm text-white float-end">Add
                            Slider</a>
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($sliders as $slider)
                                <tr>
                                    <td>{{ $slider->id }}</td>
                                    <td><img src="{{ asset("$slider->image") }}" class="w-100" alt=""></td>
                                    <td>{{ $slider->title }}</td>
                                    <td>{{ $slider->description }}</td>
                                    <td>{{ $slider->status == '1' ? 'Hidden' : 'visible' }}</td>
                                    <td>
                                        <a href="{{ url('admin/slider/' . $slider->id . '/edit') }}"
                                            class="btn btn-primary btn-sm">Edit</a>
                                        <a href="{{ url('admin/slider/' . $slider->id . '/delete') }}"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are You Sure, You Want To Delete This Slider? ')">Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No Slider Found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                    {{-- pagination  --}}
                    <div class="mt-2 float-end">
                        {{ $sliders->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<style>
    .w-5 {
        display: none;
    }
</style>
