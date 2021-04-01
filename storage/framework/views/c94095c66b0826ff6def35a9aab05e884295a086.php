<?php
$title = "Dashboard";
$subtitle = "Admin dashboard";

$rbrcData = $stats['rbrcData'];
$trmData = $stats['trmData'];
$trmData2 = $stats['trmData2'];

?>



<?php $__env->startSection('scripts'); ?>
<link href="<?php echo e(asset('lib/morris-bundle/morris.css')); ?>" rel="stylesheet">
<script src="<?php echo e(asset('lib/morris-bundle/raphael.min.js')); ?>"></script>
<script src="<?php echo e(asset('lib/morris-bundle/morris.js')); ?>"></script>
<script src="<?php echo e(asset('lib/morris-bundle/morris-init.js')); ?>"></script>
<script>
let rbrcData = [
<?php

 $opts4 = [
								'studio' => "Studio",
												    '1bed' => "1 bedroom",
												    '2bed' => "2 bedrooms",
												    '3bed' => "3 bedrooms",
												    'penthouse' => "Penthouse apartment",
					  ];

foreach($rbrcData as $k => $v)
{
?>
{value: <?php echo e($v); ?>, label: "<?php echo e($opts4[$k]); ?>"},
<?php
}
?>
];

let trmData = [

<?php

$ctr = 0;

foreach($trmData as $k => $v)
{
?>
{x: "<?php echo e($k); ?>", y: <?php echo e($v); ?>,}<?php if($ctr < count($trmData)): ?>,<?php endif; ?>
<?php
++$ctr;
}
?>
        ];
		
