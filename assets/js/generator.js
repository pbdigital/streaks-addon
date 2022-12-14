(function($){

    $( '#color' ).wpColorPicker();
    $( '#button_color' ).wpColorPicker();
    $( '#streak_connection_color' ).wpColorPicker();
    $( '#today_color' ).wpColorPicker();

    function get_shortcode() {
        var id = $('#id').val()
        var color = $('#color').val()
        var button_color = $('#button_color').val()
        var streak_connection_color = $('#streak_connection_color').val()
        var today_color = $('#today_color').val()
        var pbd_class = $('#class').val()
        var pbd_count = $('#count').val()

        $.post(
            pbd.ajaxurl, 
            {
                'action': 'pbd_generate_shortcode',
                'id': id,
                'color': color,
                'button_color': button_color,
                'streak_connection_color': streak_connection_color,
                'today_color': today_color,
                'class': pbd_class,
                'count': pbd_count
            }, 
            function(response) {
                $('#pbd-preview-container').html(response)
            }
        );
    }

    $(document).on('click', '#generate-button', function(e){
        e.preventDefault();
        get_shortcode()
    })

    get_shortcode()


})(jQuery);