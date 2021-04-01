<?php
$title = "Products";
$subtitle = "View all products";
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
                            <h5 class="card-header">View all products<a class="btn btn-primary ml-3" href="{{url('add-product')}}">Add Product</a></h5>
                            <h5 class="card-header</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Product name</th>
												<th>Model</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  <?php
										   if(count($products) > 0)
										   {
											  foreach($products as $p)
											   {
												$statusClass = "danger";
												$arrClass = "success";
												$arrText = "Enable";
												

											   $name = $p['name'];
											   $pd = $p['data'];
											   $uu = url('product')."?xf=".$p['id'];
											    $sss = $p['status'];
												
												if($sss == "enabled")
												{
													$statusClass = "success";
													$arrClass = "warning";
													$arrText = "Disable";
												}
											   $imgs = $p['imggs'];

												   $arr = url('ups')."?xf=".$p['id']."&type=".strtolower($arrText);
												   $dr = url('remove-product')."?xf=".$p['id'];
												   #$ar = $a['rating'];
												   $ar = 3;
										  ?>
                                            <tr>
                                               <td><img class="img-fluid" onclick="window.location='{{$uu}}'" src="{{$imgs[0]}}" alt="{{$name}}" style="cursor: pointer; width: 100px; height: 100px;"/></td> 
											   <td> <a href="{{$uu}}"><h4>{{ucwords($name)}}</h4></a> </td> 
												<td><a href="{{$uu}}"><h4>{{$p['model']}}</h4></a></td>	
                                                <td>&#163;{{number_format($pd['amount'],2)}}</td>
												<td>{{$p['qty']}}</td>
                                                <td><span class="label label-{{$statusClass}}">{{strtoupper($sss)}}</span></td>
                                                <td>
												 <a class="btn btn-{{$arrClass}} btn-sm" href="{{$arr}}">{{$arrText}}</a>
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