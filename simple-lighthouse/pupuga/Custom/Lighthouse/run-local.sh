#!/bin/bash
/var/www/lighthouse.loc/wp-content/themes/simple-lighthouse/pupuga/Custom/Lighthouse/run-install.sh;
php '/var/www/lighthouse.loc/wp-content/themes/simple-lighthouse/pupuga/Custom/Lighthouse/cmd-create-sh.php';
/var/www/lighthouse.loc/wp-content/themes/simple-lighthouse/pupuga/Custom/Lighthouse/run-create-score.sh &>/dev/null;
php '/var/www/lighthouse.loc/wp-content/themes/simple-lighthouse/pupuga/Custom/Lighthouse/cmd-calculate-scores.php';