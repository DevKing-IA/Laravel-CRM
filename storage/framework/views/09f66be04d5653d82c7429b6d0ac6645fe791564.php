 <?php $__env->startSection('content'); ?>
<?php if(session()->has('message')): ?>
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>

<section>
    <div class="container-fluid">
        <button class="btn btn-info" data-toggle="modal" data-target="#truck-modal"><i class="fa fa-plus"></i> <?php echo e(trans('file.Add Truck')); ?></button>
    </div>
    <div class="table-responsive">
        <table id="truck-table" class="table table-striped">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.name')); ?></th>
                    <th><?php echo e(trans('file.Model')); ?></th>
                    <th><?php echo e(trans('file.Identification')); ?></th>
                    <th><?php echo e(trans("file.Driver's Name")); ?></th>
                    <th><?php echo e(trans('file.Maximum Capacity')); ?></th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $lims_truck_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$truck): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr data-id="<?php echo e($truck->id); ?>">
                    <td><?php echo e($key); ?></td>
                    <td><?php echo e($truck->name); ?></td>
                    <td><?php echo e($truck->model); ?></td>
                    <td><?php echo e($truck->identification); ?></td>
                    <td><?php echo e($truck->driver_name); ?></td>
                    <td><?php echo e($truck->capacity .' '.$truck->unit->unit_code); ?></td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo e(trans('file.action')); ?>

                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <!--<li><button type="button" data-id="<?php echo e($truck->id); ?>" data-name="<?php echo e($truck->name); ?>" data-model="<?php echo e($truck->model); ?>" data-identification="<?php echo e($truck->identification); ?>" data-driver_name="<?php echo e($truck->driver_name); ?>" data-capacity="<?php echo e($truck->capacity); ?>" data-unit_id="<?php echo e($truck->unit->id); ?>" class="edit-btn btn btn-link" data-toggle="modal" data-target="#truck-edit-modal"><i class="fa fa-edit"></i> <?php echo e(trans('file.edit')); ?></button></li>-->
                                <li><a href="<?php echo e(route('trucks.transactionDetails', $truck->id)); ?>" class="btn btn-link"><i class="ion-ios-paper-outline"></i> Listado</a></li>
                                <li><a href="<?php echo e(route('trucks.daytransactionDetails', $truck->id)); ?>" class="btn btn-link"><i class="ion-ios-paper-outline"></i> List(Day)</a></li>
                                <!--<li class="divider"></li>
                                <?php echo e(Form::open(['route' => ['trucks.destroy', $truck->id], 'method' => 'DELETE'] )); ?>

                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> <?php echo e(trans('file.delete')); ?></button>
                                </li>
                                <?php echo e(Form::close()); ?>-->
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot class="tfoot active">
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tfoot>
        </table>
    </div>
</section>

<!-- edit modal -->
<div id="truck-edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
	<div role="document" class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	            <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.Add Truck')); ?></h5>
	            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
	        </div>
	        <div class="modal-body">
	          <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
	            <?php echo Form::open(['route' => ['trucks.update', 1], 'method' => 'put']); ?>

	                <?php 
                        $lims_unit_list = DB::table('units')->where('is_active', true)->get();
                    ?>
	              <div class="row">
	                <div class="col-md-6 form-group">
	                	<input type="hidden" name="id" class="form-control">
	                    <label><strong><?php echo e(trans('file.name')); ?> *</strong></label>
	                    <input type="text" name="name" class="form-control" required>
	                </div>
	                <div class="col-md-6 form-group">
	                    <label><strong><?php echo e(trans('file.Model')); ?></strong></label>
	                    <input type="text" name="model" class="form-control">
	                </div>
	                <div class="col-md-6 form-group">
	                    <label><strong><?php echo e(trans('file.Identification')); ?> *</strong></label>
	                    <input type="text" name="identification" class="form-control" required>
	                </div>
	                <div class="col-md-6 form-group">
	                    <label><strong><?php echo e(trans("file.Driver's Name")); ?> *</strong></label>
	                    <input type="text" name="driver_name" class="form-control" required>
	                </div>
	                <div class="col-md-6 form-group">
	                    <label><strong><?php echo e(trans('file.Maximum Capacity')); ?> (Kg) *</strong></label>
	                    <input type="number" name="capacity" step="any" required class="form-control">
	                </div>	                
	              </div>
	              
	              <div class="form-group">
	                  <button type="submit" class="btn btn-primary"><?php echo e(trans('file.submit')); ?></button>
	              </div>
	            <?php echo e(Form::close()); ?>

	        </div>
	    </div>
	</div>
</div>


<script type="text/javascript">

    $("ul#truck").siblings('a').attr('aria-expanded','true');
    $("ul#truck").addClass("show");
    $("ul#truck #truck-list-menu").addClass("active");

    $(document).ready(function() {
        $('.edit-btn').on('click', function() {
        	$("#truck-edit-modal input[name='id']").val($(this).data('id'));
        	$("#truck-edit-modal input[name='name']").val($(this).data('name'));
        	$("#truck-edit-modal input[name='model']").val($(this).data('model'));
        	$("#truck-edit-modal input[name='identification']").val($(this).data('identification'));
        	$("#truck-edit-modal input[name='driver_name']").val($(this).data('driver_name'));
        	$("#truck-edit-modal input[name='capacity']").val($(this).data('capacity'));
        	$("#truck-edit-modal select[name='unit_id']").val($(this).data('unit_id'));
            $('.selectpicker').selectpicker('refresh');
        });
    })

function confirmDelete() {
    if (confirm("Are you sure want to delete?")) {
        return true;
    }
    return false;
}

    $('#truck-table').DataTable( {
        "order": [],
        'language': {
            'lengthMenu': '_MENU_ <?php echo e(trans("file.records per page")); ?>',
             "info":      '<?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)',
            "search":  '<?php echo e(trans("file.Search")); ?>',
            'paginate': {
                    'previous': '<?php echo e(trans("file.Previous")); ?>',
                    'next': '<?php echo e(trans("file.Next")); ?>'
            }
        },
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 6]
            },
            {
                'checkboxes': {
                   'selectRow': true
                },
                'targets': 0
            }
        ],
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: '<"row"lfB>rtip',
        buttons: [
            {
                extend: 'pdf',
                text: '<?php echo e(trans("file.PDF")); ?>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'csv',
                text: '<?php echo e(trans("file.CSV")); ?>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'print',
                text: '<?php echo e(trans("file.Print")); ?>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'colvis',
                text: '<?php echo e(trans("file.Column visibility")); ?>',
                columns: ':gt(0)'
            },
        ],
    } );

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>