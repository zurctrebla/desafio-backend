# 🚀 Desafio Backend — Laravel + API Pexels

Este projeto é um desafio backend desenvolvido com Laravel que consome a API pública do [Pexels](https://www.pexels.com/pt-br/api/documentation/), retornando dados formatados via endpoint próprio protegido com token.

---

## ✅ Requisitos

- PHP 8.2+
- Composer
- Conta na [Pexels](https://www.pexels.com/pt-br/) para obter sua API key

---

## 📅 Clonando o projeto

```bash
git clone https://github.com/zurctrebla/desafio-backend.git
cd desafio-backend
```

---

## ⚙️ Configuração

### 1. Copie o `.env.example` para `.env`

```bash
cp .env.example .env
```

### 2. Instale as dependências PHP

```bash
composer install
```

### 3. Gere a chave da aplicação

```bash
php artisan key:generate
```

---

## 🔐 Configuração de tokens

### 📌 Token da API do Pexels

Crie uma conta em [pexels.com](https://www.pexels.com/pt-br/) e obtenha sua chave de API.  
Depois, adicione no seu `.env`:

```env
API_TOKEN_PEXELS=coloque_sua_chave_aqui
```

---

### 📌 Token de acesso à sua API local

Para proteger os endpoints da sua API, você precisa gerar um token local.  
Você pode gerar um com o comando abaixo:

```bash
php -r "echo bin2hex(random_bytes(32)) . PHP_EOL;"
```

Cole o token gerado no seu `.env`:

```env
FRONTEND_ACCESS_TOKEN=bd43e77489859c11c09ed410e1b69efdc2706265dbad36c0a78bb155be118aca
```

> Este será o valor exigido no cabeçalho `Authorization` das requisições.

---

## 📚 Gerar a documentação Swagger

```bash
php artisan l5-swagger:generate
```

---

## ▶️ Rodando o servidor local

```bash
php artisan serve
```

Acesse a documentação da API em:

```
http://127.0.0.1:8000/api/documentation
```

---

## 🔐 Testando o endpoint protegido

Use um client como Postman, Insomnia ou `curl` com o cabeçalho:

```http
Authorization: bd43e77489859c11c09ed410e1b69efdc2706265dbad36c0a78bb155be118aca
```

Exemplo com `curl`:

```bash
curl -H "Authorization: bd43e77489859c11c09ed410e1b69efdc2706265dbad36c0a78bb155be118aca" \
     "http://127.0.0.1:8000/api/videos?query=nature&per_page=5"
```

---

## 🥪 Executar os testes

```bash
php artisan test
```

---

## 🔗 Endereço da API hospedada

Esta API está hospedada em:

```
https://api-laravel.newttech.com.br/api/documentation
```

---

