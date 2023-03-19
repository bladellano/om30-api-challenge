
# Desafio Api Restfull om30

Desenvolver uma API RestFull de cadastro de pacientes com seu devido endereço.

## Requerido
- [Docker](https://www.docker.com/)
- [Docker Composer](https://docs.docker.com/compose/)
- [Make](https://linuxhint.com/install-use-make-ubuntu/)

## 🚀 Sobre mim
Sou organizado e perfeccionista, preocupo-me com a qualidade. Gosto de ambientes estruturados com regras claras. Quando recebo uma tarefa, procuro executá-la com precisão e atenção aos detalhes. Sou calmo e bom ouvinte, acompanho os processos sempre que possível.

## Executar localmente

Clonar o projeto
```bash
  git clone https://github.com/bladellano/om30-api-challenge.git
```

Vá para o diretório do projeto
```bash
  cd om30-api-challenge
```

Criar arquivo .env

```bash
  cd laravel-app
  cp .env.example .env
  cd ..
```

## Construir projeto
### Opção 01 - com Make:

```bash
  make setup
```

### Opção 02 - sem Make:
```bash
  docker-compose up -d

  docker exec laravel-app bash -c "composer update && php artisan key:generate"

  docker exec -t laravel-app bash -c 'chown -R www-data:www-data /var/www/html/storage'	

  docker exec laravel-app bash -c "php artisan migrate"

  docker exec laravel-app bash -c "php artisan db:seed"  
```
Após executar todas essa etapas e o projeto estiver criado, clique aqui para ver a aplicação funcionando http://127.0.0.1:8080/api 

## Entrar no bash da aplicação
```bash
make in
```
## Executar o comando Queue
```bash
make queue
```
## Entrar no container Redis
```bash
make redis
```
## Executar Tests
```bash
make test
```

# Referências da API

## Retorna todos pacientes ou uma pesquisa (nome ou cpf)

```http
  GET /api/patients
```
| Query | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `search`      | `int\|string` | **Not required**|

## Buscar paciente

```http
  GET /api/patients/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `int` | **Required**|

## Gravar paciente

```http
  POST /api/patients
```
Header `Content-Type:multipart/form-data`
| Query | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `photo`      | `file` | **Not required**|
| `full_name`      | `string` | **Required**|
| `mother_full_name`      | `string` | **Required**|
| `date_of_birth`      | `string` | **Required**|
| `cpf`      | `string` | **Required**|
| `cns`      | `string` | **Required**|
| `address[street]`      | `string` | **Required**|
| `address[number]`      | `string` | **Required**|
| `address[zip_code]`      | `string` | **Required**|
| `address[complement]`      | `string` | **Not required**|
| `address[district]`      | `string` | **Required**|
| `address[city]`      | `string` | **Required**|
| `address[state]`      | `string` | **Required**|

## Atualizar paciente

```http
  PUT /api/patients/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `int` | **Required**|

Header `Content-Type:multipart/form-data`
| Query | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `photo`      | `file` | **Not required**|
| `full_name`      | `string` | **Required**|
| `mother_full_name`      | `string` | **Required**|
| `date_of_birth`      | `string` | **Required**|
| `cpf`      | `string` | **Required**|
| `cns`      | `string` | **Required**|
| `address[street]`      | `string` | **Required**|
| `address[number]`      | `string` | **Required**|
| `address[zip_code]`      | `string` | **Required**|
| `address[complement]`      | `string` | **Not required**|
| `address[district]`      | `string` | **Required**|
| `address[city]`      | `string` | **Required**|
| `address[state]`      | `string` | **Required**|

## Remover paciente

```http
  DELETE /api/patients/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `int` | **Required**|

## Buscar CEP

```http
  GET /api/cep/{cep}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `cep`      | `int` | **Required**|

## Importar CSV

```http
  POST /api/import-csv
```
Header `Content-Type:multipart/form-data`
| Query | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `csv`      | `file` | **Required**|


