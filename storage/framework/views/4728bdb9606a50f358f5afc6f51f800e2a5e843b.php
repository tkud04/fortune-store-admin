<?php
$title = "Add Category";
$subtitle = "Add a new category.";
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
<?php echo $__env->make('page-header',['title' => "Categories",'subtitle' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right mb-3">
	    <a href="javascript:void(0)" id="add-category-submit" class="btn btn-primary"><i class="fas fa-save"></i></a>
	    <a href="<?php echo e(url('products')); ?>" class="btn btn-danger"><i class="fas fa-reply"></i></a>
	  </div>

										
 <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  <form action="<?php echo e(url('add-category')); ?>" id="add-category-form" method="post"  enctype="multipart/form-data">
  <?php echo csrf_field(); ?>

    <div class="tab-vertical">
	  <ul class="nav nav-tabs" id="myTab3" role="tablist">
         <li class="nav-item">
           <a class="nav-link active show" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
         </li>
         <li class="nav-item">
           <a class="nav-link" id="data-tab" data-toggle="tab" href="#data" role="tab" aria-controls="data" aria-selected="false">Data</a>
		 </li>
		 <li class="nav-item">
           <a class="nav-link" id="seo-tab" data-toggle="tab" href="#seo" role="tab" aria-controls="links" aria-selected="false">SEO</a>
         </li>
      </ul>
	</div>
	<div class="tab-content" id="myTabContent3">
	   <div class="tab-pane active show" id="general" role="tabpanel" aria-labelledby="general-tab">
                                      <h5 class="card-header">General</h5>
                                       <div class="card-body">
									   
									    <div class="row">
										  <div class="col-md-12">
										    <div class="form-group">
                                             <label>Name <span class="text-danger text-bold">*</span></label>
                                            <input id="add-category-name" type="text" name="name" placeholder="Category name e.g Tablets" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                               <label>Tag</label>
                                            <input id="add-category-tag" type="text" name="category" value="" placeholder="Tag e.g tablets" class="form-control">
                                            </div>
											 <div class="form-group">
                                             <label>Description</label>
                                               <textarea id="add-category-description" name="description" class="form-control" placeholder="Description" rows="8"></textarea>
                                            </div>
										  </div>
										</div>
                                       </div>
                                    </div>
									<div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="data-tab">
                                      <h5 class="card-header">Data</h5>
                                       <div class="card-body">
									   
									    <div class="row">
										  <div class="col-md-12">
										     <div class="form-group mt-2">
                                                <label>Parent</label>
                                                <select id="add-category-parent" name="parent" class="form-control">
											       <option value="0">None</option>
												    <?php
												     foreach($categories as $c)
												     {
												    ?>
											       <option value="<?php echo e($c['id']); ?>"><?php echo e(ucwords($c['name'])); ?></option>
											        <?php
												     }
												    ?>
											    </select>
                                              </div>
											<div class="form-group mt-2">
                                              <label>Meta tag title <span class="req">*</span></label>
                                              <input id="add-category-meta-title" name="meta_title" type="text" placeholder="Meta tag title" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                               <label>Meta tag Description</label>
                                               <textarea id="add-category-meta-description" name="meta_description" class="form-control" placeholder="Meta tag description" rows="8"></textarea>
                                            </div>
											<div class="form-group mt-2">
                                              <label>Meta tag keywords</label>
                                              <input id="add-category-meta-keywords" name="meta_keywords" type="text" placeholder="Meta tag keywords" class="form-control">
                                            </div>
											<div class="form-group mt-2">
                                              <label>Image</label>
                                              <input type="file" class="form-control" id="add-category-image" name="image">
                                            </div>
										  </div>
										</div>
                                       </div>
                                    </div>
									<div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                                      <h5 class="card-header">SEO</h5>
                                       <div class="card-body">
									   
									    <div class="row">
										  <div class="col-md-12">
										    <div class="form-group">
                                              <label>
											   Keywords <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Do not use spaces, instead replace spaces with - and make sure the SEO URL is globally unique."><i class="fas fa-question-circle"></i> </a>
											   </label>
                                              <input id="add-category-seo-keywords" name="seo_keywords" type="text" placeholder="Keywords" class="form-control">
                                            </div>
											
										  </div>
										</div>
                                       </div>
                                    </div>
	</div>
	</form>
 </div>
	
</div>	
<div class="row">
                                            <div class="col-sm-6 pb-2 pb-sm-4 pb-lg-0 pr-0">
                                                <label class="be-checkbox custom-control custom-checkbox">
                                                   <span class="custom-control-label">Categories help you group similar products in one logical section.</span>
                                                </label>
                                            </div>
                                        </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\chstore-admin\resources\views/add-category.blade.php ENDPATH**/ ?>