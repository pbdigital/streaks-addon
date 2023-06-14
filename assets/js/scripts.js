(function($){

    function renderCalendar(id, events) {
        var list_events = events.map( event => {
            return {
                title: '',
                start: event.date,
                end: event.date,
                className: "selected-event"
            }
        })
    
        srcCalendarEl = document.getElementById(id);
        srcCalendar = new FullCalendar.Calendar(document.getElementById(id), {
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
    
        srcCalendar.render();

        $('.selected-event').closest('td').addClass('active-streak');
        $('.active-streak + td:not(.active-streak)').prev().addClass('last-streak');
        $('.active-streak').last().addClass('very-last');
    }

    $(document).on("click",".fc-button", () => {
        $('.selected-event').closest('td').addClass('active-streak');
        $('.active-streak + td:not(.active-streak)').prev().addClass('last-streak');
        $('.active-streak').last().addClass('very-last');
    });

    

    $(document).on('click', '.view-full-calendar', function(e) {
        e.preventDefault();

        
        $(this).parent().parent().find('.week-view').hide()
        $(this).parent().parent().find('.month-view').show()

        renderCalendar($(this).data('id'), $(this).data('events'))
    })

    $(document).on('click', '.hide-full-calendar', function(e) {
        e.preventDefault();
        $(this).parent().parent().find('.month-view').hide()
        $(this).parent().parent().find('.week-view').show()
    })



    
   


})(jQuery);