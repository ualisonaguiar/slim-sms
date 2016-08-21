<?php

$retorno = "";

function curl($dados = "", $tipo = "", $meta = "", $GET = false)
{
    if ($GET && $dados) {
        $curl = curl_init("http://localhost/enviosms/" . $dados);
    } else {
        $curl = curl_init("http://localhost/enviosms");
    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    /* PARA METODOS POST, PUT e DELETE */
    if (!$GET)
        curl_setopt($curl, $meta, $tipo);
    if (!$GET)
        curl_setopt($curl, CURLOPT_POSTFIELDS, $dados);

    $strAuthentication = base64_encode($_REQUEST['usuario'] . '@' . $_REQUEST['senha']);
    $arrHeaders = array(
        'Authorization: Basic ' . $strAuthentication,
        'Content-Type: application/json',
        'Accept: application/json',
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $arrHeaders);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    $curl_response = curl_exec($curl);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($http_status !== 200) {
        return 'Error: ' . $http_status . ' - ' . $curl_response;
    }
    return $curl_response;
}

$dados = "";

if ($_POST) {

    $dados = $_POST['dados'];
    switch ($_POST['metodo']) {
        case 'GET':
            $retorno = curl($_POST['dados'], "", "", true);
            break;
        case 'POST':
            $retorno = curl($_POST['dados'], "POST", CURLOPT_POST);
            break;
        case 'PUT':
            $retorno = curl($_POST['dados'], "PUT", CURLOPT_CUSTOMREQUEST);
            break;
        case 'DELETE':
            $retorno = curl($_POST['dados'], "DELETE", CURLOPT_CUSTOMREQUEST);
            break;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<br>

<form method="POST">
    <center>
        <table>
            <tr>
                <td>Usuário:</td>
                <td><input type="text" name="usuario" autocomplete="off" required="true"
                           value="<?php echo $_REQUEST['usuario']; ?>"></td>
            </tr>
            <tr>
                <td>Senha:</td>
                <td><input type="password" name="senha" required="true" value="<?php echo $_REQUEST['senha']; ?>"></td>
            </tr>
            <tr>
                <td valign="TOP">
                    <input type="hidden" id='met' name='metodo'>
                    <input onclick="document.getElementById('met').value='GET'" style="width:80px" type="submit"
                           value="GET"><br>
                    <input onclick="document.getElementById('met').value='POST'" style="width:80px" type="submit"
                           value="POST"><br>
                    <input onclick="document.getElementById('met').value='PUT'" style="width:80px" type="submit"
                           value="PUT"><br>
                    <input onclick="document.getElementById('met').value='DELETE'" style="width:80px" type="submit"
                           value='DELETE'>
                </td>
                <td valign="TOP">
                    <textarea placeholder="Dados" name="dados"
                              style="width:500px; height:94px;"><?php echo $dados; ?></textarea><br>
                    <textarea placeholder="Retorno"
                              style="width:500px; height:200px;"><?php echo $retorno; ?></textarea>
                </td>
            </tr>
        </table>
    </center>
</form>


</body>
</html>