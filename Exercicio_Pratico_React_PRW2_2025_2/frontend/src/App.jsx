import "./App.css";
import axios from "axios";
import ProductsList from "./ProductsList";
import UsersList from "./UsersList";
import { useState } from 'react';
import ProductRegister from "./ProductRegister";

function App() {
  const [users, setUsers] = useState([]);
  const [products, setProducts] = useState([]);
  const api = axios.create({
    baseURL: "http://localhost:3000"
  });

  async function loadUsers() {
    try {
      let res = await api.get("/usuarios");
      setUsers(res.data);
    } catch (error) {
      console.log(error);
    }
  }

  async function loadProducts() {
    try {
      let res = await api.get("/produtos");
      setProducts(res.data);
    } catch (error) {
      console.log(error);
    }
  }

  function calculateTotal(idUser) {
    let soma = 0;

    users.filter((user) => user.id == idUser)[0].produtos.forEach(product => {
      soma = soma + product.preco;
    });

    return soma;
  }

  if (users.length == 0) {
    loadUsers();
  }

  if (products.length == 0) {
    loadProducts();
  }

  return (
    <>
      <h1 className="p-3 text-center">Lista de compras por usuário</h1>
      <div className="container">
        <div className="row">
          <div className="col p-1">
            <h2 className="mt-4">Cadastrar pessoa</h2>
            <form id="formPessoas" className="row g-3">
              <div className="col-12 nomePessoa">
                <label htmlFor="inputNome" className="form-label">Nome</label>
                <input type="text" className="form-control" id="inputNome" placeholder="Digite o nome"
                  required />
              </div>
              <div className="col-12">
                <button type="submit" className="btn btn-primary">Cadastrar</button>
              </div>
            </form>
            <h2 className="mt-4">Comprar produto</h2>
            <form id="formCompra" className="row g-3">
              <div className="col-12 comprarProduto">
                <fieldset>
                  <label htmlFor="pessoaSelecionado" className="form-label pt-2">Pessoa</label>
                  <select id="pessoaSelecionado" className="form-select">
                    <option value="0">Selecione uma pessoa</option>
                  </select>
                  <label htmlFor="produtoSelecionado" className="form-label pt-2">Produto</label>
                  <select id="produtoSelecionado" className="form-select">
                    <option value="0">Selecione um produto</option>
                  </select>
                </fieldset>
              </div>
              <div className="col-12">
                <button type="submit" className="btn btn-primary">Comprar</button>
              </div>
            </form>
            <h2 className="display-6 text-center mt-4">Lista de Pessoas</h2>
            <UsersList users={users} calculateTotal={calculateTotal}></UsersList>

          </div>
          <div className="col-2"></div>
          <div className="col p-1">
            <h2 className="mt-4">Cadastrar produto</h2>
            <ProductRegister products={products} setProducts={setProducts}></ProductRegister>

            <h2 className="display-6 text-center mt-4">Lista de Produtos</h2>
            <ProductsList products={products}></ProductsList>
          </div>
        </div>

      </div>
    </>
  )
}

export default App
