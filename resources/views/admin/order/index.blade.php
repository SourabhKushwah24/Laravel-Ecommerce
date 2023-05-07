@extends('layouts.admin')

@section('title', 'Order')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>My Orders</h4>
                </div>
                <div class="card-body">
                    <form action="" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Filter By Date</label>
                                <input type="date" name="date" value="{{ Request::get('date') ?? date('Y-m-d') }}"
                                    class="form-control" style="border: solid rgb(130, 130, 130);">
                            </div>
                            <div class="col-md-3">
                                <label>Filter By Status</label>
                                <select name="status" class="form-select"
                                    style="height: 70%; border: solid rgb(130, 130, 130);">
                                    <option value="">Select All Status</option>
                                    <option value="in process"
                                        {{ Request::get('status') == 'in process' ? 'selected' : '' }}>In Process
                                    </option>
                                    <option value="completed" {{ Request::get('status') == 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="panding" {{ Request::get('status') == 'panding' ? 'selected' : '' }}>
                                        Panding</option>
                                    <option value="cancelled" {{ Request::get('status') == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                    <option value="out-of-delivery"
                                        {{ Request::get('status') == 'out-of-delivery' ? 'selected' : '' }}>Out Of
                                        Delivery</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <br>
                                <button type="submit" class="btn btn-primary text-white fw-bold "
                                    style="width: 50%; height: 70%;">Filter</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Tracking No</th>
                                    <th>Username</th>
                                    <th>Payment Mode</th>
                                    <th>Ordered Date</th>
                                    <th>Status Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $orderItem)
                                    <tr>
                                        <td>{{ $orderItem->id }}</td>
                                        <td>{{ $orderItem->tracking_no }}</td>
                                        <td>{{ $orderItem->fullname }}</td>
                                        <td>{{ $orderItem->payment_mode }}</td>
                                        <td>{{ $orderItem->created_at->format('d-m-y') }}</td>
                                        <td>{{ $orderItem->status_message }}</td>
                                        <td>
                                            <a href="{{ url('admin/order/' . $orderItem->id) }}"
                                                class="btn btn-primary btn-sm text-white">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">No Orders Available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-2 float-end">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
