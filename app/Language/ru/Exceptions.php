<?php


/**
 * Ошибки
 * @codeCoverageIgnore
 */

return [
    AUTH_EXCEPTION_CODE => 'Неверный логин или пароль!',
    INVITER_EXCEPTION_CODE => 'Невалидный код приглашения!',
    REGISTER_LOGIN_USED_EXCEPTION_CODE => 'Этот логин уже используется!',
    FIELDS_HASH_EXCEPTION_CODE => 'Хеш не совпал! Ссылка устарела или данные были подмененны!',
    EXPIRED_TIME_CONFIRM_EXCEPTION_CODE => 'Время на подтверждение истекло!',
    NOT_STATUS_IS_WAIT_EMAIL_CONFIRMATION_EXCEPTION_CODE => 'Ваш аккаунт сейчас не находится в ожидании подтверждения почты!',
    VERIFY_CODE_EXCEPTION_CODE => 'Неверный код верификации!',
];
