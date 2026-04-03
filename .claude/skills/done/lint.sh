#!/bin/bash
# lint.sh — Phase 2: run PHP syntax check on session files
# Usage: lint.sh [file1.php file2.php ...]
# If no files given, checks all modified PHP files in the working tree

echo "=== PHP Syntax Check ==="

ERRORS=0
CHECKED=0

if [ $# -gt 0 ]; then
  FILES="$@"
else
  FILES=$(git diff --name-only --diff-filter=ACM -- '*.php' 2>/dev/null)
  STAGED=$(git diff --cached --name-only --diff-filter=ACM -- '*.php' 2>/dev/null)
  FILES="$FILES $STAGED"
fi

for f in $FILES; do
  if [ -f "$f" ] && [[ "$f" == *.php ]]; then
    CHECKED=$((CHECKED + 1))
    OUTPUT=$(php -l "$f" 2>&1)
    if [ $? -ne 0 ]; then
      echo "ERROR: $f"
      echo "  $OUTPUT"
      ERRORS=$((ERRORS + 1))
    fi
  fi
done

echo ""
echo "Checked: $CHECKED files"
echo "Errors: $ERRORS"
echo "=== Lint Exit Code: $ERRORS ==="
exit $ERRORS
