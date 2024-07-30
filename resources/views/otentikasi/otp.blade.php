<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ $judul }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset ('otpstyle.css') }}">
</head>
<body>
    <div class="container">
        <h4 class="mb-20">Verify OTP</h2>
        <p class="mb-20">Your code was sent to you via email</p>
        <form  action="/register/otp" method="POST">
            @csrf
            @if (session()->has('errorOtp'))
                <p class="error" id="errorOtp">
                    {{ session('errorOtp') }}
                </p>
            @endif  
            <div class="input-field">
                <input type="number" id="numb1" name="numb1" autofocus maxlength="1" />
                <input type="number" id="numb2" name="numb2" disabled maxlength="1" />
                <input type="number" id="numb3" name="numb3" disabled maxlength="1" />
                <input type="number" id="numb4" name="numb4" disabled maxlength="1" />
            </div>
            <input type="hidden" id="emailInput" name="email" value="{{ $mail }}">
            <div class="konten-betwen">
                <p>Time Remaining: 
                    <span class="count" id="count">
                    </span>
                </p>
                <a class="" id="kirimUlang" href="/kirim-otp/{{ $mail }}">Resend OTP</a>
            </div>
            <button class="button" id="verifyButton" type="submit">Verify</button>
        </form>
    </div>
</body>
<script>
    const errorOtp = document.getElementById('errorOtp');
    if (errorOtp) {
        setTimeout(function() {
            errorOtp.style.display = 'none';
        }, 5000);
    }
</script>
<script>
    const inputs = document.querySelectorAll(".input-field > input");
    const button = document.querySelector(".button");
    window.addEventListener("load", () => inputs[0].focus());
    button.setAttribute("disabled", "disabled");
    inputs[0].addEventListener("paste", function (event) {
        event.preventDefault();
        const pastedValue = (event.clipboardData || window.clipboardData).getData(
            "text"
        );
        const otpLength = inputs.length;
        for (let i = 0; i < otpLength; i++) {
            if (i < pastedValue.length) {
                inputs[i].value = pastedValue[i];
                inputs[i].removeAttribute("disabled");
                inputs[i].focus;
            } else {
                inputs[i].value = "";
                inputs[i].focus;
            }
        }
    });
    inputs.forEach((input, index1) => {
        input.addEventListener("keyup", (e) => {
            const currentInput = input;
            const nextInput = input.nextElementSibling;
            const prevInput = input.previousElementSibling;
            if (currentInput.value.length > 1) {
                currentInput.value = "";
                return;
            }
            if (
                nextInput &&
                nextInput.hasAttribute("disabled") &&
                currentInput.value !== ""
            ) {
                nextInput.removeAttribute("disabled");
                nextInput.focus();
            }
            if (e.key === "Backspace") {
                inputs.forEach((input, index2) => {
                    if (index1 <= index2 && prevInput) {
                        input.setAttribute("disabled", true);
                        input.value = "";
                        prevInput.focus();
                    }
                });
            }
            button.classList.remove("active");
            button.setAttribute("disabled", "disabled");
            const inputsNo = inputs.length;
            if (!inputs[inputsNo - 1].disabled && inputs[inputsNo - 1].value !== "") {
                button.classList.add("active");
                button.removeAttribute("disabled");
                return;
            }
        });
    });
</script>
<script>
    const countElement = document.getElementById('count');
    const resendLink = document.getElementById('kirimUlang');
    function countdown() {
        let time = sessionStorage.getItem('timeRemaining') || 0;
        time = parseInt(time);
        if (time > 0) {
            countElement.innerText = formatTime(time);
            time--;
            sessionStorage.setItem('timeRemaining', time);
            setTimeout(countdown, 1000);
        } else {
            countElement.innerText = '';
            countElement.classList.add('count');
            resendLink.classList.remove('kirim');
        }
    }
    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
    }
    resendLink.addEventListener('click', function (event) {
        sessionStorage.setItem('timeRemaining', 150);
        countElement.innerText = '2:30';
        countElement.classList.remove('count');
        resendLink.classList.add('kirim');
        countdown();
    });
    if (sessionStorage.getItem('timeRemaining') > 0) {
        countElement.classList.remove('count');
        resendLink.classList.add('kirim');
        countdown();
    }
</script>
</html>
