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

### Shortcode

To display the habit tracker on your site, use the following shortcode in your posts or pages:
[pbd_streaks_tracker]
#### Customization Options

You can customize the shortcode with the following parameters:

- **user_id**: (optional) Specify the user ID to display the habit tracker for a specific user. Default is the current logged-in user.
  
  Example: 
  ```markdown
  [pbd_streaks_tracker user_id="123"]
  ```

- **show_progress**: (optional) Set to `true` or `false` to show or hide the progress bar for habits. Default is `true`.
  
  Example: 
  ```markdown
  [pbd_streaks_tracker show_progress="false"]
  ```

- **layout**: (optional) Choose the layout style for the tracker. Options are `vertical` or `horizontal`. Default is `vertical`.
  
  Example: 
  ```markdown
  [pbd_streaks_tracker layout="horizontal"]
  ```

- **title**: (optional) Customize the title of the habit tracker display.
  
  Example: 
  ```markdown
  [pbd_streaks_tracker title="My Custom Habit Tracker"]
  ```

This shortcode will display the habit tracker for user ID 123, show the progress bar, use a horizontal layout, and set a custom title.




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
