<?php
$title = "Invoice";
$blank = true;
?>

@extends('layout')

@section('title',$title)


@section('content')
<script>
let orderProducts = [], products = [];

	 @foreach($products as $p)
	  products.push({
		  id: "{{$p['id']}}", 
		  name: "{{$p['name']}}", 
		  model: "{{$p['model']}}", 
		  qty: "{{$p['qty']}}", 
		  amount: "{{$p['data']['amount']}}"
		  });
 @endforeach

$(document).ready(() => {
 
 @foreach($o['items'] as $i)
	  orderProducts.push({p: {{$i['product_id']}}, q: {{$i['qty']}}});
	  @endforeach
	  
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
?>
<div class="row">
                        <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header p-4">
                                     <a class="pt-2 d-inline-block" href="javascript:void(0)">Invoice</a>
                                   
                                    <div class="float-right"> <h3 class="mb-0">Order #{{$o['reference']}}</h3>
                                    Date: {{$o['date']}}</div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive-sm mb-5">
									
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Order Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="center">
													  <h3 class="text-dark mb-1">Mobile Buzz</h3>                                            
                                                      <div>478 Collins Avenue</div>
                                                      <div>Canal Winchester, OH 43110</div><br><br>
                                                      <div>Email: info@mobilebuzz.co.uk</div>
                                                      <div>Phone: +614-837-8483</div>
                                                      <div>Website: <a href="http://localhost:8000">http://localhost:8000</a></div>
													</td>
													<td class="center">                                       
                                                      <div><span class="text-dark mr-5">Date added</span> {{$o['date']}}</div>
                                                      <div><span class="text-dark mr-5">Order ID</span> {{$o['reference']}}</div>
                                                      <div><span class="text-dark mr-5">Payment method</span> {{$payment_method}}</div>
                                                      <div><span class="text-dark mr-5">Shipping method</span> {{$shipping_method}}</div>
													</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
									<div class="table-responsive-sm mb-5">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                   
                                                    <th>Payment Address</th>
                                                    <th>Shipping Address</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
													  <div>{{strtoupper($pd['fname']." ".$pd['lname'])}}</div>
													  <div>{{strtoupper($pd['address_1'])}}</div>
													  @if($pd['address_2'] != "") <div>{{strtoupper($pd['address_2'])}}</div>@endif
													  <div>{{strtoupper($pd['city']." ".$pd['zip'])}}</div>
													  <div>{{ucwords($pd['region'])}}</div>
													  <div>{{ucwords($countries[$pd['country']])}}</div>
													</td>
													<td>
													  <div>{{strtoupper($sd['fname']." ".$sd['lname'])}}</div>
													  <div>{{strtoupper($sd['address_1'])}}</div>
													  @if($sd['address_2'] != "") <div>{{strtoupper($sd['address_2'])}}</div>@endif
													  <div>{{strtoupper($sd['city']." ".$sd['zip'])}}</div>
													  <div>{{ucwords($sd['region'])}}</div>
													  <div>{{ucwords($countries[$sd['country']])}}</div>
													</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
									<div class="table-responsive-sm mb-5">
                                        <table class="table table-striped">
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
                    </div>
@stop