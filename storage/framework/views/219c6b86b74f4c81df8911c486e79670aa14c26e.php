 <?php $__env->startSection('content'); ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<?php if(session()->has('create_message')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('create_message')); ?></div> 
<?php endif; ?>
<style>
    .fc-center>div {
        display: -ms-flexbox;
        display: flex;
    }
    .fc-toolbar h2 {
        margin: 5px 20px !important;
        font-size: 30px;
    }
    .fc-widget-header .fc-title{
        color:red
    }
    .fc-title{
        color:white
    }
    .fc-time{
        color:red
    }
  
</style>
<link rel="stylesheet" href="https://unpkg.com/fullcalendar@3.10.2/dist/fullcalendar.min.css"></link>  
<script type="text/javascript" src="https://unpkg.com/moment@2.26.0/min/moment.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/fullcalendar@3.10.2/dist/fullcalendar.min.js"></script>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="fullcalendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">   
 $( document ).ready(function() {
    var fullcalendar = <?php echo json_encode($events)?>; 
    var fullcalendar_data=[];
    for(var i=0; i<fullcalendar.length;i++){				
        var item={
                title:fullcalendar[i].meeting,
                start:fullcalendar[i].start_time,      
            }
            fullcalendar_data.push(item)
        }
    $('.fullcalendar').fullCalendar({
        header: {
        left: '',
        center: 'prev,title,next',
        right: ''
        },
        height: '970',
        contentHeight: 'auto',
        weekNumbers: true,
        eventLimit: true, // allow "more" link when too many events
        events: fullcalendar_data
    });
    $("ul#calendar").siblings('a').attr('aria-expanded','true');
    $("ul#calendar").addClass("show");
    $("ul#calendar #calendar-create-menu").addClass("active");
 });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>