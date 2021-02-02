@extends('layout')

@section('title')
    Про нас
@endsection

@section('content')
    <div class="info">
        <!--Загальна інформація-->
        <h4>Про магазин "books"</h4>
        <div class="row">
            <p>books™ - мережа книжкових магазинів, створена 2020 року.
                Асортимент магазину - книжки українською та іноземними мовами.</p>
        </div>

        <!--Доставка-->
        <p class="chapter">
            Доставка<i class="fas fa-truck"></i>
        </p>
        <div class="row">
            <p>Способи доставки:</p>
        </div>
        <div class="row">
            <ul>
                <li>Доставка кур'єрською службою Meest Express: 90 UAH (з ПДВ);</li>
                <li>Доставка до відділення Meest Express: 90 UAH (з ПДВ);</li>
                <li>Доставка до відділення Нової Пошти: 90 UAH (з ПДВ);</li>
            </ul>
            <p>Замовлення на суму від 450 UAH доставляються безкоштовно.</p>
            <p>Терміни доставки залежать від Вашого регіону.</p>
        </div>

        <!--Оплата-->
        <div class="row">
            <p class="chapter">
                Оплата<i class="fas fa-comment-dollar"></i>
            </p>
        </div>
        <div class="row">
            <p>Оплатата готівкою / онлайн:</p>
        </div>
        <div class="payment-technology row">
            <i class="fab fa-cc-visa"></i>
            <i class="fab fa-cc-mastercard"></i>
            <i class="fab fa-cc-paypal"></i>
        </div>
    </div>
@endsection
