<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="min-h-screen flex justify-center items-center bg-gray-100">
    <form method="POST" action="{{ route('login') }}" id="loginForm"
          class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
        @csrf
        <h1 class="text-2xl font-semibold mb-6">ToDo Login</h1>
        <div class="mb-4">
            <label class="block text-sm">Email</label>
            <input type="email" name="email" class="w-full p-2 border rounded-lg" autocomplete="username">
            <label class="text-red-500 text-sm error" id="email-error" for="email"></label>
        </div>
        <div class="mb-4">
            <label class="block text-sm">Password</label>
            <input type="password" name="password" class="w-full p-2 border rounded-lg" autocomplete="current-password">
            <label class="text-red-500 text-sm error" id="password-error" for="password"></label>
        </div>
        <button class="bg-blue-500 text-white py-2 w-full rounded-lg">Login</button>
        <div class="mt-4 text-center">
            <a href="{{ route('register') }}" class="text-blue-500">Register</a>
        </div>
    </form>
</div>
<script src="{{ asset('assets/js/notification.js') }}"></script>
<script src="{{ asset('assets/js/common.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#loginForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                email: {
                    required: "Please enter your email",
                    email: "Please enter a valid email address"
                },
                password: {
                    required: "Please enter your password",
                    minlength: "Password must be at least 6 characters"
                }
            },
            submitHandler: function (form) {
                showLoader();
                $.ajax({
                    url: "{{ route("login") }}",
                    type: 'POST',
                    data: $(form).serialize(),
                    success: function (response) {
                        hideLoader();
                        if (response.success && typeof response.data != "undefined" && Object.keys(response.data).length > 0) {
                            storeToken(response.data.token);
                            window.location.href = response.data.redirect_url || "{{ route("main") }}";
                            successToast(response.message);
                        } else {
                            errorToast(response.message);
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
                        } else if (xhr.responseJSON.message !== "undefined") {
                            errorToast(xhr.responseJSON.message);
                        } else {
                            errorToast("Something went wrong");
                        }
                    }
                });
                return false;
            }
        });
    });

    function storeToken(token) {
        if (token) {
            // Ensure Pinia is initialized
            const authStore = window.authStore || null;

            if (authStore) {
                authStore.setToken(token);
            } else {
                // If Pinia isn't initialized, set token in localStorage and initialize it later
                localStorage.setItem('token', token);
            }
        }
    }
</script>
</body>
</html>
