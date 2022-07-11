<?php
namespace PlatformNotificationApp\Slack;

class SlackIntegration extends \WC_Integration
{

    /**
     * Init and hook in the integration.
     */
    public function __construct ()
    {
        global $woocommerce;

        $this->id = 'wc_slack_integration';
        $this->method_title = __( 'Slack For WooCommerce', APP_TEXTDOMAIN );
        $this->method_description = __( 'Get notified in slack when a new order is placed', APP_TEXTDOMAIN );

        // Load the settings.
        $this->init_form_fields();
        $this->init_settings();

        // Define user set variables.
        $this->slack_bot_token = $this->get_option( 'slack_bot_token' );
        $this->slack_channel_name = $this->get_option('slack_channel_name');
        $this->slack_channel_id = $this->get_option('slack_channel_id');

        // Actions.
        add_action( 'woocommerce_update_options_integration_' . $this->id, array( $this, 'process_admin_options' ) );

        // Filters.
        add_filter( 'woocommerce_settings_api_sanitized_fields_' . $this->id, array( $this, 'sanitize_settings' ) );

        if ( $this->get_option( 'status' ) == 'yes' ) {
            $this->handleNotifications();
        }
    }

    public function init_form_fields() {
        $this->form_fields = array(
            'slack_bot_token'   => array(
                'title'             => __( 'Slack Bot Token', APP_TEXTDOMAIN ),
                'type'              => 'password',
                'desc_tip'          => true,
                'description'       => __( 'Enter your slack bot token.', APP_TEXTDOMAIN ),
                'default'           => ''
            ),
            'slack_channel_name' => array(
                'title'             => __( 'Slack Channel Name', APP_TEXTDOMAIN ),
                'type'              => 'text',
                'desc_tip'          => true,
                'description'       => __( 'Enter your slack channel name where you want to get the notifications.', APP_TEXTDOMAIN ),
                'default'           => ''
            ),
            'slack_channel_id' => array(
                'title'             => __( 'Slack Channel ID', 'slack-for-woocommerce' ),
                'type'              => 'text',
                'desc_tip'          => true,
                'description'       => __( 'Enter your slack channel id where you want to get the notifications.', APP_TEXTDOMAIN ),
                'default'           => ''
            ),
            'notifications'         => array(
                'title'             => __( 'Notifications', APP_TEXTDOMAIN ),
                'type'              => 'multiselect',
                'description'       => __( 'Notifications that are enabled at this moment', APP_TEXTDOMAIN ),
                'default'           => array( 'new_order' ),
                'options'           => array(
                    'new_order' => 'New Order',
                    'pending'   => 'Pending Order',
                    'processing' => 'Processing Order',
                    'on-hold'   => 'On Hold Order',
                    'completed' => 'Completed Order',
                    'cancelled' => 'Cancelled Order',
                    'refunded'  => 'Refunded Order',
                    'failed'    => 'Failed Order',
                    'all'       => 'On any changes'
                )
            ),
            'status' => array(
                'title'             => __( 'Status', APP_TEXTDOMAIN ),
                'type'              => 'checkbox',
                'label'             => __( 'Enable Slack integration', APP_TEXTDOMAIN ),
                'default'           => 'no',
                'description'       => __( 'Enable/Disable Slack integration', APP_TEXTDOMAIN ),
            )
        );
    }

    public function sanitize_settings( $settings ) {
        return $settings;
    }

    private function handleNotifications ()
    {
        add_action('woocommerce_order_status_changed', array( new NotificationOnStatusChange , 'onStatusChanged'), 10, 3);
        add_action('woocommerce_new_order', array( new NotificationOnOrder , 'newOrder'));
    }
}