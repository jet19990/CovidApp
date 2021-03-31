@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" class="row">
                        @csrf

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="text-md-right">{{ __('Full Name') }}</label>

                                <div class="">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="age" class="text-md-right">{{ __('Age') }}</label>

                                <div class="">
                                    <input id="age" type="integer" class="form-control @error('age') is-invalid @enderror" name="age" value="{{ old('age') }}" required autocomplete="age">

                                    @error('age')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="gender" class="text-md-right">{{ __('Gender') }}</label>

                                <div class="">
                                     <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" value="{{ old('gender') }}" required autocomplete="gender">
                                        <option selected disabled>Select your gender</option>
                                        <option @if (old('gender') == 'male') selected="selected" @endif value="male">Male</option>
                                        <option @if (old('gender') == 'female') selected="selected" @endif value="female">Female</option>
                                        <option @if (old('gender') == 'other') selected="selected" @endif value="other">Other</option>
                                     </select>
                        

                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">

                        <div class="form-group">
                                <label for="address" class="text-md-right">{{ __('Address') }}</label>

                                <div class="">
                                    <input id="address" type="integer" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address">

                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $messaddress }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="health_condition" class="text-md-right">{{ __('Health Condition') }}</label>

                                <div class="">
                                     <select id="health_condition" class="form-control @error('health_condition') is-invalid @enderror" name="health_condition" value="{{ old('health_condition') }}" required autocomplete="health_condition">
                                        <option selected disabled>Select your health condition</option>
                                        <option @if (old('health_condition') == 'healthy') selected="selected" @endif value="healthy">Healthy</option>
                                        <option @if (old('health_condition') == 'sick') selected="selected" @endif value="sick">Sick</option>
                                     </select>
                        

                                    @error('health_condition')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        <div class="form-group">
                            <label for="password" class="text-md-right">{{ __('Password') }}</label>

                            <div class="">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group mb-0 float-right">
                            <div class="">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                        
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
