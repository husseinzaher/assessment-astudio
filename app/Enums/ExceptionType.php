<?php

namespace App\Enums;

enum ExceptionType: string
{
    case InvalidLoginCredentials = 'invalid_login_credentials';
    case MethodNotAllowed = 'method_not_allowed';
    case AuthenticationException = 'authentication_exception';
    case NotFoundHttpException = 'not_found_http_exception';
    case AccessDenied = 'access_denied';
    case Validation = 'validation';
}
