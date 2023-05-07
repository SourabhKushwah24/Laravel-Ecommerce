@extends('layouts.admin')

{{-- @section('title', 'Orders Details') --}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('message'))
                <div class="alert alert-success mb-3">
                    {{ session('message') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-2 text-primary"><i class="mdi mdi-cart text-dark"></i> My Order Details
                        <a href="{{ url('admin/order') }}" class="btn btn-danger btn-sm float-end">Back</a>
                        <a href="{{ url('admin/invoice/' . $order->id . '/generate') }}"
                            class="btn btn-primary btn-sm float-end mx-2">Download
                            Invoice</a>
                        <a href="{{ url('admin/invoice/' . $order->id) }}" target="_blank"
                            class="btn btn-warning btn-sm float-end">View
                            Invoice</a>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Order Details</h5>
                            <hr>
                            <h6>Order Id: {{ $order->id }}</h6>
                            <h6>Tracking Id/No: {{ $order->tracking_no }}</h6>
                            <h6>Ordered Date: {{ $order->created_at->format('d-m-y h:i A') }}</h6>
                            <h6>Payment Mode: {{ $order->payment_mode }}</h6>
                            <h6 class="border p-2 text-success">Order Status Message: <span class="text-uppercase"></span>
                                {{ $order->status_message }}</h6>
                        </div>
                        <div class="col-md-6">
                            <h5>User Details</h5>
                            <hr>
                            <h6>FullName: {{ $order->fullname }}</h6>
                            <h6>Email: {{ $order->email }}</h6>
                            <h6>Phone: {{ $order->phone }}</h6>
                            <h6>Pin Code: {{ $order->pincode }}</h6>
                            <h6>Address: {{ $order->address }}</h6>
                        </div>
                    </div>
                    <br>
                    <h5>Order Items</h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Item Id</th>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalamount = 0;
                                @endphp
                                @foreach ($order->orderItem as $Items)
                                    <tr>
                                        <td>{{ $Items->id }}</td>
                                        <td>
                                            @if ($Items->product->productImages)
                                                <img src="{{ asset($Items->product->productImages[0]->image) }}"
                                                    style="width: 50px; height: 50px" alt="">
                                            @else
                                                <img src="" style="width: 50px; height: 50px" alt="">
                                            @endif
                                        </td>
                                        <td>
                                            {{ $Items->product->name }}
                                            @if ($Items->productColor)
                                                @if ($Items->productColor->color)
                                                    <span>- Color:
                                                        {{ $Items->productColor->color->name }}</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td><span>&#8377;</span>{{ $Items->price }}</td>
                                        <td>{{ $Items->quantity }}</td>
                                        <td class="fw-bold"><span>&#8377;</span>{{ $Items->quantity * $Items->price }}
                                        </td>
                                    </tr>
                                    @php
                                        $totalamount += $Items->quantity * $Items->price;
                                    @endphp
                                @endforeach
                                <tr>
                                    <td colspan="5" class="fw-bold">Total Amount</td>
                                    <td colspan="1" class="fw-bold"><span>&#8377;</span>{{ $totalamount }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="card border mt-3">
                <div class="card-body">
                    <h4>Order Process(Order Status Update)</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-5">
                            <form action="{{ url('admin/order/' . $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <label>Update Your Order Status</label>
                                <div class="input-group">
                                    <select name="order_status" class="form-select">
                                        <option value="">Select Order Status</option>
                                        <option value="in process"
                                            {{ Request::get('status') == 'in process' ? 'selected' : '' }}>In Process
                                        </option>
                                        <option value="completed"
                                            {{ Request::get('status') == 'completed' ? 'selected' : '' }}>
                                            Completed</option>
                                        <option value="panding"
                                            {{ Request::get('status') == 'panding' ? 'selected' : '' }}>
                                            Panding</option>
                                        <option value="cancelled"
                                            {{ Request::get('status') == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                        <option value="out-of-delivery"
                                            {{ Request::get('status') == 'out-of-delivery' ? 'selected' : '' }}>Out Of
                                            Delivery</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary text-white mx-2"> Update</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-7">
                            <br>
                            <h4 class="mt-3">Current Order Status: <span
                                    class="text-uppercase">{{ $order->status_message }}</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
