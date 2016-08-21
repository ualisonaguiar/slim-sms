<?php
// Routes
$app->get('/enviosms', 'Sms\Controller\EnvioSms:listagem');
$app->get('/enviosms/{id_sms}', 'Sms\Controller\EnvioSms:listagem');
$app->post('/enviosms', 'Sms\Controller\EnvioSms:salvar');
$app->put('/enviosms', 'Sms\Controller\EnvioSms:salvar');
$app->delete('/enviosms', 'Sms\Controller\EnvioSms:excluir');