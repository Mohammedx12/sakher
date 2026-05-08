#!/usr/bin/env bash
# Sync frontend/index.html (+ admin.html) from `main` to `gh-pages` branch
# at the repo root, then push. Run this whenever you've made frontend
# changes on `main` and want to update the live GitHub Pages site.
#
# Usage:
#   ./scripts/deploy-pages.sh
#
set -euo pipefail

# Make sure we have a clean working tree on main
git checkout main
if ! git diff --quiet || ! git diff --cached --quiet; then
  echo "Working tree not clean. Commit or stash first." >&2
  exit 1
fi

# Capture the source files from main
SRC_INDEX=$(git show main:frontend/index.html)
SRC_ADMIN=$(git show main:frontend/admin.html)

# Switch to gh-pages
git checkout gh-pages

# Write files at root, NOT under frontend/
printf '%s' "$SRC_INDEX" > index.html
printf '%s' "$SRC_ADMIN" > admin.html

# Stage only the root-level html files
git add index.html admin.html

# Make sure no stray frontend/ folder is tracked
if git ls-files --error-unmatch frontend/index.html >/dev/null 2>&1; then
  git rm -rf frontend
fi

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
