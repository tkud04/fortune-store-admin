<?php
$title = ucwords($m['name']);
$subtitle = "Edit this manufacturer.";
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
@include('page-header',['title' => "Manufacturers",'subtitle' => $title])
@stop

@section('content')
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Edit Manufacturer</h5>
                                <div class="card-body">
                                    <form action="{{url('manufacturer')}}" id="manufacturer-form" method="post" enctype="multipart/form-data">
										{!! csrf_field() !!}
										<input type="hidden" name="xf" value="{{$m['id']}}">
										<div class="row">
										<div class="col-md-6">
										<div class="form-group">
                                            <label>Name <span class="text-danger text-bold">*</span></label>
                                            <input id="add-manufacturer-name" type="text" name="name" value="{{$title}}" placeholder="Manufacturer name e.g Acer" class="form-control">
                                        </div>
										</div>
										<div class="col-md-6">
										<div class="form-group">
                                            <label>Image</label>
											<img src="{{$m['image'][0]}}" width="150" height="150" alt="{{$title}}">
											
											<h5>Change image</h5>
                                            <input type="file" class="form-control" id="manufacturer-image" name="image">
                                        </div>
										</div>
										</div>
										
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="manufacturer-submit">Submit</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>		
</div>		
@stop