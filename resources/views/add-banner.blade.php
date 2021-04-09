<?php
$title = "Add Banner";
$subtitle = "Add a new image to be displayed on the home page.";
?>

@extends('layout')

@section('title',$title)


@section('page-header')
@include('page-header',['title' => "Banners",'subtitle' => $title])
@stop


@section('content')
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Add Banner</h5>
                                <div class="card-body">
                                    <form action="{{url('add-banner')}}" id="ab-form" method="post">
										{!! csrf_field() !!}
										
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ab-img">Upload image</label>
                                            <input id="ab-img" type="file" name="img" class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ab-title">Main title</label>
                                             <input type="text" class="form-control" placeholder="Main title" name="title" id="ab-title">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ab-top-subtitle">Top subtitle</label>
                                             <input type="text" class="form-control" placeholder="Top subtitle" name="subtitle_1" id="ab-subtitle-1">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ab-top-subtitle">Bottom subtitle</label>
                                             <input type="text" class="form-control" placeholder="Bottom subtitle" name="subtitle_2" id="ab-subtitle-2">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <h4>Status</h4>
                                            <select class="form-control" name="status" id="ap-status" style="margin-bottom: 5px;">
							                  <option value="none">Select status</option>
								           <?php
								            $secs = ['enabled' => "Enabled",'disabled' => "Disabled"];
								            foreach($secs as $key => $value){
									      	 
								           ?>
								              <option value="{{$key}}">{{$value}}</option>
								           <?php
								           }
								           ?>
							                </select>
                                        </div>
										</div>
										</div>
										
										
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="ab-form-btn">Save</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
@stop
