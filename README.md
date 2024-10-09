# PBD Streaks Add-on

## Description

The PBD Streaks Add-on is a WordPress plugin designed to enhance your site with a habit tracker style display. This plugin integrates seamlessly with GamiPress, allowing you to track user habits and rewards effectively.

## Features

- **Habit Tracking**: Users can track their habits and see their progress over time.
- **GamiPress Integration**: Requires GamiPress to function, providing a robust rewards system.
- **Easy Setup**: Simple installation and activation process.
- **Automatic Updates**: The plugin checks for updates from the GitHub repository.

## Requirements

- WordPress version 3.3 or higher
- GamiPress plugin installed and activated

## Installation

1. Download the plugin from the [GitHub repository](https://github.com/pbdigital/streaks-addon).
2. Upload the `pbd-streaks-addon` folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Ensure that GamiPress is installed and activated.

## Usage

Once activated, the PBD Streaks Add-on will automatically integrate with your GamiPress setup. You can configure the settings and start tracking habits directly from the GamiPress interface.

### Shortcodes

To display the habit tracker on your site, use the following shortcodes in your posts or pages:

1. Streaks Tracker:
```
[streaks id=61 color="#24D8A2" button_color="green" streak_connection_color="red" today_color="yellow" class="class_name_goes_here"]
```

2. Longest Streaks:
```
[longest_streaks id=61]
```

3. Current Streaks:
```
[current_streaks id=61]
```

#### Customization Options

You can customize the `[streaks]` shortcode with the following parameters:

- **id**: (required) Specify the GamiPress achievement type ID.
- **color**: (optional) Set the main color for the streak tracker. Default is "#24D8A2".
- **button_color**: (optional) Set the color for buttons. Default is "green".
- **streak_connection_color**: (optional) Set the color for streak connections. Default is "red".
- **today_color**: (optional) Set the color for today's date. Default is "yellow".
- **class**: (optional) Add custom CSS classes to the streak tracker container.

Example:
```
[streaks id=61 color="#FF5733" button_color="blue" streak_connection_color="#00FF00" today_color="#FFC300" class="my-custom-class"]
```

The `[longest_streaks]` and `[current_streaks]` shortcodes only require the `id` parameter, which should match the GamiPress achievement type ID used in the main `[streaks]` shortcode.

## License

This plugin is licensed under the MIT License. See the LICENSE file for more details.

## Author

- **PB Digital**  
  [Website](https://pbdigital.com.au/)  
  [Contact](mailto:info@pbdigital.com.au)

## Changelog

### Version 1.0.6
- Initial release with core features and GamiPress integration.

## Support

For support, please open an issue on the [GitHub repository](https://github.com/pbdigital/streaks-addon/issues).
