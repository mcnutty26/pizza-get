# pizza-get
Pizza ordering system for UWCS, available at https://pizza.uwcs.co.uk

Collects pizza choices and can process payments by card. Interface is done in flatui. All payments are handled by Stripe so that we don't have to deal with sensitive information :)

v1.0 features (released 16/10/2015):
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

v1.2 features (released 29/10/2015):
* Added support for personal pizzas
* Added ability to mark orders as entered into the Dominoes website
* Modified control panel forms to use Ajax
* Moved hard coded values over to the config file
