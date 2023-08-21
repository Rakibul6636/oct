@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Transactions and Current Balance') }}</div>

                <div class="card-body">
                    <p>Current Balance: ${{ $currentBalance }}</p>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sl. No.</th>
                                <th>Transaction Type</th>
                                <th>Amount</th>
                                <th>Fee</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $sl = 0;
                        @endphp
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $sl = $sl + 1 }}</td>
                                <td>{{ ucfirst($transaction->transaction_type) }}</td>
                                <td>{{ $transaction->amount }}</td>
                                <td>{{ $transaction->fee }}</td>
                                <td>{{ $transaction->date }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
