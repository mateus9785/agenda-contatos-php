# Agenda de Contatos: API

![CI](https://github.com/mateus9785/agenda-contatos-php/actions/workflows/ci.yml/badge.svg)

API Laravel para um gerenciador de contatos: usuários, contatos (com
telefones, endereços e grupos), redefinição de senha por e-mail e uma
integração OAuth com [Conta Azul](https://contaazul.com/) que busca os
códigos de estados do IBGE para o formulário de endereço.

## Stack

- **Laravel 13** em **PHP 8.3**
- **MySQL** via Eloquent, banco de dados principal
- **PHPUnit 11**: testes unitários e de feature, executados contra um arquivo sqlite no CI
- **Laravel Pint** e **Larastan** (PHPStan): aplicados no CI, não apenas documentados
- **Laravel Mix** para o pouco JS/SCSS próprio (telas de autenticação baseadas em Bootstrap)

## Arquitetura

```
routes/  ->  Controllers  ->  Services  ->  Repositories  ->  Models (Eloquent)
                                  |
                              Clients/ (outbound HTTP to third parties)
```

- **Controllers** validam a entrada via classes Form Request e delegam para
  um **Service**, sem consultas Eloquent aqui.
- **Services** concentram as regras de negócio e orquestram chamadas a um
  **Repository**. `ContactService` também é o único lugar que fala com um
  cliente HTTP externo (`IbgeProvincesClientInterface`), nunca diretamente
  com `file_get_contents`/Guzzle.
- **Repositories** são as únicas classes que falam diretamente com os
  models Eloquent, atrás de uma interface vinculada em
  `RepositoryServiceProvider`.
- **Clients** (`app/Clients`) encapsulam chamadas HTTP de saída para APIs de
  terceiros atrás de uma interface, seguindo o mesmo padrão de injeção de
  dependência dos repositories. Atualmente há apenas o `IbgeProvincesClient`
  (geonames.org), vinculado em `ClientServiceProvider`.
- Controllers que precisam de `auth` implementam
  `Illuminate\Routing\Controllers\HasMiddleware` com um método estático
  `middleware()`, que é a substituição do Laravel 11+ para a antiga chamada
  `$this->middleware(...)` no construtor, já que a classe base `Controller`
  não a disponibiliza mais.

## Decisões Técnicas

- **Laravel 13, não 11.** O plano original era usar Laravel 11 (um salto
  menor a partir da versão 8), mas o `composer audit` em uma instalação
  limpa do Laravel 11 revelou CVEs reais e não corrigidos, afetando todas
  as versões 11.x (por exemplo, CVE-2026-48019, corrigido apenas em
  12.60+/13.10+). A versão mais recente (13.17+) passa limpa na auditoria.
  Publicar uma versão com um CVE aberto conhecido só para economizar um
  diff de migração menor não era a escolha certa.
- **Erros do PHPStan vão para a baseline, não são corrigidos em massa
  silenciosamente.** O nível 5 revelou cerca de 130 ocorrências de dois
  padrões sistêmicos, porém inofensivos (propriedades de construtor não
  declaradas, que dependem da criação dinâmica de propriedades hoje
  descontinuada no PHP, e tipos em docblocks `@param`/`@return` sem a
  barra invertida inicial, que faz o PHPStan resolvê-los contra o
  namespace errado). O `phpstan-baseline.neon` registra isso como dívida
  técnica visível e pesquisável, em vez de uma leva de mudanças não
  relacionadas encaixada em qualquer PR que por acaso tenha adicionado a
  ferramenta. Os arquivos vão sendo limpos conforme são tocados por outros
  motivos (veja os PRs do `IbgeProvincesClient` e do Laravel 13, que
  reduziram a baseline como efeito colateral de um trabalho que já estava
  sendo feito ali).
- **Os testes rodam contra um *arquivo* sqlite, não `:memory:`.** As
  migrations rodam em um processo separado (`php artisan migrate`) antes
  que o `artisan test` inicie outro processo, e `:memory:` não sobrevive a
  essa fronteira. Isso importa na prática aqui: `tests/Unit/*Test.php` usa
  `DatabaseTransactions`, não `RefreshDatabase`, então esses testes esperam
  que o schema já exista em vez de migrá-lo por conta própria.
- **`IbgeProvincesClient` em vez de `file_get_contents` no `ContactService`.**
  O código original chamava geonames.org diretamente de um método do
  service: sem cliente injetado, sem tratamento de erro (uma requisição
  que falhasse gerava uma desreferência de null), sem timeout, e impossível
  de testar sem uma chamada de rede real. Encapsular isso atrás de uma
  interface e da facade `Http` do Laravel resolveu os quatro problemas de
  uma vez.

## Configuração

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install && npm run dev   # first-party JS/SCSS for the auth views
php artisan serve
```

## Testes

```bash
touch database/testing.sqlite
DB_CONNECTION=sqlite DB_DATABASE=database/testing.sqlite php artisan migrate --force
php artisan test
vendor/bin/pint --test
vendor/bin/phpstan analyse --memory-limit=512M
```

O CI (`.github/workflows/ci.yml`) executa exatamente essa sequência em
cada push e PR.

## Limitações conhecidas / Próximos passos

- `phpstan-baseline.neon` ainda carrega cerca de 81 entradas pré-existentes
  (reduzido de 132 no início dessa limpeza). Isso é rastreado, não
  escondido, veja [Decisões Técnicas](#decisões-técnicas).
- Os assets de frontend ainda são construídos com Laravel Mix (webpack),
  não Vite. O skeleton padrão do Laravel 13 já vem com Vite, mas o Mix
  ainda é uma ferramenta mantida e versionada de forma independente, e
  migrar isso não fez parte desta etapa.
- `config/app.php` define `'locale' => 'pt'`, mas `resources/lang/` só tem
  um diretório `en/`, então as traduções caem silenciosamente para o
  `fallback_locale`. É uma lacuna pré-existente, não introduzida por esta
  limpeza.

## Licença

[MIT](./LICENSE)
