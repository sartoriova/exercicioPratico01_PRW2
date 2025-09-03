<?php

require_once(__DIR__ . "/../configs/Database.php");
require_once(__DIR__ . "/../configs/utils.php");


class Compras
{
    public static function inserir($id_produto, $id_usuario)
    {
        try {
            $conexao = Conexao::getConexao();

            $stmt = $conexao->prepare("INSERT INTO compras(id_produto, id_usuario) VALUES (?,?)");
            $stmt->execute([$id_produto, $id_usuario]);
            return  $stmt->rowCount();
        } catch (Exception $e) {
            output(500, ["msg" => $e->getMessage()]);
        }
    }

    public static function existe_by_id($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT COUNT(*) as qtde FROM compras WHERE id = ?");
            $stmt->execute([$id]);

            return $stmt->fetchColumn();
        } catch (Exception $e) {
            output(500, ["msg" => $e->getMessage()]);
        }
    }

    public static function remove($id_produto, $id_usuario)
    {
        try {
            $conexao = Conexao::getConexao();

            $stmt = $conexao->prepare("DELETE FROM compras WHERE id_usuario = ? AND id_produto = ?");
            $stmt->execute([$id_usuario, $id_produto]);

            return $stmt->rowCount();
        } catch (Exception $e) {
            output(500, ["msg" => $e->getMessage()]);
        }
    }

    public static function listar_total_gasto()
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT u.cpf, SUM(p.preco) as total_gasto FROM usuarios u JOIN compras c ON u.id = c.id_usuario JOIN produtos p ON c.id_produto = p.id GROUP BY u.cpf");
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            output(500, ["msg" => $e->getMessage()]);
        }
    }

    public static function listar_usuarios_compraram($id_produto)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT p.nome, COUNT(*) as quantidade_vendas FROM produtos p JOIN compras c ON c.id_produto = p.id WHERE c.id_produto = ?");
            $stmt->execute([$id_produto]);

            return $stmt->fetchAll()[0];
        } catch (Exception $e) {
            output(500, ["msg" => $e->getMessage()]);
        }
    }

    public static function existe_by_idproduto($id_produto)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT COUNT(*) as qtde FROM compras WHERE id_produto = ?");
            $stmt->execute([$id_produto]);

            return $stmt->fetchColumn();
        } catch (Exception $e) {
            output(500, ["msg" => $e->getMessage()]);
        }
    }

    public static function existe_compra($id_usuario, $id_produto)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT COUNT(*) as qtde FROM compras WHERE id_usuario = ? AND id_produto = ?");
            $stmt->execute([$id_usuario, $id_produto]);

            return $stmt->fetchColumn();
        } catch (Exception $e) {
            output(500, ["msg" => $e->getMessage()]);
        }
    }
}
