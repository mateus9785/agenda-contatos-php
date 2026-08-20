# Agenda de Contatos — API

![CI](https://github.com/mateus9785/agenda-contatos-php/actions/workflows/ci.yml/badge.svg)

Laravel API for a contacts manager: users, contacts (with phones, addresses
and groups), password reset by email, and an OAuth integration with
[Conta Azul](https://contaazul.com/) that pulls IBGE province codes for the
address form.

## Stack

- **Laravel 13** on **PHP 8.3**
- **MySQL** via Eloquent — primary datastore
- **PHPUnit 11** — unit + feature tests, run against a sqlite file in CI
- **Laravel Pint** + **Larastan** (PHPStan) — enforced in CI, not just documented
- **Laravel Mix** for the small amount of first-party JS/SCSS (Bootstrap-based auth views)

## Architecture

```
routes/  ->  Controllers  ->  Services  ->  Repositories  ->  Models (Eloquent)
                                  |
                              Clients/ (outbound HTTP to third parties)
```

- **Controllers** validate input via Form Request classes and delegate to a
  **Service** — no Eloquent queries here.
- **Services** hold the business rules and orchestrate calls to a
  **Repository**. `ContactService` is also the one place that talks to an
  external HTTP client (`IbgeProvincesClientInterface`), never directly to
  `file_get_contents`/Guzzle.
- **Repositories** are the only classes that talk to Eloquent models
  directly, behind an interface bound in `RepositoryServiceProvider`.
- **Clients** (`app/Clients`) wrap outbound calls to third-party HTTP APIs
  behind an interface, the same DI pattern as repositories — currently just
  `IbgeProvincesClient` (geonames.org), bound in `ClientServiceProvider`.
- Controllers that need `auth` implement `Illuminate\Routing\Controllers\HasMiddleware`
  with a static `middleware()` method — the Laravel 11+ replacement for the
  old `$this->middleware(...)` constructor call, which the base `Controller`
  class no longer provides.

## Technical Decisions

- **Laravel 13, not 11.** The original plan was Laravel 11 (a smaller jump
  from 8), but `composer audit` on a clean Laravel 11 install turned up real,
  unpatched CVEs affecting every 11.x release (e.g. CVE-2026-48019, fixed
  only in 12.60+/13.10+). Latest (13.17+) audits clean. For a repo meant to
  demonstrate senior judgment, shipping a version with a known open CVE
  wasn't the right trade-off just to save a smaller migration diff.
- **PHPStan errors get baselined, not silently fixed in bulk.** Level 5
  surfaced ~130 instances of two systemic-but-harmless patterns (undeclared
  constructor properties relying on PHP's now-deprecated dynamic property
  creation, and `@param`/`@return` docblock types missing a leading
  backslash that PHPStan then resolves against the wrong namespace).
  `phpstan-baseline.neon` records them as visible, greppable debt instead of
  a wall of unrelated changes bolted onto whatever PR happened to add the
  tool — files get cleaned up as they're touched for other reasons (see the
  `IbgeProvincesClient` and Laravel 13 PRs, which each shrank the baseline
  as a side effect of work already happening there).
- **Tests run against a sqlite *file*, not `:memory:`.** Migrations run as a
  separate `php artisan migrate` process before `artisan test` starts a new
  one, and `:memory:` doesn't survive across that boundary. This matters
  concretely here: `tests/Unit/*Test.php` use `DatabaseTransactions`, not
  `RefreshDatabase`, so they expect the schema to already exist rather than
  migrating it themselves.
- **`IbgeProvincesClient` instead of `file_get_contents` in `ContactService`.**
  The original code called geonames.org directly from a service method: no
  injected client, no error handling (a failed request produced a null
  dereference), no timeout, untestable without a live network call. Wrapping
  it behind an interface + Laravel's `Http` facade fixed all four at once.

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install && npm run dev   # first-party JS/SCSS for the auth views
php artisan serve
```

## Testing

```bash
touch database/testing.sqlite
DB_CONNECTION=sqlite DB_DATABASE=database/testing.sqlite php artisan migrate --force
php artisan test
vendor/bin/pint --test
vendor/bin/phpstan analyse --memory-limit=512M
```

CI (`.github/workflows/ci.yml`) runs this exact sequence on every push and PR.

## Known limitations / Roadmap

- `phpstan-baseline.neon` still carries ~81 pre-existing entries (down from
  132 at the start of this cleanup) — tracked, not hidden, see
  [Technical Decisions](#technical-decisions).
- Frontend assets still build with Laravel Mix (webpack), not Vite — Laravel
  13's default skeleton ships Vite, but Mix is still a maintained,
  independently-versioned tool and migrating it wasn't part of this pass.
- `config/app.php` sets `'locale' => 'pt'`, but `resources/lang/` only has an
  `en/` directory — translations silently fall back to `fallback_locale`.
  Pre-existing gap, not introduced by this cleanup.

## License

[MIT](./LICENSE)
