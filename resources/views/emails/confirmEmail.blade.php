Hello {{ $username }}!<br>
 
<p>We've received your request for changing email on NewsMaker<br>
If you received this email by mistake ignore it, otherwise click on following link or paste it in your internet browser:</p><br>

<a href="{{ URL::route('confirmEmail') }}?code={{ $code }}&username={{ $username }}&email={{ $email }}">{{ URL::route("confirmEmail") }}?code={{ $code }}&username={{ $username }}&email={{ $email }}</a><br><br>

Thank you!!