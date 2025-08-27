<?php

require_once(__DIR__ . "/configs/utils.php");
require_once(__DIR__ . "/model/Compras.php");
require_once(__DIR__ . "/model/Produtos.php");
require_once(__DIR__ . "/model/Usuarios.php");

header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
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
        if (!valid($dados, ["id_produto", "id_usuario"])) {
            throw new Exception("id_produto e/ou id_usuario não enviados ou inválidos", 400);
        }
        if (!Produtos::existe_by_id($dados["id_produto"])) {
            throw new Exception("Produto não existe", 400);
        }
        if (!Usuarios::existe_by_id($dados["id_usuario"])) {
            throw new Exception("Usuário não existe", 400);
        }
        if (Compras::existe_compra($dados["id_usuario"], $dados["id_produto"])) {
            throw new Exception("Usuário já comprou o item", 400);
        }
        if (!Compras::inserir($dados["id_produto"], $dados["id_usuario"])) {
            throw new Exception("Compra não pôde ser inserida", 500);
        }
        output(200, ["msg" => "Cadastro realizado com sucesso"]);
    } catch (Exception $e) {
        output($e->getCode(), ["msg" => $e->getMessage()]);
    }
}

if (method("DELETE")) {
    try {
        if (!valid($_GET, ["id_produto", "id_usuario"])) {
            throw new Exception("id_produto ou id_usuario não enviado ou inválido", 400);
        }
        if (!Produtos::existe_by_id($_GET["id_produto"])) {
            throw new Exception("Produto não existe", 400);
        }
        if (!Usuarios::existe_by_id($_GET["id_usuario"])) {
            throw new Exception("Usuário não existe", 400);
        }
        if (!Compras::existe_compra($_GET["id_usuario"], $_GET["id_produto"])) {
            throw new Exception("Usuário não comprou o item", 400);
        }
        if (!Compras::remove($_GET["id_produto"], $_GET["id_usuario"])) {
            throw new Exception("Compra não pôde ser inserida", 500);
        }
        output(200, ["msg" => "Compra removida com sucesso"]);
    } catch (Exception $e) {
        output($e->getCode(), ["msg" => $e->getMessage()]);
    }
}
output(200, ["msg" => "Operação inválida"]);
