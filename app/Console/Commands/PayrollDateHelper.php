<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class PayrollDateHelper
 * Bass class for the PayrollDates class
 *
 * @package App\Console\Commands
 */
abstract class PayrollDateHelper extends Command
{
    /**
     * First expense date
     */
    const FIRST_EXPENSE_DATE = 1;

    /**
     * Second expense date
     */
    const SECOND_EXPENSE_DATE = 15;

    /**
     * Scheduled payroll date
     */
    const FULL_DATE_FORMAT = 'Y-m-d';
    
    /**
     * @param $month
     * @param $year
     * @return mixed
     */
    protected function countDaysInMonth($month, $year)
    {
        return date('t', mktime(0, 0, 0, $month, 1, (date('Y') + $year)));
    }

    /**
     * Returns the date from given parameters
     * 
     * @param $format
     * @param $day
     * @param $month
     * @param $year
     * @return mixed
     */
    protected function getDate($format, $day, $month, $year)
    {
        return date($format, mktime(0, 0, 0, $month, $day, (date('Y') + $year)));
    }

    /**
     * Calculates the working days for the payroll
     *
     * @param $day
     * @param $month
     * @param $year
     * @param bool $payDay
     * @return mixed
     */
    abstract public function getScheduledDate($day, $month, $year, $payDay = false);

}