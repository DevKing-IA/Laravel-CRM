<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="<?php echo e(url('public/logo', $general_setting->site_logo)); ?>" />
    <title><?php echo e($general_setting->site_title); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">


    <style type="text/css">
        * {
            font-size: 14px;
            line-height: 24px;
            font-family: 'Ubuntu', sans-serif;
            text-transform: capitalize;
        }
        .btn {
            padding: 2px 2px;
            text-decoration: none;
            border: none;
            display: block;
            text-align: center;
            margin: 7px;
            cursor:pointer;
        }

        .btn-info {
            background-color: #999;
            color: #FFF;
        }

        .btn-primary {
            background-color: #6449e7;
            color: #FFF;
            width: 100%;
        }
        td,
        th,
        tr,
        table {
            border-collapse: collapse;
        }
        tr {border-bottom: 1px dotted #ddd;}
        td,th {padding: 1px 0;width: 50%;}

        table {width: 100%;}
        tfoot tr th:first-child {text-align: left;}

        .centered {
            text-align: center;
            align-content: center;
        }
        small{font-size:11px;}

        @media  print {
            * {
                font-size:14px;
                line-height: 20px;
            }
            td,th {padding: 1px 0;}
            .hidden-print {
                display: none !important;
            }
            @page  { margin: 0; } body { margin: 0.5cm; margin-bottom:1.6cm; } 
        }
    </style>
  </head>
<body>
<?php setlocale(LC_ALL,"es_ES"); ?>
<div style="max-width:1200px;margin:0 auto">
    <?php if(preg_match('~[0-9]~', url()->previous())): ?>
        <?php $url = '../../pos'; ?>
    <?php else: ?>
        <?php $url = url()->previous(); ?>
    <?php endif; ?>
    <div class="hidden-print">
        <table>
            <tr>
                <td><a href="<?php echo e($url); ?>" class="btn btn-info"><i class="fa fa-arrow-left"></i> <?php echo e(trans('file.Back')); ?></a> </td>
                <td><button onclick="window.print();" class="btn btn-primary"><i class="fa fa-print"></i> <?php echo e(trans('file.Print')); ?></button></td>
            </tr>
        </table>
        <br>
    </div>
    
        <table class="table mt-5">
            <tbody>
                <tr>
                    <td class="border-0 pl-0" width="70%">
                        <?php if($lims_biller_data->company_name == 'PRODECON'): ?>
                        <img src="<?php echo e(url('public/logo/CERT PRODECON.jpg')); ?>" height="135" width="240" style="margin:1px 0;filter: brightness(1);">
                        <p><strong>PRODECON
                        <br>COMERCIALIZADORA DE PRODUCTOS
                        <br>NIT: <?php echo e($lims_biller_data->vat_number); ?></strong>
                        </p>
                        <?php endif; ?>
                        <?php if($lims_biller_data->company_name == 'DEMACOL'): ?>
                        <img src="<?php echo e(url('public/logo/DEMACOL.jpg')); ?>" height="135" width="240" style="margin:1px 0;filter: brightness(1);">
                        <p><strong>DEMACOL
                        <br>DISTRIBUIDORA DE MATERIALES
                        <br>NIT: <?php echo e($lims_biller_data->vat_number); ?></strong>
                        </p>
                        <?php endif; ?>
                            
                    </td>
                    <td class="border-0 pl-0">
                        <?php 
                        $spanish_months = array(
                                    'January' => 'enero',
                                    'February' => 'febrero',
                                    'March' => 'marzo',
                                    'April' => 'abril',
                                    'May' => 'mayo',
                                    'June' => 'junio',
                                    'July' => 'julio',
                                    'August' => 'agosto',
                                    'September' => 'septiembre',
                                    'October' => 'octubre',
                                    'November' => 'noviembre',
                                    'December' => 'diciembre'
                                );
                        $month=date_format(date_create($lims_sale_data->created_at),'F');
                        $day=date_format(date_create($lims_sale_data->created_at),'d');
                        $sp_month=$spanish_months[$month];
                        $lims_dato=date_format(date_create($lims_sale_data->created_at),'Y-F-d');
                        $lims_data=date_format(date_create($lims_sale_data->created_at),'Y-F-d H:i:s');
                        $lims_data=str_replace($month, $sp_month, $lims_data);
 ?>
                        <p>
                        <?php if($lims_sale_data->reference_no > 1): ?>
                        <strong style="font-size:20px;">FECHA: <?php echo e($lims_data); ?></strong>
                        <br><strong style="font-size:20px;">COTIZACION-<?php echo e($lims_sale_data->reference_no); ?></strong>
                        <?php else: ?>
                        <strong style="font-size:20px;">FECHA: <?php echo e($lims_data); ?></strong>
                        <br><strong style="font-size:20px;"><?php echo e($lims_sale_data->reference_no); ?></strong>
                        <?php endif; ?>
                        <br><strong style="font-size:20px;">RAZON SOCIAL: <?php echo e($lims_customer_data->company_name); ?></strong>
                        <br><strong>CLIENTE: </strong><?php echo e($lims_customer_data->name); ?>

                        <br><strong>NIT: </strong><?php echo e($lims_customer_data->tax_no); ?>

                        <br><strong>DIRECCION: </strong><?php echo e($lims_customer_data->address); ?>

                        <br><strong>ZONA: </strong><?php echo e($lims_customer_data->zone); ?>

                        <br><strong>TELEFONO: </strong><?php echo e($lims_customer_data->phone_number); ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <table class="table">
            <thead>
               <tr style="border-bottom:1px solid;background-color:#ddd;">
                    <th style="padding: 5px;width:20%">Descripcion</th>
                    <th style="padding: 5px;width:20%">cantidad</th>
                    <th style="text-align:left">Pecio unitario</th>
                    <th style="padding: 5px;width:20%">subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $lims_product_sale_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_sale_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php 
                    $lims_product_data = \App\Product::find($product_sale_data->product_id);
                    if($product_sale_data->variant_id) {
                        $variant_data = \App\Variant::find($product_sale_data->variant_id);
                        $product_name = $lims_product_data->name.' ['.$variant_data->name.']';
                    }
                    else
                        $product_name = $lims_product_data->name;
                ?>
                <tr style="border-bottom:1px dotted"><td style="padding: 5px;width:30%"><?php echo e($product_name); ?></td>
                    <td style="text-align:center"><?php echo e($product_sale_data->qty); ?></td>
                    <td style="text-align:left"><?php echo e(number_format((float)($product_sale_data->total / $product_sale_data->qty), 2, '.', ',')); ?></td>
                    <td style="padding: 5px;width:20%"><?php echo e(number_format((float)$product_sale_data->total, 2, '.', ',')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot>
                <tr style="border-bottom:1px dotted">
                    <th colspan="3">Subtotal</th>
                    <th style="text-align:right"><?php echo e(number_format((float)$lims_sale_data->total_price, 2, '.', ',')); ?></th>
                </tr>
                <?php if($lims_sale_data->order_tax): ?>
                <tr style="border-bottom:1px dotted">
                    <th colspan="3">IVA 19%</th>
                    <th style="text-align:right"><?php echo e(number_format((float)$lims_sale_data->order_tax, 2, '.', ',')); ?></th>
                </tr>
                <?php endif; ?>
                <?php if($lims_sale_data->order_discount): ?>
                <tr style="border-bottom:1px dotted">
                    <th colspan="3">Retencion</th>
                    <th style="text-align:right"><?php echo e(number_format((float)$lims_sale_data->order_discount, 2, '.', ',')); ?></th>
                </tr>
                <?php endif; ?>
                <?php if($lims_sale_data->coupon_discount): ?>
                <tr style="border-bottom:1px dotted">
                    <th colspan="3"><?php echo e(trans('file.Coupon Discount')); ?></th>
                    <th style="text-align:right"><?php echo e(number_format((float)$lims_sale_data->coupon_discount, 2, '.', ',')); ?></th>
                </tr>
                <?php endif; ?>
                <?php if($lims_sale_data->shipping_cost): ?>
                <tr style="border-bottom:1px dotted">
                    <th colspan="3">RETEICA</th>
                    <th style="text-align:right"><?php echo e(number_format((float)$lims_sale_data->shipping_cost, 2, '.', ',')); ?></th>
                </tr>
                <?php endif; ?>
                <tr style="border-bottom:1px solid;background-color:#ddd;">
                    <th colspan="3">TOTAL</th>
                    <th style="text-align:right"><?php echo e(number_format((float)$lims_sale_data->grand_total, 2, '.', ',')); ?></th>
                </tr>
                <tr>
                    <?php if($general_setting->currency_position == 'prefix'): ?>
                    <th class="centered" colspan="3"><?php echo e(trans('file.In Words')); ?>: <span><?php echo e($general_setting->currency); ?></span> <span><?php echo e(str_replace("-"," ",$numberInWords)); ?></span></th>
                    <?php else: ?>
                    <th class="centered" colspan="3"><?php echo e(trans('file.In Words')); ?>: <span><?php echo e(str_replace("-"," ",$numberInWords)); ?></span> <span><?php echo e($general_setting->currency); ?></span></th>
                    <?php endif; ?>
                </tr>
            </tfoot>
        </table>
        <table>
            <tbody>
                <?php $__currentLoopData = $lims_payment_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr style="background-color:#ddd;">
                    <td style="padding: 5px;width:30%"><?php echo e(trans('file.Paid By')); ?>: Efectivo</td>
                    <td style="padding: 5px;width:40%"><strong>Cantidad pagada: <?php echo e(number_format((float)$payment_data->amount, 2, '.', ',')); ?></strong></td>
                    <td style="padding: 5px;width:30%"><?php echo e(trans('file.Change')); ?>: <?php echo e(number_format((float)$payment_data->change, 2, '.', ',')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr><td class="left" colspan="3"><strong style="font-size:18px;"><?php echo e($lims_sale_data->sale_note); ?></strong></td></tr>
                <tr><td class="left" colspan="3"><strong style="font-size:18px;">Firma recibido:___________________________________</strong></td></tr>
                <?php if($lims_biller_data->company_name == 'PRODECON'): ?>
                <tr><td class="centered" colspan="3"><strong>CR 86F No 51B-40 SUR BARRIO BETANIA, BOGOTA DC  TELEFONOS: 3136284216 - 3209990744 - 7231772</strong></td></tr>
                <tr><td class="centered" colspan="3"><strong>GRACIAS POR PREFERIRNOS PRODECON SIEMPRE CONTIGO</strong></td></tr>
                <?php endif; ?>
                <?php if($lims_biller_data->company_name == 'DEMACOL'): ?>
                <tr><td class="centered" colspan="3"><strong>CR 86F No 51B-40 SUR BARRIO BETANIA, BOGOTA DC  TELEFONOS: 3136284216 - 3209990744 - 7231772</strong></td></tr>
                <tr><td class="centered" colspan="3"><strong>GRACIAS POR PREFERIRNOS DEMACOL SIEMPRE CONTIGO</strong></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    <div id="receipt-data">
                 
        <!--<div class="centered">
            
        </div>
        <p><?php echo e(trans('file.Date')); ?>: <?php echo e($lims_sale_data->created_at); ?><br>
            <?php echo e(trans('file.reference')); ?>: <?php echo e($lims_sale_data->reference_no); ?><br>
            <?php echo e(trans('file.customer')); ?>: <?php echo e($lims_customer_data->name); ?>

        </p>
        <table>
            <tbody>
                <?php $__currentLoopData = $lims_product_sale_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_sale_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php 
                    $lims_product_data = \App\Product::find($product_sale_data->product_id);
                    if($product_sale_data->variant_id) {
                        $variant_data = \App\Variant::find($product_sale_data->variant_id);
                        $product_name = $lims_product_data->name.' ['.$variant_data->name.']';
                    }
                    else
                        $product_name = $lims_product_data->name;
                ?>
                <tr><td colspan="2"><?php echo e($product_name); ?><br><?php echo e($product_sale_data->qty); ?> x <?php echo e(number_format((float)($product_sale_data->total / $product_sale_data->qty), 2, '.', ',')); ?></td>
                    <td style="text-align:right;vertical-align:bottom"><?php echo e(number_format((float)$product_sale_data->total, 2, '.', '')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2"><?php echo e(trans('file.Total')); ?></th>
                    <th style="text-align:right"><?php echo e(number_format((float)$lims_sale_data->total_price, 2, '.', ',')); ?></th>
                </tr>
                <?php if($lims_sale_data->order_tax): ?>
                <tr>
                    <th colspan="2"><?php echo e(trans('file.Order Tax')); ?></th>
                    <th style="text-align:right"><?php echo e(number_format((float)$lims_sale_data->order_tax, 2, '.', ',')); ?></th>
                </tr>
                <?php endif; ?>
                <?php if($lims_sale_data->order_discount): ?>
                <tr>
                    <th colspan="2"><?php echo e(trans('file.Order Discount')); ?></th>
                    <th style="text-align:right"><?php echo e(number_format((float)$lims_sale_data->order_discount, 2, '.', ',')); ?></th>
                </tr>
                <?php endif; ?>
                <?php if($lims_sale_data->coupon_discount): ?>
                <tr>
                    <th colspan="2"><?php echo e(trans('file.Coupon Discount')); ?></th>
                    <th style="text-align:right"><?php echo e(number_format((float)$lims_sale_data->coupon_discount, 2, '.', ',')); ?></th>
                </tr>
                <?php endif; ?>
                <?php if($lims_sale_data->shipping_cost): ?>
                <tr>
                    <th colspan="2"><?php echo e(trans('file.Shipping Cost')); ?></th>
                    <th style="text-align:right"><?php echo e(number_format((float)$lims_sale_data->shipping_cost, 2, '.', ',')); ?></th>
                </tr>
                <?php endif; ?>
                <tr>
                    <th colspan="2"><?php echo e(trans('file.grand total')); ?></th>
                    <th style="text-align:right"><?php echo e(number_format((float)$lims_sale_data->grand_total, 2, '.', ',')); ?></th>
                </tr>
                <tr>
                    <?php if($general_setting->currency_position == 'prefix'): ?>
                    <th class="centered" colspan="3"><?php echo e(trans('file.In Words')); ?>: <span><?php echo e($general_setting->currency); ?></span> <span><?php echo e(str_replace("-"," ",$numberInWords)); ?></span></th>
                    <?php else: ?>
                    <th class="centered" colspan="3"><?php echo e(trans('file.In Words')); ?>: <span><?php echo e(str_replace("-"," ",$numberInWords)); ?></span> <span><?php echo e($general_setting->currency); ?></span></th>
                    <?php endif; ?>
                </tr>
            </tfoot>
        </table>
        <table>
            <tbody>
                <?php $__currentLoopData = $lims_payment_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr style="background-color:#ddd;">
                    <td style="padding: 5px;width:30%"><?php echo e(trans('file.Paid By')); ?>: <?php echo e($payment_data->paying_method); ?></td>
                    <td style="padding: 5px;width:40%"><?php echo e(trans('file.Amount')); ?>: <?php echo e(number_format((float)$payment_data->amount, 2, '.', ',')); ?></td>
                    <td style="padding: 5px;width:30%"><?php echo e(trans('file.Change')); ?>: <?php echo e(number_format((float)$payment_data->change, 2, '.', ',')); ?></td>
                </tr>
                <tr><td class="centered" colspan="3"><?php echo e(trans('file.Thank you for shopping with us. Please come again')); ?></td></tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>-->
        <!-- <div class="centered" style="margin:30px 0 50px">
            <small><?php echo e(trans('file.Invoice Generated By')); ?> <?php echo e($general_setting->site_title); ?>.
            <?php echo e(trans('file.Developed By')); ?> LionCoders</strong></small>
        </div> -->
    </div>
</div>

<script type="text/javascript">
    function auto_print() {     
        window.print()
    }
    setTimeout(auto_print, 1000);
</script>

</body>
</html>
