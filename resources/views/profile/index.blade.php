@extends('layouts.app')

@section('content')
<section class="section">
    <div class="container">
        @include('alert::bootstrap')
        <div class="card">
            <div class="card-body">
                <header class="header">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>
                                {{ __('My Profile') }}
                            </h2>
                        </div>
                    </div>
                </header>
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('profile.update') }}" method="POST">
                        @method('PUT')
                        @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">{{ __('E-Mail Address') }}</label>
                                        <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            value="{{ old('email') ?? $user->email }}"
                                            name="email"
                                            id="email"
                                            required>

                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nick">{{ __('Nick') }}</label>
                                        <input type="text" class="form-control{{ $errors->has('nick') ? ' is-invalid' : '' }}"
                                            value="{{ old('nick') ?? $user->nick }}"
                                            name="nick"
                                            id="nick"
                                            required>

                                            @if ($errors->has('nick'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('nick') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">{{ __('Password') }}</label>
                                        <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                            name="password"
                                            id="password">

                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password-confirmation">{{ __('Confirm Password') }}</label>
                                        <input type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                            name="password_confirmation"
                                            id="password-confirmation">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="birthdate" class="text-md-right">{{ __('Birthdate') }}</label>
                                        <input id="birthdate" type="search" class="form-control{{ $errors->has('birthdate') ? ' is-invalid' : '' }}" name="birthdate" value="{{ old('birthdate') ?? $user->f_birthdate }}" data-toggle="datepicker" autocomplete="off" required>

                                        @if ($errors->has('birthdate'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('birthdate') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gender" class="text-md-right">{{ __('Gender') }}</label>
                                        <div>
                                            <div class="form-check-inline pt-2{{ $errors->has('gender') ? ' is-invalid' : '' }}">
                                                <input class="form-check-input" type="radio" name="gender" value="F" id="gender1" 
                                                {{ $user->gender == 'F' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="gender1">
                                                    {{ __('Female') }}
                                                </label>
                                            </div>
                                            <div class="form-check-inline pt-2{{ $errors->has('gender') ? ' is-invalid' : '' }}">
                                                <input class="form-check-input" type="radio" name="gender" value="M" id="gender2" 
                                                {{ $user->gender == 'M' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="gender2">
                                                    {{ __('Male') }}
                                                </label>
                                            </div>

                                            @if ($errors->has('gender'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('gender') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary">{{ __('Save') }}</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('Anonymize your account') }}</h5>
                                <p class="card-text">{{ __('We will keep your events and invitations, but you can require account anonymization. Your data will be unredable.') }}</p>
                                <a href="#" class="btn btn-outline-danger">{{ __('Anonymize me') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script type="text/javascript">
        $('#birthdate').inputmask('dd.mm.yyyy')
    </script>
@endpush