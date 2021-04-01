<?php
$title = "Add Order";
$subtitle = "Add an order.";
?>



<?php $__env->startSection('title',$title); ?>


<?php $__env->startSection('page-header'); ?>
<?php echo $__env->make('page-header',['title' => $title,'subtitle' => $subtitle], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<script>
let xf = "", products = [], pCover = "none", tkAddOrder = "<?php echo e(csrf_token()); ?>",
    orderProducts = [], aoPaymentXF = "new", aoShippingXF = "new";

$(document).ready(() => {
	hideElem(["#ao-loading"]);
	
	 <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	  products.push({
		  id: "<?php echo e($p['id']); ?>", 
		  name: "<?php echo e($p['name']); ?>", 
		  model: "<?php echo e($p['model']); ?>", 
		  qty: "<?php echo e($p['qty']); ?>", 
		  amount: "<?php echo e($p['data']['amount']); ?>"
		  });
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
});
</script>
<div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3">
	    <div class="text-left" >
		  <h4 id="ao-loading">Processing.. <img src="<?php echo e(asset('images/loading.gif')); ?>" class="img img-fluid" alt="Processing.."></h4>
		</div>
		<div class="text-right" id="ao-submit">
	      <a href="javascript:void(0)" id="add-order-submit" class="btn btn-primary"><i class="fas fa-save"></i></a>
	      <a href="<?php echo e(url('orders')); ?>" class="btn btn-danger"><i class="fas fa-reply"></i></a>
	    </div>
	    
	  </div>
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="tab-vertical">
                                <ul class="nav nav-tabs" id="myTab3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">Payment Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="shipping-tab" data-toggle="tab" href="#shipping" role="tab" aria-controls="shipping" aria-selected="false">Shipping</a>
                                    </li>
									<li class="nav-item">
                                        <a class="nav-link" id="totals-tab" data-toggle="tab" href="#totals" role="tab" aria-controls="totals" aria-selected="false">Totals</a>
                                    </li>
									
                                </ul>
                                <div class="tab-content" id="myTabContent3">
                                    <div class="tab-pane active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                                      <h5 class="card-header">General</h5>
                                       <div class="card-body">
									   
									    <div class="row">
										  <div class="col-md-12">
										    <div class="form-group">
                                              <label>Customer <span class="req">*</span></label>
                                              <select id="add-order-customer" class="form-control">
											    <option value="none">Select customer</option>
												<?php											      
												  foreach($customers as $c)
												  {
												 ?>
											     <option value="<?php echo e($c['id']); ?>"><?php echo e($c['fname']." ".$c['lname']); ?></option>
												 <?php
												  }
												 ?>
											   </select>
                                            </div>
											<div class="mt-5">
                                             <table class="table table-striped table-bordered first etuk-table">
                                              <thead>
                                                <tr>
                                                  <th>Product</th>
                                                  <th>Model</th>
												  <th>Quantity</th>
                                                  <th>Unit price</th>
                                                  <th>Total</th>
                                                  <th>Action</th>
                                                </tr>
                                              </thead>
                                              <tbody id="add-order-products">
										      
									    	  </tbody>
											 </table>
										     </div>
											 <div class="row mt-5">
											   <div class="col-md-6">
											     <div class="form-group">
                                                   <label>Product <span class="req">*</span></label>
                                                   <input id="add-order-product" type="text" placeholder="Select product" class="form-control" list="add-order-product-list">
												   <datalist id="add-order-product-list"> 
													<?php											      
												        foreach($products as $p)
												        {
												      ?>
											          <option value="<?php echo e($p['id']); ?>"><?php echo e(ucwords($p['name'])); ?></option>
												      <?php
												        }
												       ?>
											       </datalist>
                                                 </div>
											   </div>
											   <div class="col-md-6">
											     <div class="form-group">
                                                   <label>Quantity <span class="req">*</span></label>
                                                   <input id="add-order-qty" type="number" placeholder="Quantity" class="form-control">
                                                 </div>
											   </div>
											   <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="add-order-product-submit"><i class="fas fa-plus"></i> Add</button>
                                                </p>
                                               </div>
											 </div>
										   </div>
										  </div>
                                       </div>
                                    </div>
									<div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                                       <h5 class="card-header">Payment Details</h5>
                                       <div class="card-body">
									   
									    <div class="row">
										  <div class="col-md-12">
										   <div class="row">
										    <div class="col-md-6">
										      <div class="form-group">
                                                <label>First Name <span class="req">*</span></label>
                                                <input id="add-order-payment-fname" type="text" placeholder="First name" class="form-control">
                                              </div>
                                            </div>
											<div class="col-md-6">
											  <div class="form-group mt-2">
                                                 <label>Last Name <span class="req">*</span></label>
                                                 <input id="add-order-payment-lname" type="text" placeholder="Last name" class="form-control">
                                              </div>
											</div>
										   </div>
											<div class="form-group mt-2">
                                              <label>Company </label>
                                               <input id="add-order-payment-company" type="text" placeholder="Company" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Address 1 <span class="req">*</span></label>
                                               <input id="add-order-payment-address-1" type="text" placeholder="Address line 1" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Address 2</label>
                                               <input id="add-order-payment-address-2" type="text" placeholder="Address line 2" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>City <span class="req">*</span></label>
                                               <input id="add-order-payment-city" type="text" placeholder="City" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Region/State <span class="req">*</span></label>
                                               <input id="add-order-payment-region" type="text" placeholder="Region or state" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Postcode</label>
                                               <input id="add-order-payment-postcode" type="text" placeholder="Postcode" class="form-control">
                                            </div>
											
											<div class="form-group mt-2">
                                               <label>Country <span class="req">*</span></label>
                                               <select id="add-order-payment-country" class="form-control">
											    <option value="none">Select country</option>
											    <?php
											      foreach($countries as $k => $v)
												  {
												  ?>
											     <option value="<?php echo e($k); ?>"><?php echo e(ucwords($v)); ?></option>
												 <?php
												  }
												 ?>
											   </select>
                                            </div>
										  </div>
										</div>
                                        
                                       </div>
                                    </div>
                                    <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                                        <h5 class="card-header">Shipping Details</h5>
                                       <div class="card-body">
									   
									    <div class="row">
										  <div class="col-md-12">
										   <div class="row">
										    <div class="col-md-6">
										      <div class="form-group">
                                                <label>First Name <span class="req">*</span></label>
                                                <input id="add-order-shipping-fname" type="text" placeholder="First name" class="form-control">
                                              </div>
                                            </div>
											<div class="col-md-6">
											  <div class="form-group mt-2">
                                                 <label>Last Name <span class="req">*</span></label>
                                                 <input id="add-order-shipping-lname" type="text" placeholder="Last name" class="form-control">
                                              </div>
											</div>
										   </div>
											<div class="form-group mt-2">
                                              <label>Company </label>
                                               <input id="add-order-shipping-company" type="text" placeholder="Company" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Address 1 <span class="req">*</span></label>
                                               <input id="add-order-shipping-address-1" type="text" placeholder="Address line 1" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Address 2</label>
                                               <input id="add-order-shipping-address-2" type="text" placeholder="Address line 2" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>City <span class="req">*</span></label>
                                               <input id="add-order-shipping-city" type="text" placeholder="City" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Region/State <span class="req">*</span></label>
                                               <input id="add-order-shipping-region" type="text" placeholder="Region or state" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                                <label>Postcode</label>
                                               <input id="add-order-shipping-postcode" type="text" placeholder="Postcode" class="form-control">
                                            </div>
											
											<div class="form-group mt-2">
                                               <label>Country <span class="req">*</span></label>
                                               <select id="add-order-shipping-country" class="form-control">
											    <option value="none">Select country</option>
											    <?php
											      foreach($countries as $k => $v)
												  {
												  ?>
											     <option value="<?php echo e($k); ?>"><?php echo e(ucwords($v)); ?></option>
												 <?php
												  }
												 ?>
											   </select>
                                            </div>
										  </div>
										</div>
                                        
                                       </div>
                                    </div>
									<div class="tab-pane fade" id="totals" role="tabpanel" aria-labelledby="totals-tab">
                                        <h5 class="card-header">Totals</h5>
                                       <div class="card-body">
									   
									    <div class="row">
										  <div class="col-md-12">
										   <div class="mt-5 mb-5">
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
                                              <tbody id="add-order-products-review">
										      
									    	  </tbody>
											 </table>
										     </div>
											 <div class="form-group mt-2">
                                               <label>Payment type <span class="req">*</span></label>
                                               <select id="add-order-payment-type" class="form-control">
											     <option value="none">Select payment type</option>
											     <option value="card" selected="selected">Credit/debit card</option>
											   </select>
                                            </div>
											<div class="form-group mt-2">
                                               <label>Shipping type <span class="req">*</span></label>
                                               <select id="add-order-shipping-type" class="form-control">
											     <option value="none">Select shipping type</option>
											     <option value="free" selected="selected">Free shipping</option>
											   </select>
                                            </div>
											<div class="form-group mt-2">
                                                <label>Comment</label>
                                               <textarea rows="8" id="add-order-comment" type="text" placeholder="Comment" class="form-control"></textarea>
                                            </div>
											<div class="form-group mt-2">
                                               <label>Status <span class="req">*</span></label>
                                               <select id="add-order-status" class="form-control">											   
											     <option value="none">Select status</option>
											     <?php
												   foreach($statuses as $k => $v)
												   {
													 $ss = $k == "processing" ? " selected='selected'" : "";   
												 ?>
												  <option value="<?php echo e($k); ?>"<?php echo e($ss); ?>><?php echo e($v); ?></option>
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
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\chstore-admin\resources\views/add-order.blade.php ENDPATH**/ ?>