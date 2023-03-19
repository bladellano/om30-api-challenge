
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