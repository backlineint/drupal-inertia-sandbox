# Inertia Sandbox

Initial POCs for a Drupal implementation of [Inertia.js](https://inertiajs.com/)

While hopefully these implementation concepts are useful, be sure to check out
the docs for the Inertia project itself, which is debatably the more interesting
part of all this.

## Setup

Install [ddev](https://ddev.readthedocs.io/en/stable/) and run the following:

`ddev install`

In the resulting Drupal instance, all nodes in the default display mode and the
route /inertia/example will be rendered using Inertia.

For the curious, `ddev install` runs the bash script at `.ddev/commands/host/install`

## Modules

### Inertia

A pre-release version of the Drupal module is published on Drupal.org at
https://www.drupal.org/project/inertia

The inertia module primarily adds an implementation of Inertia's ::render()
method. This render method also introduces the concept of slots, which will map
nicely to Single Directory Components, but is not currently part of the main
Inertia implementation.

Additionally, the module provides a ::renderByContext() method that given the
$variables array for a particular template, will render all fields as slots.
This honors things like display mode controls in Drupal - re-order fields and
see the result in Inertia/React.

Equivalents will also be offered as Twig extensions, but are not yet implemented.

The current implementation only handles the initial page load and does not yet
support Inertia's client-side navigation for subsequent page loads.

### Inertia Examples

Provides examples of the two existing methods provided by the Inertia module.

In the browser, try inspecting the #app element. You'll see the data-page
attribute, which contains the serialized json used when mounting the Inertia app.

When viewing a node - with js disabled, you'll see template elements for each
field. With js enabled, you'll see the React components that replace those.

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

#### File structure

This module still does some heavy-ish lifting that we'd we'd probably want ironed
out in a more production-ready implementation.

- The root directory contains standard Drupal module files.
- /src contains the controller for the /inertia/example route.
- /js - a helper script for HMR with Vite and React.
- /app contains the Inertia app.
  - /app/src/main.tsx calls @inertiajs/react's createInertiaApp method. This
    renders the app and also handles resolving the requested React template. It
    also parses slots from Drupal using html-react-parser, which is unique to this
    implementation.
  - /app/src/App.tsx is a port of Inertia's App component, primarily to handle
    the slot rendering.
  - /app/src/Pages contains the React components for each Drupal template.

### Vite

inertia_examples uses the Drupal Vite module to enable HMR when running in dev
mode. To start Vite in dev mode run:

`ddev vite`

Any updates to tsx templates in modules/custom/inertia_examples/app/src/Pages
will be reflected in the browser automatically.

When switching between prod and dev mode, be sure to clear Drupal's cache.

You'll also see Vite related configuration in the module's libraries.yml file,
and the app's vite.config.js file.
