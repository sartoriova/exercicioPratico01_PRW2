# Exercício prático react PRW2 - 2025-2

> Exercício prático de React para a disciplina de PRW2 de ADS do IFSP São Carlos. Contém um backend PHP com banco de dados servindo um servidor REST e um frontend a ser desenvolvido usando react.

### Avisos

Este código é puramente didático e deve ser utilizado apenas como modelo inicial de desenvolvimento.

## 💻 Pré-requisitos

Antes de começar, verifique que sua máquina possua:

- Docker

## 🚀 Instalando

Este projeto utiliza o Docker Compose para automatizar o processo de deploy do ambiente de desenvolvimento. Para executá-lo, no terminal, digite o seguinte comando:

```
docker compose up --build
```

## ☕ Usando

Desenvolva o código-fonte do frontend react diretamente na pasta `frontend/src/`. As requisições HTTP do frontend devem ser realizadas para o endereço base `http://localhost:3000/`. As rotas disponíveis e seus propósitos são:

- GET `/usuarios` - Retorna a lista de usuários cadastrados no sistema.
- POST `/usuarios` - Cadastra um novo usuario. Deve ser enviado no corpo da requisição o parâmetro **nome** em formato json.
- DELETE `/usuarios/<ID>` - Remove o usuário de acordo com seu ID, caso exista. Remove as compras associadas ao usuario.
- GET `/produtos` - Retorna a lista de produtos cadastrados no sistema.
- POST `/produtos` - Cadastra um novo produto. Deve ser enviado no corpo da requisição os parâmetros **nome** e **preco** em formato json. O **preco** deve ser um número maior que zero.
- PUT `/produtos/<ID>` - Edita um produto existente. Deve ser enviado no corpo da requisição os parâmetros **nome** e **preco** em formato json. O **preco** deve ser um número maior que zero.
- DELETE `/produtos/<ID>` - Remove o produto de acordo com seu ID, caso exista. Remove as compras associadas ao produto.
- POST `/compras` - Cadastra uma nova compra produto. Deve ser enviado no corpo da requisição os parâmetros **id_produto** e **id_usuario** em formato json. Ambos **id_produto** e **id_usuario** devem ser valores válidos e devem ser únicos.
- DELETE `/compras/<ID_PRODUTO>/<ID_USUARIO>` - Remove uma compra específica de um usuário de um produto.
