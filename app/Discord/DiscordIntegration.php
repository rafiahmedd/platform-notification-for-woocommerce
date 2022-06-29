<?php


namespace PlatformNotificationApp\Discord;

class DiscordIntegration extends \WC_Integration
{

    public function __construct ()
    {
        global $woocommerce;

        $this->id = 'wc_discord_integration';
        $this->method_title = __( 'Discord For WooCommerce', APP_TEXTDOMAIN );
        $this->method_description = __( 'Get notified in discord when a new order is placed', APP_TEXTDOMAIN );

        // Load the settings.
        $this->init_form_fields();
        $this->init_settings();

        // Define user set variables.
        $this->discord_webhook_url = $this->get_option('discord_webhook_url');
        $this->status = $this->get_option('status');

        // Actions.
        add_action( 'woocommerce_update_options_integration_' . $this->id, array( $this, 'process_admin_options' ) );

        // Filters.
        add_filter( 'woocommerce_settings_api_sanitized_fields_' . $this->id, array( $this, 'sanitize_settings' ) );
    }

    public function init_form_fields() {
        $this->form_fields = array(
            'discord_webhook_url' => array(
                'title'             => __( 'Discord Webhook URL', APP_TEXTDOMAIN ),
                'type'              => 'text',
                'desc_tip'          => true,
                'description'       => __( 'Enter your discord webhook url where you want to get the notifications.', 'discord-for-woocommerce' ),
                'default'           => ''
            ),
            'status' => array(
                'title'             => __( 'Status', APP_TEXTDOMAIN ),
                'type'              => 'checkbox',
                'label'             => __( 'Enable/Disable', APP_TEXTDOMAIN ),
                'default'           => 'no',
                'description'       => __( 'Enable/Disable the integration.', APP_TEXTDOMAIN ),
            )
        );
    }

    public function sanitize_settings( $settings ) {
        return $settings;
    }
}