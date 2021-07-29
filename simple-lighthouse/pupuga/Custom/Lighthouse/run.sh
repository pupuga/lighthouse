#!/bin/bash
php '/home/r2d2/web/lighthouse.zen.cheitgroup.com/public_html/wp-content/themes/simple-lighthouse/pupuga/Custom/Lighthouse/cmd-create-sh.php';
/home/r2d2/web/lighthouse.zen.cheitgroup.com/public_html/wp-content/themes/simple-lighthouse/pupuga/Custom/Lighthouse/run-create-score.sh &>/dev/null;
php '/home/r2d2/web/lighthouse.zen.cheitgroup.com/public_html/wp-content/themes/simple-lighthouse/pupuga/Custom/Lighthouse/cmd-calculate-scores.php';