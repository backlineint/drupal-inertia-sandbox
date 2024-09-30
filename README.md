# Inertia Sandbox

Initial POCs for a Drupal implementation of [Inertia.js](https://inertiajs.com/)

## Setup

Install [ddev](https://ddev.readthedocs.io/en/stable/) and run the following:

`ddev install`

In the resulting Drupal instance, all nodes and the route /inertia/example will
be rendered using Inertia.

## Modules

### Inertia

TODO - Things to look at in inertia...

### Inertia Examples

Provides examples of the two existing methods provided by the Inertia module.

#### Inertia::render

The module provides a custom route at `/inertia/example` that uses the
`Inertia::render` method to render a simple Inertia page.

see `src/Controller/InertiaController.php` for more.

#### Inertia::renderByContext

In inertia_examples.module a preprocess_node hook calls the
`Inertia::renderByContext` method to render render all nodes using
Inertia.

renderByContent will use the appropriate template in app/src/Pages based on the
node template suggestion. All fields will be converted to slots which will be
rendered by React.

### How Inertia Examples uses Vite

TODO
