<?php
$title = "Add Banner";
$subtitle = "Add a new image to be displayed on the home page.";
?>



<?php $__env->startSection('title',$title); ?>


<?php $__env->startSection('page-header'); ?>
<?php echo $__env->make('page-header',['title' => "Banners",'subtitle' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Add Banner</h5>
                                <div class="card-body">
                                    <form action="<?php echo e(url('add-banner')); ?>" id="ab-form" method="post" enctype="multipart/form-data">
										<?php echo csrf_field(); ?>

										
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ab-images">Upload image</label>
                                            <input id="ab-images" type="file" name="ab-images[]" class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ab-title">Main title</label>
                                             <input type="text" class="form-control" placeholder="Main title" name="title" id="ab-title">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ab-top-subtitle">Top subtitle</label>
                                             <input type="text" class="form-control" placeholder="Top subtitle" name="subtitle_1" id="ab-subtitle-1">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ab-top-subtitle">Bottom subtitle</label>
                                             <input type="text" class="form-control" placeholder="Bottom subtitle" name="subtitle_2" id="ab-subtitle-2">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <h4>Status</h4>
                                            <select class="form-control" name="status" id="ap-status" style="margin-bottom: 5px;">
							                  <option value="none">Select status</option>
								           <?php
								            $secs = ['enabled' => "Enabled",'disabled' => "Disabled"];
								            foreach($secs as $key => $value){
									      	 
								           ?>
								              <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
								           <?php
								           }
								           ?>
							                </select>
                                        </div>
										</div>
										</div>
										
										
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="ab-form-btn">Save</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\fortune-store-admin\resources\views/add-banner.blade.php ENDPATH**/ ?>