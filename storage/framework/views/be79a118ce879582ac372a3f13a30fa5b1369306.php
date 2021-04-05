<?php
$title = "Edit Shipping";
$subtitle = "Edit this shipping information.";
?>



<?php $__env->startSection('title',$title); ?>


<?php $__env->startSection('page-header'); ?>
<?php echo $__env->make('page-header',['title' => "Shipping",'subtitle' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Edit Plugin</h5>
                                <div class="card-body">
                                    <form action="<?php echo e(url('edit-shipping')); ?>" id="ash-form" method="post">
										<?php echo csrf_field(); ?>

										<input type="hidden" name="xf" value="<?php echo e($s['id']); ?>"/>
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ash-name">Name</label>
                                            <input id="ash-name" type="text" value="<?php echo e($s['name']); ?>" placeholder="Shipping name" name="name" class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="ash-value">Value</label>
                                             <input id="ash-value" type="text" value="<?php echo e($s['value']); ?>" placeholder="Value" name="value" class="form-control">
                                        </div>
										</div>
										
										</div>
										
										
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="ash-form-btn">Save</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\fortune-store-admin\resources\views/edit-shipping.blade.php ENDPATH**/ ?>