@extends('layouts.app')

@section('content')

<div class="container">
<div class="card logincard">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            

                            <div class="col-md-12">
                            <label for="email" class=" col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            

                            <div class="col-md-12">
                                <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> -->

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary btnRed">
                                    {{ __('Login') }}
                                </button>

                                <!-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
</div>
@endsection

@section('content2')
    <!-- user pwd modal -->
    <div class="modal fade authModal" id="authModal" tabindex="-1" role="dialog" aria-labelledby="authModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="authModalLabel">Enter Credentials to Continue</h5>
                </div>
                <!-- wrong_credentials alert -->
                <div class="alert alert-danger wrong_credentials" role="alert" hidden>
                    Wrong username or password.
                </div>
                <form method="POST" action="#">
                    <div class="modal-body">
                        <!-- user -->
                        <div class="form-group">
                            <label for="">User</label>
                            <input type="text" placeholder="Enter User" class="form-control user" required max="50" required>
                        </div>
                        <!-- password -->
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" placeholder="Enter password" class="form-control password" min=4 required>
                        </div>
                        <div class="modalBtn">
                            <button type="button" class="btn btn-primary btn_submit_auth btnRed">Submit</button>
                        </div>
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn_submit_auth">Submit</button>
                    </div> -->
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- check for ip -->
    <script>
        var res = "";
        function check_for_ip(){
            $.ajax({
                type: 'GET',
                async: false,
                "_token": "{{ csrf_token() }}",
                url: `<?php echo(route('check_for_ip')); ?>`,
                success: function(data){
                    res = data;
                }
            });
        }
    </script>

    <!-- show auth modal -->
    <script>
        function show_auth_modal(){
            $('.wrong_credentials').prop('hidden', true);
            $('#authModal').modal({backdrop: 'static', keyboard: false}) 
            $('#authModal').modal('show');
            $('#email').prop('readonly', true);
            $('#password').prop('readonly', true);
        }
    </script>

    <!-- modal decider -->
    <script>
        function modal_decider(res){
            if(res == 'false'){
                $('#authModal .wrong_credentials').prop('hidden', false);
            }
            else{
                $('.wrong_credentials').prop('hidden', true);
                $('#authModal').modal('hide');
                $('#email').prop('readonly', false);
                $('#password').prop('readonly', false);
            }
        }
    </script>

    <!-- ready -->
    <script>
        $(document).ready(function(){
            check_for_ip();
            if(res == 'false'){
                show_auth_modal();
            }

            // auth
            $('#authModal').on('click', '.btn_submit_auth', function(){
                var user = $('#authModal .user').val();
                var password = $('#authModal .password').val();

                $.ajax({
                    type: 'GET',
                    async: false,
                    url: `<?php echo(route('ip_auth')); ?>`,
                    data: {
                        user: user,
                        password: password
                    },
                    success: function(data){
                        modal_decider(data);
                    }
                });
            });

            $('#authModal').on("contextmenu",function(){
                return false;
            });

            $(document).keydown(function(e){
                if(e.which === 123){
                    return false;
                }
            });
        });
    </script>
@endsection
