# Run locally

Setup redis connection in config/redis.yaml and then run:

```
php bin/console domain:process <url> [depth]
```


# Run with docker

Be sure to have all required options in Your kernel config enabled if You're using Linux or FreeBSD.
Modify crawler command in `docker-composse.yml` (optionally) and run:

```
docker-compose up --build
```

Wait for crawler to finish (optionally) and then access http://localhost:8080
Also You can keep refreshing the page while crawler command is working


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
* Use redis bundle (one bundle needs an ancient php, other can't create a non-clustered connection)


# Notes

* The project is able to crawl and then output multiple sites info
