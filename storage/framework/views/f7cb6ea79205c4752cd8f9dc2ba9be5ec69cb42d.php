 <?php $__env->startSection('content'); ?>
<section class="forms">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header mt-2">
                <h3 class="text-center"><?php echo e(trans('file.Customer Report')); ?></h3>
            </div>
            <?php echo Form::open(['route' => 'report.customer', 'method' => 'post']); ?>

            <div class="row">
                <div class="col-md-4 offset-md-2 mt-3">
                    <div class="form-group row">
                        <label class="d-tc mt-2"><strong><?php echo e(trans('file.Choose Your Date')); ?></strong> &nbsp;</label>
                        <div class="d-tc">
                            <div class="input-group">
                                <input type="text" class="daterangepicker-field form-control" value="<?php echo e($start_date); ?> To <?php echo e($end_date); ?>" required />
                                <input type="hidden" name="start_date" value="<?php echo e($start_date); ?>" />
                                <input type="hidden" name="end_date" value="<?php echo e($end_date); ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group row">
                        <label class="d-tc mt-2"><strong><?php echo e(trans('file.Choose Customer')); ?></strong> &nbsp;</label>
                        <div class="d-tc">
                            <input type="hidden" name="customer_id_hidden" value="<?php echo e($customer_id); ?>" />
                            <select id="customer_id" name="customer_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins">
                                <?php $__currentLoopData = $lims_customer_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($customer->id); ?>"><?php echo e($customer->name); ?> (<?php echo e($customer->phone_number); ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mt-3">
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit"><?php echo e(trans('file.submit')); ?></button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="customer_id_hidden" value="<?php echo e($customer_id); ?>" />
            <?php echo Form::close(); ?>


            <ul class="nav nav-tabs ml-4 mt-3" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" href="#customer-sale" role="tab" data-toggle="tab"><?php echo e(trans('file.Sale')); ?></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#customer-payments" role="tab" data-toggle="tab"><?php echo e(trans('file.Payment')); ?></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#customer-quotation" role="tab" data-toggle="tab"><?php echo e(trans('file.Quotation')); ?></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#customer-return" role="tab" data-toggle="tab"><?php echo e(trans('file.return')); ?></a>
              </li>
            </ul>
    
            <div class="tab-content">

                <div role="tabpanel" class="tab-pane fade show active" id="customer-sale">
                    <div class="table-responsive mb-4">
                        <table id="sale-table" class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="not-exported-sale"></th>
                                    <th><?php echo e(trans('file.Date')); ?></th>
                                    <th><?php echo e(trans('file.reference')); ?> No</th>
                                    <th><?php echo e(trans('file.Warehouse')); ?></th>
                                    <th><?php echo e(trans('file.product')); ?> (<?php echo e(trans('file.qty')); ?>)</th>
                                    <th><?php echo e(trans('file.grand total')); ?></th>
                                    <th><?php echo e(trans('file.Paid')); ?></th>
                                    <th><?php echo e(trans('file.Due')); ?></th>
                                    <th><?php echo e(trans('file.Status')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $lims_sale_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    if($sale->sale_status == 1)
                                        $sale_status = trans('file.Completed');
                                    elseif($sale->sale_status == 2)
                                        $sale_status = trans('file.Pending');
                                    else
                                        $sale_status = trans('file.Draft');

                                    if($sale->coupon_id){
                                        $coupon = Coupon::find($sale->coupon_id);
                                        $coupon_code = $coupon->code;
                                    }
                                    else
                                        $coupon_code = null;
                                ?>
                                <tr>
                                    <td><?php echo e($key); ?></td>
                                    <td><?php echo e(date($general_setting->date_format, strtotime($sale->created_at->toDateString())) . ' '. $sale->created_at->toTimeString()); ?></td>
                                    <td><button type="button" class="btn btn-link sale-link" data-sale='[ "<?php echo e(date($general_setting->date_format, strtotime($sale->created_at->toDateString()))); ?>", "<?php echo e($sale->reference_no); ?>", "<?php echo e($sale_status); ?>", "<?php echo e($sale->biller->name); ?>", "<?php echo e($sale->biller->company_name); ?>","<?php echo e($sale->biller->email); ?>", "<?php echo e($sale->biller->phone_number); ?>", "<?php echo e($sale->biller->address); ?>", "<?php echo e($sale->biller->city); ?>", "<?php echo e($sale->customer->name); ?>", "<?php echo e($sale->customer->phone_number); ?>", "<?php echo e($sale->customer->address); ?>", "<?php echo e($sale->customer->city); ?>", "<?php echo e($sale->id); ?>", "<?php echo e($sale->total_tax); ?>", "<?php echo e($sale->total_discount); ?>", "<?php echo e($sale->total_price); ?>", "<?php echo e($sale->order_tax); ?>", "<?php echo e($sale->order_tax_rate); ?>", "<?php echo e($sale->order_discount); ?>", "<?php echo e($sale->shipping_cost); ?>", "<?php echo e($sale->grand_total); ?>", "<?php echo e($sale->paid_amount); ?>", "<?php echo e($sale->sale_note); ?>", "<?php echo e($sale->staff_note); ?>", "<?php echo e($sale->user->name); ?>", "<?php echo e($sale->user->email); ?>", "<?php echo e($sale->warehouse->name); ?>", "<?php echo e($coupon_code); ?>", "<?php echo e($sale->coupon_discount); ?>"]'><?php echo e($sale->reference_no); ?></button></td>
                                    <td><?php echo e($sale->warehouse->name); ?></td>
                                    <td>
                                        <?php $__currentLoopData = $lims_product_sale_data[$key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_sale_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php 
                                            $product = App\Product::select('name')->find($product_sale_data->product_id);
                                            if($product_sale_data->variant_id) {
                                                $variant = App\Variant::find($product_sale_data->variant_id);
                                                $product->name .= ' ['.$variant->name.']'; 
                                            }
                                            $unit = App\Unit::find($product_sale_data->sale_unit_id);
                                        ?>
                                        <?php if($unit): ?>
                                            <?php echo e($product->name.' ('.$product_sale_data->qty.' '.$unit->unit_code.')'); ?>

                                        <?php else: ?>
                                            <?php echo e($product->name.' ('.$product_sale_data->qty.')'); ?>

                                        <?php endif; ?>
                                        <br>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td><?php echo e($sale->grand_total); ?></td>
                                    <td><?php echo e($sale->paid_amount); ?></td>
                                    <td><?php echo e(number_format((float)($sale->grand_total - $sale->paid_amount), 2, '.', '')); ?></td>
                                    <?php if($sale->sale_status == 1): ?>
                                    <td><div class="badge badge-success"><?php echo e(trans('file.Completed')); ?></div></td>
                                    <?php else: ?>
                                    <td><div class="badge badge-danger"><?php echo e(trans('file.Pending')); ?></div></td>
                                    <?php endif; ?>
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
                                    <th>0.00</th>
                                    <th>0.00</th>
                                    <th>0.00</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="customer-payments">
                    <div class="table-responsive mb-4">
                        <table id="payment-table" class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="not-exported-payment"></th>
                                    <th><?php echo e(trans('file.Date')); ?></th>
                                    <th><?php echo e(trans('file.Payment Reference')); ?></th>
                                    <th><?php echo e(trans('file.Sale Reference')); ?></th>
                                    <th><?php echo e(trans('file.Amount')); ?></th>
                                    <th><?php echo e(trans('file.Paid Method')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $lims_payment_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key); ?></td>
                                        <td><?php echo e(date($general_setting->date_format, strtotime($payment->created_at))); ?></td>
                                        <td><?php echo e($payment->payment_reference); ?></td>
                                        <td><?php echo e($payment->sale_reference); ?></td>
                                        <td><?php echo e($payment->amount); ?></td>
                                        <td><?php echo e($payment->paying_method); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot class="tfoot active">
                                <tr>
                                    <th></th>
                                    <th>Total:</th>
                                    <th></th>
                                    <th></th>
                                    <th>0.00</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="customer-return">
                    <div class="table-responsive mb-4">
                        <table id="return-table" class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="not-exported-return"></th>
                                    <th><?php echo e(trans('file.Date')); ?></th>
                                    <th><?php echo e(trans('file.reference')); ?></th>
                                    <th><?php echo e(trans('file.Warehouse')); ?></th>
                                    <th><?php echo e(trans('file.Biller')); ?></th>
                                    <th><?php echo e(trans('file.product')); ?> (<?php echo e(trans('file.qty')); ?>)</th>
                                    <th><?php echo e(trans('file.grand total')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $lims_return_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key); ?></td>
                                    <td><?php echo e(date($general_setting->date_format, strtotime($return->created_at->toDateString())) . ' '. $return->created_at->toTimeString()); ?></td>
                                    <td><?php echo e($return->reference_no); ?></td>
                                    <td><?php echo e($return->warehouse->name); ?></td>
                                    <td><?php echo e($return->biller->name); ?></td>
                                    <td>
                                        <?php $__currentLoopData = $lims_product_return_data[$key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_return_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php 
                                            $product = App\Product::select('name')->find($product_return_data->product_id);
                                            if($product_return_data->variant_id) {
                                                $variant = App\Variant::find($product_return_data->variant_id);
                                                $product->name .= ' ['.$variant->name.']';
                                            }
                                            $unit = App\Unit::find($product_return_data->sale_unit_id);
                                        ?>
                                        <?php if($unit): ?>
                                            <?php echo e($product->name.' ('.$product_return_data->qty.' '.$unit->unit_code.')'); ?>

                                        <?php else: ?>
                                            <?php echo e($product->name.' ('.$product_return_data->qty.')'); ?>

                                        <?php endif; ?>
                                        <br>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td><?php echo e(number_format((float)($return->grand_total), 2, '.', '')); ?></td>
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
                                    <th></th>
                                    <th>0.00</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="customer-quotation">
                    <div class="table-responsive mb-4">
                        <table id="quotation-table" class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="not-exported-quotation"></th>
                                    <th><?php echo e(trans('file.Date')); ?></th>
                                    <th><?php echo e(trans('file.reference')); ?></th>
                                    <th><?php echo e(trans('file.Warehouse')); ?></th>
                                    <th><?php echo e(trans('file.Supplier')); ?></th>
                                    <th><?php echo e(trans('file.product')); ?> (<?php echo e(trans('file.qty')); ?>)</th>
                                    <th><?php echo e(trans('file.grand total')); ?></th>
                                    <th><?php echo e(trans('file.Status')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $lims_quotation_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$quotation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key); ?></td>
                                    <?php
                                        $supplier = DB::table('suppliers')->find($quotation->supplier_id);
                                    ?>
                                    <td><?php echo e(date($general_setting->date_format, strtotime($quotation->created_at->toDateString())) . ' '. $quotation->created_at->toTimeString()); ?></td>
                                    <td><?php echo e($quotation->reference_no); ?></td>
                                    <td><?php echo e($quotation->warehouse->name); ?></td>
                                    <?php if($supplier): ?>
                                        <td><?php echo e($supplier->name); ?></td>
                                    <?php else: ?>
                                        <td>N/A</td>
                                    <?php endif; ?>
                                    <td>
                                        <?php $__currentLoopData = $lims_product_quotation_data[$key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_quotation_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php 
                                            $product = App\Product::select('name')->find($product_quotation_data->product_id);
                                            if($product_quotation_data->variant_id) {
                                                $variant = App\Variant::find($product_quotation_data->variant_id);
                                                $product->name .= ' ['.$variant->name.']';
                                            }
                                            $unit = App\Unit::find($product_quotation_data->sale_unit_id);
                                        ?>
                                        <?php if($unit): ?>
                                            <?php echo e($product->name.' ('.$product_quotation_data->qty.' '.$unit->unit_code.')'); ?>

                                        <?php else: ?>
                                            <?php echo e($product->name.' ('.$product_quotation_data->qty.')'); ?>

                                        <?php endif; ?>
                                        <br>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td><?php echo e($quotation->grand_total); ?></td>
                                    <?php if($quotation->quotation_status == 1): ?>
                                    <td><div class="badge badge-danger"><?php echo e(trans('file.Pending')); ?></div></td>
                                    <?php elseif($quotation->quotation_status == 2): ?>
                                    <td><div class="badge badge-success"><?php echo e(trans('file.Sent')); ?></div></td>
                                    <?php endif; ?>
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
                                    <th></th>
                                    <th>0.00</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="sale-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="container mt-3 pb-2 border-bottom">
                <div class="row">
                    <div class="col-md-3">
                        
                    </div>
                    <div class="col-md-6">
                        <h3 id="exampleModalLabel" class="modal-title text-center container-fluid"><?php echo e($general_setting->site_title); ?></h3>
                    </div>
                    <div class="col-md-3">
                        <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close d-print-none"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="col-md-12 text-center">
                        <i style="font-size: 15px;"><?php echo e(trans('file.Sale Details')); ?></i>
                    </div>
                </div>
            </div>
            <div id="sale-content" class="modal-body">
            </div>
            <br>
            <table class="table table-bordered product-sale-list">
                <thead>
                    <th>#</th>
                    <th><?php echo e(trans('file.product')); ?></th>
                    <th><?php echo e(trans('file.Qty')); ?></th>
                    <th><?php echo e(trans('file.Unit Price')); ?></th>
                    <th><?php echo e(trans('file.Tax')); ?></th>
                    <th><?php echo e(trans('file.Discount')); ?></th>
                    <th><?php echo e(trans('file.Subtotal')); ?></th>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div id="sale-footer" class="modal-body"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report #customer-report-menu").addClass("active");

    $('#customer_id').val($('input[name="customer_id_hidden"]').val());
    $('.selectpicker').selectpicker('refresh');

    $(document).on("click", "button.sale-link", function() {
        sale = $(this).data('sale');
        saleDetails(sale);
    });

    function saleDetails(sale){
        var htmltext = '<strong><?php echo e(trans("file.Date")); ?>: </strong>'+sale[0]+'<br><strong><?php echo e(trans("file.reference")); ?>: </strong>'+sale[1]+'<br><strong><?php echo e(trans("file.Warehouse")); ?>: </strong>'+sale[27]+'<br><strong><?php echo e(trans("file.Sale Status")); ?>: </strong>'+sale[2]+'<br><br><div class="row"><div class="col-md-6"><strong><?php echo e(trans("file.From")); ?>:</strong><br>'+sale[3]+'<br>'+sale[4]+'<br>'+sale[5]+'<br>'+sale[6]+'<br>'+sale[7]+'<br>'+sale[8]+'</div><div class="col-md-6"><div class="float-right"><strong><?php echo e(trans("file.To")); ?>:</strong><br>'+sale[9]+'<br>'+sale[10]+'<br>'+sale[11]+'<br>'+sale[12]+'</div></div></div>';
        $.get('../sales/product_sale/' + sale[13], function(data){
            $(".product-sale-list tbody").remove();
            var name_code = data[0];
            var qty = data[1];
            var unit_code = data[2];
            var tax = data[3];
            var tax_rate = data[4];
            var discount = data[5];
            var subtotal = data[6];
            var newBody = $("<tbody>");
            $.each(name_code, function(index){
                var newRow = $("<tr>");
                var cols = '';
                cols += '<td><strong>' + (index+1) + '</strong></td>';
                cols += '<td>' + name_code[index] + '</td>';
                cols += '<td>' + qty[index] + ' ' + unit_code[index] + '</td>';
                cols += '<td>' + parseFloat(subtotal[index] / qty[index]).toFixed(2) + '</td>';
                cols += '<td>' + tax[index] + '(' + tax_rate[index] + '%)' + '</td>';
                cols += '<td>' + discount[index] + '</td>';
                cols += '<td>' + subtotal[index] + '</td>';
                newRow.append(cols);
                newBody.append(newRow);
            });

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong><?php echo e(trans("file.Total")); ?>:</strong></td>';
            cols += '<td>' + sale[14] + '</td>';
            cols += '<td>' + sale[15] + '</td>';
            cols += '<td>' + sale[16] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=6><strong><?php echo e(trans("file.Order Tax")); ?>:</strong></td>';
            cols += '<td>' + sale[17] + '(' + sale[18] + '%)' + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=6><strong><?php echo e(trans("file.Order Discount")); ?>:</strong></td>';
            cols += '<td>' + sale[19] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);
            if(sale[28]) {
                var newRow = $("<tr>");
                cols = '';
                cols += '<td colspan=6><strong><?php echo e(trans("file.Coupon Discount")); ?> ['+sale[28]+']:</strong></td>';
                cols += '<td>' + sale[29] + '</td>';
                newRow.append(cols);
                newBody.append(newRow);
            }

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=6><strong><?php echo e(trans("file.Shipping Cost")); ?>:</strong></td>';
            cols += '<td>' + sale[20] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=6><strong><?php echo e(trans("file.grand total")); ?>:</strong></td>';
            cols += '<td>' + sale[21] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=6><strong><?php echo e(trans("file.Paid Amount")); ?>:</strong></td>';
            cols += '<td>' + sale[22] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=6><strong><?php echo e(trans("file.Due")); ?>:</strong></td>';
            cols += '<td>' + parseFloat(sale[21] - sale[22]).toFixed(2) + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            $("table.product-sale-list").append(newBody);
        });
        var htmlfooter = '<p><strong><?php echo e(trans("file.Sale Note")); ?>:</strong> '+sale[23]+'</p><p><strong><?php echo e(trans("file.Staff Note")); ?>:</strong> '+sale[24]+'</p><strong><?php echo e(trans("file.Created By")); ?>:</strong><br>'+sale[25]+'<br>'+sale[26];
        $('#sale-content').html(htmltext);
        $('#sale-footer').html(htmlfooter);
        $('#sale-details').modal('show');
    }

    $('#sale-table').DataTable( {
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
                    columns: ':visible:Not(.not-exported-sale)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_sale(dt, true);
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                    datatable_sum_sale(dt, false);
                },
                footer:true
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-sale)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_sale(dt, true);
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                    datatable_sum_sale(dt, false);
                },
                footer:true
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-sale)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_sale(dt, true);
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                    datatable_sum_sale(dt, false);
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
            datatable_sum_sale(api, false);
        }
    } );

    function datatable_sum_sale(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 5 ).footer() ).html(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.column( 5, {page:'current'} ).data().sum().toFixed(2));
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.column( 6, {page:'current'} ).data().sum().toFixed(2));
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(2));
        }
    }

    $('#payment-table').DataTable( {
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
                    columns: ':visible:Not(.not-exported-payment)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_payment(dt, true);
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                    datatable_sum_payment(dt, false);
                },
                footer:true
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_payment(dt, true);
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                    datatable_sum_payment(dt, false);
                },
                footer:true
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_payment(dt, true);
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                    datatable_sum_payment(dt, false);
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
            datatable_sum_payment(api, false);
        }
    } );

    function datatable_sum_payment(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 4 ).footer() ).html(dt_selector.cells( rows, 4, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.column( 4, {page:'current'} ).data().sum().toFixed(2));
        }
    }

    $('#return-table').DataTable( {
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
                    columns: ':visible:Not(.not-exported-quotation)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_return(dt, true);
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                    datatable_sum_return(dt, false);
                },
                footer:true
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_return(dt, true);
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                    datatable_sum_return(dt, false);
                },
                footer:true
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_return(dt, true);
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                    datatable_sum_return(dt, false);
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
            datatable_sum_return(api, false);
        }
    } );

    function datatable_sum_return(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.column( 6, {page:'current'} ).data().sum().toFixed(2));
        }
    }

    $('#quotation-table').DataTable( {
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
                    columns: ':visible:Not(.not-exported-quotation)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_quotation(dt, true);
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                    datatable_sum_quotation(dt, false);
                },
                footer:true
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_quotation(dt, true);
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                    datatable_sum_quotation(dt, false);
                },
                footer:true
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_quotation(dt, true);
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                    datatable_sum_quotation(dt, false);
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
            datatable_sum_quotation(api, false);
        }
    } );

    function datatable_sum_quotation(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.column( 6, {page:'current'} ).data().sum().toFixed(2));
        }
    }

$(".daterangepicker-field").daterangepicker({
  callback: function(startDate, endDate, period){
    var start_date = startDate.format('YYYY-MM-DD');
    var end_date = endDate.format('YYYY-MM-DD');
    var title = start_date + ' To ' + end_date;
    $(this).val(title);
    $('input[name="start_date"]').val(start_date);
    $('input[name="end_date"]').val(end_date);
  }
});

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>