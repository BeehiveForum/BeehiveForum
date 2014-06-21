<?php

define('BH_INCLUDE_PATH', 'forum/include/');
define('BH_FORUM_PATH', 'forum/');

require_once 'forum/boot.php';

email_send_notification(41081, 1);
email_send_thread_subscription(26255, 1);
email_send_folder_subscription(40776, 1);
email_send_pm_notification(24306);
email_send_pw_reminder('MATT');
email_send_new_pw_notification(19, 19, 'inkj34ken123n12nn2');
email_send_user_confirmation(19);
email_send_changed_email_confirmation(19);
email_send_user_approval_notification(19, 19);
email_send_new_user_notification(19, 19);
email_send_user_approved_notification(19);
email_send_post_approval_notification(19);
email_send_link_approval_notification(19);
email_send_message_to_user(19, 19, 'Test', 'Body', true);
