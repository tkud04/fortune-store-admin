<?php
$title = $i['title'];
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
<?php echo $__env->make('page-header',['title' => "Information",'subtitle' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<script>
$(document).ready(() => {
	let informationContentEditor = new Simditor({
		textarea: $('#add-information-content'),
		toolbar: toolbar,
		placeholder: `Enter your content here. Maximum of 2000 words..`
	});	
	
	informationContentEditor.setValue(`<?php echo $i['content']; ?>`);
});
</script>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
 <div class="text-right mb-3">
	      <a href="<?php echo e(url('information')); ?>" class="btn btn-primary"><i class="fas fa-reply"></i></a>
	    </div>
                            <div class="card">
                                <h5 class="card-header">Edit Information</h5>
                                <div class="card-body">
                                    <form action="<?php echo e(url('edit-information')); ?>" id="information-form" method="post" enctype="multipart/form-data">
										<?php echo csrf_field(); ?>

										<input type="hidden" name="xf" value="<?php echo e($i['id']); ?>">
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label>Title <span class="text-danger text-bold">*</span></label>
                                            <input id="add-information-title" type="text" name="title" value="<?php echo e($i['title']); ?>" placeholder="Title" class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label>Type <span class="text-danger text-bold">*</span></label>
                                            <select id="add-information-type" name="type" class="form-control">
											  <option value="none">Select type</option>
											  <?php
											  foreach($xx as $k => $v)
											  {
											  ?>
											  <option value="<?php echo e($k); ?>"><?php echo e($v); ?></option>
											  <?php
											  }
											  ?>
											</select>
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label>Content</label>
                                            <textarea class="form-control" placeholder="Your message" name="content" id="add-information-content"></textarea>
                                        </div>
										</div>
										</div>
										
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="information-submit">Submit</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>		
</div>		
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\chstore-admin\resources\views/information-single.blade.php ENDPATH**/ ?>