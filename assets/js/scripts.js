(function($){

    var list_events = pbd.events.map( event => {
        return {
            title: '',
            start: event.date,
            end: event.date,
            className: "selected-event"
        }
    })

    srcCalendarEl = document.getElementById('source-calendar'); //$('#pbd-sa-calendar')
    srcCalendar = new FullCalendar.Calendar(srcCalendarEl, {
        headerToolbar: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        height:"auto",
        selectable:false,
        selectHelper:true,
        initialView: 'dayGridMonth',
        dayMaxEvents: true, // allow "more" link when too many events
        events: list_events
    });

    // Calendar 

    $('.selected-event').closest('td').addClass('active-streak');
    $('.active-streak + td:not(.active-streak)').prev().addClass('last-streak');
    $('.active-streak').last().addClass('very-last');

    function callCalendar() {
        $('#source-calendar').css('visibility', 'hidden');
        setTimeout(() => {                    
            srcCalendar.destroy();
            $('#source-calendar').css('visibility', 'visible');
            srcCalendar.render();
            $('.selected-event').closest('td').addClass('active-streak');
            $('.active-streak + td:not(.active-streak)').prev().addClass('last-streak');
            $('.active-streak').last().addClass('very-last');
        }, 100);

        setTimeout( () => {
            $(".has-previous-streak").each( function(){
                $(this).closest("td").addClass("fc-daypast-nostreak");
            });
        }, 100);
    }

    $(document).on("click",".fc-button", () => {
        callCalendar();
    });

    

    $(document).on('click', '.view-full-calendar', function(e) {
        e.preventDefault();

        
        $('.week-view').hide()
        $('.month-view').show()
        
        callCalendar();

    })

    $(document).on('click', '.hide-full-calendar', function(e) {
        e.preventDefault();
        $('.month-view').hide()
        $('.week-view').show()

        callCalendar();
    })



    // circle progress bar for week view
    let dayStatus = $('.day-status');

    dayStatus.circleProgress({
        size: 36,
        startAngle: -1.55,
        lineCap: 'round',
        fill: {color: pbd.color}
    });
   


})(jQuery);