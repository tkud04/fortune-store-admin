<?php
$blank = true;
?>



<?php $__env->startSection('title',"Sign Up"); ?>

<?php $__env->startSection('styles'); ?>
<style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- ============================================================== -->
    <!-- signup page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center"><a href="<?php echo e(url('/')); ?>"><h3>THEMOBILEBUZZ ADMIN</h3></a><span class="splash-description">Create Account.</span></div>
            <div class="card-body">
                <form method="post" action="<?php echo e(url('signup')); ?>" id="s-form">
                    <?php echo csrf_field(); ?>

					
					<div class="form-group">
                        <input class="form-control form-control-lg" name="fname" id="signup-fname" type="text" placeholder="First name" autocomplete="off">
                    </div>
					<div class="form-group">
                        <input class="form-control form-control-lg" name="lname" id="signup-lname" type="text" placeholder="Last name" autocomplete="off">
                    </div>
					<div class="form-group">
                        <input class="form-control form-control-lg" name="email" id="signup-email" type="text" placeholder="Email address" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="password" id="signup-password" type="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="password_confirmation" id="signup-password-2" type="password" placeholder="Confirm password">
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox"><span class="custom-control-label">Remember Me</span>
                        </label>
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" id="s-form-btn">Sign up</button>
                </form>

							
            </div>
            <div class="card-footer bg-white p-0  ">
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="<?php echo e(url('hello')); ?>" class="footer-link">Sign in instead</a></div>
            </div>
        </div>
    </div>
 	
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\chstore-admin\resources\views/signup.blade.php ENDPATH**/ ?>