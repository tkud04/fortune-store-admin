<?php
$title = "Add Gallery";
$subtitle = "Add a new item to the gallery on the home page.";
?>



<?php $__env->startSection('title',$title); ?>


<?php $__env->startSection('page-header'); ?>
<?php echo $__env->make('page-header',['title' => "Gallery",'subtitle' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Add Gallery</h5>
                                <div class="card-body">
                                    <form action="<?php echo e(url('add-gallery')); ?>" id="ab-form" method="post" enctype="multipart/form-data">
										<?php echo csrf_field(); ?>

										
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ab-images">Upload image</label>
                                            <input type="file" name="img" class="form-control">
                                        </div>
										</div>
										
										</div>
										
										
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" type="submit">Save</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\fortune-store-admin\resources\views/add-gallery.blade.php ENDPATH**/ ?>