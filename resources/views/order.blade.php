<?php
$title = "Order #".$o['reference'];
$subtitle = "View information on this order.";
?>

@extends('layout')

@section('title',$title)


@section('page-header')
@include('page-header',['title' => $title,'subtitle' => $subtitle])
@stop


@section('content')
<script>
let xf = "", products = [], pCover = "none", tkOrderHistory = "{{csrf_token()}}",
    orderProducts = [], eoPaymentXF = "new", eoShippingXF = "new";

  

$(document).ready(() => {
	hideElem(["#eo-loading"]);
	
	 @foreach($products as $p)
	  products.push({
		  id: "{{$p['id']}}", 
		  name: "{{$p['name']}}", 
		  model: "{{$p['model']}}", 
		  qty: "{{$p['qty']}}", 
		  amount: "{{$p['data']['amount']}}"
		  });
 @endforeach
 
 @foreach($o['items'] as $i)
	  orderProducts.push({p: {{$i['product_id']}}, q: {{$i['qty']}}});
	  @endforeach
	  
	  refreshProducts({type: "normal", target: "#order-products", t: 'order'});
		   refreshProducts({type: "review", target: "#order-products-review", t: 'order'});
		   refreshProducts({type: "review", target: "#order-products-2", t: 'order'});
});
</script>

<?php
$pd = $o['pd'];
$sd = $o['sd'];
$customer = $o['user'];
$cname = $customer['fname']." ".$customer['lname'];

$payment_method = "Credit Card/Debit Card";
$shipping_method = "Free Shipping";

$pu = url('invoice')."?xf=".$o['id'];
$su = url('shipping-list')."?xf=".$o['id'];
$eu = url('order')."?xf=".$o['id']."&type=edit";
?>

