<?php

/**
 * This script updates the passwords of a given list of users
 * (given by e-mail) and resends them their account creation
 * confirmation e-mail.
 * Note that the password generation has been simplified, which
 * means the password below is not really "safe"
 * To enable script, prefix the first die(); with //
 * @package chamilo.cron.user_import
 */
/**
 * Initialization
 */
/* Example of input file:
  sam@example.com
  Matthew@example.com
  HERMAN@example.com
 */
die();
//change filename depending on file containing mails list, with one e-mail per line.
$list = file('input.txt');
require_once '../../inc/global.inc.php';
$users = Database::get_main_table(TABLE_MAIN_USER);
$userManager = UserManager::getManager();
$repository = UserManager::getRepository();

/**
 * E-mails list loop
 */
foreach ($list as $mail) {
    $mail = trim($mail);
    $sql = "SELECT user_id, official_code, firstname, lastname, email, username, language
            FROM $users WHERE email = '$mail'\n";
    $res = Database::query($sql);
    if ($res === false) {
        echo 'Error in database with email ' . $mail . "\n";
    }
    if (Database::num_rows($res) == 0) {
        echo '[Error] Email not found in database: ' . $row['email'] . "\n";
    } else {
        $row = Database::fetch_assoc($res);
        $pass = api_substr($row['username'], 0, 4) . rand(0, 9) . rand(0, 9);

        if ($user) {

            /** @var User $user */
            $user = $repository->find($row['user_id']);
            $user->setPlainPassword($pass);
            $userManager->updateUser($user, true);
        } else {
            echo "[Error] Error updating password. Skipping $mail\n";
            continue;
        }

        $user = array(
            'FirstName' => $row['firstname'],
            'LastName' => $row['lastname'],
            'UserName' => $row['username'],
            'Password' => $pass,
            'Email' => $mail,
        );
        //This comes from main/admin/user_import.php::save_data() slightly modified
        $recipient_name = api_get_person_name(
            $user['FirstName'],
            $user['LastName'],
            null,
            PERSON_NAME_EMAIL_ADDRESS
        );
        $emailsubject = '['.api_get_setting('platform.site_name').'] '.get_lang(
                'YourReg'
            ).' '.api_get_setting('platform.site_name');
        $emailbody = get_lang('Dear').' '.api_get_person_name(
                $user['FirstName'],
                $user['LastName']
            ).",\n\n".get_lang('YouAreReg')." ".api_get_setting(
                'platform.site_name'
            )." ".get_lang('WithTheFollowingSettings')."\n\n".get_lang(
                'Username'
            )." : ".$user['UserName']."\n".get_lang(
                'Pass'
            )." : ".$user['Password']."\n\n".get_lang(
                'Address'
            )." ".api_get_setting('platform.site_name')." ".get_lang(
                'Is'
            )." : ".api_get_path(WEB_PATH)." \n\n".get_lang(
                'Problem'
            )."\n\n".get_lang('Formula').",\n\n".api_get_person_name(
                api_get_setting('admin.administrator_name'),
                api_get_setting('admin.administrator_surname')
            )."\n".get_lang('Manager')." ".api_get_setting(
                'platform.site_name'
            )."\nT. ".api_get_setting(
                'admin.administrator_phone'
            )."\n".get_lang(
                'Email'
            )." : ".api_get_setting('admin.administrator_email')."";
        $sender_name = api_get_person_name(
            api_get_setting('admin.administrator_name'),
            api_get_setting('admin.administrator_surname'),
            null,
            PERSON_NAME_EMAIL_ADDRESS
        );
        $email_admin = api_get_setting('admin.administrator_email');
        @api_mail_html(
            $recipient_name,
            $user['Email'],
            $emailsubject,
            $emailbody,
            $sender_name,
            $email_admin
        );
        echo "[OK] Sent to $mail with new password $pass (encrypted:$crypass)... w/ subject: $emailsubject\n";
    }
}
