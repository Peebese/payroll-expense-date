# payroll-expense-date
Payroll and expense working day caluculation

This is a CLI application which creates a payroll and expense calender.

1) PayDay: Occurs on the last day of the month, or the previous working day

2) 1st Expense date: Occurs on the 1st of the month or the following Monday

3) 2nd Expense date: Occurs on the 15th of the month or the following Monday

The calender is written to this location: payroll_dates/storage/app/
The data is written to a .txt file in JSON format.

/--------------------------
Format example
---------------------------/

"Month Name", "1st expenses day", “2nd expenses day”, "Salary day" 


/---------------------------
Requirements
----------------------------/

PHP 5.6

To execute, run command in CLI: php artisan payroll:generate <year>
e.g. php artisan payroll:generate 2016
