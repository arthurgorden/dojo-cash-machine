<?php

class CashMachine
{
    public array $cashMachine = [
        500 => 0,
        200 => 0,
        100 => 0,
        50 => 0,
        20 => 0,
        10 => 0,
        5 => 0,
    ];

    private array $authorisedBills = [0, 5, 10, 20, 50, 100, 200, 500];

    public function addCash(int $billValue, int $billsAdded): bool 
    {        
        if ($billsAdded >= 0 && in_array($billValue, $this->authorisedBills)) {
                $this->cashMachine[$billValue] += $billsAdded; 
                return true;
        } else {
            return false;
        }
    }

    public function removeCash(int $billValue, int $billsRemoved)
    {
        if ($billsRemoved >= 0 && in_array($billValue, $this->authorisedBills)) {
            $this->cashMachine[$billValue] -= $billsRemoved;
        }
    }
    
    public function getRemainingCash(): array
    {
        return $this->cashMachine;
    }

    public array $billsWithdrawn = [];

    public function countBills(int $amount, int $bill, array $disponibleBills)
    {
        if ($amount % $bill === 0 && $amount / $bill <= $disponibleBills[$bill] && $amount / $bill !== 0) {
            $withdraw = $amount / $bill;
            $this->billsWithdrawn[$bill] = $withdraw;
            $this->removeCash($bill, $withdraw);
        }
        else {
            if (intdiv($amount, $bill) <= $disponibleBills[$bill] && intdiv($amount, $bill) !== 0)
            {
                $withdraw = intdiv($amount, $bill);
                $this->billsWithdrawn[$bill] = $withdraw;
                $this->removeCash($bill, $withdraw);

                $amount = $amount % $bill;
            }
        }
    }

    public function withdraw(int $amount): array
    {
        $this->countBills($amount, 500, $this->getRemainingCash()); 
        $this->countBills($amount, 200, $this->getRemainingCash()); 
        $this->countBills($amount, 100, $this->getRemainingCash()); 
        $this->countBills($amount, 50, $this->getRemainingCash()); 
        $this->countBills($amount, 20, $this->getRemainingCash()); 
        $this->countBills($amount, 10, $this->getRemainingCash()); 
        $this->countBills($amount, 5, $this->getRemainingCash()); 
        return $this->billsWithdrawn;
    }
}