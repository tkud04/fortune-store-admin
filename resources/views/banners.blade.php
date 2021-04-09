<?php
$title = "Banners";
$subtitle = "View all banners";
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
                            <h5 class="card-header">View all Banners<a class="btn btn-primary ml-3" href="{{url('add-banner')}}">Add Banner</a></h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Top subtitle</th>
                                                <th>Main title</th>
                                                <th>Bottom subtitle</th>
                                                <th>Cover</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  <?php
										   if(count($banners) > 0)
										   {
											  foreach($banners as $b)
											   {
												$statusClass = "danger";
											
											   $sss = $b['status'];
												
												if($sss == "enabled")
												{
													$statusClass = "success";
													
												}
											   $img = $b['img'];

												  $dr = url('remove-banner')."?xf=".$b['id'];
												
										  ?>
                                            <tr>
                                               <td><img class="img-fluid" src="{{$img}}" alt="" style="cursor: pointer; width: 100px; height: 100px;"/></td> 
											   <td>
											     <h4>{{$b['subtitle_1']}}</h4>
											   </td> 
											   <td>
											     <h4>{{$b['title']}}</h4>
											   </td> 
											   <td>
											     <h4>{{$b['subtitle_2']}}</h4>
											   </td> 
											   <td>
											     <h4>{{$b['cover']}}</h4>
											   </td> 
                                               <td><span class="label label-{{$statusClass}}">{{strtoupper($sss)}}</span></td>
                                                <td>
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