<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="min-h-screen flex justify-center items-center bg-gray-100">
    @include('layout.loader')
    <form method="POST" action="{{ route('register') }}" id="registerForm"
          class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
        @csrf
        <h1 class="text-2xl font-semibold mb-6">ToDo Register</h1>
        <div class="mb-4">
            <label class="block text-sm">Name</label>
            <input type="text" id="name" name="name" class="w-full p-2 border rounded-lg">
            <label class="text-red-500 text-sm error" id="name-error" for="name"></label>
        </div>
        <div class="mb-4">
            <label class="block text-sm">Phone No</label>
            <input type="text" id="phone" name="phone" class="w-full p-2 border rounded-lg">
            <label class="text-red-500 text-sm error" id="phone-error" for="phone"></label>
        </div>
        <div class="mb-4">
            <label class="block text-sm">Email</label>
            <input type="email" id="email" name="email" class="w-full p-2 border rounded-lg" autocomplete="username">
            <label class="text-red-500 text-sm error" id="email-error" for="email"></label>
        </div>
        <div class="mb-4">
            <label class="block text-sm">Password</label>
            <input type="password" id="password" name="password" class="w-full p-2 border rounded-lg" autocomplete="new-password">
            <label class="text-red-500 text-sm error" id="password-error" for="password"></label>
        </div>
        <div class="mb-4">
            <label class="block text-sm">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" class="w-full p-2 border rounded-lg" autocomplete="new-password">
            <label class="text-red-500 text-sm error" id="confirm_password-error" for="confirm_password"></label>
        </div>
        <button class="bg-blue-500 text-white py-2 w-full rounded-lg">Register</button>
        <div class="mt-4 text-center">
            <a href="{{ route('login_form') }}" class="text-blue-500">Login</a>
        </div>
    </form>
</div>
<script src="{{ asset('assets/js/notification.js') }}"></script>
<script src="{{ asset('assets/js/common.js') }}"></script>
<script>
    $(document).ready(function () {

        $.validator.addMethod("matches", function (value, element) {
            return this.optional(element) || value === $("#password").val();
        }, "Passwords do not match.");

        $("#registerForm").validate({
            rules: {
                name: {
                    required: true
                },
                phone: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                confirm_password: {
                    required: true,
                    minlength: 6,
                    matches: true
                }
            },
            messages: {
                name: {
                    required: "Please enter your name",
                },
                phone: {
                    required: "Please enter your phone number",
                    digits: "Please enter a valid phone number",
                    minlength: "Phone number must be in 10 digits",
                    maxlength: "Phone number must be in 10 digits"
                },
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email address"
                },
                password: {
                    required: "Please enter your password",
                    minlength: "Password must be at least 6 characters"
                },
                confirm_password: {
                    required: "Please enter your confirm password",
                    minlength: "Your password must be at least 6 characters",
                    matches: "Confirm Passwords do not match with password"
                }
            },
            submitHandler: function (form) {
                showLoader();
                $.ajax({
                    url: "{{ route("register") }}",
                    type: 'POST',
                    data: $(form).serialize(),
                    success: function (response) {
                        hideLoader();
                        if (response.success) {
                            successToast("Register Successfully");
                            setTimeout(function (){
                                window.location.href = "{{ route("login_form") }}";
                            },500);
                        }
                    },
                    error: function (xhr, status, error) {
                        hideLoader();
                        let errors = xhr.responseJSON.errors || undefined;
                        if (typeof errors != "undefined" && Object.keys(errors).length > 0) {
                            $("span.error").text("");
                            $.each(errors, function (key, value) {
                                $('#' + key + '_error').text(value[0]);
                            });
                        }else if(xhr.responseJSON.message !== "undefined"){
                            errorToast(xhr.responseJSON.message);
                        }else{
                            errorToast("Something went wrong");
                        }
                    }
                });
                return false;
            }
        });
    });
</script>
</body>
</html>
