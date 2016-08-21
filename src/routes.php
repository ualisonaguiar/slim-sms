<?php
// Routes

$app->get('/enviosms', 'Sms\Controller\EnvioSms:listagem');
$app->post('/enviosms', 'Sms\Controller\EnvioSms:registrar');
$app->put('/enviosms', 'Sms\Controller\EnvioSms:alterar');
$app->delete('/enviosms', 'Sms\Controller\EnvioSms:excluir');
