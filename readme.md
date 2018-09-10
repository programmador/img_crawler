# Run

```
php bin/console domain:process <url> [depth]
```


# Todo (project design)

* ImageStatsBuilder should build a Page composite instead of a stats array. Of course it should then be ranamed.
* Site contents should be requested with Guzzle.
* Get rid of creating and keeping a new Crawler recursively. Either the odd crawler should be cleaned/unset or we have to get rid of recursion.


# Todo (tasks)

* Page number limit for parser Command
* Duration processing time
* Tests
* strict_types


# Wontfix

* Use SQL storage
