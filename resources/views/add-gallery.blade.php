<?php
$title = "Add Gallery";
$subtitle = "Add a new item to the gallery on the home page.";
?>

@extends('layout')

@section('title',$title)


@section('page-header')
@include('page-header',['title' => "Gallery",'subtitle' => $title])
@stop


@section('content')
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Add Gallery</h5>
                                <div class="card-body">
                                    <form action="{{url('add-gallery')}}" id="ab-form" method="post" enctype="multipart/form-data">
										{!! csrf_field() !!}
										
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ab-images">Upload image</label>
                                            <input type="file" name="img" class="form-control">
                                        </div>
										</div>
										
										</div>
										
										
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" type="submit">Save</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
@stop
