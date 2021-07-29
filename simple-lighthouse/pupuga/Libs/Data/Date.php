<?php

namespace Pupuga\Libs\Data;

class Date
{
    /**
     * convert number (1 - 12) to month name
     *
     * @param string $lang
     * @param string $number
     *
     * @return string|array
     */
    public static function getLangMonth($lang = 'no', $number = null)
    {
    	$result = '';
        switch ($lang) {
            case 'de' :
                $months = array('Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember');
                break;
            case 'nl' :
                $months = array('januari', 'februari', 'maart', 'april', 'mei', 'juni', 'juli', 'augustus', 'september', 'oktober', 'november', 'december');
                break;
            case 'el' :
                $months = array('Ιανουάριος', 'Φεβρουάριος', 'Μάρτιος', 'Απρίλιος', 'Μάιος', 'Ιούνιος', 'Ιούλιος', 'Αύγουστος', 'Σεπτέμβριος', 'Οκτώβριος', 'Νοέμβριος', 'Δεκέμβριος');
                break;
            case 'hu' :
                $months = array('január', 'február', 'március', 'április', 'május', 'június', 'július', 'augusztus', 'szeptember', 'október', 'november', 'december');
                break;
            case 'sk' :
                $months = array('januar', 'februar', 'marec', 'april', 'maj ', 'junij', 'julij', 'avgust', 'september', 'oktober', 'november', 'december');
                break;
            case 'no' :
	            $months = array('Januar', 'Februar', 'Mars', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Desember');
                break;
	        case 'ru' :
		        $months = array('Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь');
		        $monthsNumber = array('Января', 'Февраля', 'Марта', 'Апрелья', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');
		        break;
            default :
                $months = array('January', 'February', 'March', 'April', 'May ', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                break;
        }


	    if (isset($months)) {
		    if (is_null($number)) {
			    $result = empty($monthsNumber) ? $months : array($months, $monthsNumber);
		    } else {
			    $month = $months[$number - 1];
			    if (!empty($monthsNumber)) {
                    $monthNumber = $monthsNumber[$number - 1];
                }
			    $result = (empty($monthNumber)) ? $month : array($month, $monthNumber);
		    }
	    }

        return $result;
    }

    /**
     * convert date (y-m-d) to custom format
     *
     * @param  string $date
     * @param  string $format (y-m-d)
     *
     * @return string $formatDate
     */
    public static function getLangDate($date, $format = 'd m y')
    {
        $dateParts = explode('-', $date);
        $dateParts[1] = self::getLangMonth($dateParts[1]);
        $formatDate = str_replace(array('y', 'm', 'd'), $dateParts, $format);
        return $formatDate;
    }

    /**
     * return year or period of years
     *
     * @param  string $period (year | years)
     * @param  string $before text is placing before date
     * @param  string $after text is placing after date
     *
     * @return string $copyright
     */
    public static function getCopyright($period = '', $before = 'Copyright &copy; ', $after = '')
    {
        $year = date('Y');

        $period = empty($period)
            ? $year
            : $period . ' - ' . $year;

        $copyright = $before . $period . $after;

        return $copyright;
    }

    public static function checkStringDate($date, $format = 'Y-m-d'): ?object
    {
        $dateObject = \DateTime::createFromFormat($format, $date);

        return ($dateObject && $dateObject->format($format) == $date) ? $dateObject : null;
    }
}