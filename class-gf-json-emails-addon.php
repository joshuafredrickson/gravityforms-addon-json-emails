<?php

GFForms::include_feed_addon_framework();

class GfJsonEmailsAddOn extends GFFeedAddOn
{
    protected $_version = GF_JSON_EMAILS_ADDON_VERSION;
    protected $_min_gravityforms_version = '2.8.0';
    protected $_slug = 'gravityforms-addon-json-emails';
    protected $_path = 'gravityforms-addon-json-emails/gravityforms-addon-json-emails.php';
    protected $_full_path = __FILE__;
    protected $_title = 'Gravity Forms JSON-Formatted Email Notifications Add-On';
    protected $_short_title = 'JSON Emails';
    private static $_instance = null;

    /**
     * Get an instance of this class.
     */
    public static function get_instance(): GfJsonEmailsAddOn
    {
        if (self::$_instance == null) {
            self::$_instance = new GfJsonEmailsAddOn();
        }

        return self::$_instance;
    }

    /**
     * Plugin starting point. Handles hooks and loading of language files.
     */
    public function init(): void
    {
        parent::init();
    }

    /**
     * Process the feed e.g. subscribe the user to a list.
     *
     * @param array $feed The feed object to be processed.
     * @param array $entry The entry object currently being processed.
     * @param array $form The form object currently being processed.
     * @return void
     */
    public function process_feed($feed, $entry, $form)
    {
        $error = '';

        // Validate email addresses
        $from = $feed['meta']['fromEmail'];
        $to = $feed['meta']['toEmail'];

        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $error = 'Invalid "to" email: ' . print_r($to, true);
        } elseif (!filter_var($from, FILTER_VALIDATE_EMAIL)) {
            $error = 'Invalid "from" email: ' . print_r($from, true);
        }

        if ($error) {
            $this->log_debug("[JsonEmails] {$error}");

            // Add note to the entry
            $this->add_note(
                $entry['id'],
                "Failed to send JSON-formatted email: {$error}",
                'error'
            );

            return;
        }

        // Send the email
        $subject = "Form {$form['id']}: Entry {$entry['id']}";
        $message = wp_json_encode($entry);

        $emailSent = wp_mail($to, $subject, $message, [
            'From: ' . $from,
        ]);

        // Add note to the entry
        $this->add_note(
            $entry['id'],
            $emailSent
                ? "JSON-formatted email sent to {$to}."
                : "Failed to send JSON-formatted email to {$to}.",
            $emailSent ? 'success' : 'error'
        );

        return;
    }

    /**
     * Configures the settings which should be rendered on the feed edit page in the Form Settings area.
     *
     * @return array
     */
    public function feed_settings_fields()
    {
        return [[
            'title' => esc_html__('JSON Email Settings', 'jsonemailsaddon'),
            'fields' => [
                [
                    'label' => esc_html__('Feed name', 'jsonemailsaddon'),
                    'type' => 'text',
                    'name' => 'feedName',
                    'tooltip' => esc_html__('Enter a name to identify this feed. It is not public.', 'jsonemailsaddon'),
                    'class' => 'small',
                    'required' => 1,
                ],
                [
                    'label' => esc_html__('"To" email', 'jsonemailsaddon'),
                    'type' => 'text',
                    'name' => 'toEmail',
                    'tooltip' => esc_html__('The email will be sent to this address.', 'jsonemailsaddon'),
                    'class' => 'small',
                    'required' => 1,
                ],
                [
                    'label' => esc_html__('"From" email', 'jsonemailsaddon'),
                    'type' => 'text',
                    'name' => 'fromEmail',
                    'tooltip' => esc_html__('The email will be sent from this address.', 'jsonemailsaddon'),
                    'class' => 'small',
                    'required' => 1,
                ],
                [
                    'name' => 'condition',
                    'label' => esc_html__('Conditional Processing', 'jsonemailsaddon'),
                    'type' => 'feed_condition',
                ],
            ],
        ]];
    }

    /**
     * Configures which columns should be displayed on the feed list page.
     *
     * @return array
     */
    public function feed_list_columns()
    {
        return array(
            'feedName' => esc_html__('Feed', 'jsonemailsaddon'),
            'toEmail' => esc_html__('"To" email', 'jsonemailsaddon'),
            'fromEmail' => esc_html__('"From" email', 'jsonemailsaddon'),
        );
    }
}
