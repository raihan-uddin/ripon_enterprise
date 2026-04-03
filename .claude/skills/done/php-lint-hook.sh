#!/bin/bash
# php-lint-hook.sh — PostToolUse hook: auto-lint PHP files after Write/Edit
# Reads hook JSON from stdin, checks if file is PHP, runs php -l

FILE=$(jq -r '.tool_response.filePath // .tool_input.file_path // empty' 2>/dev/null)

if [ -z "$FILE" ]; then
  echo '{"suppressOutput":true}'
  exit 0
fi

if echo "$FILE" | grep -qE '\.php$'; then
  RESULT=$(php -l "$FILE" 2>&1)
  if [ $? -ne 0 ]; then
    # Extract just the error message
    ERR=$(echo "$RESULT" | head -1 | sed 's/"/\\"/g')
    echo "{\"systemMessage\":\"PHP syntax error: ${ERR}\",\"hookSpecificOutput\":{\"hookEventName\":\"PostToolUse\",\"additionalContext\":\"PHP SYNTAX ERROR in ${FILE}. Fix it before continuing.\"}}"
  else
    echo '{"suppressOutput":true}'
  fi
else
  echo '{"suppressOutput":true}'
fi
