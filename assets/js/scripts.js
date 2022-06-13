(function($){

    var list_events = events.map( event => {
        return {
            title: '',
            start: event.start,
            end: event.js_end,
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
        events: [{
            "title": '',
            "className": "selected-event",
            "start": '2022-06-10',
            "end": '2022-06-10'
        },
        {
            "title": '',
            "className": "selected-event",
            "start": '2022-06-11',
            "end": '2022-06-11'
        },
        {
            "title": '',
            "className": "selected-event",
            "start": '2022-06-12',
            "end": '2022-06-12'
        },
        {
            "title": '',
            "className": "selected-event",
            "start": '2022-06-13',
            "end": '2022-06-13'
        },
        {
            "title": '',
            "className": "selected-event",
            "start": '2022-06-18',
            "end": '2022-06-18'
        },
        {
            "title": '',
            "className": "selected-event",
            "start": '2022-06-20',
            "end": '2022-06-20'
        },
        {
            "title": '',
            "className": "selected-event",
            "start": '2022-06-21',
            "end": '2022-06-21'
        },
        {
            "title": '',
            "className": "selected-event",
            "start": '2022-06-22',
            "end": '2022-06-22'
        }]
    });

    // Calendar 
    srcCalendar.render();

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

        
        $('.week-view').slideUp('slow')
        $('.month-view').slideDown('slow')
        
        callCalendar();

    })

    $(document).on('click', '.hide-full-calendar', function(e) {
        e.preventDefault();
        $('.month-view').slideUp('slow')
        $('.week-view').slideDown('slow')

        callCalendar();
    })



    // circle progress bar for week view
    let dayStatus = $('.day-status');

    dayStatus.circleProgress({
        size: 36,
        startAngle: -1.55,
        lineCap: 'round',
        fill: {color: '#00BEDF'}
    });
   


})(jQuery);