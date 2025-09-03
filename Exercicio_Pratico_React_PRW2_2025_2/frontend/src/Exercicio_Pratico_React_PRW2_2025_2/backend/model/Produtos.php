<?php

require_once(__DIR__ . "/../configs/Database.php");
require_once(__DIR__ . "/../configs/utils.php");


class Produtos
{
    public static function inserir($nome, $preco)
    {
        try {
            $conexao = Conexao::getConexao();

            $stmt = $conexao->prepare("INSERT INTO produtos(nome, preco) VALUES (?,?)");
            $stmt->execute([$nome, $preco]);
            return $stmt->rowCount();
        } catch (Exception $e) {
            output(500, ["msg" => $e->getMessage()]);
        }
    }

    public static function editar($id, $nome, $preco)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("UPDATE produtos SET nome = ?, preco = ? WHERE id = ?");
            $stmt->execute([$nome, $preco, $id]);
            return $stmt->rowCount();
        } catch (Exception $e) {
            output(500, ["msg" => $e->getMessage()]);
        }
    }

    public static function existe_by_id($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT COUNT(*) as qtde FROM produtos WHERE id = ?");
            $stmt->execute([$id]);

            return $stmt->fetchColumn();
        } catch (Exception $e) {
            output(500, ["msg" => $e->getMessage()]);
        }
    }

    public static function listar()
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM produtos");
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            output(500, ["msg" => $e->getMessage()]);
        }
    }

    public static function remove($id)
    {
        try {
            $conexao = Conexao::getConexao();

            $stmt = $conexao->prepare("DELETE FROM produtos WHERE id = ?");
            $stmt->execute([$id]);

            return $stmt->rowCount();
        } catch (Exception $e) {
            output(500, ["msg" => "Produto não pôde ser removido"]);
        }
    }


    public static function existe_by_nome($nome)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT COUNT(*) as qtde FROM produtos WHERE nome = ?");
            $stmt->execute([$nome]);

            return $stmt->fetchColumn();
        } catch (Exception $e) {
            output(500, ["msg" => $e->getMessage()]);
        }
    }

    public static function existe_by_nome_notId($nome, $id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT COUNT(*) as qtde FROM produtos WHERE nome = ? AND id != ?");
            $stmt->execute([$nome, $id]);

            return $stmt->fetchColumn();
        } catch (Exception $e) {
            output(500, ["msg" => $e->getMessage()]);
        }
    }
}
