EXPERIMENTAL (such T4) extract of the Donation Context out of the FundraisingFrontend git repo.

[![Build Status](https://travis-ci.org/wmde/fundraising-donations.svg?branch=master)](https://travis-ci.org/wmde/fundraising-donations)

## Development

### Installing the dependencies

    docker run -it --rm --user $(id -u):$(id -g) -v ~/.composer:/composer -v $(pwd):/app docker.io/composer

### Running the tests

    make ci

This implicitly builds the `app` container as defined in `docker-compose.yml` & `Dockerfile`
and executes all CI checks. For commands that run only a subset, see `Makefile`.

#### PHPUnit with filter

Individual commands like PHPUnit with a filter can be run like

    docker-compose run --rm app ./vendor/bin/phpunit --filter valid
