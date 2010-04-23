dmFloodControlPlugin provides a way to limit the number of action a client (identified with an IP) can do.
You can assign a number of credits for an action. When the client uses this action, a credit is used.
When all credits are used, a dmFloodControlOutOfCreditException is thrown.
This plugin can be used to prevent bots to send tons of mails from your website, for example.
Note that it is not as efficient as a captcha.

The plugin is fully extensible. Only works with [Diem 5](http://diem-project.org/) installed.

Documentation
-------------

See the online documentation : [Diem Flood Control plugin documentation](http://diem-project.org/plugins/dmfloodcontrolplugin)