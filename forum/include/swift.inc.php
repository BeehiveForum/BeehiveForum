<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

// Required includes
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'server.inc.php';
// End Required includes

// Include Swift Mailer
require_once BH_INCLUDE_PATH . 'swift/swift_required.php';

// Swift Mailer Transport Factory
abstract class Swift_TransportFactory
{
    public static function get()
    {
        $mail_function = forum_get_global_setting('mail_function', null, MAIL_FUNCTION_PHP);

        if ($mail_function == MAIL_FUNCTION_NONE) {
            return Swift_NullTransport::newInstance();
        }

        if (($mail_function == MAIL_FUNCTION_SMTP) && ($smtp_server = forum_get_global_setting('smtp_server'))) {

            $smtp_port = forum_get_global_setting('smtp_port', null, '25');

            $smtp_ssl = forum_get_global_setting('smtp_ssl', 'Y');

            $transport = Swift_SmtpTransportSingleton::getInstance($smtp_server, $smtp_port, $smtp_ssl);

            if (($smtp_username = forum_get_global_setting('smtp_username', 'strlen', false)) !== false) {

                /** @noinspection PhpUndefinedMethodInspection */
                $transport->setUsername($smtp_username);
            }

            if (($smtp_password = forum_get_global_setting('smtp_password', 'strlen', false)) !== false) {

                /** @noinspection PhpUndefinedMethodInspection */
                $transport->setPassword($smtp_password);
            }

            return $transport;
        }

        if (($mail_function == MAIL_FUNCTION_SENDMAIL) && ($sendmail_path = forum_get_global_setting('sendmail_path'))) {
            return Swift_SendmailTransportSingleton::getInstance($sendmail_path);
        }

        return Swift_MailTransportSingleton::getInstance();
    }

    public static function check_mail_vars()
    {
        if (server_os_mswin()) {
            if (!(bool)ini_get('sendmail_from') || !(bool)ini_get('SMTP')) return false;
        } else {
            if (!(bool)@ini_get('sendmail_path')) return false;
        }

        return true;
    }
}

// Swift Mailer SMTP Transport Singleton wrapper
class Swift_SmtpTransportSingleton extends Swift_SmtpTransport
{
    private static $instance;

    public static function getInstance($smtp_server, $smtp_port, $smtp_ssl = false)
    {
        if (is_null(self::$instance)) {
            self::$instance = Swift_SmtpTransport::newInstance($smtp_server, $smtp_port, $smtp_ssl ? 'ssl' : null);
        }

        return self::$instance;
    }
}

// Swift Mailer Mail Transport Singleton wrapper
class Swift_MailTransportSingleton extends Swift_MailTransport
{
    private static $instance;

    public static function getInstance()
    {
        if (!Swift_TransportFactory::check_mail_vars()) return false;

        if (is_null(self::$instance)) {
            self::$instance = Swift_MailTransport::newInstance();
        }

        return self::$instance;
    }
}

// Swift Mailer SendMail Transport Singleton wrapper
class Swift_SendmailTransportSingleton extends Swift_SendmailTransport
{
    private static $instance;

    public static function getInstance($sendmail_path)
    {
        if (!Swift_TransportFactory::check_mail_vars()) return false;

        if (is_null(self::$instance)) {
            self::$instance = Swift_SendmailTransport::newInstance($sendmail_path);
        }

        return self::$instance;
    }
}

// Beehive Forum SwiftMessage wrapper.
class Swift_MessageBeehive extends Swift_Message
{
    public function __construct($subject = null, $body = null, $contentType = null, $charset = null)
    {
        // Call the parent constructor.
        parent::__construct($subject, $body, $contentType, $charset);

        // Set the Beehive specific headers
        $this->set_headers();
    }

    private function set_headers()
    {
        // Get the forum name.
        $forum_name = forum_get_setting('forum_name', null, 'A Beehive Forum');

        // Get the forum email address
        $forum_email = forum_get_setting('forum_noreply_email', null, 'noreply@beehiveforum.co.uk');

        // Mail function we're using.
        $mail_function = forum_get_global_setting('mail_function', null, MAIL_FUNCTION_PHP);

        // Get the Swift Headers set
        $headers = $this->getHeaders();

        // Add PHP version number to headers
        $headers->addTextHeader('X-Mailer', 'PHP/' . phpversion());

        // Add the Beehive version number to headers
        $headers->addTextHeader('X-Beehive-Forum', 'Beehive Forum ' . BEEHIVE_VERSION);

        // Add header to identify Swift version
        $headers->addTextHeader('X-Swift-Mailer', 'Swift Mailer ' . Swift::VERSION);

        // Add header to identify mail function used
        $headers->addTextHeader('X-Beehive-Mail-Function', $mail_function);

        // Set the Message From Header
        $this->setFrom($forum_email, $forum_name);

        // Set the Message Reply-To Header
        $this->setReplyTo($forum_email, $forum_name);

        // Set the Message Return-path Header
        $this->setReturnPath($forum_email);
    }

    public static function newInstance($subject = null, $body = null, $contentType = null, $charset = null)
    {
        return new self($subject, $body, $contentType, $charset);
    }
}