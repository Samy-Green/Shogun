@php
$customizerHidden = 'customizer-hide';

$pageConfigs = ['myLayout' => 'blank'];
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Register Basic - Pages')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/@form-validation/form-validation.scss'
])
@endsection

@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-auth.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js'
])
@endsection

@section('page-script')
@vite([
  'resources/assets/js/pages-auth.js'
])
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-6">

      <!-- Register Card -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center mb-6">
            <a href="{{url('/')}}" class="app-brand-link">
              <span class="app-brand-logo demo">@include('_partials.macros',['height'=>20,'withbg' => "fill: #fff;"])</span>
              <span class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName') }}</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-1">Bienvenu sur votre portail d'administration. 🚀</h4>
          <p class="mb-6">Veuillez créer votre compte administrateur, cette page n'apparaitra ensuite plus jamais!</p>

          <form id="formAuthentication" class="mb-6"  method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-6">
              <label for="name" class="form-label">Nom</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Entrez votre nom" value="{{ old('name') }}" autofocus>
              @if ($errors->has('name'))
                  <div class="text-danger">{{ $errors->first('name') }}</div>
              @endif
            </div>
            <div class="mb-6">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Entrez votre email" value="{{ old('email') }}">
              @if ($errors->has('email'))
                  <div class="text-danger">{{ $errors->first('email') }}</div>
              @endif
            </div>
            <div class="mb-6 form-password-toggle">
              <label class="form-label" for="password">Mot de passe</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
              </div>
              @if ($errors->has('password'))
                  <div class="text-danger">{{ $errors->first('password') }}</div>
              @endif
            </div>
            <div class="mb-6 form-password-toggle">
              <label class="form-label" for="password_confirmation">Confirmation du mot de passe</label>
              <div class="input-group input-group-merge">
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password_confirmation" />
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
              </div>
              @if ($errors->has('password_confirmation'))
                  <div class="text-danger">{{ $errors->first('password_confirmation') }}</div>
              @endif
            </div>

            {{-- <div class="my-8">
              <div class="form-check mb-0 ms-2">
                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
                <label class="form-check-label" for="terms-conditions">
                  I agree to
                  <a href="javascript:void(0);">privacy policy & terms</a>
                </label>
              </div>
            </div> --}}
             @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="my-8">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif
            <button class="btn btn-primary d-grid w-100">
              S'inscrire
            </button>
          </form>

          <p class="text-center">
            <span>Vous avez déjà un compte ?</span>
            <a href="{{route('login')}}">
              <span>Connectez-vous</span>
            </a>
          </p>
        </div>
      </div>
      <!-- Register Card -->
    </div>
  </div>
</div>
@endsection
