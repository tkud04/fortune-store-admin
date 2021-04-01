<?php
$title = "Orders";
$subtitle = "View all orders";
?>

@extends('layout')

@section('title',$title)

@section('scripts')
  <!-- DataTables CSS -->
  <link href="{{asset('lib/datatables/css/buttons.bootstrap.min.css')}}" rel="stylesheet" /> 
  <link href="{{asset('lib/datatables/css/buttons.dataTables.min.css')}}" rel="stylesheet" /> 
  <link href="{{asset('lib/datatables/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" /> 
  
      <!-- DataTables js -->
       <script src="{{asset('lib/datatables/js/datatables.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('lib/datatables/js/datatables-init.js')}}"></script>
@stop

@section('page-header')
@include('page-header',['title' => $title,'subtitle' => $subtitle])
@stop

@section('content')
<div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Orders<a class="btn btn-primary ml-3" href="{{url('add-order')}}">Add Order</a></h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Customer</th>
												<th>Status</th>
                                                <th>Total</th>
                                                <th>Date added</th>
                                                <th>Date modified</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  <?php
										  
										   if(count($orders) > 0)
										   {
											  foreach($orders as $o)
											   {
												   
												 $customer = $o['user'];
											   $totals = $o['totals'];
											   $uu = url('order')."?xf=".$o['id'];
											   $sss = $o['status'];
												
												   $arr = url('order')."?xf=".$o['id']."&type=edit";
												   $dr = url('remove-order')."?xf=".$o['id'];
												   #$ar = $a['rating'];
												   $ar = 3;
										  ?>
                                            <tr>
                                               <td><a href="{{$uu}}"><h4>{{$o['reference']}}</a></td> 
											   <td>{{ucwords($customer['fname']." ".$customer['lname'])}}</td> 
												<td>{{strtoupper($o['status'])}}</h4></td>	
                                                <td>&#163;{{number_format($totals['subtotal'],2)}}</td>
												<td>{{$o['date']}}</td>
												<td>{{$o['updated']}}</td>
                                                <td>
												 <a class="btn btn-info btn-sm" href="{{$arr}}">Edit</a>
												 <a class="btn btn-danger btn-sm" href="{{$dr}}">Remove</a>
												 </td>
                                            </tr>
									     <?php
											   }
										   }
										 ?>
									   </tbody>
									</table>
							    </div>
							 </div>
						</div>
                    </div>
                </div>			
@stop