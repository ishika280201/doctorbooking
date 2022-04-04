@extends('layouts.master')
@section('content')
<div class="container">
<div class="row">
<div align="right">
  <!--     <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">Create Record</button> -->
     </div>
    <h3>Appointment Management</h3>
    <table class="table table-bordered appointment-table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Customer_order_id</th>
            <th>User Name</th>
            <th>Phone Number</th>
            <th>Appointment Date</th>
            <th>Appointment Time</th>
            <th>Discount</th>
            <th>Grand Total</th>
            <th>Payement Method Id</th>
            <th>Payement Mode</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

@endsection