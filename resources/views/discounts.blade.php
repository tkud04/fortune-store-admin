<?php
$title = "Discounts";
$subtitle = "View all product discounts";
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
					<a href="{{url('new-discount')}}" class="btn btn-outline-secondary">Add discount</a>
                        <div class="card">
                            <h5 class="card-header">Discounts</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                 <th>Product</th>
                                                 <th>Discount type</th>
                                                 <th>Discount</th>
                                                 <th>Status</th>
                                                 <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  <?php
										   if(count($discounts) > 0)
										   {
											  foreach($discounts as $d)
											   {
												   $p = $d['product'];
												   $name = $p['name'];
											    	$pid = $p['id'];
									      	       $imgs = $p['imggs'];
												   $ss = $d['status'] == "enabled" ? "text-success" : "text-danger";
												    $dt = ['flat' => "Flat",'percentage' => "Percentage"];
													$ru = url('remove-discount')."?xf=".$d['id'];
										 ?>
                                            <tr>
                                                <td>
												 <img class="img-fluid" src="{{$imgs[0]}}" alt="" style="width: 50px; height: 50px;"/>
											     {{$name}}
												</td>
					                            <td><b>{{ $dt[$d['discount_type']] }}</b></td>
					                            <td>
												@if($d['discount_type'] == "flat")
												<b>&#8358;{{ number_format($d['discount'],2) }}</b>
												@elseif($d['discount_type'] == "percentage")
												<b>%{{ $d['discount'] }}</b>
												@endif
												</td>
					                            <td>				   
					                             <h3 class="{{$ss}}">{{strtoupper($d['status'])}}</h3>
					                            </td>
					                            <td>
						                          <a class="btn btn-default btn-block btn-clean" href="{{$ru}}">Remove</a>
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