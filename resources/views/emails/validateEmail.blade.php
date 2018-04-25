Hello {{ $username }}!<br>
 
<p>You've registered on Event script and you need to validate your email address.<br>
Click on following link or paste it in your internet browser to complete this process:</p><br>

<a href="{{ URL::route('validate') }}?code={{ $code }}&username={{ $username }}">{{ URL::route("validate") }}?code={{ $code }}&username={{ $username }}</a><br><br>

Thank you!!