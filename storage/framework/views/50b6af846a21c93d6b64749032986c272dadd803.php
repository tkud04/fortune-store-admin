<?php
$title = "Add Products";
$subtitle = "Add one or more products";
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
<script>
let categories = [], buupCounter = 0;

 $(document).ready(() =>{
 $('.buup-hide').hide();
 	$('#result-box').hide();
	$('#finish-box').hide();
 localStorage.clear();
 
 <?php $__currentLoopData = $c; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 	<?php if($cc['status'] == "enabled"): ?>
	  categories.push("<?php echo e($cc['category']); ?>");
	<?php endif; ?>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 });
 </script>
<div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<input type="hidden" id="tk" value="<?php echo e(csrf_token()); ?>">
                        <div class="card">
                            <h5 class="card-header">Add products</h5>
                            <h5 class="card-header" style="margin:20px; padding: 10px; border: 1px dashed #fff; with: 50%;"><span class="label label-success text-uppercase">Tip:</span> Click the radio button beside an image to set it as the cover image</h5>
                            <div class="card-body">
							  <form action="<?php echo e(url('buup')); ?>" id="buup-form" method="post" enctype="multipart/form-data">
                                <div class="table-responsive">
                                    <table id="buup-table" class="table table-striped table-bordered first">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Price(&#163;)</th>
                                                <th>Current stock</th>
                                                <th>Category</th>
                                                <th>Status</th>
								 	            <th width="20%">Upload Images</th>
                                                <th>Actions</th>  
                                            </tr>
                                        </thead>
                                        <tbody>
										 
									   </tbody>
									</table>
							    </div>
								 <div class=" pull-left">
					      
							
							  <input type="hidden" id="buup-dt" name="dt">
							 
                                <div class="hp-sm" id="button-box">
								 <button onclick="BUUPAddRow(); return false;" class="btn btn-success" style="margin-top: 5px;">Add new product</button>
							
								 <h3 id="buup-select-product-error" class="label label-danger text-uppercase buup-hide mr-5 mb-5">Please add a new product</h3>
								 <h3 id="buup-select-validation-error" class="label label-danger text-uppercase buup-hide">All fields are required</h3>
								 <br>
								 <button onclick="BUUP(); return false;" class="btn btn-primary" style="margin-top: 5px;">Submit</button>
								</div>
								<div class="hp-sm" id="result-box">
								 <h4 id="buup-loading">Uploading products <img src="images/loading.gif" class="img img-fluid" alt="Loading" width="50" height="50"></h4><br>
								 <h5>Products uploaded: <span class="label label-success" id="result-ctr">0</span></h5>
								</div>
                                <div class="hp-sm" id="finish-box">
								 <h4>Upload complete!</h4>
								</div>                                
                                </div>
								</form>
							 </div>
						</div>
                    </div>
                </div>			
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\chstore-admin\resources\views/buup.blade.php ENDPATH**/ ?>