import { useState } from "react";

function ProductRegister(props) {
    const [product, setProduct] = useState({
        id: 6,
        nome: "",
        preco: "",
    });

    function update(e) {
        setProduct({...product, [e.target.name] : e.target.value});
    }

    function register(e) {
        e.preventDefault();

        props.setProducts([...props.products, product]);
        setProduct({nome: "", preco: ""});
    }

    return (
        <>
            <form id="formProdutos" className="row g-3" onSubmit={register}>
                <div className="col-12 nomeProduto">
                    <label htmlFor="inputProdutoNome" className="form-label">Nome</label>
                    <input type="text" className="form-control" id="inputProdutoNome" name="nome"
                        placeholder="Digite o nome" required onChange={update} value={product.nome}/>
                </div>
                <div className="col-12">
                    <label htmlFor="inputProdutoPreco" className="form-label">Preço</label>
                    <input type="number" min="0" step="0.01" name="preco" className="form-control"
                        id="inputProdutoPreco" placeholder="Digite o preço" required onChange={update} value={product.preco}/>
                </div>
                <div className="col-12">
                    <button type="submit" className="btn btn-primary" id="cadastrarProduto">Cadastrar</button>
                </div>
            </form>
        </>
    )
}

export default ProductRegister;