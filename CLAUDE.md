# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Dental clinic website for **Praxis** built with **Nette Framework** (PHP 8.2). Supports Czech and English languages. Includes a public-facing site and an admin panel for product/price management.

## Development Commands

**Start the application (Docker):**
```bash
cd .docker && ./up.sh
# Or manually:
docker-compose -p praxis up -d --build --force-recreate
docker exec praxis composer update
```

**Stop:**
```bash
cd .docker && ./down.sh
```

**Access:**
- Website: http://localhost:8080
- phpMyAdmin: http://localhost:8100
- MySQL: `localhost:3306`, DB `test`, user `test`, password `test`

**Composer:**
```bash
composer install
composer dump-autoload
```

There is no test suite in this project.

## Architecture

**Pattern:** Nette MVC (Model-View-Presenter)
- **Presenters** (`app/Presenters/`) — controllers; each extends `BaseFrontendPresenter`
- **Templates** (`app/Presenters/templates/`) — Latte templates; layout in `@layout.latte`
- **Services** (`app/Services/`) — database/business logic injected via DI
- **Router** (`app/Router/RouterFactory.php`) — locale-aware routing
- **Config** (`config/common.neon`) — Nette DI container, DB config, session settings

**Presenter hierarchy:**
- `BaseFrontendPresenter` — handles locale detection (cs/en), canonical URLs, hreflang tags; all public pages extend this
- `AdminPresenter` — standalone admin with session auth; includes cURL/DOMDocument scraping of external supplier sites

**Routing:**
- Pattern: `[<locale=cs cs|en>/]<presenter>/<action>[/<id>]`
- Default locale: Czech (`cs`); English URLs are prefixed with `/en/`
- `/home/` redirects to `/`

**Multilingual support:**
- Locale is detected from URL and stored in `$this->locale`
- Templates use conditional blocks (`{if $locale === 'en'}`) for language-specific content
- `BaseFrontendPresenter` generates hreflang alternate links for SEO

**Dependency Injection:**
- Services auto-discovered via `search` in `config/common.neon`
- Constructor injection is standard; `#[Inject]` attribute used in presenters

**Database:**
- Nette Database Explorer pattern (`$this->database->table(...)`)
- Two active tables: `users`, `products`
- Schema in `.docker/build/database/01_create.sql`

## Key Conventions

- All PHP files use `declare(strict_types=1)`
- PSR-4 autoloading under `App\` namespace
- Latte templates use `{varType}` hints at the top for IDE support
- CSS entry point: `www/css/style.css`; third-party libs in `www/lib/`
- Local config (DB credentials override, etc.) goes in `config/local.neon` (gitignored)
- Logs go to `log/`; cache to `temp/cache/`
