=== Stopwatch ===
Contributors: luisperezphd
Donate link: 
Tags: stopwatch
Requires at least: 3.3
Tested up to: 3.5
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A stopwatch, start, stop, pause, etc.

== Description ==

A stopwatch from <a href="http://ipadstopwatch.com">ipadstopwatch.com</a>. It works on PC and mobile devices. It adjusts to any size. Very easy to use and keeps running after you leave which makes it perfect for measuring long running tasks that span hours, even days.

== Installation ==

You can download and install Stopwatch using the built in WordPress plugin installer. If you download Stopwatch manually, make sure it is uploaded to "/wp-content/plugins/stopwatch/".

Activate Stopwatch in the "Plugins" admin panel using the "Activate" link.

== Screenshots ==

1. **Paused** - Keeps running even after the user leaves. Big colorful buttons makes it easy to understand and use.
2. **Running** - Unnecessary buttons disappear, displays the elapsed time down to the milliseconds.
3. **Start** - Users will always know what to do first, when it loads nothing but a big green button.

== How it works ==

The widget works by pulling in the stopwatch from the actual
ipadstopwatch.com site. This way the person can start and stop the 
stopwatch and stopwatch can continue working after the leave the site
by tracking the time in the ipadstopwatch.com cookie.

More specifically it pulls in an HTML file into an iframe.