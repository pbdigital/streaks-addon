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
        initialView: 'dayGridMonth',
        dayMaxEvents: true, // allow "more" link when too many events
        events: list_events,
    });

    

    $(document).on('click', '.view-full-calendar', function(e) {
        e.preventDefault();
        $('.week-view').slideUp('slow')
        $('.month-view').slideDown('slow')
        srcCalendar.render();
    })

    $(document).on('click', '.hide-full-calendar', function(e) {
        e.preventDefault();
        $('.month-view').slideUp('slow')
        $('.week-view').slideDown('slow')
        srcCalendar.destroy();
    })

})(jQuery);