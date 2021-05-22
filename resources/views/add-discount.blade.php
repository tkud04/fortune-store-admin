<?php
$title = "Add Discount";
$subtitle = "Add a discount to a product.";
?>

@extends('layout')

@section('title',$title)


@section('page-header')
@include('page-header',['title' => "Discounts",'subtitle' => $title])
@stop


@section('content')
<script>
let products = [];
</script>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Add Discount</h5>
                                <div class="card-body">
                                    <form action="{{url('new-discount')}}" method="post">
										{!! csrf_field() !!}
										<input type="hidden" name="products" id="products" value="">
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <h4>Select product(s)</h4>
                                            <div class="row form-control-plaintext" style="margin-bottom: 5px;">
								           <?php
								            foreach($products as $p){
												$name = $p['name'];
												$pid = $p['id'];
									      	 $imgs = $p['imggs'];
								           ?>
										     <div class="col-md-4">
								              <input type="checkbox" onchange="toggleProduct(this,'{{$pid}}')">
											  <img class="img-fluid" src="{{$imgs[0]}}" alt="" style="width: 50px; height: 50px;"/>
											  {{$name}}
											 </div>
								           <?php
								           }
								           ?>
							                </select>
                                        </div>
										</div>
										<div class="form-group">
                                            <h4>Discount type</h4>
                                            <select class="form-control" name="discount_type" style="margin-bottom: 5px;">
							                  <option value="none">Select discount type</option>
								           <?php
								            $secs = ['flat' => "Flat",'percentage' => "Percentage"];
								            foreach($secs as $key => $value){
									      	 
								           ?>
								              <option value="{{$key}}">{{$value}}</option>
								           <?php
								           }
								           ?>
							                </select>
                                        </div>
										<div class="form-group">
                                            <h4>Applies to</h4>
                                            <select class="form-control" name="type" style="margin-bottom: 5px;">
							                  <option value="none">Select type</option>
								           <?php
								            $secs = ['products' => "Products",'users' => "Users"];
								            foreach($secs as $key => $value){
									      	 
								           ?>
								              <option value="{{$key}}">{{$value}}</option>
								           <?php
								           }
								           ?>
							                </select>
                                        </div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="apl-value">Amount or Percentage</label>
                                             <input type="number" class="form-control" name="amount" placeholder="Amount or Percentage">
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
                                                    <button class="btn btn-space btn-secondary">Save</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
@stop