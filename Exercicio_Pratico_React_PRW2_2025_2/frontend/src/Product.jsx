function Product(props) {
    return (
        <>
            <tr>
                <td>{props.id}</td>
                <td>{props.name}</td>
                <td>{props.price}</td>
                <td>
                    <button className="btn btn-primary">+ preço</button>
                    <button className="btn btn-secondary">- preço</button>
                    <button className="btn btn-success">Editar</button>
                    <button className="btn btn-danger">Remover</button>
                </td>
            </tr>
        </>
    )
}

export default Product;