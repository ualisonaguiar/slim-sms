<?php
// Routes

$app->get('/cliente', 'Sms\Controller\Cliente:index');
$app->post('/envio-sms', 'Sms\Controller\EnvioSms:registrar');
