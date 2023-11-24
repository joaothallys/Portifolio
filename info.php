<?php

// Função para obter o endereço IP do usuário
function getIPAddress() {
    // Verifica se o usuário está atrás de um proxy
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

// Obtém o endereço IP do usuário
$ip = getIPAddress();

// Obtém a contagem atual para o endereço IP
$ipCountKey = 'ipCount_' . $ip;
$ipCount = isset($_COOKIE[$ipCountKey]) ? (int)$_COOKIE[$ipCountKey] : 0;

// Verifica se o IP já acessou o site
if (!isset($_COOKIE[$ipCountKey])) {
    // Incrementa a contagem
    $ipCount++;
    
    // Define o cookie para o IP (pode ajustar o tempo conforme necessário)
    setcookie($ipCountKey, $ipCount, time() + (365 * 24 * 60 * 60)); // Define o cookie por 365 dias
}

// Restante do seu código PHP (envio de e-mail, etc.)

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter dados do formulário
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];

    // Verificar campos vazios
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        echo "Todos os campos são obrigatórios.";
        exit();
    }

    // Configurar o destinatário do e-mail
    $to = "jlemes796@gmail.com";

    // Configurar o assunto do e-mail
    $subject = "Novo Formulário de Contato";

    // Montar o corpo do e-mail
    $body = "Nome: $name\n";
    $body .= "Email: $email\n";
    $body .= "Telefone: $phone\n\n";
    $body .= "Mensagem:\n$message";

    // Enviar e-mail
    mail($to, $subject, $body);

    // Redirecionar de volta à página após o envio do e-mail (opcional)
    header("Location: index.html");
    exit();
}
?>


