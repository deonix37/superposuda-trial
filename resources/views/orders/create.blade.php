@extends('layouts.app')

@section('content')
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <h2>Создание заказа</h2>
        @if (session('status'))
            <p>{{ session('status') }}</p>
        @endif
        <p>
            <label>
                ФИО:
                <input name="fullName" value="{{ old('fullName') }}">
            </label>
            @error('fullName')
                <span>{{ $message }}</span>
            @enderror
        </p>
        <p>
            <label>
                Комментарий клиента:
                <input name="customerComment" value="{{ old('customerComment') }}">
            </label>
            @error('customerComment')
                <span>{{ $message }}</span>
            @enderror
        </p>
        <p>
            <label>
                Артикул товара:
                <input name="article" value="{{ old('article') }}">
            </label>
            @error('article')
                <span>{{ $message }}</span>
            @enderror
        </p>
        <p>
            <label>
                Бренд товара:
                <input name="manufacturer" value="{{ old('manufacturer') }}">
            </label>
            @error('manufacturer')
                <span>{{ $message }}</span>
            @enderror
        </p>
        <p>
            <button>Отправить</button>
        </p>
    </form>
@endsection
