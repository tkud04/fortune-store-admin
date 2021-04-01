<?php
$title = "Orders";
$subtitle = "View all orders";
?>



<?php $__env->startSection('title',$title); ?>

<?php $__env->startSection('scripts'); ?>
  <!-- DataTables CSS -->
  <link href="<?php echo e(asset('lib/datatables/css/buttons.bootstrap.min.css')); ?>" rel="stylesheet" /> 
  <link href="<?php echo e(asset('lib/datatables/css/buttons.dataTables.min.css')); ?>" rel="stylesheet" /> 
  <link href="<?php echo e(asset('lib/datatables/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet" /> 
  
      <!-- DataTables js -->
       <script src="<?php echo e(asset('lib/datatables/js/datatables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js')); ?>"></script>
    <script src="<?php echo e(asset('lib/datatables/js/datatables-init.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
<?php echo $__env->make('page-header',['title' => $title,'subtitle' => $subtitle], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Orders<a class="btn btn-primary ml-3" href="<?php echo e(url('add-order')); ?>">Add Order</a></h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Customer</th>
												<th>Status</th>
                                                <th>Total</th>
                                                <th>Date added</th>
                                                <th>Date modified</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  <?php
										  
										   if(count($orders) > 0)
										   {
											  foreach($orders as $o)
											   {
												   
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
												 <a class="btn btn-info btn-sm" href="<?php echo e($arr); ?>">Edit</a>
												 <a class="btn btn-danger btn-sm" href="<?php echo e($dr); ?>">Remove</a>
												 </td>
                                            </tr>
									     <?php
											   }
										   }
										 ?>
									   </tbody>
									</table>
							    </div>
							 </div>
						</div>
                    </div>
                </div>			
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\chstore-admin\resources\views/orders.blade.php ENDPATH**/ ?>