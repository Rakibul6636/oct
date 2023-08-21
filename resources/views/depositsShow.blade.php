@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Deposited Transactions') }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sl. No.</th>
                                <th>User ID</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $sl = 0;
                        @endphp

                            @foreach($deposits as $deposit)
                            <tr>
                                <td>{{ $sl = $sl + 1 }}</td>
                                <td>{{ $deposit->user_id }}</td>
                                <td>{{ $deposit->amount }}</td>
                                <td>{{ $deposit->date }}</td>
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
