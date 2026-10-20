# CLAUDE.md

Project-level instructions for Claude. They add to the global `~/.claude/CLAUDE.md`; where both
speak, this file wins for this project.

## Commit messages (important)

- At the **end of every feature, fix or change** you make, finish your reply with a **suggested commit
  message** in a code block, ready to paste.
- Format: one imperative subject line, `type(scope): summary` (feat, fix, style, refactor, chore,
  docs), 72 characters or fewer. Add a short body only when the *why* is not obvious.
- **No Claude watermark, ever.** Never add `Co-Authored-By: Claude ...`, "Generated with Claude Code",
  or any other mention of Claude/AI to a commit message or PR description - not in the suggestion,
  and not in commits you create yourself.
- Only commit or push when I ask. Never commit `.env`, dumps, backups or other secrets.

## How I want you to work

- Change what I asked for and keep everything else. No unrelated refactors or renames.
- Read the existing code first and follow its patterns; never invent files, columns, routes or config.
- Say plainly what you ran and what you did not. Do not claim something works unless you tested it.
- Ask before anything hard to undo (dropping data, rewriting history, force push, running migrations
  on a database that is not clearly local). Back up first when data is involved.
- Keep answers short and practical. Link files as clickable paths.
## Project: workspace (Laravel 10 backend)

- Runs on **both MySQL and PostgreSQL**: no engine-specific SQL unless guarded by the driver; prefer
  Eloquent / Query Builder / Schema Builder.
- Columns are **snake_case** (`is_active`, `is_personal`, ...). The camelCase to snake_case rename
  migration exists; new code and migrations must use snake_case.
- Local database: PostgreSQL `workspace` on localhost:5432. It was restored from a dump, so
  `php artisan migrate:status` shows many old migrations as Pending even though the tables exist.
  **Never run plain `php artisan migrate` here**: run a specific migration with `--path=` and back up
  first (`pg_dump -Fc`).
- Use XAMPP's PHP explicitly (`E:\xampp\php\php.exe`); a stray file named `php` in the user home
  shadows the `php` command in some shells.
- After changing `.env` or config run `php artisan config:clear`.
