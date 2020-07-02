   <!-- <table id="transation-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th class="not-exported-transaction"></th>
                            <th>{{trans('file.Image')}}</th>                            
                            <th>{{trans('file.product')}} {{trans('file.name')}}</th>
                            <th>{{trans('file.product')}} ({{trans('file.qty')}})</th> 
                            <th>{{trans('file.Delivery')}} {{trans('file.reference')}}</th>                           
                            <th>{{trans('file.grand total')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lims_truck_data as $k=>$item)                       
                        <tr>
                            <td>{{$k}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->qty}}</td>
                            <td>{{$item->reference_no}}</td>
                            <td>{{$item->total}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="tfoot active">
                        <tr>
                            <th></th>
                            <th>Total:</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table> -->