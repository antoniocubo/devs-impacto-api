<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="320" alt="Laravel Logo">
</p>

<p align="center">
  <strong>Devs Impacto API</strong><br>
  Plataforma em Laravel para criação de posts, enquetes e interações sociais.
</p>

---

## ✨ Visão Geral

Esta API concentra toda a lógica de conteúdo da Devs Impacto: gerenciamento de posts por categoria, enquetes colaborativas, integração com o chat e relacionamento entre usuários e categorias através do recurso de “seguir”. O projeto foi estruturado sobre Laravel 12, Sanctum para autenticação e Spatie Laravel Data para validações/DTOs.

## 🚀 Funcionalidades Principais

- **Autenticação & Gestão de Usuários** – Registro, login e proteção de rotas com Sanctum.
- **Categorias & Posts** – CRUD de categorias, criação de posts, filtro por categoria e feed personalizado das categorias seguidas.
- **Enquetes (Polls)** – Criação de enquetes, votos “a favor” ou “contra” e contagem automática.
- **Chat & Conteúdo** – Integrações existentes para chat e artigos permanecem funcionais.
- **Dados Abertos** – Cliente dedicado para buscar eventos da Câmara dos Deputados.

## 🛠️ Stack & Dependências

| Camada | Tecnologias |
| --- | --- |
| Linguagem | PHP 8.2 + Laravel 12 |
| Banco | PostgreSQL (ou compatível) |
| Autenticação | Laravel Sanctum |
| DTO/Validação | spatie/laravel-data |
| Integrações | N8N, Dados Abertos Câmara, Supabase (DB hospedado) |

## 📦 Configuração do Ambiente

1. **Instale dependências**
   ```bash
   composer install
   npm install
   ```
2. **Copie o `.env` e configure**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Ajuste as variáveis de conexão (`DB_*`, `SANCTUM_*`, `N8N_*`, etc.).
3. **Migrar & Seed**
   ```bash
   php artisan migrate --seed
   ```
4. **Rodar a aplicação**
   ```bash
   php artisan serve
   ```

## 🔐 Autenticação

- Rotas sensíveis (polls, follow de categorias, chat, etc.) requerem token Sanctum.
- Para testar rapidamente utilize `php artisan tinker` ou Postman para gerar o token via `/api/v1/auth/login`.

## 📚 Endpoints em Destaque

| Recurso | Método | Rota | Descrição |
| --- | --- | --- | --- |
| Auth | `POST` | `/api/v1/auth/register` | Cria usuário |
| Auth | `POST` | `/api/v1/auth/login` | Retorna token |
| Posts | `POST` | `/api/v1/posts` | Cria post (requer `category_id`) |
| Posts | `GET` | `/api/v1/posts/category/{id}` | Lista posts da categoria |
| Categorias | `POST` | `/api/v1/categories/follow` | Segue categorias (logado) |
| Categorias | `GET` | `/api/v1/categories/followed/posts` | Feed com posts das categorias seguidas |
| Enquetes | `POST` | `/api/v1/polls` | Cria enquete |
| Enquetes | `POST` | `/api/v1/polls/{pollId}/vote` | Vota (a favor/contra) |

> Consulte `routes/api.php` para ver todas as rotas disponíveis.

## 🔄 Integração com N8N

O projeto expõe webhooks e eventos pensados para interagir com fluxos automatizados no **N8N**, permitindo:

- Disparo automático ao criar posts ou enquetes (ex: enviar notificações).
- Processamento de votos/opiniões para dashboards externos.
- Sincronização de categorias seguidas com newsletters ou campanhas.

### Fluxo da Integração

1. **Webhook**: o N8N recebe payloads da API (via rotas ou Jobs).
2. **Processamento**: o fluxo aplica regras de negócio, enriquece dados ou envia notificações.
3. **Retorno/Feedback**: se necessário, o N8N chama endpoints de callback da API.

> **Espaço reservado para vídeo**  
> _(insira aqui o link/iframe do vídeo demonstrando o fluxo no N8N)_.

## 🧪 Testes

```bash
php artisan test
```

Os testes básicos garantem que o ambiente está configurado corretamente. Expanda-os conforme novas features forem introduzidas.

## 🗺️ Convenções & Estrutura

- `app/Domain` – DTOs e Models.
- `app/Infrastructure` – Services, Repositories e Clients externos.
- `app/Http/Actions` – Actions por endpoint (inspirado em ADR).
- `database/migrations` – Evolução de schema versionada.

## 🤝 Contribuição

1. Crie uma issue descrevendo a proposta.
2. Abra um PR com testes e descrição detalhada.
3. Use commits claros (ex: `feat(poll): add vote endpoint`).

## 📄 Licença

Projeto disponibilizado sob licença MIT. Veja o arquivo `LICENSE` para detalhes.