<div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3">
	    <div class="text-right" id="ap-submit">
	      <a href="{{$pu}}" target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Print Invoice"><i class="fas fa-print"></i></a>
	      <a href="{{$su}}" target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Print Shipping List"><i class="fas fa-truck"></i></a>
	      <a href="{{$eu}}" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fas fa-edit"></i></a>
	      <a href="{{url('orders')}}" class="btn btn-primary"><i class="fas fa-reply"></i></a>
	    </div>
	  </div>
      
	  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
	    <div class="card">
           <div class="card-body">
                <h3 class="card-title"><i class="fas fa-user"></i> Order Details</h3>
           </div>
           <ul class="list-group list-group-flush">
		   
                <li class="list-group-item">
				  <span class="badge badge-primary p-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Date added"><i class="fas fa-calendar"></i> </span>
				  {{$o['date']}}
				</li>
				<li class="list-group-item">
				  <span class="badge badge-primary p-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Payment method"><i class="fas fa-credit-card"></i> </span>
				  {{$payment_method}}
				</li>
				<li class="list-group-item">
				  <span class="badge badge-primary p-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Shipping method"><i class="fas fa-truck"></i> </span>
				  {{$shipping_method}}
				</li>
           </ul>
        </div>
	  </div>
	  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 mb-3">
	    <div class="card">
           <div class="card-body">
                <h3 class="card-title"><i class="fas fa-user"></i> Customer Details</h3>
           </div>
           <ul class="list-group list-group-flush">
		   
                <li class="list-group-item">
				  <span class="badge badge-primary p-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Customer name"><i class="fas fa-user"></i> </span>
				  {{ucwords($cname)}}
				</li>
				<li class="list-group-item">
				  <span class="badge badge-primary p-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Customer email"><i class="fas fa-envelope"></i> </span>
				  {{ucwords($customer['email'])}}
				</li>
				<li class="list-group-item">
				  <span class="badge badge-primary p-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Customer phone number"><i class="fas fa-phone"></i> </span>
				  {{ucwords($customer['phone'])}}
				</li>
           </ul>
        </div>
	  </div>
	  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12  col-6 mb-3">
	    <div class="card">
           <div class="card-body">
                <h3 class="card-title"><i class="fas fa-user"></i> Order #{{$o['reference']}}</h3>
				<div class="table-responsive mb-5">
				  <table class="table table-striped table-bordered first etuk-table">
                                              <thead>
                                                <tr>
                                                  <th>Payment Address</th>
                                                  <th>Shipping Address</th>
                                                </tr>
                                              </thead>
                                              <tbody>
										      <?php
											  
											  ?>
											   <tr>
											     <td>
											      {{strtoupper($cname)}}<br>
											      {{strtoupper($pd['address_1'])}}<br>
											      @if($pd['address_2'] != ""){{strtoupper($pd['address_2'])}}<br>@endif
											      {{strtoupper($pd['city'])." ".$pd['zip']}}<br>
											      {{strtoupper($pd['region'])}}<br>
											      {{ucwords($countries[$pd['country']])}}<br>
											      </td>
												  <td>
											      {{strtoupper($cname)}}<br>
											      {{strtoupper($sd['address_1'])}}<br>
											      @if($pd['address_2'] != ""){{strtoupper($sd['address_2'])}}<br>@endif
											      {{strtoupper($sd['city'])." ".$sd['zip']}}<br>
											      {{strtoupper($sd['region'])}}<br>
											      {{ucwords($countries[$sd['country']])}}<br>
											      </td>											  
											   </tr>
											  <?php
											  
											  ?>
									    	  </tbody>
					</table>
				</div>
				<div class="table-responsive mb-5">
				   <table class="table table-striped table-bordered first etuk-table">
                                              <thead>
                                                <tr>
                                                  <th>Product</th>
                                                  <th>Model</th>
												  <th>Quantity</th>
                                                  <th>Unit price</th>
                                                  <th>Total</th>
                                                </tr>
                                              </thead>
                                              <tbody id="order-products-2">
										        <?php
												
												?>
												 
												<?php
												
												?>
									    	  </tbody>
											 </table>
				</div>
           </div>
		</div>
	  </div>
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
	   <h3 class="mb-2"><i class="fas fa-comment-o"></i> Order History</h3>
                            <div class="tab-vertical">
                                <ul class="nav nav-tabs" id="myTab3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="true">History</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="additional-tab" data-toggle="tab" href="#additional" role="tab" aria-controls="additional" aria-selected="false">Additional</a>
                                    </li>
                                   
									
                                </ul>
                                <div class="tab-content" id="myTabContent3">
                                    <div class="tab-pane active show" id="history" role="tabpanel" aria-labelledby="history-tab">
                                      <h5 class="card-header">History</h5>
                                       <div class="card-body">
									   <form method="post" action="{{url('add-order-history')}}" id="order-history-form">
										   {!! csrf_field() !!}
										   <input type="hidden" id="order-history-xf" name="xf" value="{{$o['id']}}">
									    <div class="row">
										  <div class="col-md-12">
											<div class="mt-5">
                                             <table class="table table-striped table-bordered first etuk-table">
                                              <thead>
                                                <tr>
                                                  <th>Date added</th>
                                                  <th>Comment</th>
												  <th>Status</th>
                                                  <th>Customer Notified?</th>
                                                </tr>
                                              </thead>
                                              <tbody>
										      <?php
											    foreach($o['history'] as $t)
												{
													$ts = $statuses[$t['status']];
											  ?>
											   <tr>
											     <td>{{$t['date']}}</td>
											     <td>{{$t['comment']}}</td>
											     <td>{{strtoupper($ts)}}</td>
											     <td>{{$t['notify_customer']}}</td>
											   </tr>
											  <?php
												}
											  ?>
									    	  </tbody>
											 </table>
										     </div>
											 <div class="row mt-5">
											   <div class="col-md-12">
											     <div class="form-group">
                                                   <label>Order Status<span class="req">*</span></label>
                                                   <select id="order-history-status" name="status" class="form-control">
												   <option value="none">Select order status</option>
													<?php											      
												        foreach($statuses as $k => $v)
												        {
												      ?>
											          <option value="{{$k}}">{{ucwords($v)}}</option>
												      <?php
												        }
												       ?>
											       </select>
                                                 </div>
											   </div>
											   <div class="col-md-12">
											     <div class="form-group">
                                                   <label>Notify Customer?<span class="req">*</span></label>
                                                   <select id="order-history-notify-customer" name="nc" class="form-control">
												   <option value="none">Notify customer?</option>
												   <option value="yes">Yes</option>
												   <option value="no" selected='selected'>No</option>
											       </select>
                                                 </div>
											   </div>
											   <div class="col-md-12">
											     <div class="form-group">
                                                   <label>Comment </label>
                                                   <textarea id="order-history-comment" name="comment" rows="8" placeholder="Comment" class="form-control"></textarea>
                                                 </div>
											   </div>
											   <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="order-history-submit"><i class="fas fa-plus"></i> Submit</button>
                                                </p>
                                               </div>
											 </div>
										   </div>
										  </div>
										  </form>
                                       </div>
                                    </div>
									<div class="tab-pane fade" id="additional" role="tabpanel" aria-labelledby="additional-tab">
                                       <h5 class="card-header">Additional</h5>
                                       <div class="card-body">
									   
									    <div class="row">
										  <div class="col-md-12">
										   <div class="row">
										    <div class="col-md-6">
										      <div class="form-group">
                                                <label>First Name <span class="req">*</span></label>
                                                <input id="order-payment-fname" type="text" value="{{$pd['fname']}}" placeholder="First name" class="form-control">
                                              </div>
                                            </div>
											<div class="col-md-6">
											  <div class="form-group mt-2">
                                                 <label>Last Name <span class="req">*</span></label>
                                                 <input id="order-payment-lname" type="text" value="{{$pd['lname']}}" placeholder="Last name" class="form-control">
                                              </div>
											</div>
										   </div>
											<div class="form-group mt-2">
                                              <label>Company </label>
                                               <input id="order-payment-company" type="text" value="{{$pd['company']}}" placeholder="Company" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Address 1 <span class="req">*</span></label>
                                               <input id="order-payment-address-1" type="text" value="{{$pd['address_1']}}" placeholder="Address line 1" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Address 2</label>
                                               <input id="order-payment-address-2" type="text" value="{{$pd['address_2']}}" placeholder="Address line 2" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>City <span class="req">*</span></label>
                                               <input id="order-payment-city" type="text" value="{{$pd['city']}}" placeholder="City" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Region/State <span class="req">*</span></label>
                                               <input id="order-payment-region" type="text" value="{{$pd['region']}}" placeholder="Region or state" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Postcode</label>
                                               <input id="order-payment-postcode" type="text" value="{{$pd['zip']}}" placeholder="Postcode" class="form-control">
                                            </div>
											
											<div class="form-group mt-2">
                                               <label>Country <span class="req">*</span></label>
                                               <select id="order-payment-country" class="form-control">
											    <option value="none">Select country</option>
											    <?php
											      foreach($countries as $k => $v)
												  {
													  $ss = $k == $pd['country'] ? " selected='selected'" : "";
												  ?>
											     <option value="{{$k}}"{{$ss}}>{{ucwords($v)}}</option>
												 <?php
												  }
												 ?>
											   </select>
                                            </div>
										  </div>
										</div>
                                        
                                       </div>
                                    </div>
                                </div>
                                    
                                </div>
                            </div>
      </div>
@stop