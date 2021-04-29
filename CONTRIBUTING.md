# Contributing guidelines

## Documentation
- each feature should be documented in the `.docs/` folder

## Tests
- each new class / method must be covered by a test, that
 - is named <ClassName>Test.php
 - is located in the `tests/` folder
 - has the same namespace except for the `\Test\` part
 - is correctly categorized as `Unit`, `Feature` or `End2End` test
   (and located accordingly)
- each test method
  - should start with the `test_` prefix and should be named after the method to be tested,
    e.g. `test_resolveProducts`
    (unless an edge case is tested, e.g. `test_resolveProducts_deduplicates_based_on_name`)
  - should use a data provider that
    - ends with the suffix `_dataProvider`, e.g. `resolveProducts_dataProvider`
    - uses meaningful names as array key for the individual data sets
      (spaces can be used to separate words)

### Example
#### Class
- Class
  - name: `Foo.php`
  - location: `Modules/Experimental/Bar/Foo.php`
  - namespace `Modules\Experimental\Bar`
- Test
  - name: `FooTest.php`
  - location: `Modules/Experimental/tests/Unit/Bar/FooTest.php`
  - namespace `Modules\Experimental\Test\Unit\Bar`

#### Method
- Method
  - name: `resolveData()`
- Test
  - name: `test_resolveData()`
  - dataProvider: `resolveData_dataProvider`
    - dataSet:
      ````
      return [
        "resolves default data on empty input" => [
          // ...
        ]
      ];
      ````

## PR process

### Before the PR
- all style checks pass
  - `make phpcs`
- all tests pass
  - `make test`

### Make the PR
- if setup data is needed, describe how to import the data
- add non-obvious todos for the approver and provide the corresponding commands (if applicable), e.g.
  - added/changed environment variables
  - infrastructure that needs to updated/created
  - changes in the docker setup that require a rebuild

### Code Review
- code reviews should be performed according to the guidelines explained in https://google.github.io/eng-practices/review/reviewer/

## Git
### Squash / Rebase commits
- rebase unnecessary commits, e.g.
  ````
  (4) Fix bad bug >:O
   |
  (3) wip
   |
  (2) test
   |
  (1) fixmelater
  ````
  via `git rebase -i HEAD~4` or better with the concrete branch name `git rebase -i develop`
  ````
  r (1) fixmelater
  f (2) test
  f (3) wip
  f (4) Fix bad bug, I am a  pretty message
  ````
  to keep only `(1)` and be able to (r)eword the commit message of that commit
- *never* rebase commits merged from other (remote) branches!
- see https://about.gitlab.com/2018/06/07/keeping-git-commit-history-clean/

### <span id="commit-message">Commit messages</span>
- Guideline: https://chris.beams.io/posts/git-commit/
  - Separate subject from body with a blank line
  - Limit the subject line to 50 characters
  - Capitalize the subject line
  - Do not end the subject line with a period
  - Use the imperative mood in the subject line
  - Wrap the body at 72 characters
  - Use the body to explain what and why vs. how
- if a commit resolves an issue, put it at the end prefixed by `Resolves:`
  ````
  Resolves:
  MT-1337
  ````

#### Examples
**Bad**
````
added thing, fixed other thing and changed filename
````
**Better**
````
Add thing, fix other thing and change filename
````

**Bad**
````
made changes on the module related to ticket MT-1444 without foo and bar as connected things
````
**Better**
````
Change the module "Module"

Foo and bar are connected through
baz. Needed to decouple them to create
better understanding of thing.

Resolves:
GH-1

Related:
GH-2
GH-3
````
