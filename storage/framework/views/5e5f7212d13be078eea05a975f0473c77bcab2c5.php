 
<?php $__env->startSection('content'); ?>
<?php if(session()->has('message')): ?>
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo session()->get('message'); ?></div> 
<?php endif; ?>
<section class="forms">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header mt-2">
                <h3 class="text-center"><?php echo e(trans('file.Transaction Details')); ?></h3>
                <h3 class="text-center"><?php echo e(trans('file.Maximum Capacity')); ?> [ <?php echo e($get_truck_data->capacity); ?> kg]</h3>
            </div>
            <?php echo Form::open(['route' => 'trucks.daytransaction', 'method' => 'post']); ?>

            <div class="row">
                <div class="col-md-4 offset-md-2 mt-3">
                    <div class="form-group row">
                        <label class="d-tc mt-2"><strong><?php echo e(trans('file.Choose Your Date')); ?></strong> &nbsp;</label>
                        <div class="d-tc">
                            <div class="input-group">
                                <input type="text" class="daterangepicker-field form-control" value="<?php echo e($start_date); ?> To <?php echo e($end_date); ?>" id="title_date" required />
                                <input type="hidden" name="start_date" id="sstart" value="<?php echo e($start_date); ?>" />
                                <input type="hidden" name="end_date" id="estart" value="<?php echo e($end_date); ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group row">
                        <label class="d-tc mt-2"><strong><?php echo e(trans('file.Choose Trucks')); ?></strong> &nbsp;</label>
                        <div class="d-tc">
                            <select id="trucks_myid" name="trucks_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                               <?php $__currentLoopData = $truck_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$truck): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                               <option 
                                <?php if($truck_id == $truck->id): ?>
                                <?php echo e("selected"); ?>

                                <?php endif; ?>
                               value="<?php echo e($truck->id); ?>"><?php echo e($truck->name); ?></option>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mt-3">
                    <div class="form-group">
                        <button class="btn btn-success" type="button" data-toggle="modal" id="qty" data-target="#myModal">Add Qty</button>
                        <button class="btn btn-primary" type="submit"><?php echo e(trans('file.submit')); ?></button>
                    </div>
                </div>
            </div>
            <?php echo Form::close(); ?>

            <div class="table-responsive mb-4">
                <table id="transation-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th class="not-exported-transaction"></th>
                            <th><?php echo e(trans('file.product')); ?> <?php echo e(trans('file.name')); ?></th>
                            <th><?php echo e(trans('file.product')); ?> (<?php echo e(trans('file.qty')); ?>)</th> 
                            <th><?php echo e(trans('file.weight')); ?></th>
                            <th><?php echo e(trans('file.Delivery')); ?> <?php echo e(trans('file.reference')); ?></th>                           
                            <th><?php echo e(trans('file.grand total')); ?></th>                            
                            <th><?php echo e(trans('file.qty')); ?> * <?php echo e(trans('file.weight')); ?></th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $total_grand=0;
                         $toal_qty_w=0;
                         ?>
                         
                        <?php $__currentLoopData = $lims_truck_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                       
                        <tr>
                            <?php 
                            $total_grand += $item->total;
                            $toal_qty_w += $item->qty*$item->weight;
                             ?>
                            <td><?php echo e($k); ?></td>
                            <td><?php echo e($item->name); ?></td>
                            <td><?php echo e($item->qty); ?></td>
                            <td><?php echo e($item->weight); ?></td>
                            <td><?php echo e($item->reference_no); ?></td>
                            <td><?php echo e($item->total); ?></td>                            
                            <td><?php echo e($item->qty*$item->weight); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot class="tfoot active">                       
                        <tr>
                            <th></th>
                            <th>Total:</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><?php echo e(number_format($total_grand,2)); ?></th>
                            <th 
                            <?php if($toal_qty_w > $get_truck_data->capacity): ?>
                            style="color:red"
                            <?php endif; ?>
                            ><?php echo e(number_format($toal_qty_w,2)); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <div class="modal-header">
          <h5 class="modal-title">ADD Qty</h5>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <div class="modal-body">
                <?php echo Form::open(['route' => 'delivery.store', 'method' => 'post', 'files' => true]); ?>

                <?php 
                    $lims_product_list = \App\Product::all();
                ?>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><strong><?php echo e(trans('file.Delivery Reference')); ?></strong></label>
                        <p id="dr"></p>
                    </div>
<!--                      <div class="col-md-6 mt-2 form-group">
                        <label><strong>Product Name</strong></label>
                        <input type="text" name="delivered_by" class="form-control" value="<?php echo e($item->name); ?>">
                    </div> -->



                    <div class="col-md-6 form-group">
                        <label><strong><?php echo e(trans('file.Product Name')); ?></strong> &nbsp;</label>
                            <select id="trucks_id" name="trucks_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                               <?php $__currentLoopData = $lims_product_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$truck): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                               <option 
                                <?php if($truck_id == $truck->id): ?>
                                <?php echo e("selected"); ?>

                                <?php endif; ?>
                               value="<?php echo e($truck->id); ?>"><?php echo e($truck->name); ?></option>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                    </div>



                    <div class="col-md-6 mt-2 form-group">
                        <label><strong>Add Product(Qty)</strong></label>
                        <input type="number" name="delivered_by" class="form-control">
                        <input type="hidden" class="hidden" value="">
                    </div>
                </div>

        </div>
        
        <div class="modal-footer">
              <button type="submit" class="btn btn-danger">SUBMIT</button>
          <?php echo e(Form::close()); ?>

        
        </div>
        
      </div>
    </div>
  </div>
<script type="text/javascript">

    $("#qty").click(function(){
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var yyyy = today.getFullYear();

        today ="dr" + "-" + yyyy + mm + dd + "-" + new Date().getHours("hh") + new Date().getMinutes("mm") + new Date().getSeconds("ss");
        $("#dr").text(today);
    });



    var titleTimerId = setInterval(function(){


        document.title = "Prodecon-Demacol" + "(" + $("#trucks_myid option:selected" ).text() + ", "+ $("#sstart").val() + " to " + $("#estart").val() + ")";
        
    }, 800);


    $('#transation-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': 0
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
                exportOptions: {
                    columns: ':visible:Not(.not-exported-transaction)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                },
                footer:true
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-transaction)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                },
                footer:true
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-transaction)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                },
                footer:true
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            }
        ],
        drawCallback: function () {
            var api = this.api();
           console.log("tue");
        }
    } );
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }); 
    var prev_date = new Date();
    console.log(prev_date);
prev_date.setDate(prev_date.getDate() + 30000);    
    $(".daterangepicker-field").daterangepicker({
        maxDate: prev_date,
    callback: function(startDate, endDate, period){
        var start_date = startDate.format('YYYY-MM-DD');
        var end_date = endDate.format('YYYY-MM-DD');
        var title = start_date + ' To ' + end_date;
        $(".daterangepicker-field").val(title);
        $('input[name="start_date"]').val(start_date);
        $('input[name="end_date"]').val(end_date);
    }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>