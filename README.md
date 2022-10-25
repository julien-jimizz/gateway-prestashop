# Jimizz Gateway - Prestashop Integration

## Description
Jimizz Gateway - Prestashop Integration

This module adds a Jimizz Payment Gateway to your Prestashop installation.<br>
Jimizz is a cryptocurrency designed by the French leader of the porn industry.

When the Jimizz payment is chosen by your users, they are redirected to the Jimizz Gateway.<br>
Once they paid with Jimizz cryptocurrency on the blockchain, the Jimizz Gateway sends a Payment Notification to your server.<br>
This plugin generates an url that can catch the notification call from the Jimizz Gateway's server.

If payment was successful, this plugin validates the order through Prestashop.<br>
If payment was declined, the order will be cancelled.

This plugin also offers the possibility to use the Gateway in TEST mode, which allows you to simulate approved and failed payments during your integration tests.

## Requirements
* PHP >= 7.2
* [Prestashop](https://www.prestashop.com/)

## Installation
1. Upload the entire folder `jimizzgateway` to the `/modules/` directory

2. Activate the plugin through the 'Module Catalog' menu in Prestashop

## License
Please refer to [LICENSE](https://github.com/julien-jimizz/gateway-prestashop/blob/master/LICENSE).
