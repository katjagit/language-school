<?php
declare(strict_types=1);

function check_option($subject, $check_subject):string {
    if ($subject === $check_subject) {
        return 'selected';
    }
    return '';
}

$subject = '';
if (request_method() === 'POST'){

    $firstname = e(request('firstname')) ?? '';
    $lastname = e(request('lastname')) ?? '';
    $email = e(request('email')) ?? '';
    $status = e(request('status')) ?? '';
    $subject = e(request('subject')) ?? '';
    $message = e(request('message')) ?? '';
    $agb = e(request('checkbox')) ?? '';

    if ($firstname === '') {
        $errors['empty_firstname'] = 'Das Feld darf nicht leer sein';
    }

    if ($lastname === '') {
        $errors['empty_lastname'] = 'Das Feld darf nicht leer sein';
    }

    if ($email === '') {
        $errors['empty_email'] = 'Das Feld darf nicht leer sein';
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email_invalid'] = 'Bitte eine gültige Email eingeben';
        }
    }

    if ($status === '') {
        $errors['empty_status'] = 'Bitte wählen Sie eine Option';
    }

    if ($subject === '') {
        $errors['empty_subject'] = 'Bitte wählen Sie einen Grund';
    }

    if ($message === '') {
        $errors['empty_message'] = 'Das Feld darf nicht leer sein';
    }

    if ($agb === '') {
        $errors['empty_agb'] = 'Bitte akzeptieren Sie die Datenschutzrichtlinien';
    }

    if (!$errors) {
        $feedback = 'Ihre Nachricht wurde verschickt';
        
        db_insert('contacts', [
            'firstname' => $firstname, 
            'lastname' => $lastname,
            'email' => $email,
            'status' => $status,
            'subject' => $subject,
            'message' => $message, 
        ]);

        // clean the form after sending
        $firstname = $lastname = $email = $status = $gender = $subject = $message = $agb = '';
    }
}

?>