<?php

require_once(__DIR__ . "/configs/utils.php");
require_once(__DIR__ . "/model/Produtos.php");

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
        if (!valid($dados, ["nome", "preco"])) {
            throw new Exception("Nome e/ou preco não enviados", 400);
        }
        if (!is_numeric($dados["preco"]) || floatval($dados["preco"]) < 0) {
            throw new Exception("Preço inválido ou menor que zero", 400);
        }
        if (Produtos::existe_by_nome($dados["nome"])) {
            throw new Exception("Nome de produto duplicado", 400);
        }
        if (!Produtos::inserir($dados["nome"], $dados["preco"])) {
            throw new Exception("Produto não pôde ser inserido", 500);
        }
        output(200, ["msg" => "Cadastro realizado com sucesso"]);
    } catch (Exception $e) {
        output($e->getCode(), ["msg" => $e->getMessage()]);
    }
}

if (method("PUT")) {
    try {
        if (!valid($_GET, ["id"])) {
            throw new Exception("id não enviado ou inválido", 400);
        }
        $dados = inputJSON();
        if (!$dados) {
            throw new Exception("JSON inválido ou não enviado", 400);
        }
        if (!valid($dados, ["nome", "preco"])) {
            throw new Exception("Nome e/ou preco não enviados", 400);
        }
        if (!Produtos::existe_by_id($_GET["id"])) {
            throw new Exception("Produto não existe", 400);
        }
        if (!is_numeric($dados["preco"]) || floatval($dados["preco"]) < 0) {
            throw new Exception("Preço inválido ou menor que zero", 400);
        }
        if (Produtos::existe_by_nome_notId($dados["nome"], $_GET["id"])) {
            throw new Exception("Nome de produto duplicado", 400);
        }
        if (!Produtos::editar($_GET["id"], $dados["nome"], $dados["preco"])) {
            throw new Exception("Produto não pôde ser editado", 500);
        }
        output(200, ["msg" => "Produto editado com sucesso"]);
    } catch (Exception $e) {
        output($e->getCode(), ["msg" => $e->getMessage()]);
    }
}

if (method("DELETE")) {
    try {
        if (!valid($_GET, ["id"])) {
            throw new Exception("id não enviado ou inválido", 400);
        }
        if (!Produtos::existe_by_id($_GET["id"])) {
            throw new Exception("Produto não existe", 400);
        }
        if (!Produtos::remove($_GET["id"])) {
            throw new Exception("Produto não pôde ser removido", 500);
        }
        output(200, ["msg" => "Produto removido com sucesso"]);
    } catch (Exception $e) {
        output($e->getCode(), ["msg" => $e->getMessage()]);
    }
}

if (method("GET")) {
    try {
        output(200, Produtos::listar());
    } catch (Exception $e) {
        output($e->getCode(), ["msg" => $e->getMessage()]);
    }
}



output(200, ["msg" => "Operação inválida"]);
