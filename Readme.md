# Order Status History

This module allows to display in your back office the various status changes of your orders,
and the date the statuses were changed.

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is OrderStatusHistory, or upload the Zip file from the "Modules" page of your back-office.
* Activate the module the "Modules" pages of your back-office.

### Composer

Add it in your main thelia composer.json file

```
composer require cqfdev/order-status-history-module ~1.0.0
```

## Usage

Go to order detail pages in your back-office to see order status changes for the order. 

## The order-status-history loop

### Input Arguments

|Argument   |Description    |
|---        |---            |
|**order_id**| The id of the order|

### Output variables

|Variable    |Description    |
|---         |---            |
|$ORDER_ID   | the id of the order |
|$STATUS_ID  | the id of the status |
|$CHANGE_DATE| the date where the order change status |

---

# Order Status History

Ce module permet d'afficher dans votre back-office les divers changement de status de vos commandes, 
et la date à laquelle les status ont été modifiés.

## Installation

### Manuellement

* L'installation est classique, soit en copiant les module dans le dossier ```<thelia_root>/local/modules/``` de votre Thelia, soit en envoyant le fichier Zip depuis la page "Modules" de vitre back-office.

* Activez ensuite le module.

### Composer

Ajouter dans le fichier composer.json de thelia

```
composer require cqfdev/order-status-history-module ~1.0.0
```

## Usage

Rendez-vous dans les fiches commande pour voir les changements de status 

### Input Arguments

|Argument   |Description    |
|---        |---            |
|**order_id**| L'id de la commande|

### Output variables

|Variable    |Description    |
|---         |---            |
|$ORDER_ID   | L'id de la commande |
|$STATUS_ID  | L'id du statut |
|$CHANGE_DATE| La date ou la commade a changer de statut|




