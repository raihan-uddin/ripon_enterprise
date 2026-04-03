---
name: agents
description: Internal guidance for when and how to use subagents in this project. Claude should automatically use subagents for complex tasks — users don't need to request them.
---

## When to Automatically Use Subagents

Claude should launch subagents proactively (without the user asking) when:

- A task touches **3+ files across different modules** — split by module
- A task requires **deep exploration** before making changes — use Explore agent first
- A task has **independent subtasks** that can run in parallel
- The user asks for something **broad** like "fix all X" or "update all Y"
- A **bug investigation** could be in multiple areas — search in parallel
- Creating a **new feature** that needs model + controller + views simultaneously

## Agent Types for This Project

| Type | When to Use | Example |
|------|-------------|---------|
| `Explore` | Need to find/read files, understand code, search patterns | "Find all places that use Customers model" |
| `Plan` | Need to design an approach before coding | "Plan how to add batch processing to inventory" |
| `general-purpose` | Need to write/edit code in a specific area | "Update the SellOrderController to add X action" |

## Project-Specific Patterns

### Multi-Module Feature
When adding a feature that spans modules, launch one agent per module:
- Agent 1: sell module changes
- Agent 2: inventory module changes
- Agent 3: accounting module changes

### New Entity Setup
When scaffolding a new entity:
1. First: read DB schema (sequential — need schema before proceeding)
2. Then parallel:
   - Agent 1: create model
   - Agent 2: create controller
   - Agent 3: create views

### Bug Hunt
When investigating a bug with unclear origin:
- Agent 1: search controllers for the error pattern
- Agent 2: search models for data validation issues
- Agent 3: search views for rendering problems

### Report Creation
When creating a new report:
- Explore agent 1: understand the data tables and joins needed
- Explore agent 2: read existing report patterns for reference
- Then: create the report files with full context

### Bulk Updates
When updating many similar files (e.g., "add validation to all forms"):
- Group files by module/area
- Launch one agent per group
- Each agent handles its group independently

## Agent Prompt Template

Always include this context in agent prompts:

```
This is a PHP/Yii 1.x ERP project.

Key conventions:
- Controllers extend RController with 'rights' filter for RBAC
- Models extend CActiveRecord with tableName(), rules(), relations()
- Views in themes/erp/views/ (NOT protected/views/)
- Modules: protected/modules/{sell,commercial,accounting,inventory,user,rights,loan}/
- DB: MySQL ripon_ent, localhost, root, no password
- Use CHtml::encode() for output, parameterized queries for SQL
- Transactions: beginTransaction() → save → commit/rollback with try-catch
```

## Rules

- Launch independent agents in a SINGLE message for true parallelism
- Don't duplicate work — if an agent is exploring, don't also search yourself
- Use `Explore` for read-only tasks (faster)
- Use `general-purpose` only when code changes are needed
- Use `isolation: "worktree"` when agents might modify the same files
- Maximum 5 parallel agents to avoid overwhelming the system
- Always verify agent results before presenting to the user
- Prefer agents over sequential manual work when 3+ independent tasks exist
