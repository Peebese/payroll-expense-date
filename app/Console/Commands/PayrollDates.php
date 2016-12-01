<?php

namespace App\Console\Commands;

use App\Console\Commands;
use Illuminate\Support\Facades\Storage;


class PayrollDates extends PayrollDateHelper
{
    /**
     * End of script result: Successful
     *
     * Constant string
     */
    const SUCCESS = 'PayrollExpense Calender Successfully Created';

    /**
     * End of script result: Failed
     *
     * Constant string
     */
    const FAIL = 'PayrollExpense Calender Failed';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payroll:generate {year}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Payroll - Expense Calendar';

    /**
     * Calender year
     *
     * @var string
     */
    private $calenderYear;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $year = $this->argument('year');
            $this->calenderYear = ($year - date('Y'));
            $payrollExpenseCalender = json_encode($this->calculatePayrollCalender());
            
            Storage::disk('local')->put('calender_' . $year . '.txt', $payrollExpenseCalender);
            $this->info(self::SUCCESS);

        } catch (\Exception $e) {
            
            $this->info(self::FAIL . ', ' . $e->getMessage());
        }
    }

    /**
     * Calculates the expense and payday dates
     *
     * @return array
     */
    private function calculatePayrollCalender()
    {
        $payrollCalendarYear = [];

        for ($i = 1; $i <= 12; $i++) {
            $month = date('F', mktime(0, 0, 0, $i, 1, 0));
            $payrollCalendarYear[] = [
                $month,
                $this->getScheduledDate(self::FIRST_EXPENSE_DATE, $i, $this->calenderYear),
                $this->getScheduledDate(self::SECOND_EXPENSE_DATE, $i, $this->calenderYear),
                $this->getPayDay($i, $this->calenderYear)
            ];
        }
        return $payrollCalendarYear;
    }
}
