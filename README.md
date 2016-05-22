# pizza-get
Pizza ordering system for UWCS, hosted at https://pizza.uwcs.co.uk

## Description
pizza-get soves the problem of ordering pizza for large numbers of people by allowing them to submit orders to a central location. It accepts and processes card payments to avoid the age-old hunt for change and the subsequent trip to the cash machine in the rain. All orders go to a control panel, where order makers can mark them as paid (for cash transactions) and then entered into the website basket.

## Technologies
The interface is done in flatui. All payments are handled by Stripe, so the application doesn't actually have to handle and store sensitive information. There is a fee associated with stripe payments which is factored into the cost of paying by card.

## Releases
* v1 (released 29/10/2015)
* v2 (released 22/05/2016)

## Licenses
* pizza-get is licensed under the GNU GPL v3
* [Flat-UI](https://github.com/designmodo/Flat-UI) is licensed under the Creative Commons Attribution 3.0 Unported license (CC BY 3.0)
