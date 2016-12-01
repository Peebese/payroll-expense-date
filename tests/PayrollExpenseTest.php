<?php

use App\Console\Commands\PayrollDates;

class PayrollExpenseTest extends TestCase
{

    /**
     * Test expense days that fall on a weekend change to following monday
     */
    public function testExpenseDayWeekendFail()
    {
        $payRollExpense = new PayrollDates();
        $year = (2016 - date('Y'));
        $date = $payRollExpense->getScheduledDate(3, 12, $year);
        $this->assertEquals('2016-12-05',$date);
    }

    /**
     * Tests expense working days are successful
     */
    public function testExpenseWorkingDaySuccess()
    {
        $payRollExpense = new PayrollDates();
        $year = (2016 - date('Y'));
        $date = $payRollExpense->getScheduledDate(1, 07, $year, true);
        $this->assertEquals('2016-07-01',$date);
    }

    /**
     * Tests pay day that fall on a weekend change to previous working day
     */
    public function testPayDayWeekendFail()
    {
        $payRollExpense = new PayrollDates();
        $year = (2016 - date('Y'));
        $date = $payRollExpense->getScheduledDate(31, 07, $year, true);
        $this->assertEquals('2016-07-29',$date);
    }

    /**
     * Test pay day that fall on a working day is successful
     */
    public function testPayDayWorkingDaySuccess()
    {
        $payRollExpense = new PayrollDates();
        $year = (2016 - date('Y'));
        $date = $payRollExpense->getScheduledDate(26, 07, $year, true);
        $this->assertEquals('2016-07-26',$date);
    }
}
