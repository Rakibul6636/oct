<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Http\Controllers\Auth;

class TransactionController extends Controller
{   //deposit form
    public function showDepositForm()
    {
        return view('deposit');
    }
    //create deposit
    public function deposit(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $user = User::findOrFail($request->user_id);

        $transaction = new Transaction([
            'user_id' => $user->id,
            'transaction_type' => 'credit',
            'amount' => $request->amount,
            'fee' => 0.0,
            'date' => now(),
        ]);

        $user->transactions()->save($transaction);

        $user->balance += $request->amount;
        $user->save();

        return response()->json(['message' => 'Deposit successful'], 200);
    }
    //show users deposit
    public function showDeposits()
    {
        $user = auth()->user();
        $deposits = $user->transactions()->where('transaction_type', 'credit')->get();

        return view('depositsShow', compact('deposits'));
    }
    //show withdraw form
    public function showWithdrawForm()
    {
        return view('withdraw');
    }

 
    public function withdraw(Request $request)
        {
            $user = auth()->user(); // Get the authenticated user
            $request->validate([
                'amount' => 'required|numeric|min:0.01',
            ]);

            $accountType = $user->account_type;

            // Calculate withdrawal fee based on account type and withdrawal amount
            $withdrawalFee = $this->calculateWithdrawalFee($accountType, $request->amount);
           
            // Check if the user has sufficient balance (including fee)
            $totalWithdrawalAmount = $request->amount + $withdrawalFee;
            if ($user->balance < $totalWithdrawalAmount) {
                return response()->json(['message' => 'Insufficient balance'], 400);
            }

            // Deduct withdrawal amount and fee from user's balance
            $user->balance -= $totalWithdrawalAmount;
            $user->save();

            // Create a transaction record
            $transaction = new Transaction([
                'user_id' => $user->id,
                'transaction_type' => 'debit',
                'amount' => $request->amount,
                'fee' => $withdrawalFee,
                'date' => now(),
            ]);

            $user->transactions()->save($transaction);

            return response()->json(['message' => 'Withdrawal successful'], 200);
        }


    private function calculateWithdrawalFee($accountType, $amount)
    {

    // Apply individual account withdrawal conditions
    if ($accountType === 'personal') {
        // Free withdrawal on Fridays
        if (now()->dayOfWeek === 5) { // 5 is Friday
            return 0.0;
        }


        // Calculate the fee for the amount that exceeds 1K
        $excessAmount = max($amount - 1000, 0); // Calculate the excess amount beyond 1K
        $excessFee = 0;

        if ($excessAmount > 0) {

            // Check the total withdrawal amount for this month
            $totalWithdrawalThisMonth = $this->calculateTotalWithdrawalThisMonth();
            $remainingFreeWithdrawal = max(5000 - $totalWithdrawalThisMonth, 0); // Remaining free up to 5K
            $chargedAmount = max($excessAmount - $remainingFreeWithdrawal,0);
            $excessFee = $chargedAmount * 0.015;
        }

        // The total fee is the fee for the excess amount beyond 1K
        return $excessFee;
        }
    
        // Decrease fee to 0.015 for business accounts after 50K withdrawal
        if ($accountType === 'business') {
            $totalWithdrawal = $this->calculateTotalWithdrawal();
            if ($totalWithdrawal > 50000) {
                $fee = $amount * 0.015;
                
            }
            else{
                $fee = $amount * 0.025;
            }
            return $fee;
        }
    
        return 0;
    }
    //calculate withdraw for a month
    private function calculateTotalWithdrawalThisMonth()
    {
        $user = auth()->user();
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
    
        $totalWithdrawalThisMonth = $user->transactions()
            ->where('transaction_type', 'debit')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
    
        return $totalWithdrawalThisMonth;
    }
    //calculate total withdraw
    private function calculateTotalWithdrawal()
    {
        $user = auth()->user();
    
        $totalWithdrawal = $user->transactions()
            ->where('transaction_type', 'debit')
            ->sum('amount');
    
        return $totalWithdrawal;
    }
    //show total withdraw of user
    public function showWithdrawals()
    {
        $user = auth()->user();
        $withdrawals = Transaction::where('user_id', $user->id)
            ->where('transaction_type', 'debit')
            ->get();

        return view('withdrawShow', compact('withdrawals'));
    }
    //show total transaction of user
    public function showTransactions()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $transactions = $user->transactions;
        $currentBalance = $user->balance;

        return view('transactions', compact('transactions', 'currentBalance'));
    }
    
}

