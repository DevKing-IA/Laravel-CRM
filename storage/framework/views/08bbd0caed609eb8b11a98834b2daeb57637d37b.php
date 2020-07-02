<h1>Delivery Details</h1>
<h3>Dear <?php echo e($customer); ?>,</h3>
<?php if($status == 2): ?>
	<p>Your Product is Delivering.</p>
<?php else: ?>
	<p>Your Product is Delivered.</p>
<?php endif; ?>
<p><strong>Sale Reference: </strong><?php echo e($sale_reference); ?></p>
<p><strong>Delivery Reference: </strong><?php echo e($delivery_reference); ?></p>
<p><strong>Destination: </strong><?php echo e($address); ?></p>
<?php if($delivered_by): ?>
<p><strong>Delivered By: </strong><?php echo e($delivered_by); ?></p>
<?php endif; ?>
<p>Thank You</p>