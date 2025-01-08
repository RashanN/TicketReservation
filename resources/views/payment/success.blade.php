@extends('layouts.app')

@section('content')
    <h1>Payment Successful</h1>
    <p>Transaction Reference: {{ $transaction['txnReference'] }}</p>
    <p>Amount: {{ $transaction['amount']['paymentAmount'] / 100 }} LKR</p>
@endsection
