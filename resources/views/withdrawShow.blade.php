@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Withdrawal Transactions') }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sl. No.</th>
                                <th>User ID</th>
                                <th>Amount</th>
                                <th>Fee</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $sl = 0;
                        @endphp
                            @foreach($withdrawals as $withdrawal)
                            <tr>
                                <td>{{ $sl = $sl + 1 }}</td>
                                <td>{{ $withdrawal->user_id }}</td>
                                <td>{{ $withdrawal->amount }}</td>
                                <td>{{ $withdrawal->fee }}</td>
                                <td>{{ $withdrawal->date }}</td>
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
