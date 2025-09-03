<?php

require_once(__DIR__ . "/configs/utils.php");
require_once(__DIR__ . "/model/Usuarios.php");

header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if (method("OPTIONS")) {
    output(200, ["msg" => "OK"]);
}

if (method("POST")) {
    try {
        $dados = inputJSON();
        if (!$dados) {
            throw new Exception("JSON inválido ou não enviado", 400);
        }
        if (!valid($dados, ["nome"])) {
            throw new Exception("'nome' não enviado", 400);
        }
        if (!Usuarios::inserir($dados["nome"])) {
            throw new Exception("Usuário não pôde ser inserido", 500);
        }
        output(200, ["msg" => "Cadastro realizado com sucesso"]);
    } catch (Exception $e) {
        output($e->getCode(), ["msg" => $e->getMessage()]);
    }
}

if (method("GET")) {
    try {
        output(200, Usuarios::listar());
    } catch (Exception $e) {
        output($e->getCode(), ["msg" => $e->getMessage()]);
    }
}

if (method("DELETE")) {
    try {
        if (!valid($_GET, ["id"])) {
            throw new Exception("'id' não enviado na url", 400);
        }
        if (!Usuarios::existe_by_id($_GET["id"])) {
            throw new Exception("Usuário não existe", 400);
        }
        if (!Usuarios::remover($_GET["id"])) {
            throw new Exception("Usuário não pôde ser removido", 500);
        }
        output(200, ["msg" => "Usuário removido com sucesso"]);
    } catch (Exception $e) {
        output($e->getCode(), ["msg" => $e->getMessage()]);
    }
}

output(200, ["msg" => "Operação inválida"]);
