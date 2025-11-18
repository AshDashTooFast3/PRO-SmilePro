#!/bin/bash

# Script to push the main branch to the remote repository
# Run this script to complete the main branch creation

set -e

echo "Checking if main branch exists locally..."
if git rev-parse --verify main >/dev/null 2>&1; then
    echo "✓ Main branch exists locally"
else
    echo "Creating main branch from initial commit..."
    git checkout -b main 18bf517
fi

echo "Pushing main branch to remote repository..."
git push -u origin main

echo "✓ Main branch has been pushed to the remote repository"
echo ""
echo "To set main as the default branch:"
echo "1. Go to GitHub repository Settings → Branches"
echo "2. Change default branch to 'main'"
