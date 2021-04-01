<?php
$title = "Order #".$o['reference'];
$subtitle = "View information on this order.";
?>



<?php $__env->startSection('title',$title); ?>


<?php $__env->startSection('page-header'); ?>
<?php echo $__env->make('page-header',['title' => $title,'subtitle' => $subtitle], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<script>
let xf = "", products = [], pCover = "none", tkOrderHistory = "<?php echo e(csrf_token()); ?>",
    orderProducts = [], eoPaymentXF = "new", eoShippingXF = "new";

  

$(document).ready(() => {
	hideElem(["#eo-loading"]);
	
	 <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	  products.push({
		  id: "<?php echo e($p['id']); ?>", 
		  name: "<?php echo e($p['name']); ?>", 
		  model: "<?php echo e($p['model']); ?>", 
		  qty: "<?php echo e($p['qty']); ?>", 
		  amount: "<?php echo e($p['data']['amount']); ?>"
		  });
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 
 <?php $__currentLoopData = $o['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	  orderProducts.push({p: <?php echo e($i['product_id']); ?>, q: <?php echo e($i['qty']); ?>});
	  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	  
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
	      <a href="<?php echo e($pu); ?>" target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Print Invoice"><i class="fas fa-print"></i></a>
	      <a href="<?php echo e($su); ?>" target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Print Shipping List"><i class="fas fa-truck"></i></a>
	      <a href="<?php echo e($eu); ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fas fa-edit"></i></a>
	      <a href="<?php echo e(url('orders')); ?>" class="btn btn-primary"><i class="fas fa-reply"></i></a>
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
				  <?php echo e($o['date']); ?>

				</li>
				<li class="list-group-item">
				  <span class="badge badge-primary p-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Payment method"><i class="fas fa-credit-card"></i> </span>
				  <?php echo e($payment_method); ?>

				</li>
				<li class="list-group-item">
				  <span class="badge badge-primary p-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Shipping method"><i class="fas fa-truck"></i> </span>
				  <?php echo e($shipping_method); ?>

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
				  <?php echo e(ucwords($cname)); ?>

				</li>
				<li class="list-group-item">
				  <span class="badge badge-primary p-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Customer email"><i class="fas fa-envelope"></i> </span>
				  <?php echo e(ucwords($customer['email'])); ?>

				</li>
				<li class="list-group-item">
				  <span class="badge badge-primary p-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Customer phone number"><i class="fas fa-phone"></i> </span>
				  <?php echo e(ucwords($customer['phone'])); ?>

				</li>
           </ul>
        </div>
	  </div>
	  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12  col-6 mb-3">
	    <div class="card">
           <div class="card-body">
                <h3 class="card-title"><i class="fas fa-user"></i> Order #<?php echo e($o['reference']); ?></h3>
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
											      <?php echo e(strtoupper($cname)); ?><br>
											      <?php echo e(strtoupper($pd['address_1'])); ?><br>
											      <?php if($pd['address_2'] != ""): ?><?php echo e(strtoupper($pd['address_2'])); ?><br><?php endif; ?>
											      <?php echo e(strtoupper($pd['city'])." ".$pd['zip']); ?><br>
											      <?php echo e(strtoupper($pd['region'])); ?><br>
											      <?php echo e(ucwords($countries[$pd['country']])); ?><br>
											      </td>
												  <td>
											      <?php echo e(strtoupper($cname)); ?><br>
											      <?php echo e(strtoupper($sd['address_1'])); ?><br>
											      <?php if($pd['address_2'] != ""): ?><?php echo e(strtoupper($sd['address_2'])); ?><br><?php endif; ?>
											      <?php echo e(strtoupper($sd['city'])." ".$sd['zip']); ?><br>
											      <?php echo e(strtoupper($sd['region'])); ?><br>
											      <?php echo e(ucwords($countries[$sd['country']])); ?><br>
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
									   <form method="post" action="<?php echo e(url('add-order-history')); ?>" id="order-history-form">
										   <?php echo csrf_field(); ?>

										   <input type="hidden" id="order-history-xf" name="xf" value="<?php echo e($o['id']); ?>">
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
											     <td><?php echo e($t['date']); ?></td>
											     <td><?php echo e($t['comment']); ?></td>
											     <td><?php echo e(strtoupper($ts)); ?></td>
											     <td><?php echo e($t['notify_customer']); ?></td>
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
											          <option value="<?php echo e($k); ?>"><?php echo e(ucwords($v)); ?></option>
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
                                                <input id="order-payment-fname" type="text" value="<?php echo e($pd['fname']); ?>" placeholder="First name" class="form-control">
                                              </div>
                                            </div>
											<div class="col-md-6">
											  <div class="form-group mt-2">
                                                 <label>Last Name <span class="req">*</span></label>
                                                 <input id="order-payment-lname" type="text" value="<?php echo e($pd['lname']); ?>" placeholder="Last name" class="form-control">
                                              </div>
											</div>
										   </div>
											<div class="form-group mt-2">
                                              <label>Company </label>
                                               <input id="order-payment-company" type="text" value="<?php echo e($pd['company']); ?>" placeholder="Company" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Address 1 <span class="req">*</span></label>
                                               <input id="order-payment-address-1" type="text" value="<?php echo e($pd['address_1']); ?>" placeholder="Address line 1" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Address 2</label>
                                               <input id="order-payment-address-2" type="text" value="<?php echo e($pd['address_2']); ?>" placeholder="Address line 2" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>City <span class="req">*</span></label>
                                               <input id="order-payment-city" type="text" value="<?php echo e($pd['city']); ?>" placeholder="City" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Region/State <span class="req">*</span></label>
                                               <input id="order-payment-region" type="text" value="<?php echo e($pd['region']); ?>" placeholder="Region or state" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Postcode</label>
                                               <input id="order-payment-postcode" type="text" value="<?php echo e($pd['zip']); ?>" placeholder="Postcode" class="form-control">
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
											     <option value="<?php echo e($k); ?>"<?php echo e($ss); ?>><?php echo e(ucwords($v)); ?></option>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\chstore-admin\resources\views/order.blade.php ENDPATH**/ ?>