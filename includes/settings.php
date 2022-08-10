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
                    <th scope="row">Days Streak Triggers</th>
                    <td>
                        <input type="text" name="pbd_sa_settings[days_streak]" size="40" value="<?= $pbd_sa_settings['days_streak'] ?>"/>
                        <br />
                        <small>Comma separated values of different days streak. i.e : 5,7,14,21 </small>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Achievement IDs</th>
                    <td>
                        <input type="text" name="pbd_sa_settings[achievement_ids]" size="40" value="<?= $pbd_sa_settings['achievement_ids'] ?>"/>
                    </td>
                </tr>
            </tbody>
        </table>

        <?php submit_button(); ?>
    </form>

</div>