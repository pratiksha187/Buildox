@extends('layouts.app')
@section('title', 'Select Your Role')
@section('content')

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Open Sans', Helvetica, Arial, sans-serif;
        background-color: #f4f6f9;
    }

    .cont {
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        width: 900px;
        height: 550px;
        margin: 50px auto;
        background: #1c2c3e;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
    }

    .form {
        position: relative;
        width: 640px;
        height: 100%;
        padding: 50px 30px 0;
        background: #ffffff;
        transition: transform 1.2s ease-in-out;
    }

    .sub-cont {
        overflow: hidden;
        position: absolute;
        left: 640px;
        top: 0;
        width: 900px;
        height: 100%;
        padding-left: 260px;
        background: #ffffff;
        transition: transform 1.2s ease-in-out;
    }

    .cont.s--signup .sub-cont {
        transform: translate3d(-640px, 0, 0);
    }

    .submit {
        display: block;
        width: 260px;
        height: 36px;
        margin: 40px auto 20px;
        border-radius: 30px;
        background: #F25C05;
        color: #fff;
        font-size: 15px;
        text-transform: uppercase;
        cursor: pointer;
        transition: background 0.3s;
    }

    .submit:hover {
        background: #d14b04;
    }

    h2 {
        width: 100%;
        font-size: 26px;
        text-align: center;
        color: #1c2c3e;
    }

    label {
        display: block;
        width: 260px;
        margin: 25px auto 0;
        text-align: center;
    }

    label span {
        font-size: 12px;
        color: #999;
        text-transform: uppercase;
    }

    input {
        display: block;
        width: 100%;
        margin-top: 5px;
        padding-bottom: 5px;
        font-size: 16px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.4);
        text-align: center;
    }

    .img {
        overflow: hidden;
        z-index: 2;
        position: absolute;
        left: 0;
        top: 0;
        width: 260px;
        height: 100%;
        padding-top: 360px;
    }

    .img:before {
        content: '';
        position: absolute;
        right: 0;
        top: 0;
        width: 900px;
        height: 100%;
        background-image: url("/images/ext.jpg");
        opacity: 0.8;
        background-size: cover;
        transition: transform 1.2s ease-in-out;
    }

    .img:after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(28, 44, 62, 0.7);
    }

    .cont.s--signup .img:before {
        transform: translate3d(640px, 0, 0);
    }

    .img__text {
        z-index: 2;
        position: absolute;
        left: 0;
        top: 50px;
        width: 100%;
        padding: 0 20px;
        text-align: center;
        color: #fff;
        transition: transform 1.2s ease-in-out;
    }

    .img__text h3 {
        margin-bottom: 10px;
        font-weight: normal;
    }

    .cont.s--signup .img__text.m--up {
        transform: translateX(520px);
    }

    .img__text.m--in {
        transform: translateX(-520px);
    }

    .cont.s--signup .img__text.m--in {
        transform: translateX(0);
    }

    .img__btn {
        overflow: hidden;
        z-index: 2;
        position: relative;
        width: 100px;
        height: 36px;
        margin: 0 auto;
        background: transparent;
        text-transform: uppercase;
        font-size: 15px;
        cursor: pointer;
    }

    .img__btn:after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        border: 2px solid #F25C05;
        border-radius: 30px;
    }

    .img__btn span {
        position: absolute;
        left: 0;
        top: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        color: #F25C05;
        transition: transform 1.2s;
    }

    .img__btn span.m--in {
        transform: translateY(-72px);
    }

    .cont.s--signup .img__btn span.m--in {
        transform: translateY(0);
    }

    .cont.s--signup .img__btn span.m--up {
        transform: translateY(72px);
    }

    .main-section {
        padding: 30px;
    }

    .main-section h2 {
        color: #1c2c3e;
        font-weight: bold;
    }

    .text-muted {
        color: #888;
        text-align: center;
        font-size: 14px;
    }

    .role-grid {
        display: flex;
        justify-content: space-around;
        margin-top: 30px;
        gap: 20px;
        flex-wrap: wrap;
    }

    .role-card {
        display: block;
        width: 200px;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        text-decoration: none;
        color: #1c2c3e;
        transition: all 0.3s ease;
        text-align: center;
    }

    .role-card:hover {
        transform: translateY(-4px);
        border-left: 5px solid #F25C05;
        background-color: #fdf7f2;
    }

    .role-icon {
        font-size: 40px;
        margin-bottom: 10px;
        color: #F25C05;
    }

    .role-title {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 5px;
    }

    .role-desc {
        font-size: 14px;
        color: #555;
    }
</style>

<div class="cont">
    <div class="form sign-in">
        <form method="POST" action="/login">
            @csrf
            <h2>Welcome</h2>
            <label>
                <span>Email</span>
                <input type="email" name="email" required />
            </label>
            <label>
                <span>Password</span>
                <input type="password" name="password" required />
            </label>
            <button type="submit" class="submit">Sign In</button>
        </form>
    </div>

    <div class="sub-cont">
        <div class="img">
            <div class="img__text m--up">
                <h3>Don't have an account? Please Sign up!</h3>
            </div>
            <div class="img__text m--in">
                <h3>If you already have an account, just sign in.</h3>
            </div>
            <div class="img__btn">
                <span class="m--up">Register</span>
                <span class="m--in">Sign In</span>
            </div>
        </div>

        <div class="form sign-up">
            <div class="main-section">
                <h2>Who are you?</h2>
                <p class="text-muted">Select your role to proceed with ConstructKaro</p>
                <div class="role-grid">
                    <a href="{{ route('project') }}" class="role-card">
                        <div class="role-icon">🏗️</div>
                        <div class="role-title">I want to build/develop</div>
                        <div class="role-desc">Find experts, get quotes, manage construction</div>
                    </a>
                    <a href="{{ route('service_provider') }}" class="role-card">
                        <div class="role-icon">👷</div>
                        <div class="role-title">I’m a service provider</div>
                        <div class="role-desc">Get leads, bid on projects, grow your business</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('.img__btn').addEventListener('click', function () {
        document.querySelector('.cont').classList.toggle('s--signup');
    });
</script>

@endsection
