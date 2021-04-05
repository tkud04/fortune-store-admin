<?php
$title = "Add Shipping Info";
$subtitle = "Add new shipping information.";
?>

@extends('layout')

@section('title',$title)


@section('page-header')
@include('page-header',['title' => "Shipping",'subtitle' => $title])
@stop


@section('content')
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Add Shipping</h5>
                                <div class="card-body">
                                    <form action="{{url('add-shipping')}}" id="ash-form" method="post">
										{!! csrf_field() !!}
										
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ash-name">Name</label>
                                            <input id="ash-name" type="text" placeholder="Shipping name" name="name" class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ash-value">Value</label>
                                             <input id="ash-value" type="text" value="{{$s['value']}}" placeholder="Value" name="value" class="form-control">
                                        </div>
										</div>
										
										</div>
										
										
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="ash-form-btn">Save</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
@stop
