<?php

namespace Wpshop\Core;

/**
 * Class ContactForm
 *
 * 1.0.2    2020-09-08    Add filter 'wpshop_contact_form_email_to' for email to
 * 1.0.1    2020-05-25    Add filter for message sent text
 */
class ContactForm {

    protected $options;

    public $fields;
    protected $fields_out = '';

    protected $nonce_action = 'wpshop_nonce_action';
    protected $nonce_name = 'wpshop_nonce_name';

    protected $errors;

    protected $success = false;

    public $admin_email;


    /**
     * Contact_Form constructor.
     *
     * @param ThemeOptions $options
     */
    public function __construct( ThemeOptions $options ) {

        $this->options = $options;

        $this->nonce_action = $this->options->theme_slug . '_nonce_action';
        $this->nonce_name = $this->options->theme_slug . '_nonce_name';

        add_shortcode( 'contactform', array( $this, 'display_form' ) );
        add_action( 'init', array( $this, 'send_form' ) );

        $this->admin_email = apply_filters( 'wpshop_contact_form_email_to', get_option( 'admin_email' ) );

    }


    public function send_form() {

        if ( ! empty( $_POST['email'] ) ) {
            return;
        }

        $body = '';

        if ( ! empty( $_POST['submitted'] ) && $_POST['submitted'] == 'submitted' ) {

            if ( wp_verify_nonce( $_POST[ $this->nonce_name ], $this->nonce_action ) ) {

                if ( empty( $_POST['fields'] ) ) $this->errors[] = __( 'Sorry, but we can\'t send form. Error #1', $this->options->text_domain );

                $fields = json_decode( base64_decode( $_POST['fields'] ), true );

                if ( empty( $fields ) ) $this->errors[] = __( 'Sorry, but we can\'t send form. Error #2', $this->options->text_domain );

                foreach ( $fields as $n => $field ) {

                    $field_name = $field['name'];
                    if ( ! empty( $field['placeholder'] ) ) $field_name = $field['placeholder'];
                    if ( ! empty( $field['label'] ) ) $field_name = $field['label'];

                    if ( isset( $field['required'] ) && $field['required'] == 'required' && empty( $_POST[ $field['name'] ] ) ) {
                        $this->errors[] = __( 'Fill field ' . $field_name, $this->options->text_domain );
                        $fields[$n]['error'] = 'error';
                    }

                    if ( ! empty( $_POST[ $field['name'] ] ) ) {

                        $body .= $field_name . ': ' . PHP_EOL . sanitize_text_field( $_POST[ $field['name'] ] ) . PHP_EOL . PHP_EOL;

                    }
                }

                $name = ( ! empty( $_POST['contact-name'] ) ) ? sanitize_text_field( $_POST['contact-name'] ) : 'Contact Form' ;
                $from_email = ( ! empty( $_POST['contact-email'] ) ) ? sanitize_text_field( $_POST['contact-email'] ) : $this->admin_email ;
                $subject = ( ! empty( $_POST['contact-subject'] ) ) ? sanitize_text_field( $_POST['contact-subject'] ) : __( 'Message from contact form', $this->options->text_domain );

                if ( ! is_email( $from_email ) ) {
                    $this->errors[] = __( 'Wrong e-mail format', $this->options->text_domain );
                }

                $body .= __( 'Message from ', $this->options->text_domain ) . get_site_url();

                if ( empty( $this->errors ) ) {

                    $mail_from = apply_filters( 'wpshop_contact_form_email_from' , $from_email );
                    $headers = 'From: '.$name.' <'.$mail_from.'>' . "\r\n" . 'Reply-To: ' . $from_email;

                    wp_mail( $this->admin_email, $subject, $body, $headers );

                    $this->success = true;

                }

            }
        }
    }

    public function display_form( $atts ) {

        $out = '';

        $out .= '<div class="contact-form">';

        if ( $this->success ) {
            $out .= '<div class="contact-form__success">';
            $out .= apply_filters( 'wpshop_contact_form_message_sent', __( 'Message sent successfully!', $this->options->text_domain ) );
            $out .= '</div>';
        }

        if ( ! empty( $this->errors ) ) {
            $out .= '<ul class="contact-form__errors">';
            foreach ( $this->errors as $error ) {
                $out .= '<li>' . $error . '</li>';
            }
            $out .= '</ul>';
        }

        if ( ! $this->success ) {
            $out .= $this->form_start();
            $out .= $this->fields_out;
            $out .= $this->form_end();
        }
        $out .= '</div>';

        return $out;

    }


    protected function form_start() {
        $out = '';
        $out .= '<form action="" method="post">';
        $out .= '<input type="email" name="email" style="display:none;">';

        return $out;
    }


    protected function form_end() {
        $out = '';

        $fields_out = base64_encode( json_encode($this->fields) );

        $out .= wp_nonce_field( $this->nonce_action, $this->nonce_name, true, false );
        $out .= '<input type="hidden" name="redirect_url" value="' . get_the_permalink() . '">';
        $out .= '<input type="hidden" name="submitted" value="submitted">';
        $out .= '<input type="hidden" name="fields" value="' . $fields_out . '">';
        $out .= apply_filters( 'wpshop_text_before_submit', '' );
        $out .= '<button type="submit" name="submit" class="btn btn-primary">' . __( 'Send', $this->options->text_domain ) . '</button>';
        $out .= '</form>';

        return $out;
    }


    protected function create_field( $args = array() ) {

        $out = '';
        $atts = array();
        $attributes = '';

        if ( empty( $args['name'] ) ) return '<!-- name required -->';

        $tag         = ( ! empty( $args['tag'] ) ) ? $args['tag'] : 'input';

        $type        = ( ! empty( $args['type'] ) ) ? $args['type'] : 'text';
        $placeholder = ( ! empty( $args['placeholder'] ) ) ? $args['placeholder'] : '';
        $name        = ( ! empty( $args['name'] ) ) ? $args['name'] : '';
        $label       = ( ! empty( $args['label'] ) ) ? $args['label'] : '';
        $value       = ( ! empty( $_POST[ $name ] ) ) ? trim( $_POST[ $name ] ) : '';
        $required    = ( ! empty( $args['required'] ) ) ? true : false;

        if ( ! empty( $type ) )         $atts['type'] = $type;
        if ( ! empty( $placeholder ) )  $atts['placeholder'] = $placeholder;
        if ( ! empty( $name ) )         $atts['name'] = $name;
        if ( ! empty( $name ) )         $atts['id'] = $name;
        if ( ! empty( $value ) )        $atts['value'] = $value;
        if ( $required )                $atts['required'] = 'required';

        $atts['class'] = 'field-' . $name;
        if ( $required ) $atts['class'] .= ' field-required';

        if ( $tag == 'textarea' ) {
            unset( $atts['type'] );
            unset( $atts['value'] );
        }

        foreach ( $atts as $k => $v ) {
            $attributes .= ' ' . $k . '="' . esc_attr( $v ) . '"';
        }

        $out .= '<div class="contact-form__field contact-form--type-' . $type . '">';
        if ( ! empty( $label ) ) $out .= '<label for="' . $name . '">' . $label . '</label>';
        if ( $tag == 'textarea' ) {
            $out .= '<textarea' . $attributes . '>' . $value . '</textarea>';
        } else {
            $out .= '<input' . $attributes . '>';
        }
        $out .= '</div>';

        return $out;
    }


    public function create_fields( $fields = array() ) {
        if ( ! is_array( $fields ) ) return;
        $this->fields = $fields;

        foreach ( $fields as $field ) {
            $this->fields_out .= $this->create_field( $field );
        }
    }

}