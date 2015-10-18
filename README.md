# pizza-get
Pizza ordering system for UWCS, available at https://pizza.uwcs.co.uk

Collects pizza choices and can process payments by card. Interface is done in flatui. All payments are handled by Stripe so that we don't have to deal with sensitive information :)

v1 features (released 16/10/2015):
* Support for Dominoes pizzas and crust selections
* Support for payments by card and by cash
* Admin interface for order management

v2 features (pending):
* Ability to change between live and test API keys on the control panel
* Fixed a bug where invalid post params weren't caught
* Added extra discount options
* Made the generic error message on order.php more appropriate

Planned features:
* Support for half and half pizzas
* Support for choose your own pizzas
* Support for other pizza vendors
* Swap database.php interactions to prepared statements
* Add total to control panel
* Remove unused form elements from order.php
* test mode indicator for index.php
* improve the index page when orders are off
* Support for ordering sides
* Add a break row to the control panel every £250 (dominoes order limit)
