# Introduction

## Makefile
`make` is the central tool for working with this repository. Run `make` to get a list of available targets
and / or have a look directly in the `Makefile`.

## Docker setup
Build the docker setup via `docker-*` `make` commands.

## Application setup
Setup via `make init` (create the application .env file) and `make setup` (install composer dependencies)

## Tooling
### Tests
Run tests via `make test`

### Style
This repository follows PSR-12.

Run the style checks via `make phpcs`. Fixable style errors can be fixed via `make phpcbf` 

