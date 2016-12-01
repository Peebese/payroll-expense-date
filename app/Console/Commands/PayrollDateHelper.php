<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
    private function getDate($format, $day, $month, $year)
    {
        return date($format, mktime(0, 0, 0, $month, $day, (date('Y') + $year)));
    }

    /**
     * Gets the last working day in the given month
     * 
     * @param $month
     * @param $year
     * @return mixed
     */
    protected function getPayDay($month, $year)
    {
        $monthLastDay = $this->countDaysInMonth($month, $year);
        return $this->getScheduledDate($monthLastDay, $month, $year, true);
    }

    /**
     * Calculates the appropriate working day
     * 
     * @param $day
     * @param $month
     * @param $year
     * @param bool $payDay
     * @return mixed
     */
    public function getScheduledDate($day, $month, $year, $payDay = false)
    {
        $expenseDateDay = $this->getDate(self::FULL_DATE_FORMAT . ',l', $day, $month, $year);
        $expenseDateArray = explode(',', $expenseDateDay);
        $expenseDate = $expenseDateArray[0];
        $expenseDay = $expenseDateArray[1];

        if ($payDay === true) {
            $sundayFormula = ($day - 2);
            $saturdayFormula = ($day - 1);

        } else {
            $sundayFormula = ($day + 1);
            $saturdayFormula = ($day + 2);
        }

        switch (strtolower($expenseDay)) {

            case 'sunday':

                $expenseDate = $this->getDate(self::FULL_DATE_FORMAT, $sundayFormula, $month, $year);

                break;

            case 'saturday':

                $expenseDate = $this->getDate(self::FULL_DATE_FORMAT, $saturdayFormula, $month, $year);

                break;
        }
        return $expenseDate;
    }


}