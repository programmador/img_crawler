# Run locally

Setup redis connection and then run:

```
php bin/console domain:process <url> [depth]
```


# Run with docker

Be sure to have all required options in Your kernel config if You're using Linux or FreeBSD.
Setup crawler command in `docker-composse.yml` and run:

```
docker-compose up --build
```

Wait for crawler to finish (optionally) and then access http://localhost:8080


# Todo (project design)

* ImageStatsBuilder should build a Page composite instead of a stats array. Of course it should then be renamed.
* Abovementioned builder should also create an iterator to loop through Pages sorted by images number.
* Site contents should be requested with Guzzle.
* Get rid of creating and keeping a new Crawler recursively. Either the odd crawler should be cleaned/unset or we have to get rid of recursion.


# Todo (tasks)

* Page number limit for parser Command
* Duration processing time
* Tests
* strict_types


# Wontfix

* Use SQL storage (what for?)
