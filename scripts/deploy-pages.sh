#!/usr/bin/env bash
# Sync frontend/* from `main` to `gh-pages` branch (at root), then push.
# Includes index.html, admin.html, and the img/ folder.
#
# Usage:
#   ./scripts/deploy-pages.sh
#
set -euo pipefail

REPO_ROOT="$(git rev-parse --show-toplevel)"
cd "$REPO_ROOT"

# Make sure we have a clean working tree on main
git checkout main
if ! git diff --quiet || ! git diff --cached --quiet; then
  echo "Working tree not clean. Commit or stash first." >&2
  exit 1
fi

# Stage the frontend files we want to deploy into a temp dir
STAGE="$(mktemp -d)"
trap 'rm -rf "$STAGE"' EXIT
cp frontend/index.html "$STAGE/"
cp frontend/admin.html "$STAGE/"
if [ -d frontend/img ]; then
  cp -R frontend/img "$STAGE/img"
fi

# Switch to gh-pages
git checkout gh-pages

# Wipe everything currently tracked except .git
git ls-files | grep -v '^\.git/' | xargs -r rm -f
# Also remove any stale frontend/ folder still around
[ -d frontend ] && rm -rf frontend

# Copy staged files to repo root
cp "$STAGE/index.html" .
cp "$STAGE/admin.html" .
[ -d "$STAGE/img" ] && cp -R "$STAGE/img" ./img

# Stage everything (index.html, admin.html, img/*)
git add -A

# Commit + push (skip if nothing changed)
if git diff --cached --quiet; then
  echo "No changes to deploy."
else
  git commit -m "Deploy from main"
  git push
fi

# Back to main
git checkout main
echo "Done. Site rebuilds in ~30–60 seconds: https://mohammedx12.github.io/sakher/"
