<?php

/**
 * Фатальные ошибки
 * @codeCoverageIgnore
 * Descriptions:
 * UNKNOWN_DISCOUNT_EXCEPTION_CODE - не удалось подобрать скидку!
 * CURRENCY_EXCEPTION_CODE - был передан не верный id валюты в функцию(currencyConverter) хелпера(currency_helper) или в БД лежит хуйня
 */

$text = 'Внутренняя ошибка! Обратитесь в техническую поддержку!';

return [
    UNKNOWN_DISCOUNT_EXCEPTION_CODE => $text . ' Ошибка №' . UNKNOWN_DISCOUNT_EXCEPTION_CODE,
    CURRENCY_EXCEPTION_CODE => $text . ' Ошибка №' . CURRENCY_EXCEPTION_CODE,
];