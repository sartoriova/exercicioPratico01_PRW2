function User(props) {
    return (
        <>
            <tr>
                <td>{props.id}</td>
                <td>{props.name}</td>
                <td>
                    <ul>
                        {props.products.map((product, index) => (
                            <li key={index}>{product.id} - {product.nome} - {product.preco}</li>
                        ))}
                    </ul>
                </td>
                <td>{props.total}</td>
                <td>
                    <button className="btn btn-danger">Remover</button>
                </td>
            </tr>
        </>
    )
}

export default User;