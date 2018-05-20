Description
===
This plugin is intended to manage its shutters in a proportional manner.

Setting a proportional shutter
===

![introduction01](../images/Configuration.jpg)

The configuration page is quite simple.

General
---

* Name of the shutter: The name has already been set but you can change it
* Parent object: This parameter allows to add the equipment in a Jeedom object
* Category: Declare equipment in a category
* Visible: Allows to make the equipment visible in the Dashboard
* Activate: Activate the equipment

Control object of the shutter
---

* Subject to climb: Jeedom order to control the rise (Action -> Default)
* Stop Subject: Jeedom order to control the stop (Action -> Default)
* Downhill Subject: Jeedom order to control the descent (Action -> Default)

Status object of the shutter
---

* State of the movement: Jeedom command representing the state of the movement ( info -> Binary: 0 = down , 1 = up)
* State of the stop: Jeedom command representing the state of the stop ( info -> Binary: 1 = stop)
* End of mouvement: Jeedom command representing the end of the mouvement ( info -> Binary: 1 = Shutter completely closed)

time
---

* Total Time: The total time that the shutter lasts for complete closure or opening.
* Release time: Time before which the shutter comes off the ground
