SkyGridGenerator
================

PocketMine-MP Level generator


### How to use

Put the generator name as *SkyGrid* on the `server.properties` or the worlds directive.

#### Example

In `pocketmine.yml`, under `worlds:` add a new world, e.g.

```yml
worlds:
 #These settings will override the generator set in server.properties and allows loading multiple levels
 skygrid:
   seed: 404
   generator: SkyGrid
```
