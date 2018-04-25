Hello<br>
 
<p>We've received your request for changing password on NewsMaker<br>
Click on the following link or paste it in internet browser to complete this process:</p><br>

<a href="{{ URL::route('/forgotPasswordValidate') }}?code={{ $code }}&username={{ $username }}">{{ URL::route("/forgotPasswordValidate") }}?code={{ $code }}&username={{ $username }}</a><br><br>

Thank you!!