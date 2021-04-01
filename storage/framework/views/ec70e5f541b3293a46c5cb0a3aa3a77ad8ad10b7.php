<?php
$title = "Products";
$subtitle = "View all products";
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
                            <h5 class="card-header">View all products<a class="btn btn-primary ml-3" href="<?php echo e(url('add-product')); ?>">Add Product</a></h5>
                            <h5 class="card-header</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first etuk-table">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Product name</th>
												<th>Model</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  <?php
										   if(count($products) > 0)
										   {
											  foreach($products as $p)
											   {
												$statusClass = "danger";
												$arrClass = "success";
												$arrText = "Enable";
												

											   $name = $p['name'];
											   $pd = $p['data'];
											   $uu = url('product')."?xf=".$p['id'];
											    $sss = $p['status'];
												
												if($sss == "enabled")
												{
													$statusClass = "success";
													$arrClass = "warning";
													$arrText = "Disable";
												}
											   $imgs = $p['imggs'];

												   $arr = url('ups')."?xf=".$p['id']."&type=".strtolower($arrText);
												   $dr = url('remove-product')."?xf=".$p['id'];
												   #$ar = $a['rating'];
												   $ar = 3;
										  ?>
                                            <tr>
                                               <td><img class="img-fluid" onclick="window.location='<?php echo e($uu); ?>'" src="<?php echo e($imgs[0]); ?>" alt="<?php echo e($name); ?>" style="cursor: pointer; width: 100px; height: 100px;"/></td> 
											   <td> <a href="<?php echo e($uu); ?>"><h4><?php echo e(ucwords($name)); ?></h4></a> </td> 
												<td><a href="<?php echo e($uu); ?>"><h4><?php echo e($p['model']); ?></h4></a></td>	
                                                <td>&#163;<?php echo e(number_format($pd['amount'],2)); ?></td>
												<td><?php echo e($p['qty']); ?></td>
                                                <td><span class="label label-<?php echo e($statusClass); ?>"><?php echo e(strtoupper($sss)); ?></span></td>
                                                <td>
												 <a class="btn btn-<?php echo e($arrClass); ?> btn-sm" href="<?php echo e($arr); ?>"><?php echo e($arrText); ?></a>
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
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\chstore-admin\resources\views/products.blade.php ENDPATH**/ ?>