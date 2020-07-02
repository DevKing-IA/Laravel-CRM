 <?php $__env->startSection('content'); ?>

<?php if(session()->has('message')): ?>
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4><?php echo e(trans('file.Mail Setting')); ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                        <?php echo Form::open(['route' => 'setting.mailStore', 'files' => true, 'method' => 'post']); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Mail Host')); ?> *</strong></label>
                                        <input type="text" name="mail_host" class="form-control" value="<?php echo e(env('MAIL_HOST')); ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Mail Address')); ?> *</strong></label>
                                        <input type="text" name="mail_address" class="form-control" value="<?php echo e(env('MAIL_FROM_ADDRESS')); ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Mail From Name')); ?> *</strong></label>
                                        <input type="text" name="mail_name" class="form-control" value="<?php echo e(env('MAIL_FROM_NAME')); ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Mail Port')); ?> *</strong></label>
                                        <input type="text" name="port" class="form-control" value="<?php echo e(env('MAIL_PORT')); ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Password')); ?> *</strong></label>
                                        <input type="password" name="password" class="form-control" value="<?php echo e(env('MAIL_PASSWORD')); ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Encryption')); ?> *</strong></label>
                                        <input type="text" name="encryption" class="form-control" value="<?php echo e(env('MAIL_ENCRYPTION')); ?>" required />
                                    </div>
                                </div>
                            </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $("ul#setting").siblings('a').attr('aria-expanded','true');
    $("ul#setting").addClass("show");
    $("ul#setting #mail-setting-menu").addClass("active");

    $('.selectpicker').selectpicker({
      style: 'btn-link',
    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>