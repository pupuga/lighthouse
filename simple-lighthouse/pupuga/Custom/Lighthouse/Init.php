<?php

namespace Pupuga\Custom\Lighthouse;

final class Init
{
    public function __construct()
    {
        if (defined('CMD')) {
            switch (CMD) {
                case 'lighthouse-create-sh' :
                    CreateSh::app();
                    break;
                case 'lighthouse-calculate-scores' :
                    CalculateScores::app();
                    break;
            }
        } else {
            Fields::app();
            Correct::app();
            AdminGrid::app();
        }
    }
}