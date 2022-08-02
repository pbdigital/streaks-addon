<div class="wrap ">

    <h2>PBD Streaks Settings</h2>



    <?php
        $pbd_sa_settings  = get_option('pbd_sa_settings');  

    ?>
    <form method="post" action="options.php">
        <?php settings_fields( 'pbd_sa_settings' ); ?>
        <?php do_settings_sections( 'pbd_sa_settings' ); ?> 
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">Action hook</th>
                    <td>
                        <input type="text" name="pbd_sa_settings[action_hook]" size="40" value="<?= $pbd_sa_settings['action_hook'] ?>"/>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Streaks Count</th>
                    <td>
                        <input type="text" name="pbd_sa_settings[streak_count]" size="40" value="<?= $pbd_sa_settings['streak_count'] ?>"/>
                        <br/>
                        <small>Number of times before event will trigger.</smal>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php
            // if (isset($_GET['tab']) && $_GET['tab'] == 'projects') {
            //     // include_once(N2PDF_PATH_INCLUDES . '/ninja2pdf-licenses.php');
            // } else 
        ?>
        <?php submit_button(); ?>
    </form>

</div>