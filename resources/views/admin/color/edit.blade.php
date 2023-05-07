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
                    <h3>Edit Color
                        <a href="{{ url('admin/color') }}" class="btn btn-danger btn-sm text-white float-end">
                            back</a>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/color/' . $color->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label>Color Name</label>
                            <input type="text" name="name" value="{{ $color->name }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Color Code</label>
                            <input type="text" name="code" value="{{ $color->code }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <input type="checkbox" {{ $color->status ? 'checked' : '' }} name="status">
                        </div>
                        <div class="mb-1 ">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
