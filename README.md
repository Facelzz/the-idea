# The Idea repo

This is an implementation of specialist' appointment management system with Laravel framework

## Intro

Public API allows you to get list of specialists, get free days and hours for the specific specialist
_and make an appointment (WIP)_

You can browse API Docs locally at **http://the-lidea.test/docs** after following the instructions in [Local usage guide](README.md#local-usage-guide) 

## Requirements

- [Docker Desktop](https://www.docker.com/products/docker-desktop/)


## Local usage guide

1) Append your _hosts_ file (_/etc/hosts_ for UNIX systems) with test domains needed by the local usage:
```shell
# The Idea
127.0.0.1 the-lidea.test
```

2) Run Docker Compose in the separate terminal (or use **-d** flag to run it in the background):
```shell
docker compose up
```

3) Use project API locally with a domains from the 1 paragraph
