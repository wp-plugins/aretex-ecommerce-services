=== AreteX eCommerce Services ===
Contributors: 3bcto
Donate link: http://aretex.org/
Tags: eCommerce, Paid Content, Membership, Affiliates, Marketplace, Credit Cards, Subscriptions, e-commerce
Requires at least: 3.8.1
Tested up to: 4.0.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Integrated eCommerce gateway for selling content and memberships, auto-pay affiliates and contributors and more. Accept single or recurring payments!

== Description ==
# Software as a Service #
AreteX&trade; is "Software as a Service" that facilitates and manages various eCommerce tasks and processes including one time and recurring payments, delivery of payment status notifications, digital delivery authorizations, automatic calculation and payments of things like commissions, royalties and contributor fees.

This plugin is "Serviceware" that allows you to connect your WordPress site to the AreteX&trade; eCommerce Server. It requires SSL (https://) for secure communication with the AreteX server.  Designed with robust flexibility for the WordPress professional, the plugin provides customer account management, payment tracking and reporting for referrers and contributors, and sales reports. It starts with a 30 Day Free AreteX™ "Sandbox" License, allowing you to test your eCommerce site without the inherent risks of a "real money" environment.

## Integrates with Roles and Capabilities ##
* Use nearly any "membership/role manager" plugin.
* Handles any number of paid roles or upgrades.
* One-time payment or subscription capability.
* Permanent or renewing roles.

## Sell Paid Content ##
* Generate shortcodes from the editor.
* Sell nearly any kind of WordPress content.
* Unlimited bundling/mix and match capability.
* Timed (drip) delivery.
* Content delivery tied to WordPress user ID.
* Automatically split any revenue with authors or other contributors
## Integrated Payment Gateways ###
The service includes an integrated *PCI Compliant credit card payment gateway* and an authorized *ACH transmission system*. Your data (including catalog, product, customer, sales, payout, and payees) are stored on the AreteX Server with industry standard security and **backed up daily**. *Note: Vantiv merchant account required to process Credit Cards. Forte (ACH Direct) merchant account required for Direct Deposit.* 
## Payment Models Include ##
* Single Payments
* Single or Monthly Donations
* Recurring Billing
  - With or Without a "Free Trial"
  - With Limited Payments or "Until Canceled"
  - Any payment cycle (daily, weekly, monthly, quarterly or yearly)
## Commission System ##
* Integrated Affiliate Tracking
* Direct Marketing Tracking for On-line *and* Off-line Promotion Efforts
* Tracking and Reporting System for Referrers (Affiliates & Sales Reps)
* Supports N-tier Commissions
## Automatic Payouts ##
* Automatically Track Payouts Owed based on Actual Sales
* Integrated ACH (Direct Deposit) Processing
* Set your own "payday" schedule.
## Full Range of Reports ##
* Sales with Direct Marketing Tracking (with or without commissions)
* Payouts
* Customers
* Delivery Logs and Pending Deliveries
* Export
  - Excel Spreadsheet (Actual Excel, not just CSV)
  - CSV
  - Print
## Customer Account Management ##
* Your customers can:
  - Manage their contact information.
  - View their purchase history.
  - Manage their rebill agreements (i.e. update their payment cards.)
## Ideal for ##
* Selling on-line training - both "self-paced" and "Instructor led".
* Open-Source Donations - Automatically split donations between all contributors.
* Selling premium content such as Themes and "Pro" versions of plugins.
  - Handles multiple contributors
  - Pay Contributors on Net, Gross or a Fixed amount per sale
* Setting up a "Digital Marketplace" where contributors are paid when their work is purchased.
  - Sell nearly *any* digital content: Articles, Downloads, Videos, Audio, Lessons
  - Timed (Drip) Delivery - Great for lessons and bonuses


== Installation ==

# System Requirements #

SSL installed
Only tested with Apache on Linux
PHP 5.3 or higher required


# To Install This Plugin #

## From the WordPress Repository ##
    1. Be sure an **SSL Certificate** is installed on your server.
    2. Log in to your WordPress site as an Administrator **with SSL**. _AreteX will not operate in an insecure environment._
    3. Select "Plugins / Add New / Search".
    4. Find "AreteX eCommerce Services".
    5. Select Install.
    6. Activate the Plugin.
    7. There will be an "eCommerce" selection on your admin menu.
    8. Follow the on-screen instructions to get your 30 day Free Sandbox account. (No credit card required).

## From AreteX.org ##
    1. Download the zip file from AreteX.org  onto your computer.
    2. Be sure an **SSL Certificate** is installed on your server.
    3. Log in to your WordPress site as an Administrator **with SSL**. _AreteX will not operate in an insecure environment._
    4. Select "Plugins / Add New / Upload".
    5. Browse to the folder on your computer where you downloaded the zip file.
    6. Upload the file.
    7. Activate the Plugin.
    8. There will be an "eCommerce" selection on your admin menu.
    9. Follow the on-screen instructions to get your 30 day Free Sandbox account. (No credit card required).


== Frequently Asked Questions ==

= Do you support international merchants? =

No. Currently AreteX is only available to merchants in the United States.

= Will AreteX work with ANY merchant account? =

No. AreteX requires that you have a *Vantiv* merchant account to process credit cards and a *Forte (ACH Direct)* account to process direct deposits.

= Do I need a separate payment gateway? =
No. The credit card payment gateway and ACH transmission is built into the AreteX service.  
In "Sandbox Mode" you will be able to process test transactions via the Vantiv test system.


== Screenshots ==

1. Wizards will walk you through setting up your paid content, memberships, commission structures etc.
2. Generate shortcodes for AreteX directly from your WordPress editor to paste into your pages or posts.
3. The offer code management screen.
4. The payout reports screen.
5. Customer Account Management screen. In this screen shot, your customer can see his own purchase history. 
6. Nearly all reports allow you to filter and download in native Excel spreadsheet format, CSV or Print.
7. On this Payment Tracking and Reporting Screen, your referrers and contributors can see how much they are currently owed. 
8. Direct marketing tracking (media source) setup screen.

== Changelog ==
= 2.29.50 =
Updated the Sandbox registration page with more information.  Fixed a checkbox location.

= 2.29.00 =
Automatically updates AreteX server side code to match capablities.
Fixed conflict when authorizing both paid content and paid subscriptions in the same manifest.
Added more caching to improve performance. 

= 2.28.00 = 
Internal version, not released.

= 2.27.02 =
Update feature paths to allow for new updates from beta.

= 2.27.01 =
Changed aretex_core_path from "Add" to "Update" to allow for new updates from beta.
= 2.27.00 =
First public release
= 2.26.00b =
Final Beta
= 2.25.01b =
Public beta/release candidate.  

== Upgrade Notice ==
= 2.29.00 =
This upgrade is required for the plugin to function properly because of a potential confilict with paid content and paid subsciptions in the same manifest.