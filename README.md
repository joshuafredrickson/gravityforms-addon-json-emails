# Gravity Forms Add-On: JSON-Formatted Email Notifications

This Gravity Forms add-on allows you to send email notifications with JSON-formatted form entry data.

## Installation

1. Download the latest zip from [Releases](https://github.com/joshuafredrickson/gravityforms-addon-json-emails/releases).
1. Install and activate the plugin.
1. Once the plugin is activated, you'll be able to set up JSON email feeds on any given form.

## Example Email

```
To: recipient@example.test
Message-ID: <5RKPJXYADpt9YGHiZqR3rfBHSmUINZVeuyHY98HIA@example.test>
X-Mailer: PHPMailer 6.9.1 (https://github.com/PHPMailer/PHPMailer)
Return-Path: <sender@example.test>
Received: from localhost by mailhog.example (MailHog)
          id gOn49ooSzPEnNg5qXfx-Hw23VlJ7J3ASjLuENMOLSjQ=@mailhog.example; Sat, 18 May 2024 19:06:00 -0500
Subject: Form 14: Entry 13
Date: Sun, 19 May 2024 00:06:00 +0000
From: Test Sender <sender@example.test>
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8

{"id":"13","status":"active","form_id":"14","ip":"127.0.0.1","source_url":"https:\/\/example.test\/wp\/?gf_page=preview&id=14","currency":"USD","post_id":null,"date_created":"2024-05-19 00:06:00","date_updated":"2024-05-19 00:06:00","is_starred":0,"is_read":0,"user_agent":"Mozilla\/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/124.0.0.0 Safari\/537.36","payment_status":null,"payment_date":null,"payment_amount":null,"payment_method":"","transaction_id":null,"is_fulfilled":null,"created_by":"22","transaction_type":null}
```
