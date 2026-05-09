#!/usr/bin/env bash
# Deploy frontend/ from `main` to `gh-pages` branch (at root) via a
# clean worktree — no risk of accidentally publishing backend/ or
# node_modules/. Run after committing changes on `main`.
#
# Usage:
#   ./scripts/deploy-pages.sh
#
set -euo pipefail

REPO_ROOT="$(git rev-parse --show-toplevel)"
cd "$REPO_ROOT"

# Make sure we're on main with a clean tree (so the source files match HEAD)
CURRENT_BRANCH="$(git rev-parse --abbrev-ref HEAD)"
if [ "$CURRENT_BRANCH" != "main" ]; then
  git checkout main
fi
if ! git diff --quiet || ! git diff --cached --quiet; then
  echo "Working tree not clean. Commit or stash first." >&2
  exit 1
fi

# Create an isolated worktree for gh-pages
WT="$(mktemp -d)"
trap 'cd "$REPO_ROOT"; git worktree remove --force "$WT" 2>/dev/null || true; rm -rf "$WT"' EXIT

git worktree add "$WT" gh-pages
echo "Worktree created at: $WT"

# Wipe the worktree (keep .git pointer)
find "$WT" -mindepth 1 -maxdepth 1 ! -name '.git' -exec rm -rf {} +

# Copy frontend payload into the worktree at root
cp frontend/index.html "$WT/index.html"
cp frontend/admin.html "$WT/admin.html"
if [ -d frontend/img ]; then
  cp -R frontend/img "$WT/img"
fi

# Optional: drop a .nojekyll so Pages serves files literally
touch "$WT/.nojekyll"

# Commit + push from inside the worktree
cd "$WT"
git add -A
if git diff --cached --quiet; then
  echo "No changes to deploy."
else
  git commit -m "Deploy from main"
  git push origin gh-pages
fi

cd "$REPO_ROOT"
echo "Done. Site rebuilds in ~30–60 seconds: https://mohammedx12.github.io/sakher/"