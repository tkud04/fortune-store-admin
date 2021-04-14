<?php
$title = "Invoice";
$blank = true;
?>



<?php $__env->startSection('title',$title); ?>


<?php $__env->startSection('content'); ?>
<script>
let orderProducts = [], products = [],
	shipping = {
		id: "<?php echo e($shipping['id']); ?>",
		name: "<?php echo e($shipping['name']); ?>",
		value: "<?php echo e($shipping['value']); ?>",
	};

	 <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	  products.push({
		  id: "<?php echo e($p['id']); ?>", 
		  name: "<?php echo e($p['name']); ?>", 
		  model: "<?php echo e($p['model']); ?>", 
		  qty: "<?php echo e($p['qty']); ?>", 
		  amount: "<?php echo e($p['data']['amount']); ?>"
		  });
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

$(document).ready(() => {
 
 <?php $__currentLoopData = $o['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	  orderProducts.push({p: <?php echo e($i['product_id']); ?>, q: <?php echo e($i['qty']); ?>});
	  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	  
	 refreshProducts({type: "review", target: "#order-products-2", t: 'order'});
});
</script>
<?php
$pd = $o['pd'];
$sd = $o['sd'];
$customer = $o['user'];
$cname = $customer['fname']." ".$customer['lname'];

$payment_method = "Credit Card/Debit Card";
$shipping_method = $shipping['name']." - &#8358;".number_format($shipping['value'],2);
?>
<div class="row">
                        <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header p-4">
                                     <a class="pt-2 d-inline-block" href="javascript:void(0)">Invoice</a>
                                   
                                    <div class="float-right"> <h3 class="mb-0">Order #<?php echo e($o['reference']); ?></h3>
                                    Date: <?php echo e($o['date']); ?></div>
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
													  <h3 class="text-dark mb-1">Luxfabriqs Fashion</h3>                                            
                                                      <div>Ikeja, Lagos 10001 NG</div><br><br>
                                                      <div>Email: info@luxfabriqs.com</div>
                                                      <div>Phone: +614-837-8483</div>
                                                      <div>Website: <a href="javascript:void(0)">http://luxfabriqs.com</a></div>
													</td>
													<td class="center">                                       
                                                      <div><span class="text-dark mr-5">Date added</span> <?php echo e($o['date']); ?></div>
                                                      <div><span class="text-dark mr-5">Order ID</span> <?php echo e($o['reference']); ?></div>
                                                      <div><span class="text-dark mr-5">Payment method</span> <?php echo e($payment_method); ?></div>
                                                      <div><span class="text-dark mr-5">Shipping method</span>  <?php echo $shipping_method; ?></div>
													</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
									<div class="table-responsive-sm mb-5">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                  
                                                   <th>Shipping Address</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    
													<td>
													  <div><?php echo e(strtoupper($sd['fname']." ".$sd['lname'])); ?></div>
													  <div><?php echo e(strtoupper($sd['address_1'])); ?></div>
													  <?php if($sd['address_2'] != ""): ?> <div><?php echo e(strtoupper($sd['address_2'])); ?></div><?php endif; ?>
													  <div><?php echo e(strtoupper($sd['city']." ".$sd['zip'])); ?></div>
													  <div><?php echo e(ucwords($sd['region'])); ?></div>
													  <div><?php echo e(ucwords($countries[$sd['country']])); ?></div>
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
                                                  <th>SKU</th>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\fortune-store-admin\resources\views/invoice.blade.php ENDPATH**/ ?>