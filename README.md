# pizza-get
Pizza ordering system for UWCS, available at https://pizza.uwcs.co.uk

Collects pizza choices and can process payments by card. Interface is done in flatui. All payments are handled by Stripe so that we don't have to deal with sensitive information :)

v1 features (released 16/10/2015):
* Support for Dominoes pizzas and crust selections
* Support for payments by card and by cash
* Admin interface for order management

v1.1 features (released 23/10/2015):
* Added ability to change between live and test API keys on the control panel
* Added extra discount options, including pizza only discounts
* Added support for ordering sides
* Changed database.php interactions to use prepared statements
* Tidied up the conrol panel with a running total and breaks every £250 (web order limit)
* Support for half and half pizzas
* Support for choose your own pizzas

Known bugs:
* Users shouldn't be able to order a small pizza with hotdog stuffed crust
* Users should be able to order sides with no pizza

Planned features:
* Support for personal pizzas
* Ability to mark orders as entered into the Dominoes website
* Modify control panel forms to use Ajax
