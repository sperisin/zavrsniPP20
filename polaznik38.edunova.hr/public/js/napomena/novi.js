$(document).ready(function() {
    $('[data-toggle="datepicker"]').datepicker({
        autoPick: true,
        pick: function(e){
            e.preventDefault();
            var pickedDate = e.date;              
            var month = $(this).datepicker('getMonthName');
            var date = e.date.getDate();
            var day= $(this).datepicker('getDayName');
            $(".month").html(month);
            $(".date").html(date);
            $(".day").html(day);
            $(this).datepicker('hide'); 
        }
    });
  

});