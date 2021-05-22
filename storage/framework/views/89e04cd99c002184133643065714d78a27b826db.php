<?php
$title = "Discounts";
$subtitle = "View all product discounts";
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
					<a href="<?php echo e(url('new-discount')); ?>" class="btn btn-outline-secondary">Add discount</a>
                        <div class="card">
                            <h5 class="card-header">Discounts</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                 <th>Product</th>
                                                 <th>Discount type</th>
                                                 <th>Amount</th>
                                                 <th>Status</th>
                                                 <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  <?php
										   if(count($discounts) > 0)
										   {
											  foreach($discounts as $d)
											   {
												   $p = $d['product'];
												   $name = $p['name'];
											    	$pid = $p['id'];
									      	       $imgs = $p['imggs'];
												   $ss = $d['status'] == "enabled" ? "text-success" : "text-danger";
												    $dt = ['flat' => "Flat",'percentage' => "Percentage"];
													$ru = url('remove-discount')."?xf=".$d['id'];
										 ?>
                                            <tr>
                                                <td>
												 <img class="img-fluid" src="<?php echo e($imgs[0]); ?>" alt="" style="width: 50px; height: 50px;"/>
											     <?php echo e($name); ?>

												</td>
					                            <td><b><?php echo e($dt[$d['discount_type']]); ?></b></td>
					                            <td><b>&#8358;<?php echo e(number_format($d['discount'],2)); ?></b></td>
					                            <td>				   
					                             <h3 class="<?php echo e($ss); ?>"><?php echo e(strtoupper($d['status'])); ?></h3>
					                            </td>
					                            <td>
						                          <a class="btn btn-default btn-block btn-clean" href="<?php echo e($ru); ?>">Remove</a>
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
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\fortune-store-admin\resources\views/discounts.blade.php ENDPATH**/ ?>