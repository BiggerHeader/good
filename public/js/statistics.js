/**
 * Created by xiaomi on 15-9-28.
 */
$(function () {
    var myDate = new Date();
    month = myDate.getMonth()+1;
    month = month < 10 ? '0' + month : month;
    var day = myDate.getDate() < 10 ? '0' + myDate.getDate() : myDate.getDate();
    var today = myDate.getFullYear() +'-'+month+'-'+day;
    var myyyDate = myDate.getTime()-1*3600*24*1000;
    var myyDate = new Date(myyyDate);
    var y_month = myyDate.getMonth()+1;
    y_month = y_month < 10 ? '0' + y_month : y_month;
    var y_day = myyDate.getDate() < 10 ? '0' + myyDate.getDate() : myyDate.getDate();
    var yesterday = myyDate.getFullYear()+'-'+y_month+'-'+y_day;
    var lastDate = {
        startDate: '',
        endDate: ''
    };

    $('.social-time-box').daterangepicker(
        {
            format: 'YYYY-MM-DD',
            opens: 'left',
            cancelLabel: 'Clear',
            maxDate:today
        }
    );

    $('.social-time-box').on('cancel.daterangepicker', function(ev, picker) {
        $('#social_time').val('请选择时间');//取消：清空
    });

    $('.social-time-box').on('apply.daterangepicker', function(ev, picker) {
        getTime(ev, picker);
    });

    $('.social-time-box').on('hide.daterangepicker', function(ev, picker) {
        //DateNotChanged(ev);
    });

    //获取指定日期
    function getTime(ev, picker){
        var newStartDate = picker.startDate.format('YYYY-MM-DD'),
            newEndDate = picker.endDate.format('YYYY-MM-DD'),
            target = $(ev.target),
            target_siblings = target.siblings();

        if (target.attr('id') === 'device_other_time') {
            target.addClass('device_othertime_type');
            if (newStartDate === newEndDate) {
                target.html(newStartDate);
            } else {
                target.html(newStartDate + ' - ' + newEndDate);
            }
        }

        if (lastDate.startDate == newStartDate && lastDate.endDate == newEndDate) {
            return;
        }
        lastDate.startDate = newStartDate;
        lastDate.endDate = newEndDate;

//        console.log("开始日期：",newStartDate);
//        console.log("结束日期：",newEndDate);
        $('#social_time').val(newStartDate +'  至  ' + newEndDate);
        $('#social_time_2').val(newStartDate +'  至  ' + newEndDate);
        $('#social_time_3').val(newStartDate +'  至  ' + newEndDate);
    }
    $(".singleDatePicker").daterangepicker({
        singleDatePicker: true,
        format: 'YYYY-MM-DD',
        opens: 'left',
        cancelLabel: 'Clear',
        maxDate:today,
        parentEl:".navbar"
    });
    $('.singleDatePicker').on('cancel.daterangepicker', function(ev, picker) {
        $('#social_time').val('请选择时间');//取消：清空
    });
    $('.singleDatePicker').on('apply.daterangepicker', function(ev, picker) {
        var id = $(this).children("input").attr("id");
        getTime_single(ev, picker,id);
    });
    $('.singleDatePicker').on('hide.daterangepicker', function(ev, picker) {
        //DateNotChanged(ev);
    });
    function getTime_single(ev, picker,obj){
        var newStartDate = picker.startDate.format('YYYY-MM-DD'),
            target = $(ev.target),
            target_siblings = target.siblings();
        if (target.attr('id') === 'device_other_time') {
            target.addClass('device_othertime_type');
            target.html(newStartDate);
        }
        $("#"+obj+"").val(newStartDate);
    }
});

