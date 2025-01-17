<?php
function verify_recaptcha($recaptcha_response) {
    // Google reCAPTCHA API secret key
    $secret_key = '6LfZ9boqAAAAANTFbkNOCbqoupom5bDWJS_XoS_n'; // Înlocuiește cu cheia secretă corectă
    
    // Verificarea răspunsului reCAPTCHA
    $verify_captcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$recaptcha_response);
    
    // Decodează răspunsul reCAPTCHA
    $verify_response = json_decode($verify_captcha);
    
    // Returnează true dacă răspunsul reCAPTCHA este valid
    return $verify_response->success;
}
?>