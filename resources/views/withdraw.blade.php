@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Make a Withdrawal') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('withdraw') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="user_id" class="form-label">{{ __('User ID') }}</label>
                            <input type="text" class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">{{ __('Amount') }}</label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" step="0.01" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Withdraw') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
