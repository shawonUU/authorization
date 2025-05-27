@extends('layouts.app') 
@section('content') 
<div id="main-module-container">
    <div class="row">
        <div class="col-24">
            <h2>Sign Up</h2>
            <form method="post" action="{{route('register')}}" class="register">
                @csrf
                <p class="form-row form-row-first">
                <label for="reg_billing_first_name">Name <span class="required">*</span>
                </label>
                <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="">
                </p>
                <div class="clear"></div>
                <p class="form-row form-row-first">
                <label for="reg_email">Email <span class="required">*</span>
                </label>
                <input type="email" class="input-text" name="email" id="reg_email" value="">
                </p>
                <p class="form-row form-row-last">
                <label for="reg_password">Password <span class="required">*</span>
                </label>
                <input type="password" class="input-text" name="password" id="reg_password" value="">
                </p>
                <p class="form-row form-row-last">
                <label for="reg_confirm_password">Confirm Password <span class="required">*</span>
                </label>
                <input type="password" class="input-text" name="confirm_password" id="reg_confirm_password" value="">
                </p>
                <div style="left:-999em; position:absolute;">
                <label for="trap">Anti-spam</label>
                <input type="text" name="email_2" id="trap" tabindex="-1">
                </div>
                <div class="woocommerce-privacy-policy-text"></div>
                <p class="form-row">
                <input type="hidden" id="_wpnonce" name="_wpnonce" value="605aa09c84">
                <input type="hidden" name="_wp_http_referer" value="/my-account">
                <input type="submit" class="button" name="register" value="রেজিস্টার">
                </p>
            </form>
        </div>
    </div>
</div> 
@endsection