console.log(trmData);
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title',$title); ?>
<?php $__env->startSection('content'); ?>
 <div class="ecommerce-widget">

                        <div class="row">
						<?php
						 //total products
						 $tp = $stats['total_sales'];
						 if($tp == 0)
						 {
							 $tpp = 0;
						 }
						 else
						 {
							 $tpp = (($tp - 2) / $tp) * 100;
						     $toClass = "text-success";
						     $tpIcon = "<span><i class='fa fa-fw fa-arrow-up'></i></span>";
						 }
						 
						 
						 if($tpp < 0)
						 {
							 $toClass = "text-secondary";
							 $tpIcon = "<span><i class='fa fa-fw fa-arrow-down'></i></span>";
						 }
						 else if($tpp == 0)
						 {
							 $toClass = "text-primary";
							 $tpIcon = "";
						 }
						 
						 //total orders
						 $to = $stats['total_orders'];
						 $top = 0;
						 $toClass = "text-success";
						 $toIcon = "<span><i class='fa fa-fw fa-arrow-up'></i></span>";
						 
						 if($top < 0)
						 {
							 $toClass = "text-secondary";
							 $toIcon = "<span><i class='fa fa-fw fa-arrow-down'></i></span>";
						 }
						 else if($top == 0)
						 {
							 $toClass = "text-primary";
							 $toIcon = "";
						 }
						 
						 //total users
						 $tu = $stats['total_users'];
						 $tup = 0;
						 $tuClass = "text-success";
						 $tuIcon = "<span><i class='fa fa-fw fa-arrow-up'></i></span>";
						 
						 if($tup < 0)
						 {
							 $tuClass = "text-secondary";
							 $tuIcon = "<span><i class='fa fa-fw fa-arrow-down'></i></span>";
						 }
						 else if($tup == 0)
						 {
							 $tuClass = "text-primary";
							 $tuIcon = "";
						 }
						?>
                           
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Total Orders</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1"><?php echo e($to); ?></h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right <?php echo e($toClass); ?> font-weight-bold">
                                            <?php echo $toIcon; ?><span><?php echo e($top); ?>%</span>
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue3"></div>
                                </div>
                            </div>
							 <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Total Sales</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1">&#0163;<?php echo e(number_format($tp,2)); ?></h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right <?php echo e($toClass); ?> font-weight-bold">
										<?php echo $tpIcon; ?><span><?php echo e(ceil($tpp)); ?>%</span>
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue"></div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Total Customers</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1"><?php echo e($tu); ?></h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right <?php echo e($tuClass); ?> font-weight-bold">
                                            <?php echo $tuIcon; ?><span><?php echo e($tup); ?>%</span>
                                        </div>
                                    </div>
                                    <div id="sparkline-revenue4"></div>
                                </div>
                            </div>
                        </div>
                        
                            <!-- ============================================================== -->
                      
                            <!-- ============================================================== -->

                                          <!-- recent orders  -->
                            <!-- ============================================================== -->
                            <div class="row">
							<div class="col-xl-9 col-lg-12 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Latest Orders</h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0">Order ID</th>
                                                        <th class="border-0">Customer</th>
												        <th class="border-0">Status</th>
                                                        <th class="border-0">Total</th>
                                                        <th class="border-0">Date added</th>
                                                        <th class="border-0">Date modified</th>
                                                        <th class="border-0">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
												
									   <?php
										  
										   if(count($orders) > 0)
										   {
											    $ordersLength = count($orders) > 5 ? 5 : count($orders);
											  for($i = 0; $i < $ordersLength; $i++)
											   {
												   $o = $orders[$i];
												 $customer = $o['user'];
											   $totals = $o['totals'];
											   $uu = url('order')."?xf=".$o['id'];
											   $sss = $o['status'];
												
												   $arr = url('order')."?xf=".$o['id']."&type=edit";
												   $dr = url('remove-order')."?xf=".$o['id'];
												   #$ar = $a['rating'];
												   $ar = 3;
										  ?>
                                            <tr>
                                               <td><a href="<?php echo e($uu); ?>"><h4><?php echo e($o['reference']); ?></a></td> 
											   <td><?php echo e(ucwords($customer['fname']." ".$customer['lname'])); ?></td> 
												<td><?php echo e(strtoupper($o['status'])); ?></h4></td>	
                                                <td>&#163;<?php echo e(number_format($totals['subtotal'],2)); ?></td>
												<td><?php echo e($o['date']); ?></td>
												<td><?php echo e($o['updated']); ?></td>
                                                <td>
												 <a class="btn btn-info btn-sm" href="<?php echo e($uu); ?>">View</a>
												 </td>
                                            </tr>
									     <?php
											   }
										   }
										 ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end recent orders  -->		
							
							<div class="col-xl-3 col-lg-12 col-md-6 col-sm-12 col-12">
                                <!-- ============================================================== -->
                                <!-- top perfomimg  -->
                                <!-- ============================================================== -->
                                <div class="card">
                                    <h5 class="card-header">Top Performing Products</h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table no-wrap p-table">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0">Product</th>
                                                        <th class="border-0">Revenue</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
												<?php
												if(count($tph) > 0)
												{
													$tphLength = count($tph) > 5 ? 5 : count($tph);
													for($i = 0; $i < $tphLength; $i++)
													{
														$t = $tph[$i];
													
												?>
                                                    <tr>
                                                        <td><?php echo e($t['name']); ?></td>
                                                        <td><?php echo e($t['apartments']); ?></td>
                                                        <td>&#8358;<?php echo e(number_format($t['revenue'],2)); ?></td>
                                                    </tr>
												<?php
													}
												}
												?>
                                                    <tr>
                                                        <td colspan="3">
                                                            <a href="<?php echo e(url('tph')); ?>" class="btn btn-outline-light float-right">View more</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- ============================================================== -->
                                <!-- end top perfomimg  -->
                                <!-- ============================================================== -->
								
								<!-- ============================================================== -->
                                <!-- categories  -->
                                <!-- ============================================================== -->
                                <div class="card">
                                    <h5 class="card-header">Top Performing categories</h5>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table no-wrap p-table">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0">Name</th>
                                                        <th class="border-0">Sales</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
												<?php
												if(count($plans) > 0)
												{
													$pLength = count($plans) > 5 ? 5 : count($plans);
													for($i = 0; $i < $pLength; $i++)
													{
														$p = $plans[$i];
													
												?>
                                                    <tr>
                                                        <td><?php echo e($p['name']); ?></td>
                                                        <td>&#8358;<?php echo e(number_format($p['amount'],2)); ?>/<?php echo e($p['frequency']); ?></td>
                                                    </tr>
												<?php
													}
												}
												?>
                                                    <tr>
                                                        <td colspan="3">
                                                            <a href="<?php echo e(url('plans')); ?>" class="btn btn-outline-light float-right">View more</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- ============================================================== -->
                                <!-- end subscription plans  -->
                                <!-- ============================================================== -->
								
								
							</div>
							</div>
							
							<div class="row">
                            <!-- ============================================================== -->
                            <!-- total revenue  -->
                            <!-- ============================================================== -->
  
                            
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- category revenue  -->
                            <!-- ============================================================== -->
                            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Revenue Category</h5>
                                    <div class="card-body">
                                        <div id="revenue_by_room_category" style="height: 420px;"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end category revenue  -->
                            <!-- ============================================================== -->

                            <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header"> Total Revenue</h5>
                                    <div class="card-body">
                                        <div id="total_revenue_month"></div>
                                    </div>
                                    <div class="card-footer">
                                        <!--<p class="display-7 font-weight-bold"><span class="text-primary d-inline-block">&#8358;26,000</span><span class="text-success float-right">+9.45%</span></p>-->
                                    </div>
                                </div>
                            </div>
                        </div>
							
							</div>
							
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\chstore-admin\resources\views/index.blade.php ENDPATH**/ ?>